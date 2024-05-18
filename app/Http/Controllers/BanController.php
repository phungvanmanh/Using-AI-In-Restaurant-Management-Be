<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ban\CheckIdBanRequest;
use App\Http\Requests\Ban\CreateBanRequest;
use App\Http\Requests\Ban\UpdateBanRequest;
use App\Models\Ban;
use App\Models\ChiTietHoaDonBanHang;
use App\Models\HoaDonBanHang;
use App\Models\MonAn;
use Illuminate\Http\Request;
use League\CommonMark\Renderer\ChildNodeRendererInterface;

class BanController extends Controller
{
    public function getDataBan()
    {
        $data = Ban::join('khu_vucs', 'khu_vucs.id', 'bans.id_area')
            ->select('bans.*', 'khu_vucs.name_area')
            ->get();
        return response()->json([
            'data'   => $data,
        ]);
    }

    public function createBan(CreateBanRequest $request)
    {
        return $this->createModel($request, Ban::class, ['message' => 'New table added successfully!']);
    }

    public function changeStatus(CheckIdBanRequest $request)
    {
        return $this->changeStatusOrUpdateModel($request, Ban::class, 'changeStatus');
    }

    public function updateBan(UpdateBanRequest $request)
    {
        return $this->changeStatusOrUpdateModel($request, Ban::class, 'update');
    }

    public function deleteBan(CheckIdBanRequest $request)
    {
        return $this->deleteModel($request, Ban::class, 'name_table');
    }
    public function searchBan(Request $request)
    {
        $key = '%' . $request->abc . '%';

        $data   = Ban::where('name_table', 'like', $key)
            ->get();

        return response()->json([
            'data'  =>  $data,
        ]);
    }
    public function getMonAnTheoBan(Request $request)
    {
        // Lấy id_ban từ dữ liệu gửi lên trong body của request
        $id_ban = $request->input('id_ban');
        // Kiểm tra xem id_ban có tồn tại không
        $ban = Ban::find($id_ban);
        if (!$ban) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Table not found',
            ]);
        }
        // Tìm hoá đơn của bàn đang mở
        $hoaDon = HoaDonBanHang::where('id_ban', $id_ban)
            ->where('is_done', false)
            ->first();
        // Kiểm tra xem có hoá đơn nào không
        if (!$hoaDon) {
            return response()->json([
                'status'    => 0,
                'message'   => 'No invoice found for this desk',
            ]);
        }
        // Lấy danh sách chi tiết hoá đơn của hoá đơn này
        $chiTietHoaDon = ChiTietHoaDonBanHang::where('id_hoa_don', $hoaDon->id)->get();
        // Tạo mảng để lưu các món ăn
        $monAnList = [];
        // Lặp qua từng chi tiết hoá đơn để lấy thông tin món ăn
        foreach ($chiTietHoaDon as $chiTiet) {
            $monAn = MonAn::find($chiTiet->id_mon_an);
            if ($monAn) {
                $monAnList[] = [
                    'id' => $monAn->id,
                    'food_name' => $monAn->food_name,
                    'price' => $monAn->price,
                    'image' => $monAn->image,
                    'quantity' => $chiTiet->so_luong,
                    'total_price' => $chiTiet->thanh_tien,
                ];
            }
        }
        // Trả về danh sách các món ăn
        return response()->json([
            'status' => 1,
            'monAnList' => $monAnList,
        ]);
    }
    public function gopBan(Request $request)
    {
        // Lấy id_ban của bàn hiện tại
        $id_ban_hien_tai = $request->input('id_ban_hien_tai');
        // Lấy id_ban của bàn cần gộp vào
        $id_ban_can_gop = $request->input('id_ban_can_gop');

        // Tìm hoá đơn của bàn hiện tại (hoá đơn đang mở)
        $hoaDonHienTai = HoaDonBanHang::where('id_ban', $id_ban_hien_tai)
            ->where('is_done', false)
            ->first();

        // Tìm hoá đơn của bàn cần gộp vào
        $hoaDonCanGop = HoaDonBanHang::where('id_ban', $id_ban_can_gop)
            ->where('is_done', false)
            ->first();

        // Kiểm tra xem hoá đơn của cả hai bàn có tồn tại không
        if (!$hoaDonHienTai || !$hoaDonCanGop) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Receipts of at least one of the two desks could not be found',
            ]);
        }

        // Lấy danh sách chi tiết hoá đơn của bàn cần gộp vào
        $chiTietHoaDonCanGop = ChiTietHoaDonBanHang::where('id_hoa_don', $hoaDonCanGop->id)->get();
        $chiTietHoaDonHienTai = ChiTietHoaDonBanHang::where('id_hoa_don', $hoaDonHienTai->id)->get();

        // Lặp qua từng chi tiết hoá đơn của bàn cần gộp vào
        foreach ($chiTietHoaDonHienTai as $value) {
            foreach ($chiTietHoaDonCanGop as $value_1) {
                if($value->id_mon_an == $value_1->id_mon_an) {
                    // dd(1, $value->id_mon_an, $value_1->id_mon_an);
                    $value->so_luong += $value_1->so_luong;
                    $value->thanh_tien += $value_1->don_gia * $value_1->so_luong;
                    $value->save();
                    ChiTietHoaDonBanHang::find($value_1->id)->delete();
                } else {
                    // dd(2);
                    $value_1->id_hoa_don = $value->id_hoa_don;
                    $value_1->save();
                }
            }
        }

        // Xóa hoá đơn và chi tiết hoá đơn của bàn cần gộp vào
        $hoaDonCanGop->delete();
        // Cập nhật trạng thái của bàn đã gộp
        $banCanGop = Ban::find($id_ban_can_gop);
        if ($banCanGop) {
            $banCanGop->is_open_table = 0;
            $banCanGop->save();
        }

        $tong_tien=0;

        foreach($chiTietHoaDonHienTai as $key =>$value){
            $tong_tien= $tong_tien + $value->thanh_tien;
        }

        $hoaDonHienTai->tong_tien_truoc_giam = $tong_tien;
        $hoaDonHienTai->tien_thuc_nhan =  $tong_tien * (1 - ($hoaDonHienTai->phan_tram_giam) / 100);
        $hoaDonHienTai->save();
        // Trả về kết quả cho client
        return response()->json([
            'status' => 1,
            'message' => 'Successfully merged tables, pooled tables are closed.',
        ]);
    }



}
