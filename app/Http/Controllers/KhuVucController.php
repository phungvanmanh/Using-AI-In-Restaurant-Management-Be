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
        $x = $this->checkRule(24);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'data'   => [],
            ]);
        }
        $data = KhuVuc::get();
        return response()->json([
            'data'   => $data,
        ]);
    }

    public function createKhuVuc(CreateKhuVucRequest $request)
    {
        $x = $this->checkRule(23);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyền',
            ]);
        }
        return $this->createModel($request, KhuVuc::class, ['message' => 'New area added successfully!']);
    }

    public function changeStatus(CheckIdKhuVucRequest $request)
    {
        $x = $this->checkRule(27);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyền',
            ]);
        }
        return $this->changeStatusOrUpdateModel($request, KhuVuc::class, 'changeStatus');
    }

    public function updateKhuVuc(UpdateKhuVucRequest $request)
    {
        $x = $this->checkRule(25);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyền',
            ]);
        }
        return $this->changeStatusOrUpdateModel($request, KhuVuc::class, 'update');
    }

    public function deleteKhuVuc(CheckIdKhuVucRequest $request)
    {
        $x = $this->checkRule(26);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyền',
            ]);
        }
        return $this->deleteModel($request, KhuVuc::class, 'name_area');
    }

    function getDataStaffArea(Request $request) {
        $data = KhuVuc::where('id', $request->id)->select('list_admin')->first();
        return response()->json([
            'status'    => 1,
            'data'   => $data->list_admin,
        ]);
    }
}
