<?php

namespace App\Http\Controllers;

use App\Models\HoaDonBanHang;
use App\Models\HoaDonNhapKho;
use App\Models\NhaCungCap;
use App\Models\NhapKho;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NhapKhoController extends Controller
{
    public function addNguyenLieu(Request $request)
    {
        // $user = Auth::guard('sanctum')->user();
        $nha_kho = NhapKho::where('id_nguyen_lieu', $request->id)
            ->where('id_hoa_don_nhap_kho', 0)
            ->first();

        if ($nha_kho) {
            $nha_kho->so_luong += 1;
            $nha_kho->thanh_tien = $nha_kho->so_luong * $nha_kho->don_gia;
            $nha_kho->save();
        } else {
            // Nếu không tìm thấy bản ghi phù hợp, tạo mới và thiết lập id_hoa_don_nhap_kho là 0
            NhapKho::create([
                'id_nguyen_lieu' => $request->id,
                'id_hoa_don_nhap_kho' => 0,  // Thiết lập giá trị này khi tạo mới
                'so_luong' => 1,  // Bạn cần xác định số lượng ban đầu
                'don_gia' => 0,   // Giả sử bạn cần đặt giá đơn ban đầu là 0, cần cập nhật sau
                // 'id_nhan_vien' => $user->id,  // Bỏ comment này nếu cần thiết
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => "Thêm nguyên liệu thành công"
        ]);
    }

    public function getdata()
    {
        $data = NhapKho::join('nguyen_lieus', 'id_nguyen_lieu', 'nguyen_lieus.id')
            ->select('nhap_khos.*', 'nguyen_lieus.ten_nguyen_lieu')
            ->get();
        $tong_tien = $data->sum('thanh_tien');
        return response()->json([
            'data' => $data,
            'tong_tien' => $tong_tien,
        ]);
    }
    public function updateNhapKho(Request $request)
    {
        $nha_kho = NhapKho::where('id', $request->id)->first();
        if ($nha_kho) {
            $nha_kho->update([
                'so_luong' => $request->so_luong,
                'don_gia' => $request->don_gia,
                'thanh_tien' => $request->so_luong * $request->don_gia,
            ]);
            return response()->json([
                'status' => true,
                'message' => 'cập nhật thành công',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'lỗi của hệ thống',
            ]);
        }
    }
    public function xoaNguyenLieu($id)
    {
        try {
            NhapKho::where('id', $id)->delete();
            return response()->json([
                'status' => true,
                'message' => 'đã xoá thành công',
            ]);
        } catch (Exception $e) {
            Log::info("Lỗi", $e);
            return response()->json([
                'status' => true,
                'message' => "đã xoá thành công"
            ]);
        }
    }
    public function createHoaDonNhapKho(Request $request)
    {
        // $user = Auth::guard('sanctum')->user();
        $nha_cung_cap = NhaCungCap::find($request->id_nha_cung_cap);
        if (!$nha_cung_cap) {
            return response()->json([
                'status' => false,
                'message' => "Vui lòng chọn nhà cung cấp",
            ]);
        }
        $list_nhap_kho = NhapKho::where('id_hoa_don_nhap_kho', 0)
            // ->where('id_nhan_vien', $user->id)
            ->get();
        if ($list_nhap_kho->count() > 0) {
            $tong_tien = $list_nhap_kho->sum('thanh_tien');
            $hoa_don = HoaDonNhapKho::create([
                'tong_tien' => $tong_tien,
                // 'id_nhan_vien' => $user->id,
                'id_nha_cung_cap' => $request->id_nha_cung_cap,
                'ghi_chu' => $request->ghi_chu
            ]);
            $prefix = 'NK';
            $ma_hoa_don = $prefix . str_pad($hoa_don->id, 5, '0', STR_PAD_LEFT); // Sửa đổi ở đây
            $hoa_don->ma_hoa_don = $ma_hoa_don;
            $hoa_don->save();
            NhapKho::where('id_hoa_don_nhap_kho', 0)
                    //  ->where('id_nhan_vien', $user->id)
                    ->update([
                        'id_hoa_don_nhap_kho'=>$hoa_don->id
                    ]);
        }
        return response()->json([
            'status'=>true,
            'message'=>"Bạn đã cập nhật thành công"
        ]);
    }

}
