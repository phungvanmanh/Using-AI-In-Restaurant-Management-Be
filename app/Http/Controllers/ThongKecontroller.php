<?php

namespace App\Http\Controllers;

use App\Models\HoaDonBanHang;
use App\Models\HoaDonNhapKho;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ThongKecontroller extends Controller
{
    public function getDataThongKe1(Request $request)
    {
        $data = HoaDonBanHang::where('is_done', 1)
            ->whereDate('created_at', '>=', $request->begin)
            ->whereDate('created_at', '<=', $request->end)
            ->select(
                DB::raw("SUM(tien_thuc_nhan) as total"),
                DB::raw("DATE_FORMAT(created_at,'%d/%m/%Y') as label")
            )
            ->groupBy('label')
            ->get();

        $list_label = [];
        $list_data = [];

        foreach ($data as $item) {
            $list_data[] = $item->total;
            $list_label[] = $item->label;
        }

        return response()->json([
            'list_label' => $list_label,
            'list_data' => $list_data,
        ]);
    }
    public function tinhDoanhThu(Request $request)
    {
        $ngayBatDau = $request->input('ngay_bat_dau');
        $ngayKetThuc = $request->input('ngay_ket_thuc');

        // Tổng tiền nhập kho
        $tongTienNhapKho = HoaDonNhapKho::whereBetween('ngay_nhap', [$ngayBatDau, $ngayKetThuc])
            ->sum('tong_tien');

        // Tổng tiền bán hàng chỉ bao gồm các hóa đơn đã hoàn thành
        $tongTienBanHang = HoaDonBanHang::whereBetween('created_at', [$ngayBatDau, $ngayKetThuc])
            ->where('is_done', 1)
            ->sum('tien_thuc_nhan');

        // Lợi nhuận
        $loiNhuan = $tongTienBanHang - $tongTienNhapKho;

        // Trả về response JSON
        return response()->json([
            'status' => true,
            'data' => [
                'tong_tien_nhap_kho' => $tongTienNhapKho,
                'tong_tien_ban_hang' => $tongTienBanHang,
                'loi_nhuan' => $loiNhuan,
            ],
        ], 200);
    }

}
