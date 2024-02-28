<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ban\CheckIdBanRequest;
use App\Http\Requests\Ban\CreateBanRequest;
use App\Http\Requests\Ban\UpdateBanRequest;
use App\Models\Ban;
use Illuminate\Http\Request;

class BanController extends Controller
{
    public function getDataKhuVuc()
    {
        $data = Ban::get();
        return response()->json([
            'data'   => $data,
        ]);
    }

    public function createBan(CreateBanRequest $request)
    {
        $data = $request->all();
        Ban::create($data);

        return response()->json([
            'status'    => 1,
            'message'   => 'New table added successfully!',
        ]);
    }

    public function changeStatus(CheckIdBanRequest $request)
    {
        $khu_vuc = Ban::find($request->id);
        $khu_vuc->status = !$khu_vuc->status;
        $khu_vuc->save();

        return response()->json([
            'status'    => 1,
            'message'   => 'Status changed successfully!',
        ]);
    }

    public function updateBan(UpdateBanRequest $request)
    {
        $data = $request->all();
        $danh_muc = Ban::where('id', $request->id)->first();

        $danh_muc->update($data);

        return response()->json([
            'status'    => 1,
            'message'   => 'Updated successfully!',
        ]);
    }

    public function deleteBan(CheckIdBanRequest $request)
    {
        $danh_muc = Ban::find($request->id);
        $ten_danh_muc = $danh_muc->name_category;
        $danh_muc->delete();

        return response()->json([
            'status'    => 1,
            'message'   => $ten_danh_muc .' category removed successfully!',
        ]);
    }
}
