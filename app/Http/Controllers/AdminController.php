<?php

namespace App\Http\Controllers;

use App\Exports\AdminExport;
use App\Http\Requests\Admin\ChangePasswordRequest;
use App\Http\Requests\Admin\CheckIdAdminRequest;
use App\Http\Requests\Admin\CreateAdminRequest;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Mail\sendMailForgotPassword;
use App\Models\Admin;
use App\Models\ChucNang;
use App\Models\KhuVuc;
use App\Models\Quyen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function getUserPermissions()
    {
        $admin = Auth::guard("admin")->user();
        if ($admin) {
            $permissionId = $admin->id;
            $quyen = Admin::join('quyens', 'admins.id_permission', 'quyens.id')
                            ->select('list_id_function')
                            ->where('admins.id', $permissionId)
                            ->first();
            if ($quyen && !is_null($quyen->list_id_function)) {
                $list_id_function = explode(",", $quyen->list_id_function);
                if (is_array($list_id_function) && count($list_id_function) > 0) {
                    $chucNangs = ChucNang::whereIn('id', $list_id_function)
                        ->where('ten_chuc_nang', 'like', 'View%')
                        ->pluck('id');
                    return response()->json([
                        'status' => 1,
                        'data' => $chucNangs->toArray()
                    ]);
                } else {
                    return response()->json([
                        'status' => 0,
                        'message' => 'Invalid list_id_function format'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 0,
                    'message' => 'Permission not found or no functions assigned to this permission'
                ]);
            }
        } else {
            return response()->json([
                'status' => 0,
                'message' => 'Admin not logged in'
            ]);
        }
    }

    public function createAdmin(CreateAdminRequest $request)
    {
        $x = $this->checkRule(2);
        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'You are not authorized!',
            ]);
        }

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
        $x = $this->checkRule(3);
        if ($x) {
            return response()->json([
                'status'    => 0,
                'data'      => []
            ]);
        }

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
        $x = $this->checkRule(7);
        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'You are not authorized!',
            ]);
        }
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
        $x = $this->checkRule(5);
        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'You are not authorized!',
            ]);
        }
        return $this->changeStatusOrUpdateModel($request, Admin::class, 'update');
    }

    public function deleteAdmin(CheckIdAdminRequest $request)
    {
        $x = $this->checkRule(6);
        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'You are not authorized!',
            ]);
        }
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
        $x = $this->checkRule(1);
        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'You are not authorized!',
            ]);
        }

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
        $x = $this->checkRule(4);
        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'You are not authorized!',
            ]);
        }
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
        if (!$admin) {
            return response()->json([
                'status'    => false,
                'message'   => 'Account does not exist or has been locked! ',
            ]);
        }
        if ($admin->hash_reset) {
            return response()->json([
                "status"    => true,
                "message"   => "Please check your email!"
            ]);
        }
        $hash_reset = Str::uuid();
        $admin->hash_reset = $hash_reset;
        $admin->save();

        $data['email'] = $admin->email;
        $data['URL'] = "http://192.168.1.6:8001/change-password/" . $hash_reset;

        Mail::to($admin->email)->queue(new SendMailForgotPassword($data));

        return response()->json([
            "status"    => true,
            "message"   => "Please check your email!"
        ]);
    }

    public function updatePasswordAdmin(Request $request)
    {
        // Xác thực yêu cầu đầu vào
        $request->validate([
            'password' => [
                'required',
                'string',
                'min:8',             // Độ dài tối thiểu 8 ký tự
                'regex:/[A-Z]/',     // Ít nhất một chữ hoa
                'regex:/[@$!%*#?&\/]/' // Ít nhất một ký tự đặc biệt bao gồm cả dấu /
            ],
            'uuid' => 'required|exists:admins,hash_reset' // Đảm bảo uuid tồn tại trong cơ sở dữ liệu
        ]);

        $admin = Admin::where('hash_reset', $request->uuid)->where('status', 1)->first();

        if (!$admin) {
            return response()->json([
                'status'    => false,
                'message'   => 'You cannot update your password due to some problem!',
            ]);
        }

        $admin->password = bcrypt($request->password);
        $admin->hash_reset = null;
        $admin->save();

        return response()->json([
            'status'    => 1,
            'message'   => 'Updated successfully!',
        ]);
    }
}
