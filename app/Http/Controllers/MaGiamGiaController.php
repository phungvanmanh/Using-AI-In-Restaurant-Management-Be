<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMaGiamGiaRequest;
use App\Http\Requests\UpdateMaGiamGiaRequest;
use App\Models\MaGiamGia;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;

class MaGiamGiaController extends Controller
{
    public function createMaGiamGia(CreateMaGiamGiaRequest $request)
    {
        $x = $this->checkRule(96);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyền',
            ]);
        }
        return $this->createModel($request, MaGiamGia::class, ['message' => 'Successfully generated code!']);
    }
    public function getdulieu()
    {
        $x = $this->checkRule(97);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'data'      => [],
            ]);
        }
        $data = MaGiamGia::join('mon_ans', 'mon_ans.id', 'ma_giam_gias.id_mon')
            ->select('ma_giam_gias.*', 'mon_ans.food_name')
            ->get();
        return response()->json([
            'data'   => $data,
        ]);
    }
    public function changesMaGiamGia(Request $request)
    {
        $x = $this->checkRule(98);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyền',
            ]);
        }
        return $this->changeStatusOrUpdateModel($request, MaGiamGia::class, 'changeStatus');
    }
    public function updateMaGiamGia(UpdateMaGiamGiaRequest $request)
    {
        $x = $this->checkRule(99);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyền',
            ]);
        }
        return $this->changeStatusOrUpdateModel($request, MaGiamGia::class, 'update');
    }
    public function deleteMaGiamGia(Request $request)
    {
        $x = $this->checkRule(100);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyền',
            ]);
        }
        return $this->deleteModel($request, MaGiamGia::class, 'ma_giam_gia');
    }
}
