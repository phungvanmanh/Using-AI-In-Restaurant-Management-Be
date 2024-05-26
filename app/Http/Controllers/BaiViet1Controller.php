<?php

namespace App\Http\Controllers;

use App\Models\BaiViet1;
use App\Http\Requests\CreateBaiVietRequest;
use App\Http\Requests\UpdateBaiVietRequest;
use App\Http\Requests\CheckidBaiViet;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaiViet1Controller extends Controller
{
    public function createBaiViet1(CreateBaiVietRequest $request)
    {
        $x = $this->checkRule(55);
        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'You are not authorized!',
            ]);
        }
        $data = $request->all();
        BaiViet1::create($data);

        return response()->json([
            'status'    => 1,
            'message'   => 'New successfully added',
        ]);
    }
    public function getData()
    {
        $x = $this->checkRule(53);
        if ($x) {
            return response()->json([
                'status'    => 0,
                'data'  =>  [],
            ]);
        }
        $data   = BaiViet1::join('chuyen_muc_bai_viets', 'chuyen_muc_bai_viets.id', 'bai_viet1s.id_chuyen_muc_bai_viet')
            ->select('bai_viet1s.*', 'chuyen_muc_bai_viets.ten_chuyen_muc', 'chuyen_muc_bai_viets.tinh_trang')
            ->get();

        return response()->json([
            'data'  =>  $data,
        ]);
    }
    public function getDataCustumer()
    {
        $data   = BaiViet1::join('chuyen_muc_bai_viets', 'chuyen_muc_bai_viets.id', 'bai_viet1s.id_chuyen_muc_bai_viet')
                            ->select('bai_viet1s.*', 'chuyen_muc_bai_viets.ten_chuyen_muc', 'chuyen_muc_bai_viets.tinh_trang')
                            ->get();

        return response()->json([
            'data'  =>  $data,
        ]);
    }
    public function capNhatBaiViet(UpdateBaiVietRequest $request)
    {
        $x = $this->checkRule(57);
        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'You are not authorized!',
            ]);
        }
        return $this->changeStatusOrUpdateModel($request, BaiViet1::class, 'update');
    }
    public function xoaBaiViet(CheckidBaiViet $request)
    {
        $x = $this->checkRule(56);
        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'You are not authorized!',
            ]);
        }
        return $this->deleteModel($request, BaiViet1::class, 'tieu_de_bai_viet');
    }
    public function timBaiViet(Request $request)
    {
        $x = $this->checkRule(54);
        if ($x) {
            return response()->json([
                'status'    => 0,
                'message'   => 'You are not authorized!',
            ]);
        }

        $key = '%' . $request->abc . '%';

        $data   = BaiViet1::where('tieu_de_bai_viet', 'like', $key)
            ->get();

        return response()->json([
            'data'  =>  $data,
        ]);
    }
}
