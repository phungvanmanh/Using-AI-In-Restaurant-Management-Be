<?php

namespace App\Http\Controllers;

use App\Models\HoaDonBanHang;
use App\Models\ChiTietHoaDonBanHang;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HoaDonBanHangController extends Controller
{
    public function dataBill(Request $request)
    {
        $data = ChiTietHoaDonBanHang::where('id_hoa_don', $request->id_hoa_don_ban_hang)
            ->join('mon_ans', 'mon_ans.id', 'chi_tiet_hoa_don_ban_hangs.id_mon_an')
            ->select('chi_tiet_hoa_don_ban_hangs.*', 'mon_ans.food_name', 'mon_ans.price')
            ->get();
        $hoa_don = HoaDonBanHang::where('hoa_don_ban_hangs.id', $request->id_hoa_don_ban_hang)
            ->join('bans', 'bans.id', 'hoa_don_ban_hangs.id_ban')
            ->select('bans.name_table', 'hoa_don_ban_hangs.tong_tien_truoc_giam', 'hoa_don_ban_hangs.phan_tram_giam', 'hoa_don_ban_hangs.ghi_chu', 'hoa_don_ban_hangs.is_done')
            ->first();
        if ($hoa_don->is_done == 0) {
            $hoa_don->phan_tram_giam = $hoa_don->phan_tram_giam == null ? 0 : $hoa_don->phan_tram_giam;
            $hoa_don->tien_thuc_nhan = $data->sum('thanh_tien') * (1 - ($hoa_don->phan_tram_giam / 100));
            $hoa_don->tong_tien_truoc_giam = $data->sum('thanh_tien');
        }
        return response()->json([
            'status' => 1,
            'data' => $data,
            'hoa_don' => $hoa_don
        ]);
    }

    public function hoaDon(Request $request)
    {
        $data = HoaDonBanHang::join('admins', 'admins.id', '=', 'hoa_don_ban_hangs.id_nhan_vien')
                     ->join('bans', 'bans.id', 'hoa_don_ban_hangs.id_ban')
                     ->whereDate('hoa_don_ban_hangs.created_at', '>=', $request->begin)
                     ->whereDate('hoa_don_ban_hangs.created_at', '<=', $request->end)
                     ->select('hoa_don_ban_hangs.*', 'admins.first_last_name', 'bans.name_table')
                     ->get();
        return response()->json([
            'data' => $data,
        ]);
    }
}
