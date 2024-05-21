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
        $x = $this->checkRule(48);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'You are not authorized!',
            ]);
        }
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
        $x = $this->checkRule(47);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'data'   => [],
            ]);
        }
        $data   = ChuyenMucBaiViet::select('id', 'ten_chuyen_muc', 'slug_chuyen_muc', 'tinh_trang')
            ->get();

        return response()->json([
            'data'  =>  $data,
        ]);
    }
    public function capNhatChuyenMuc(UpdateChuyenMucBaiViet $request)
    {
        $x = $this->checkRule(50);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'You are not authorized!',
            ]);
        }
        try {
            ChuyenMucBaiViet::where('id', $request->id)
                ->update([
                    'ten_chuyen_muc'       => $request->ten_chuyen_muc,
                    'slug_chuyen_muc'      => $request->slug_chuyen_muc,
                    'tinh_trang'           => $request->tinh_trang,
                ]);
            return response()->json([
                'status'            =>   true,
                'message'           =>   'Successfully updated category' . $request->ten_chuyen_muc,
            ]);
        } catch (Exception $e) {
            Log::info("Lỗi", $e);
            return response()->json([
                'status'            =>   false,
                'message'           =>   'There are errors',
            ]);
        }
    }
    public function doiTrangThaiChuyenMuc(Request $request)
    {
        $x = $this->checkRule(51);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'You are not authorized!',
            ]);
        }
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
                'message'           =>   'Successfully restated',
            ]);
        } catch (Exception $e) {
            Log::info("Lỗi", $e);
            return response()->json([
                'status'            =>   false,
                'message'           =>   'There are errors',
            ]);
        }
    }
    public function deleteChuyenMuc(CheckidChuyenMucBaiViet $request)
    {
        $x = $this->checkRule(49);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'You are not authorized!',
            ]);
        }
        return $this->deleteModel($request, ChuyenMucBaiViet::class, 'ten_chuyen_muc');
    }

    public function searchChuyenMucBaiViet(Request $request)
    {
        $x = $this->checkRule(52);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'You are not authorized!',
            ]);
        }

        $key = '%' . $request->abc . '%';

        $data   = ChuyenMucBaiViet::where('ten_chuyen_muc', 'like', $key)
            ->get();

        return response()->json([
            'data'  =>  $data,
        ]);
    }
}
