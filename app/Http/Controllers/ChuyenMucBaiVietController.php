<?php

namespace App\Http\Controllers;

use App\Models\ChuyenMucBaiViet;
use App\Http\Controllers\Controller;
use App\Http\Requests\CheckidChuyenMucBaiViet;
use App\Http\Requests\CreateChuyenMucBaiVietRequest;
use App\Http\Requests\UpdateChuyenMucBaiViet;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChuyenMucBaiVietController extends Controller
{
    public function createChuyenMuc(CreateChuyenMucBaiVietRequest $request)
    {

        ChuyenMucBaiViet::create([
            'ten_chuyen_muc'      => $request->ten_chuyen_muc,
            'slug_chuyen_muc'     => $request->slug_chuyen_muc,
            'tinh_trang'        => $request->tinh_trang,
        ]);

        return response()->json([
            'status'            =>   true,
            'message'           =>   'Successfully created new category!',
        ]);
    }
    public function getData()
    {

        $data   = ChuyenMucBaiViet::select('id', 'ten_chuyen_muc', 'slug_chuyen_muc', 'tinh_trang')
            ->get();

        return response()->json([
            'data'  =>  $data,
        ]);
    }
    public function capNhatChuyenMuc(UpdateChuyenMucBaiViet $request)
    {

        try {
            ChuyenMucBaiViet::where('id', $request->id)
                ->update([
                    'ten_chuyen_muc'       => $request->ten_chuyen_muc,
                    'slug_chuyen_muc'      => $request->slug_chuyen_muc,
                    'tinh_trang'           => $request->tinh_trang,
                ]);
            return response()->json([
                'status'            =>   true,
                'message'           =>   'Đã cập nhật thành công chuyên mục ' . $request->ten_chuyen_muc,
            ]);
        } catch (Exception $e) {
            Log::info("Lỗi", $e);
            return response()->json([
                'status'            =>   false,
                'message'           =>   'Có lỗi',
            ]);
        }
    }
    public function doiTrangThaiChuyenMuc(Request $request)
    {

        try {
            if ($request->tinh_trang == 1) {
                $tinh_trang_moi = 0;
            } else {
                $tinh_trang_moi = 1;
            }
            ChuyenMucBaiViet::where('id', $request->id)
                ->update([
                    'tinh_trang'  => $tinh_trang_moi,
                ]);
            return response()->json([
                'status'            =>   true,
                'message'           =>   'Đã đổi trạng thái thành công',
            ]);
        } catch (Exception $e) {
            Log::info("Lỗi", $e);
            return response()->json([
                'status'            =>   false,
                'message'           =>   'Có lỗi',
            ]);
        }
    }
    public function deleteChuyenMuc(CheckidChuyenMucBaiViet $request)
    {
        return $this->deleteModel($request, ChuyenMucBaiViet::class, 'ten_chuyen_muc');
    }
}
