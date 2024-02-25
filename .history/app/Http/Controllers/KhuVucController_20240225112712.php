<?php

namespace App\Http\Controllers;

use App\Models\KhuVuc;
use Illuminate\Http\Request;

class KhuVucController extends Controller
{
    public function getDataDanhMuc()
    {
        $data = KhuVuc::get();
        return response()->json([
            'data'   => $data,
        ]);
    }

    public function createDanhMuc(createDanhMucRequest $request)
    {
        $data = $request->all();
        KhuVuc::create($data);

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
