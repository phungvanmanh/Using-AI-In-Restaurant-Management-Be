<?php

namespace App\Http\Controllers;

use App\Http\Requests\NhanVien\CheckIdStaffRequest;
use App\Http\Requests\NhanVien\CreateStaffRequest;
use App\Http\Requests\NhanVien\UpdateStaffRequest;
use App\Models\NhanVien;
use Illuminate\Http\Request;


class NhanVienController extends Controller
{
    public function getDataStaff()
    {
        $data = NhanVien::get();
        return response()->json([
            'data'   => $data,
        ]);
    }
    public function createNhanVien(CreateStaffRequest $request)
    {
        $data = $request->all();
        NhanVien::create($data);

        return response()->json([
            'status'    => 1,
            'message'   => 'New staff added successfully!',
        ]);
    }
    public function changeStatus(CheckIdStaffRequest $request)
    {
        $nhan_vien = NhanVien::find($request->id);
        $nhan_vien->status = !$nhan_vien->status;
        $nhan_vien->save();

        return response()->json([
            'status'    => 1,
            'message'   => 'Status changed successfully!',
        ]);
    }
    public function updateStaff(UpdateStaffRequest $request)
    {
        $data = $request->all();
        $nhanvien = NhanVien::where('id', $request->id)->first();

        $nhanvien->update($data);

        return response()->json([
            'status'    => 1,
            'message'   => 'Updated successfully!',
        ]);
    }
    public function deleteStaff(CheckIdStaffRequest $request)
    {
        // Tìm món ăn với id được cung cấp
        $nhanvien = MonAn::find($request->id);

        // Kiểm tra nếu không tìm thấy món ăn
        if (!$nhanvien) {
            // Trả về thông báo lỗi
            return response()->json([
                'status'  => 0,
                'message' => 'Không tìm thấy nhân viên',
            ]);
        }

        // Lấy tên món ăn trước khi xóa
        // $food_name = $monan->food_name;

        // Xóa món ăn
        $nhanvien->delete();

        // Trả về thông báo thành công
        return response()->json([
            'status'  => 1,
            'message' => 'Đã xóa thành công',
        ]);
    }
    
}
