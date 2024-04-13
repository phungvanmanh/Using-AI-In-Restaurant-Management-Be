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
        return $this->createModel($request, DanhMuc::class, ['message' => 'New category added successfully!']);
    }

    public function changeStatus(CheckIdDanhMucRequest $request)
    {
        return $this->changeStatusOrUpdateModel($request, DanhMuc::class, 'changeStatus');
    }

    public function updateDanhMuc(UpdateDanhMucRequest $request)
    {
        return $this->changeStatusOrUpdateModel($request, DanhMuc::class, 'update');
    }

    public function deleteDanhMuc(CheckIdDanhMucRequest $request)
    {
        return $this->deleteModel($request, DanhMuc::class, 'name_category');
    }
    public function searchDanhMuc(Request $request)
    {


        $key = '%' . $request->abc . '%';

        $data   = DanhMuc::where('name_category', 'like', $key)
            ->get();

        return response()->json([
            'data'  =>  $data,
        ]);
    }
}
