<?php

namespace App\Http\Controllers;

use App\Models\Ban;
use App\Models\ChiTietHoaDonBanHang;
use App\Models\HoaDonBanHang;
use App\Models\MonAn;
use App\Http\Controllers\Controller;
use App\Models\KhachHang;
use App\Models\MaGiamGia;
use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DichVuController extends Controller
{
    public function getdataTheoKhuVuc(Request $request)
    {
        $x = $this->checkRule(58);
        if ($x) {
            return response()->json([
                'status'    => 0,
                'data'      => [],
            ]);
        }
        $data = Ban::where('status', 1)
            ->where('id_area', $request->id)
            ->get();
        if ($data) {
            return response()->json([
                'data' => $data,
            ]);
        }
    }

    public function createHoaDon(Request $request)
    {
        $x = $this->checkRule(59);
        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'You are not authorized!',
            ]);
        }
        $ban = Ban::find($request->id_ban);
        $id_nv = Auth::guard('admin')->user()->id;
        $request['id_nhan_vien'] = $id_nv;
        if ($ban && $ban->status == 1 && $ban->is_open_table == 0) {
            $ban->is_open_table = 1;
            $ban->save();

            return $this->createModel($request, HoaDonBanHang::class, ['message' => 'Open table success!']);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'The table cannot be opened!',
            ]);
        }
    }

    public function getIdHoaDon(Request $request)
    {
        $x = $this->checkRule(60);
        if ($x) {
            return response()->json([
                'status'    => 0,
                'data'      => []
            ]);
        }
        $hoa_don = HoaDonBanHang::where('id_ban', $request->id_ban)
            ->where('is_done', 0)
            ->first();
        return response()->json([
            'status'        => 1,
            'hoa_don'    => $hoa_don,
        ]);
    }

    public function themMonAn(Request $request)
    {
        // $x = $this->checkRule(61);
        // if ($x) {
        //     return response()->json([
        //         'status'    => 0,
        //         'message'   => 'You are not authorized!',
        //     ]);
        // }
        $hoa_don = HoaDonBanHang::find($request->id_hoa_don);
        if ($hoa_don->is_done) {
            return response()->json([
                'status' => 0,
                'message' => 'Bill paid!',
            ]);
        } else {
            $monAn = MonAn::find($request->id_mon_an);
            $check = ChiTietHoaDonBanHang::where('id_hoa_don', $request->id_hoa_don)
                ->where('id_mon_an', $request->id_mon_an)
                ->first();

            // Check for discount
            $maGiamGia = MaGiamGia::where('id_mon', $request->id_mon_an)
                ->where('ngay_bat_dau', '<=', now())
                ->where('ngay_ket_thuc', '>=', now())
                ->where('status', 1)
                ->first();

            $phanTramGiam = $maGiamGia ? $maGiamGia->phan_tram_giam : 0;

            if ($check) {
                $check->so_luong = $check->so_luong + 1;
                $check->phan_tram_giam = $phanTramGiam;
                $check->thanh_tien = ($check->so_luong * $check->don_gia) * (1 - ($phanTramGiam / 100));
                $check->save();
            } else {
                ChiTietHoaDonBanHang::create([
                    'id_hoa_don' => $request->id_hoa_don,
                    'id_mon_an' => $request->id_mon_an,
                    'so_luong' => 1,
                    'don_gia' => $monAn->price,
                    'phan_tram_giam' => $phanTramGiam,
                    'thanh_tien' => $monAn->price * (1 - ($phanTramGiam / 100)),
                ]);
            }

            $data = ChiTietHoaDonBanHang::where('id_hoa_don', $request->id_hoa_don)->get();
            $tong_tien = 0;
            foreach ($data as $value) {
                $tong_tien += $value->thanh_tien;
            }

            $hoa_don->tong_tien_truoc_giam = $tong_tien;
            $hoa_don->tien_thuc_nhan = $tong_tien * (1 - ($hoa_don->phan_tram_giam / 100));
            $hoa_don->save();

            return response()->json([
                'status' => 1,
                'message' => $check ? 'Update successfully!' : 'Item added successfully!',
            ]);
        }
    }


    public function getChiTietBanHang(Request $request)
    {
        // $x = $this->checkRule(62);
        // if($x)  {
        //     return response()->json([
        //         'status'    => 0,
        //         'data'      => [],
        //         'kh'        => []
        //     ]);
        // }
        $chiTiet = ChiTietHoaDonBanHang::join('mon_ans', 'mon_ans.id', 'chi_tiet_hoa_don_ban_hangs.id_mon_an')
            ->where('chi_tiet_hoa_don_ban_hangs.id_hoa_don', $request->id_hoa_don)
            ->where('chi_tiet_hoa_don_ban_hangs.is_done', 0)
            ->select('chi_tiet_hoa_don_ban_hangs.*', 'mon_ans.food_name')
            ->get();
        $khach_hang = HoaDonBanHang::join('khach_hangs', 'hoa_don_ban_hangs.id_khach_hang', 'khach_hangs.id')
            ->where('hoa_don_ban_hangs.id', $request->id_hoa_don)
            ->select('khach_hangs.ten_khach_hang', 'khach_hangs.email', 'khach_hangs.so_dien_thoai')
            ->first();
        if ($khach_hang == null) {
            $khach_hang = new KhachHang();
            $khach_hang->ten_khach_hang = '';
            $khach_hang->email = '';
            $khach_hang->so_dien_thoai = '';
        }

        return response()->json([
            'data' => $chiTiet,
            'kh' => $khach_hang
        ]);
    }
    public function updateChiTietBanHang(Request $request)
    {
        $x = $this->checkRule(61);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'You are not authorized!',
            ]);
        }
        $chiTiet = ChiTietHoaDonBanHang::where('id', $request->id)->where('id_hoa_don', $request->id_hoa_don)->first();
        if ($chiTiet) {
            $chiTiet->so_luong = $request->so_luong;
            $chiTiet->don_gia = $request->don_gia;
            $chiTiet->phan_tram_giam = $request->phan_tram_giam;
            $chiTiet->ghi_chu = $request->ghi_chu;
            $chiTiet->thanh_tien = ($chiTiet->so_luong * $chiTiet->don_gia) - ($chiTiet->so_luong * $chiTiet->don_gia / 100 * $chiTiet->phan_tram_giam);
            $chiTiet->update();
            $data = ChiTietHoaDonBanHang::where('id_hoa_don', $chiTiet->id_hoa_don)->get();
            $tong_tien = 0;

            foreach ($data as $key => $value) {
                $tong_tien = $tong_tien + $value->thanh_tien;
            }

            $hoa_don = HoaDonBanHang::find($chiTiet->id_hoa_don);
            $hoa_don->tong_tien_truoc_giam = $tong_tien;
            $hoa_don->tien_thuc_nhan =  $tong_tien * (1 - ($hoa_don->phan_tram_giam) / 100);
            $hoa_don->save();

            return response()->json([
                'status'    => 1,
                'message'   => 'Update successfully!',
            ]);
        }
    }
    public function xoaChiTietBanHang(Request $request)
    {
        $x = $this->checkRule(62);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'You are not authorized!',
            ]);
        }
        $chiTiet = ChiTietHoaDonBanHang::where('id', $request->id)->first();
        if ($chiTiet) {
            $chiTiet->delete();
            $data = ChiTietHoaDonBanHang::where('id_hoa_don', $chiTiet->id_hoa_don)->get();
            $tong_tien = 0;
            foreach ($data as $key => $value) {
                $tong_tien = $tong_tien + $value->thanh_tien;
            }

            $hoa_don = HoaDonBanHang::find($chiTiet->id_hoa_don);
            $hoa_don->tong_tien_truoc_giam = $tong_tien;
            $hoa_don->tien_thuc_nhan =  $tong_tien * (1 - ($hoa_don->phan_tram_giam) / 100);
            $hoa_don->save();

            return response()->json([
                'status'    => 1,
                'message'   => 'Delete successfully!',
            ]);
        }
    }

    public function updateHoaDonBanHang(Request $request)
    {
        $x = $this->checkRule(63);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'You are not authorized!',
            ]);
        }
        $hoa_don = HoaDonBanHang::where('id', $request->id)->where('id_ban', $request->id_ban)->where('is_done', 0)->first();
        if ($hoa_don) {
            $hoa_don->phan_tram_giam = $request->phan_tram_giam;
            $hoa_don->tien_thuc_nhan =  $hoa_don->tong_tien_truoc_giam * (1 - ($request->phan_tram_giam / 100));
            $hoa_don->ghi_chu = $request->ghi_chu;
            $hoa_don->save();

            return response()->json([
                'status'    => 1,
                'message'   => 'Update successfully!',
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Invoice does not exist!',
            ]);
        }
    }
    public function DongBan(Request $request)
    {
        $x = $this->checkRule(64);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'You are not authorized!',
            ]);
        }
        $ban = Ban::find($request->id_ban);
        if ($ban && $ban->is_open_table == 1) {
            $hoaDon = HoaDonBanHang::where('id_ban', $request->id_ban)
                ->where('is_done', 0)
                ->first();
            $tokens = Token::where('id_ban', $request->id_ban)->first()->delete();
            if ($hoaDon) {
                $chiTietHoaDon = ChiTietHoaDonBanHang::where('id_hoa_don', $hoaDon->id)->get();
                foreach ($chiTietHoaDon as $chiTiet) {
                    $chiTiet->delete();
                }

                $hoaDon->delete();
            }
            $ban->is_open_table = 0;
            $ban->save();
            return response()->json([
                'status' => 1,
                'message' => 'The table has been successfully closed!',
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'message' => 'The table cannot be closed!',
            ]);
        }
    }
}
