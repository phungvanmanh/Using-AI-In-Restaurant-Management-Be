<?php

namespace App\Http\Controllers;

use App\Http\Requests\KhuVuc\CheckIdKhuVucRequest;
use App\Http\Requests\KhuVuc\CreateKhuVucRequest;
use App\Http\Requests\KhuVuc\UpdateKhuVucRequest;
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

    public function createKhuVuc(CreateKhuVucRequest $request)
    {
        $data = $request->all();
        KhuVuc::create($data);

        return response()->json([
            'status'    => 1,
            'message'   => 'New area added successfully!',
        ]);
    }

    public function changeStatus(CheckIdKhuVucRequest $request)
    {
        $danh_muc = KhuVuc::find($request->id);
        $danh_muc->status = !$danh_muc->status;
        $danh_muc->save();

        return response()->json([
            'status'    => 1,
            'message'   => 'Status changed successfully!',
        ]);
    }

    public function updateKhuVuc(UpdateKhuVucRequest $request)
    {
        $data = $request->all();
        $danh_muc = KhuVuc::where('id', $request->id)->first();

        $danh_muc->update($data);

        return response()->json([
            'status'    => 1,
            'message'   => 'Updated successfully!',
        ]);
    }

    public function deleteKhuVuc(CheckIdKhuVucRequest $request)
    {
        $danh_muc = KhuVuc::find($request->id);
        $ten_danh_muc = $danh_muc->name_category;
        $danh_muc->delete();

        return response()->json([
            'status'    => 1,
            'message'   => $ten_danh_muc .' category removed successfully!',
        ]);
    }
}
