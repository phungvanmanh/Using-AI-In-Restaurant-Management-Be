<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\CheckIdAdminRequest;
use App\Http\Requests\Admin\CreateAdminRequest;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Jobs\SendEmailJob;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function createAdmin(CreateAdminRequest $request)
    {
        $data = $request->all();
        $data['password'] = bcrypt($request->password);

        Admin::create($data);

        $emailDetails = [
            'tieu_de'   => "Tài Khoản Đăng Nhập Hệ Thống",
            'email'     => $request->email,
            'password'  => $request->password,
        ];
        //gửi email tới tài khoản khi tạo thành công
        // dispatch(new SendEmailJob($emailDetails));
        return response()->json([
            'status'    => 1,
            'message'   => 'New account successfully added!',
        ]);
    }

    public function getDataAdmin()
    {
        $data = Admin::join('quyens', 'admins.id_permission', 'quyens.id')
                     ->select('admins.id', 'admins.first_last_name', 'admins.email', 'admins.so_dien_thoai', 'admins.tinh_trang', 'admins.id_permission', DB::raw("DATE_FORMAT(admins.ngay_sinh, '%d-%m-%Y') as ngay_sinh"), 'quyens.ten_quyen')
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
        $admin->tinh_trang = !$admin->tinh_trang;
        $admin->save();

        return response()->json([
            'status'    => 1,
            'message'   => 'Status changed successfully!',
        ]);
    }

    public function updateAdmin(UpdateAdminRequest $request)
    {
        $data = $request->all();
        $admin = Admin::where('id', $request->id)->first();

        $admin->update($data);

        return response()->json([
            'status'    => 1,
            'message'   => 'Updated successfully!',
        ]);
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
}
