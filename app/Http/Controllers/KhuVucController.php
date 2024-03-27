<?php

namespace App\Http\Controllers;

use App\Http\Requests\KhuVuc\CheckIdKhuVucRequest;
use App\Http\Requests\KhuVuc\CreateKhuVucRequest;
use App\Http\Requests\KhuVuc\UpdateKhuVucRequest;
use App\Models\DanhMuc;
use App\Models\KhuVuc;
use Illuminate\Http\Request;

class KhuVucController extends Controller
{
    public function getDataKhuVuc()
    {
        $data = KhuVuc::get();
        return response()->json([
            'data'   => $data,
        ]);
    }

    public function createKhuVuc(CreateKhuVucRequest $request)
    {
        return $this->createModel($request, KhuVuc::class, ['message' => 'New area added successfully!']);
    }

    public function changeStatus(CheckIdKhuVucRequest $request)
    {
        return $this->changeStatusOrUpdateModel($request, KhuVuc::class, 'changeStatus');
    }

    public function updateKhuVuc(UpdateKhuVucRequest $request)
    {
        return $this->changeStatusOrUpdateModel($request, KhuVuc::class, 'update');
    }

    public function deleteKhuVuc(CheckIdKhuVucRequest $request)
    {
        return $this->deleteModel($request, DanhMuc::class, 'name_area');
    }
}
