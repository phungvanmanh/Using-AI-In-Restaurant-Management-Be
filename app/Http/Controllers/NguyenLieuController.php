<?php

namespace App\Http\Controllers;

use App\Http\Requests\createNguyenLieu;
use App\Http\Requests\Chec;
use App\Http\Requests\CheckidNguyenLieu;
use App\Models\NguyenLieu;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NguyenLieuController extends Controller
{
    public function themNguyenLieu(createNguyenLieu $request)
    {
        $x = $this->checkRule(65);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyền',
            ]);
        }
        NguyenLieu::create([
            'ten_nguyen_lieu'       => $request->ten_nguyen_lieu,
            'slug_nguyen_lieu'      => $request->slug_nguyen_lieu,
            'gia'                   => $request->gia,
            'don_vi_tinh'           => $request->don_vi_tinh,
            'tinh_trang'            => $request->tinh_trang,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'đã tạo mới nguyên liệu thành công'
        ]);
    }
    public function getNguyenLieu()
    {
        $x = $this->checkRule(66);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'data'      => [],
            ]);
        }
        $data = NguyenLieu::select('id', 'ten_nguyen_lieu', 'slug_nguyen_lieu', 'gia', 'don_vi_tinh', 'tinh_trang')->get();
        return response()->json([
            'data' => $data,
        ]);
    }
    public function capnhatNguyenLieu(Request $request)
    {
        $x = $this->checkRule(67);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyền',
            ]);
        }
        return $this->changeStatusOrUpdateModel($request, NguyenLieu::class, 'update');
    }
    public function doiTrangThai(Request $request)
    {
        $x = $this->checkRule(68);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyền',
            ]);
        }
        try {
            if ($request->tinh_trang == 1) {
                $tinh_trang_moi = 0;
            } else {
                $tinh_trang_moi = 1;
            }
            NguyenLieu::where('id', $request->id)
                ->update([
                    'tinh_trang' => $tinh_trang_moi,
                ]);
            return response()->json([
                'status' => true,
                'message' => 'Successfully restated'
            ]);
        } catch (Exception $e) {
            Log::info("Lỗi", $e);
            return response()->json([
                'status' => false,
                'message' => 'There was an error'
            ]);
        }
    }
    public function deleteNguyenLieu(CheckidNguyenLieu $request)
    {
        $x = $this->checkRule(69);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyền',
            ]);
        }
        // Tìm món ăn với id được cung cấp
        $tennguyenlieu = NguyenLieu::find($request->id);

        // Lấy tên món ăn trước khi xóa
        $ten_nguyen_lieu = $tennguyenlieu->ten_nguyen_lieu;

        return $this->deleteModel($request, NguyenLieu::class, 'ten_nguyen_lieu', 'Đã xóa món ' . $ten_nguyen_lieu . ' thành công!',);
    }
    public function searchNguyenLieu(Request $request)
    {
        $x = $this->checkRule(70);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'data'      => [],
            ]);
        }

        $key = '%' . $request->abc . '%';

        $data   = NguyenLieu::where('ten_nguyen_lieu', 'like', $key)
            ->get();

        return response()->json([
            'data'  =>  $data,
        ]);
    }
}
