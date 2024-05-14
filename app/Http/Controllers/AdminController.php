<?php

namespace App\Http\Controllers;

use App\Exports\AdminExport;
use App\Http\Requests\Admin\ChangePasswordRequest;
use App\Http\Requests\Admin\CheckIdAdminRequest;
use App\Http\Requests\Admin\CreateAdminRequest;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Mail\sendMailForgotPassword;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
class AdminController extends Controller
{
    public function createAdmin(CreateAdminRequest $request)
    {
        $data = $request->all();
        $data['password'] = bcrypt($request->password);

        Admin::create($data);

        // $emailDetails = [
        //     'tieu_de'   => "Tài Khoản Đăng Nhập Hệ Thống",
        //     'email'     => $request->email,
        //     'password'  => $request->password,
        // ];

        return response()->json([
            'status'    => 1,
            'message'   => 'New account successfully added!',
        ]);
    }

    public function getDataAdmin()
    {
        $data = Admin::join('quyens', 'admins.id_permission', 'quyens.id')
            ->select('admins.id', 'admins.first_last_name', 'admins.email', 'admins.phone_number', 'admins.status', 'admins.id_permission', "admins.date_birth", 'quyens.name_permission')
            ->paginate(10);
        $response = [
            'pagination' => [
                'total' => $data->total(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'from' => $data->firstItem(),
                'to' => $data->lastItem(),
            ],
            'data' => $data
        ];
        return $response;
    }

    public function changeStatus(CheckIdAdminRequest $request)
    {
        $admin = Admin::find($request->id);
        $admin->status = !$admin->status;
        $admin->save();

        return response()->json([
            'status'    => 1,
            'message'   => 'Status changed successfully!',
        ]);
    }

    public function updateAdmin(UpdateAdminRequest $request)
    {
        return $this->changeStatusOrUpdateModel($request, Admin::class, 'update');
    }

    public function deleteAdmin(CheckIdAdminRequest $request)
    {
        return $this->deleteModel($request, Admin::class, 'first_last_name');
    }

    public function searchAdmin(Request $request)
    {
        $search = $request->all();
        $data = Admin::join('quyens', 'admins.id_quyen', 'quyens.id')
            ->where(function ($query) use ($search) {
                $query->where('admins.ho_va_ten', 'like', '%' . $search['search'] . '%')
                    ->orWhere('admins.email', 'like', '%' . $search['search'] . '%')
                    ->orWhere('admins.so_dien_thoai', 'like', '%' . $search['search'] . '%');
            })
            ->select('admins.id', 'admins.ho_va_ten', 'admins.email', 'admins.so_dien_thoai', 'admins.tinh_trang', 'admins.id_quyen', DB::raw("DATE_FORMAT(admins.ngay_sinh, '%d-%m-%Y') as ngay_sinh"), 'quyens.ten_quyen')
            ->paginate(10);

        $response = [
            'pagination' => [
                'total' => $data->total(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'from' => $data->firstItem(),
                'to' => $data->lastItem(),
            ],
            'data' => $data
        ];
        return $response;
    }

    public function export()
    {
        $data = Admin::join('quyens', 'admins.id_permission', '=', 'quyens.id')
            ->select('admins.first_last_name', 'admins.email', 'admins.phone_number', 'admins.date_birth', 'admins.status', 'quyens.name_permission')
            ->get();
        return Excel::download(new AdminExport($data), 'admins.xlsx');
    }
    // có ssl mới sài
    // public function export()
    // {
    //     $data = Admin::join('quyens', 'admins.id_permission', '=', 'quyens.id')
    //         ->select('admins.first_last_name', 'admins.email', 'admins.phone_number', 'admins.date_birth', 'admins.status', 'quyens.name_permission')
    //         ->get();

    //     $fileName = 'admins.xlsx';
    //     $path = storage_path('app/public/' . $fileName);

    //     // Lưu vào storage
    //     Excel::store(new AdminExport($data), 'public/' . $fileName);

    //     // Lấy kích thước file
    //     $fileSize = Storage::disk('public')->size($fileName);
    //     $fileType = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';

    //     // Trả về JSON
    //     return response()->json([
    //         'size' => $fileSize,
    //         'type' => $fileType,
    //         'url'  => asset('storage/' . $fileName)
    //     ]);
    // }

    public function changePasswordAdmin(ChangePasswordRequest $request)
    {
        $admin = Admin::find($request->id);
        $admin->password = bcrypt($request->password);
        $admin->save();
        return response()->json([
            'status'    => 1,
            'message'   => 'Updated successfully!',
        ]);
    }

    public function forgotPasswordAdmin(Request $request)
    {
        $admin = Admin::where('email', $request->email)->where('status', 1)->first();
        if(!$admin) {
            return response()->json([
                'status'    => false,
                'message'   => 'Account does not exist or has been locked! ',
            ]);
        }
        if($admin->hash_reset) {
            return response()->json([
                "status"    => true,
                "message"   => "Please check your email!"
            ]);
        }
        $hash_reset = Str::uuid();
        $admin->hash_reset = $hash_reset;
        $admin->save();

        $data['email'] = $admin->email;
        $data['URL'] = "http://192.168.1.4:8001/change-password/" . $hash_reset;

        Mail::to($admin->email)->queue(new SendMailForgotPassword($data));

        return response()->json([
            "status"    => true,
            "message"   => "Please check your email!"
        ]);
    }

    public function updatePasswordAdmin(Request $request)
    {
        $admin = Admin::where('hash_reset', $request->uuid)->where('status', 1)->first();
        if(!$admin) {
            return response()->json([
                'status'    => false,
                'message'   => 'You cannot update your password due to some problem!',
            ]);
        }
        $admin->password   = bcrypt($request->password);
        $admin->hash_reset = null;
        $admin->save();
        return response()->json([
            'status'    => 1,
            'message'   => 'Updated successfully!',
        ]);
    }
}
