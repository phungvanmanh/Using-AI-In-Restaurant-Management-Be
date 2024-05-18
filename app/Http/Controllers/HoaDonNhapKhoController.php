<?php

namespace App\Http\Controllers;

use App\Models\ChiTietHoaDonNhap;
use App\Models\HoaDonNhapKho;
use App\Models\NhaCungCap;
use App\Models\TonKhoNguyenLieu;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\HoaDonNhapKhoExport;

class HoaDonNhapKhoController extends Controller
{
    public function addNguyenLieu(Request $request)
    {
        $user = Auth::guard('admin')->user();
        $nhap_kho = ChiTietHoaDonNhap::where('id_nguyen_lieu', $request->id)
            ->where('is_done', 0)
            ->first();
        if ($nhap_kho) {
            $nhap_kho->so_luong += 1;
            $nhap_kho->thanh_tien = $nhap_kho->so_luong * $nhap_kho->don_gia;
            $nhap_kho->save();
        } else {
            // Nếu không tìm thấy bản ghi phù hợp, tạo mới và thiết lập id_hoa_don_nhap_kho là 0
            ChiTietHoaDonNhap::create([
                'id_nguyen_lieu' => $request->id,
                'so_luong' => 1,  // Bạn cần xác định số lượng ban đầu
                'don_gia' => $request->gia,   // Giả sử bạn cần đặt giá đơn ban đầu là 0, cần cập nhật sau
                'id_nhan_vien' => $user->id,  // Bỏ comment này nếu cần thiết
                'thanh_tien'    => $request->gia,
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => "Add ingredients successfully"
        ]);
    }

    public function getdata()
    {
        $data = ChiTietHoaDonNhap::join('nguyen_lieus', 'chi_tiet_hoa_don_nhaps.id_nguyen_lieu', 'nguyen_lieus.id')
            ->where('is_done', 0)
            ->select('chi_tiet_hoa_don_nhaps.*', 'nguyen_lieus.ten_nguyen_lieu', 'nguyen_lieus.gia')
            ->selectRaw('chi_tiet_hoa_don_nhaps.don_gia * chi_tiet_hoa_don_nhaps.so_luong as thanh_tien')
            ->get();
        return response()->json([
            'data' => $data,
        ]);
    }

    public function createHoaDonNhapKho(Request $request)
    {
        $user = Auth::guard('admin')->user();
        $nha_cung_cap = NhaCungCap::find($request->id_nha_cung_cap);
        $now = Carbon::now();
        if (!$nha_cung_cap) {
            return response()->json([
                'status' => false,
                'message' => "Please select a provider",
            ]);
        }
        $hoa_don_nhap = HoaDonNhapKho::firstOrCreate(
            ['ma_hoa_don'           => 'NK' . $now->format('dmY') . $now->second],
            [
                'tong_tien'         => $request->tong_tien,
                'id_nhan_vien'      => $user->id,
                'id_nha_cung_cap'   => $request->id_nha_cung_cap,
                'ngay_nhap'         => $now,
                'ghi_chu'           => $request->ghi_chu
            ]
        );

        foreach ($request->list as $value) {
            $chi_tiet_hdnk = ChiTietHoaDonNhap::find($value['id']);
            $chi_tiet_hdnk->id_hoa_don_nhap = $hoa_don_nhap->ma_hoa_don;
            $chi_tiet_hdnk->is_done = 1;
            $chi_tiet_hdnk->save();
            $tkNguyenLieu = TonKhoNguyenLieu::where('id_nguyen_lieu', $value['id_nguyen_lieu'])
                ->whereDate('ngay', $now->format('Y-m-d'))
                ->first();
            if ($tkNguyenLieu) {
                $tkNguyenLieu->so_luong += $value['so_luong'];
                $tkNguyenLieu->save();
            } else {
                TonKhoNguyenLieu::create([
                    'id_nguyen_lieu' => $value['id_nguyen_lieu'],
                    'so_luong'       => $value['so_luong'],
                    'ngay'           => $now->format('Y-m-d')
                ]);
            }
        }

        return response()->json([
            'status' => true,
            'message' => "You have successfully updated"
        ]);
    }

    public function updateNhapKho(Request $request)
    {
        $nhap_kho = ChiTietHoaDonNhap::where('id', $request->id)->first();
        if ($nhap_kho) {
            $nhap_kho->update([
                'so_luong' => $request->so_luong,
                'don_gia' => $request->don_gia,
                'thanh_tien' => $request->so_luong * $request->don_gia,
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Successful update',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'System errors',
            ]);
        }
    }
    public function xoaNguyenLieu($id)
    {
        try {
            ChiTietHoaDonNhap::where('id', $id)->delete();
            return response()->json([
                'status' => true,
                'message' => 'Successfully removed',
            ]);
        } catch (Exception $e) {
            Log::info("Lỗi", $e);
            return response()->json([
                'status' => true,
                'message' => "Successfully removed"
            ]);
        }
    }
    public function getDataHoaDonNhapKho(Request $request)
    {
        $data = HoaDonNhapKho::join('admins', 'admins.id', 'hoa_don_nhap_khos.id_nhan_vien')
            ->join('nha_cung_caps', 'nha_cung_caps.id', 'hoa_don_nhap_khos.id_nha_cung_cap')
            ->whereDate('hoa_don_nhap_khos.created_at', '>=', $request->begin)
            ->whereDate('hoa_don_nhap_khos.created_at', '<=', $request->end)
            ->select(
                'hoa_don_nhap_khos.id',
                'hoa_don_nhap_khos.ma_hoa_don',
                'hoa_don_nhap_khos.tong_tien',
                'hoa_don_nhap_khos.ghi_chu',
                'nha_cung_caps.ten_cong_ty',
                'admins.first_last_name',
            )
            ->get();
        return response()->json([
            'data' => $data,
            'tong_tien' => $data->sum('tong_tien')
        ]);
    }
    public function getDataChiTietHoaDonNhapKho(Request $request)
    {
        $data = ChiTietHoaDonNhap::join('hoa_don_nhap_khos', 'hoa_don_nhap_khos.ma_hoa_don', 'chi_tiet_hoa_don_nhaps.id_hoa_don_nhap')
            ->join('nguyen_lieus', 'nguyen_lieus.id', 'chi_tiet_hoa_don_nhaps.id_nguyen_lieu')
            ->where('hoa_don_nhap_khos.ma_hoa_don', $request->ma_hoa_don)
            ->select('chi_tiet_hoa_don_nhaps.*', 'nguyen_lieus.ten_nguyen_lieu', DB::raw('DATE_FORMAT(chi_tiet_hoa_don_nhaps.created_at, "%d-%m-%Y") as ngay'))
            ->get();
        return response()->json([
            'data' => $data
        ]);
    }

    public function export(Request $request)
    {
        $maHoaDons = array_column($request->data, 'ma_hoa_don');
        $hoaDonNhaps = HoaDonNhapKho::whereIn('ma_hoa_don', $maHoaDons)
            ->join('nha_cung_caps', 'hoa_don_nhap_khos.id_nha_cung_cap', '=', 'nha_cung_caps.id')
            ->join('admins', 'hoa_don_nhap_khos.id_nhan_vien', '=', 'admins.id')
            ->select(
                'nha_cung_caps.ma_so_thue',
                'nha_cung_caps.ten_cong_ty',
                'nha_cung_caps.so_dien_thoai',
                'nha_cung_caps.dia_chi',
                'admins.first_last_name',
                'hoa_don_nhap_khos.tong_tien',
                'hoa_don_nhap_khos.ma_hoa_don',
            )
            ->get();

        foreach ($hoaDonNhaps as $hoaDonNhap) {
            $list = ChiTietHoaDonNhap::where('id_hoa_don_nhap', $hoaDonNhap->ma_hoa_don) // Sửa lại điều kiện này nếu cần
                ->join('nguyen_lieus', 'nguyen_lieus.id', '=', 'chi_tiet_hoa_don_nhaps.id_nguyen_lieu')
                ->select(
                    'chi_tiet_hoa_don_nhaps.so_luong',
                    'chi_tiet_hoa_don_nhaps.don_gia',
                    'chi_tiet_hoa_don_nhaps.thanh_tien',
                    'nguyen_lieus.ten_nguyen_lieu',
                    'nguyen_lieus.don_vi_tinh'
                )
                ->get()
                ->toArray();

            $data[] = [
                'ma_so_thue' => $hoaDonNhap->ma_so_thue,
                'ten_cong_ty' => $hoaDonNhap->ten_cong_ty,
                'so_dien_thoai' => $hoaDonNhap->so_dien_thoai,
                'dia_chi' => $hoaDonNhap->dia_chi,
                'first_last_name' => $hoaDonNhap->first_last_name,
                'tong_tien' => $hoaDonNhap->tong_tien,
                'list' => $list,
            ];
        }

        return Excel::download(new HoaDonNhapKhoExport($data), 'hoadonnhapkho.xlsx');
    }
}
