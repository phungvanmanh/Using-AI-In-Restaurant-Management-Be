<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ban\CheckIdBanRequest;
use App\Http\Requests\Ban\CreateBanRequest;
use App\Http\Requests\Ban\UpdateBanRequest;
use App\Models\Ban;

class BanController extends Controller
{
    public function getDataBan()
    {
        $data = Ban::join('khu_vucs', 'khu_vucs.id', 'bans.id_area')
                    ->select('bans.*', 'khu_vucs.name_area')
                    ->get();
        return response()->json([
            'data'   => $data,
        ]);
    }

    public function createBan(CreateBanRequest $request)
    {
        return $this->createModel($request, Ban::class, ['message' => 'New table added successfully!']);
    }

    public function changeStatus(CheckIdBanRequest $request)
    {
        return $this->changeStatusOrUpdateModel($request, Ban::class, 'changeStatus');
    }

    public function updateBan(UpdateBanRequest $request)
    {
        return $this->changeStatusOrUpdateModel($request, Ban::class, 'update');
    }

    public function deleteBan(CheckIdBanRequest $request)
    {
        return $this->deleteModel($request, Ban::class, 'name_table');
    }
}
