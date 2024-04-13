<?php

namespace App\Http\Controllers;

use App\Models\HoaDonBanHang;
use App\Models\ThanhToan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogControlter extends Controller
{
    public function dataHistoryBuill()
    {
        $data = ThanhToan::join('admins', 'thanh_toans.id_nhan_vien', 'admins.id')
            ->select('thanh_toans.id', 'thanh_toans.so_tien', 'thanh_toans.noi_dung', DB::raw("DATE_FORMAT(thanh_toans.created_at, '%d-%m-%Y %H:%i:%s') as transDate"), 'admins.first_last_name')
            ->get();

        foreach ($data as $value) {
            $matches = [];

            if (preg_match('/HDBH(\d+)/', $value->noi_dung, $matches)) {
                $id_hoa_don = $matches[1];
            } else {
                continue;
            }

            $hoa_don = HoaDonBanHang::join('bans', 'hoa_don_ban_hangs.id_ban', 'bans.id')
                                    ->where('hoa_don_ban_hangs.id', $id_hoa_don)
                                    ->where('is_done', 1)
                                    ->select('bans.name_table')
                                    ->first();
            $value['so_tien']    = number_format($value['so_tien']) . " VND";
            $value['id_hoa_don'] = $id_hoa_don;
            $value['name_table'] = $hoa_don->name_table;
        }
        return response()->json([
            'data' => $data
        ]);
    }
}
