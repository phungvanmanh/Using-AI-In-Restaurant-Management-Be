<?php

namespace App\Http\Controllers;

use App\Http\Requests\Quyen\CheckIdQuyenRequest;
use App\Http\Requests\Quyen\CreateQuyenRequest;
use App\Http\Requests\Quyen\UpdateQuyenRequest;
use App\Models\Quyen;
use Illuminate\Http\Request;

class QuyenController extends Controller
{
    public function getDataQuyen()
    {
        $data = Quyen::get();
        return response()->json([
            'data'   => $data,
        ]);
    }

    public function createQuyen(CreateQuyenRequest $request)
    {
        $data = $request->all();
        Quyen::create($data);

        return response()->json([
            'status'    => 1,
            'message'   => 'New permissions have been added successfully!',
        ]);
    }

    public function changeStatus(CheckIdQuyenRequest $request)
    {
        $admin = Quyen::find($request->id);
        $admin->tinh_trang = !$admin->tinh_trang;
        $admin->save();

        return response()->json([
            'status'    => 1,
            'message'   => 'Status changed successfully!',
        ]);
    }

    public function updateQuyen(UpdateQuyenRequest $request)
    {
        $data = $request->all();
        $quyen = Quyen::where('id', $request->id)->first();

        $quyen->update($data);

        return response()->json([
            'status'    => 1,
            'message'   => 'Updated successfully!',
        ]);
    }

    public function deleteQuyen(CheckIdQuyenRequest $request)
    {
        $quyen = Quyen::find($request->id);
        $ten_quyen = $quyen->name_permission;
        $quyen->delete();

        return response()->json([
            'status'    => 1,
            'message'   => 'Permission removed'. $ten_quyen .' success!'
        ]);
    }
}
