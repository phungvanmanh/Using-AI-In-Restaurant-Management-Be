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
        // $x = $this->checkRule(65);
        // if($x)  {
        //     return response()->json([
        //         'status'    => 0,
        //         'data'      => [],
        //     ]);
        // }
        $data = DanhMuc::get();
        return response()->json([
            'data'   => $data,
        ]);
    }
    public function getDataDanhMucCustomer()
    {
        $data = DanhMuc::get();
        return response()->json([
            'data'   => $data,
        ]);
    }

    public function createDanhMuc(createDanhMucRequest $request)
    {
        $x = $this->checkRule(17);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'You are not authorized!',
            ]);
        }
        return $this->createModel($request, DanhMuc::class, ['message' => 'New category added successfully!']);
    }

    public function changeStatus(CheckIdDanhMucRequest $request)
    {
        $x = $this->checkRule(18);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'You are not authorized!',
            ]);
        }
        return $this->changeStatusOrUpdateModel($request, DanhMuc::class, 'changeStatus');
    }

    public function updateDanhMuc(UpdateDanhMucRequest $request)
    {
        $x = $this->checkRule(20);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'You are not authorized!',
            ]);
        }
        return $this->changeStatusOrUpdateModel($request, DanhMuc::class, 'update');
    }

    public function deleteDanhMuc(CheckIdDanhMucRequest $request)
    {
        $x = $this->checkRule(21);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'You are not authorized!',
            ]);
        }
        return $this->deleteModel($request, DanhMuc::class, 'name_category');
    }
    public function searchDanhMuc(Request $request)
    {
        $x = $this->checkRule(22);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'You are not authorized!',
            ]);
        }

        $key = '%' . $request->abc . '%';

        $data   = DanhMuc::where('name_category', 'like', $key)
            ->get();

        return response()->json([
            'data'  =>  $data,
        ]);
    }
}
