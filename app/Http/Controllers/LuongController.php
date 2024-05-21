<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\LichLamViec;
use App\Models\Luong;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Psy\CodeCleaner\FunctionReturnInWriteContextPass;

class LuongController extends Controller
{
    public function store(Request $request){
        $x = $this->checkRule(84);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyền',
            ]);
        }
        $begin = $request->input('begin');
        $end   = $request->input('end');
        $date = Carbon::parse($begin);

        $year = $date->year;
        $month = $date->month;

        $nhan_vien = Admin::join('quyens', 'admins.id_permission', 'quyens.id')
                            ->whereNot('quyens.name_permission', 'like', '%Admin%')
                            ->where('quyens.status', 1)
                            ->where('admins.status', 1)
                            ->select('admins.id','admins.first_last_name', 'quyens.name_permission', 'quyens.amount')
                            ->get();
        $data = [];
        foreach($nhan_vien as $value) {
            $lich_lam = LichLamViec::whereDate('ngay_lam_viec', '>=', $begin)
                                    ->whereDate('ngay_lam_viec', "<=", $end)
                                    ->where('id_nhan_vien', $value['id'])
                                    ->where('is_done', 1)
                                    ->select('id_nhan_vien', DB::raw('COUNT(is_done) AS So_buoi_lam'))
                                    ->groupBy('id_nhan_vien')
                                    ->first();
            if($lich_lam) {
                $luong = Luong::firstOrCreate(
                    [
                        'thang'        => $month,
                        'nam'          => $year,
                        'id_nhan_vien' => $lich_lam->id_nhan_vien,
                    ],
                    [
                        'so_buoi_lam'  => $lich_lam->So_buoi_lam,
                        'tong_luong'   => ($lich_lam->So_buoi_lam * $value['amount']),
                    ],
                );

                if(!$luong->wasRecentlyCreated) {
                    $luong->so_buoi_lam = $lich_lam->So_buoi_lam;
                    $luong->tong_luong  = ($lich_lam->So_buoi_lam * $value['amount']) + $luong->hoa_hong;
                    $luong->save();
                }

                array_push($data, [
                    'id'                => $luong->id,
                    'id_nhan_vien'      => $value['id'],
                    'tong_luong'        => $luong->tong_luong,
                    'hoa_hong'          => $luong->hoa_hong,
                    'check'             => $luong->is_nhan,
                    'so_buoi_lam'       => $luong->so_buoi_lam,
                    'first_last_name'   => $value['first_last_name'],
                    'amount'            => $value['amount'],
                ]);
            }
        }

        return response()->json([
            'status' => true,
            'data'   => $data
        ]);
    }

    public function updateRose(Request $request)
    {
        $x = $this->checkRule(85);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyền',
            ]);
        }
        $luong = Luong::find($request->id);
        if($luong) {
            $luong->hoa_hong = $request->hoa_hong;
            $luong->save();
        }

        return response()->json([
            'status'    => true,
        ]);
    }

    public function updateReceive(Request $request)
    {
        $x = $this->checkRule(86);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyền',
            ]);
        }
        $luong = Luong::find($request->id);
        if($luong) {
            $luong->is_nhan = $request->check;
            $luong->save();
        }

        return response()->json([
            'status'    => true,
        ]);
    }

    public function Detal(Request $request)
    {
        $x = $this->checkRule(87);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'data'      => [],
            ]);
        }
        $data = LichLamViec::where('id_nhan_vien', $request->id_nhan_vien)
                            ->select('id', DB::raw('DATE_FORMAT(ngay_lam_viec, "%d-%m-%Y") as ngay_lam_viec'), 'buoi_lam_viec', 'is_done')
                            ->get();
        return response()->json([
            'status'    => true,
            'data'      => $data,
        ]);
    }
}
