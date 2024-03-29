<?php

namespace App\Http\Controllers;

use App\Models\LichLamViec;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LichLamViecController extends Controller
{
    public function createLichLamViec(Request $request) {
        $data = $request->all();
        $data['ngay_lam_viec'] = $request->ngay_lam_viec;
        $data['id_nhan_vien']  = 1;
        $now = Carbon::today();

        if ($now->greaterThan(Carbon::parse($data['ngay_lam_viec']))) {
            return response()->json(['status' => 0, 'message' => 'Không được thêm lịch làm việc cũ!']);
        }

        $data['gio_bat_dau'] = ($data['buoi_lam_viec'] == 0) ? "8:00:00" : "17:00:00";
        $data['gio_ket_thuc'] = ($data['buoi_lam_viec'] == 0) ? "16:00:00" : "22:00:00";

        $check_buoi_lam_viec = LichLamViec::where('ngay_lam_viec', $data['ngay_lam_viec'])
                                           ->where('buoi_lam_viec', $data['buoi_lam_viec'])
                                           ->where('id_nhan_vien', 1)
                                           ->first();
        if($check_buoi_lam_viec == null) {
            LichLamViec::create($data);
        }

        return response()->json(['status' => 1, 'message' => 'Đã thêm mới lịch làm việc']);
    }

    public function updateLichLamViec(Request $request) {
        // $user = auth('sanctum')->user();
        $data = $request->all();
        $res = DB::transaction(function () use ($data) {
            $now = Carbon::today();
            $lichLamViec = LichLamViec::where('id', $data['id'])->where('id_nhan_vien', $data['id_user'])->first();
            if ($now->greaterThan(Carbon::parse($lichLamViec->ngay_lam_viec))) {
                return false;
            } else {
                if($lichLamViec) {
                    $lichLamViec->delete();
                    return true;
                }
            }
        });

        if ($res) {
            return response()->json([
                'status'    => 1,
                'message'   => 'Updated work schedule!',
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Cannot cancel work schedule!',
            ]);
        }
    }

}
