<?php

namespace App\Http\Controllers;

use App\Http\Requests\Quyen\CheckIdQuyenRequest;
use App\Http\Requests\Quyen\CreateQuyenRequest;
use App\Http\Requests\Quyen\UpdateQuyenRequest;
use App\Models\Admin;
use App\Models\ChucNang;
use App\Models\Quyen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuyenController extends Controller
{
    public function getDataQuyen()
    {
        $x = $this->checkRule(10);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'data'      => [],
            ]);
        }
        $data = Quyen::get();
        return response()->json([
            'data'   => $data,
        ]);
    }

    public function createQuyen(CreateQuyenRequest $request)
    {
        $x = $this->checkRule(9);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'You are not authorized!',
            ]);
        }
                $data = $request->all();
        Quyen::create($data);

        return response()->json([
            'status'    => 1,
            'message'   => 'New permissions have been added successfully!',
        ]);
    }

    public function changeStatus(CheckIdQuyenRequest $request)
    {
        $x = $this->checkRule(11);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'You are not authorized!',
            ]);
        }
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
        $x = $this->checkRule(12);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'You are not authorized!',
            ]);
        }
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
        $x = $this->checkRule(13);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'You are not authorized!',
            ]);
        }
        $quyen = Quyen::find($request->id);
        $ten_quyen = $quyen->name_permission;
        $quyen->delete();

        return response()->json([
            'status'    => 1,
            'message'   => 'Permission removed'. $ten_quyen .' success!'
        ]);
    }

    public function getQuyenUser(Request $request) {
        $user  = Auth::guard('admin')->user()->id;
        $quyen = Admin::where('admins.id', $user)->join("quyens", 'admins.id_permission', 'quyens.id')->select('admins.id', 'admins.first_last_name', 'quyens.name_permission')->first();
        return response()->json([
            'status'    => 1,
            'data'   => $quyen,
        ]);
    }

    public function getDataChucNang() {
        $data = ChucNang::get();
        return response()->json([
            'data' => $data
        ]);
    }

    public function phanQuyen(Request $request)
    {
        $quyen            =  Quyen::find($request->id_quyen);
        $list_id_function =  implode(",", $request->list_phan_quyen);

        $quyen->update([
            'list_id_function' => $list_id_function
        ]);

        return response()->json([
            'status'  => true,
            'message' => "Updated permissions for " . $quyen->name_permission . " successfullyg!",
        ]);
    }
}
