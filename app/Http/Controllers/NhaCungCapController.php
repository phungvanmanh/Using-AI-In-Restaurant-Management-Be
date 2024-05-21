<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckidNhaCungCapRequest;
use App\Http\Requests\CreateNhaCungCap;
use App\Http\Requests\NhapCungCap\CreateNhaCungCapcRequest;
use App\Http\Requests\NhapCungCap\UpdateNhaCungCapcRequest;
use App\Http\Requests\UpdateNhaCungCap;
use App\Models\NhaCungCap;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NhaCungCapController extends Controller
{
    public function getData()
    {
        $x = $this->checkRule(41);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'data'   => [],
            ]);
        }

        $data = NhaCungCap::get();
        return response()->json([
            'data'   => $data,
        ]);
    }
    public function searchNhaCungCap(Request $request)
    {
        $x = $this->checkRule(42);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyền',
            ]);
        }

        $key = '%' . $request->abc . '%';

        $data   = NhaCungCap::where('ten_cong_ty', 'like', $key)
            ->get(); // get là ra 1 danh sách

        return response()->json([
            'data'  =>  $data,
        ]);
    }
    public function createNhaCungCap(CreateNhaCungCap $request)
    {
        $x = $this->checkRule(43);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyền',
            ]);
        }
        NhaCungCap::create([
            'ma_so_thue'            => $request->ma_so_thue,
            'ten_cong_ty'           => $request->ten_cong_ty,
            'ten_nguoi_dai_dien'    => $request->ten_nguoi_dai_dien,
            'so_dien_thoai'         => $request->so_dien_thoai,
            'email'                 => $request->email,
            'dia_chi'               => $request->dia_chi,
            'ten_goi_nho'           => $request->ten_goi_nho,
            'tinh_trang'            => $request->tinh_trang,
        ]);
        return response()->json([
            'status'    => true,
            'message'   => 'Create a new supplier successfully!',
        ]);
    }
    public function xoaNhaCungCap(CheckidNhaCungCapRequest $request)
    {
        $x = $this->checkRule(44);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyền',
            ]);
        }
        return $this->deleteModel($request, NhaCungCap::class, 'ten_cong_ty');
    }

    public function capNhatNhaCungCap(UpdateNhaCungCap $request)
    {
        $x = $this->checkRule(45);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyền',
            ]);
        }
        try {
            NhaCungCap::where('id', $request->id)
                ->update([
                    'ten_cong_ty'           => $request->ten_cong_ty,
                    'ma_so_thue'            => $request->ma_so_thue,
                    'ten_nguoi_dai_dien'    => $request->ten_nguoi_dai_dien,
                    'so_dien_thoai'         => $request->so_dien_thoai,
                    'email'                 => $request->email,
                    'dia_chi'               => $request->dia_chi,
                    'ten_goi_nho'           => $request->ten_goi_nho,
                    'tinh_trang'            => $request->tinh_trang,
                ]);
            return response()->json([
                'status'            =>   true,
                'message'           =>   'Đã cập nhật thành công công ty ' . $request->ten_cong_ty,
            ]);
        } catch (Exception $e) {
            Log::info("Lỗi", $e);
            return response()->json([
                'status'            =>   false,
                'message'           =>   'Có lỗi',
            ]);
        }
    }

    public function doiTrangThaiNhaCungCap(Request $request)
    {
        $x = $this->checkRule(46);
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
            NhaCungCap::where('id', $request->id)
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
}
