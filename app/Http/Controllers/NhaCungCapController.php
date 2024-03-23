<?php

namespace App\Http\Controllers;

use App\Models\NhaCungCap;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateNhaCungCap;
use App\Http\Requests\UpdateNhaCungCap;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NhaCungCapController extends Controller
{
    public function createNhaCungCap(CreateNhaCungCap $request)
    {

        NhaCungCap::create([
            'ma_so_thue'            => $request->ma_so_thue,
            'ten_cong_ty'           => $request->ten_cong_ty,
            'ten_nguoi_dai_dien'    => $request->ten_nguoi_dai_dien,
            'so_dien_thoai'         => $request->so_dien_thoai,
            'email'                 => $request->email,
            'dia_chi'               => $request->dia_chi,
            'ten_goi_nho'           => $request->ten_goi_nho,
            'tinh_trang'            => $request->tinh_trang,
        ]);
        return response()->json([
            'status'    => true,
            'message'   => 'Tạo mới nhà cung cấp thành công!',
        ]);
    }
    public function getdata()
    {
        $data = NhaCungCap::get();
        return response()->json([
            'data'   => $data,
        ]);
    }
    public function capNhatNhaCungCap(UpdateNhaCungCap $request)
    {
        // $id_chuc_nang = 16;

        try {
            NhaCungCap::where('id', $request->id)
                ->update([
                    'ten_cong_ty'           => $request->ten_cong_ty,
                    'ma_so_thue'            => $request->ma_so_thue,
                    'ten_nguoi_dai_dien'    => $request->ten_nguoi_dai_dien,
                    'so_dien_thoai'         => $request->so_dien_thoai,
                    'email'                 => $request->email,
                    'dia_chi'               => $request->dia_chi,
                    'ten_goi_nho'           => $request->ten_goi_nho,
                    'tinh_trang'            => $request->tinh_trang,
                ]);
            return response()->json([
                'status'            =>   true,
                'message'           =>   'Đã cập nhật thành công công ty ' . $request->ten_cong_ty,
            ]);
        } catch (Exception $e) {
            Log::info("Lỗi", $e);
            return response()->json([
                'status'            =>   false,
                'message'           =>   'Có lỗi',
            ]);
        }
    }
    public function doiTrangThaiNhaCungCap(Request $request)
    {
        // $id_chuc_nang = 17;

        try {
            if ($request->tinh_trang == 1) {
                $tinh_trang_moi = 0;
            } else {
                $tinh_trang_moi = 1;
            }
            NhaCungCap::where('id', $request->id)
                ->update([
                    'tinh_trang'  => $tinh_trang_moi,
                ]);
            return response()->json([
                'status'            =>   true,
                'message'           =>   'Đã đổi trạng thái thành công',
            ]);
        } catch (Exception $e) {
            Log::info("Lỗi", $e);
            return response()->json([
                'status'            =>   false,
                'message'           =>   'Có lỗi',
            ]);
        }
    }
    public function xoaNhaCungCap(Request $request)
    {
        $nha_cung_cap = NhaCungCap::find($request->id);
        $ten_nguoi_dai_dien = $nha_cung_cap->ten_nguoi_dai_dien;
        $nha_cung_cap->delete();

        return response()->json([
            'status'    => 1,
            'message'   => $ten_nguoi_dai_dien .' removed successfully!',
        ]);
    }
}
