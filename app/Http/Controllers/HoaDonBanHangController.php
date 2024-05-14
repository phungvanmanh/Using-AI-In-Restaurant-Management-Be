<?php

namespace App\Http\Controllers;

use App\Exports\HoaDonBanHangExport;
use App\Models\HoaDonBanHang;
use App\Models\ChiTietHoaDonBanHang;
use App\Http\Controllers\Controller;
use App\Mail\sendMailBill;
use App\Models\Ban;
use App\Models\KhachHang;
use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

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
        $total = 0;
        foreach ($data as $key => $value) {
            $hoa_don = HoaDonBanHang::where('hoa_don_ban_hangs.id', $value->id)
                ->first();
            if ($hoa_don->is_done) {
                $total += $hoa_don->tien_thuc_nhan;
            }
        }
        return response()->json([
            'data' => $data,
            'total' => $total,
        ]);
    }
    public function chitietHoaDon(Request $request)
    {
        $data = ChiTietHoaDonBanHang::where('id_hoa_don', $request->id)
            ->join('mon_ans', 'chi_tiet_hoa_don_ban_hangs.id_mon_an', 'mon_ans.id')
            ->select('chi_tiet_hoa_don_ban_hangs.*', 'mon_ans.food_name')
            ->get();
        return response()->json([
            'data' => $data,
        ]);
    }

    function changeStatus(Request $request)
    {
        $hoa_don = HoaDonBanHang::find($request->id_hoa_don_ban_hang);
        if ($hoa_don) {
            $hoa_don->is_done = 1;
            $hoa_don->save();
            $ban = Ban::find($hoa_don->id_ban);
            if ($ban && $ban->is_open_table == 1) {
                $ban->is_open_table = 0;
                $ban->save();
            }
            //xóa token
            $token = Token::where('id_ban', $hoa_don->id_ban)->first();
            if($token) {
                $token->delete();
            }
        }

        $chi_tiet = ChiTietHoaDonBanHang::join('mon_ans', 'chi_tiet_hoa_don_ban_hangs.id_mon_an', 'mon_ans.id')
                                        ->where('chi_tiet_hoa_don_ban_hangs.id_hoa_don', $hoa_don->id)
                                        ->select('chi_tiet_hoa_don_ban_hangs.so_luong','chi_tiet_hoa_don_ban_hangs.don_gia','chi_tiet_hoa_don_ban_hangs.thanh_tien as total','chi_tiet_hoa_don_ban_hangs.phan_tram_giam', 'mon_ans.food_name', 'mon_ans.image')
                                        ->get();
        $khach_hang = KhachHang::find($hoa_don->id_khach_hang);
        $data['chi_tiet'] = $chi_tiet;
        $data['subtotal'] = $hoa_don->tong_tien_truoc_giam;
        $data['phan_tram_giam'] = $hoa_don->phan_tram_giam;
        $data['total'] = $hoa_don->tien_thuc_nhan;
        $data['code_bill'] = $hoa_don->id;
        $data['email'] = $khach_hang->email;
        // dd($data);
        Mail::to($khach_hang->email)->queue(new sendMailBill($data));

        return response()->json([
            "status"    => 200
        ]);
    }
    public function export()
    {
        $data = HoaDonBanHang::join('admins','hoa_don_ban_hangs.id_nhan_vien','admins.id')
                              ->join('bans','hoa_don_ban_hangs.id_ban','bans.id')
            ->select('hoa_don_ban_hangs.*','bans.name_table','admins.first_last_name')
            ->get();
        return Excel::download(new HoaDonBanHangExport($data), 'hoa_don_ban_hangs.xlsx');
    }
}
