<?php

namespace App\Http\Controllers;

use App\Http\Requests\DanhMuc\CheckIdDanhMucRequest;
use App\Http\Requests\DanhMuc\createDanhMucRequest;
use App\Http\Requests\DanhMuc\UpdateDanhMucRequest;
use App\Models\DanhMuc;
use Illuminate\Http\Request;

class DanhMucController extends Controller
{
    public function getDataDanhMuc()
    {
        $data = DanhMuc::get();
        return response()->json([
            'data'   => $data,
        ]);
    }

    public function createDanhMuc(createDanhMucRequest $request)
    {
        $data = $request->all();
        DanhMuc::create($data);

        return response()->json([
            'status'    => 1,
            'message'   => 'New category added successfully!',
        ]);
    }

    public function changeStatus(CheckIdDanhMucRequest $request)
    {
        $danh_muc = DanhMuc::find($request->id);
        $danh_muc->status = !$danh_muc->status;
        $danh_muc->save();

        return response()->json([
            'status'    => 1,
            'message'   => 'Status changed successfully!',
        ]);
    }

    public function updateDanhMuc(UpdateDanhMucRequest $request)
    {
        $data = $request->all();
        $danh_muc = DanhMuc::where('id', $request->id)->first();

        $danh_muc->update($data);

        return response()->json([
            'status'    => 1,
            'message'   => 'Updated successfully!',
        ]);
    }

    public function deleteDanhMuc(CheckIdDanhMucRequest $request)
    {
        $danh_muc = DanhMuc::find($request->id);
        $ten_danh_muc = $danh_muc->name_category;
        $danh_muc->delete();

        return response()->json([
            'status'    => 1,
            'message'   => $ten_danh_muc .' category removed successfully!',
        ]);
    }
}
