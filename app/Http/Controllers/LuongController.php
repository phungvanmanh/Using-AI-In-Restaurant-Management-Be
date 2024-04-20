<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\LichLamViec;
use App\Models\Luong;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LuongController extends Controller
{
    public function store(){
        $begin = "2024-04-01";
        $end   = "2024-04-30";  // Corrected the date, as April has 30 days.
        $nhan_vien = Admin::join('quyens', 'admins.id_permission', 'quyens.id')
                            ->whereNot('quyens.name_permission', 'like', '%Admin%')
                            ->where('quyens.status', 1)
                            ->where('admins.status', 1)
                            ->select('admins.id','admins.first_last_name','admins.email','admins.phone_number', 'quyens.name_permission', 'quyens.amount')
                            ->get();

        foreach($nhan_vien as $value) {
            $lich_lam = LichLamViec::whereDate('ngay_lam_viec', '>=', $begin)
                                    ->whereDate('ngay_lam_viec', "<=", $end)
                                    ->where('id_nhan_vien', $value->id)
                                    ->where('is_done', 1)
                                    ->select('id_nhan_vien', DB::raw('COUNT(is_done) AS So_buoi_lam'))
                                    ->groupBy('id_nhan_vien')
                                    ->first();
            Luong::create([
                'id_nhan_vien'      => $lich_lam->id_nhan_vien,
                'so_buoi_lam'       => $lich_lam->So_buoi_lam,
                'tong_luong'        => $lich_lam->So_buoi_lam * $value['amount'],
            ]);

        }
    }

}
