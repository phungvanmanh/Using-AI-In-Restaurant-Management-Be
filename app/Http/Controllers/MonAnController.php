<?php

namespace App\Http\Controllers;

use App\Http\Requests\MonAn\createMonAnRequest;
use App\Models\DanhMuc;
use App\Models\MonAn;
use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonAnController extends Controller
{

    public function createMonAn(createMonAnRequest $request)
    {
        $x = $this->checkRule(28);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyền',
            ]);
        }
        $data = $request->all();
        MonAn::create($data);

        return response()->json([
            'status'    => 1,
            'message'   => 'Successfully added new dishes',
        ]);
    }
    public function getDataMonAn()
    {
        $x = $this->checkRule(29);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyền',
            ]);
        }
        // Join the tables and select required fields
        $data = MonAn::join('danh_mucs', 'mon_ans.id_category', '=', 'danh_mucs.id')
            ->select('mon_ans.*', 'danh_mucs.name_category', 'danh_mucs.status as category_status')
            ->get();

        foreach ($data as $item) {
            $monAn = MonAn::find($item->id);
            $danhMuc = DanhMuc::find($item->id_category);

            if ($danhMuc->status == 0 && $monAn->status != 0) {
                $monAn->status = 0;
                $monAn->save();
            } else if($danhMuc->status == 1 && $monAn->status != 1) {
                $monAn->status = 1;
                $monAn->save();
            }
        }

        $updatedData = MonAn::join('danh_mucs', 'mon_ans.id_category', '=', 'danh_mucs.id')
            ->select('mon_ans.*', 'danh_mucs.name_category')
            ->get();

        return response()->json([
            'data' => $updatedData,
        ]);
    }


    public function getDataMonAnToken($token)
    {
        $check = Token::where('token', $token)->first();
        if ($check) {
            $data = MonAn::join('danh_mucs', 'mon_ans.id_category', 'danh_mucs.id')
                ->select('mon_ans.*', 'danh_mucs.name_category')
                ->get();
            return response()->json([
                'data'   => $data,
            ]);
        }

        return response()->json([
            'status'    => false,
        ]);
    }

    public function deleteMonAn(Request $request)
    {
        $x = $this->checkRule(32);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyền',
            ]);
        }
        $monan = MonAn::find($request->id);

        if (!$monan) {
            return response()->json([
                'status'  => 0,
                'message' => 'Food not found',
            ]);
        }
        $food_name = $monan->food_name;
        $monan->delete();
        return response()->json([
            'status'  => 1,
            'message' => 'Item removed ' . $food_name . ' successful',
        ]);
    }

    public function changeStatus(Request $request)
    {
        $x = $this->checkRule(30);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyền',
            ]);
        }
        $monan = MonAn::find($request->id);
        $monan->status = !$monan->status;
        $monan->save();

        return response()->json([
            'status'    => 1,
            'message'   => 'Successfully restated',
        ]);
    }
    public function updateMonAn(Request $request)
    {
        $x = $this->checkRule(31);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyền',
            ]);
        }
        $data = $request->all();
        $quyen = MonAn::where('id', $request->id)->first();

        $quyen->update($data);

        return response()->json([
            'status'    => 1,
            'message'   => 'Successfully updated',
        ]);
    }
    public function searchMonAn(Request $request)
    {
        $key = '%' . $request->abc . '%';
        $data   = MonAn::where('food_name', 'like', $key)
            ->get();
        return response()->json([
            'data'  =>  $data,
        ]);
    }

    public function getMonTheoID(Request $request)
    {
        $id = $request->input('id');
        if (!$id) {
            return response()->json([
                'status'    => 0,
                'message'   => 'No ID provided',
            ]);
        }
        $danhMuc = DanhMuc::find($id);
        if (!$danhMuc) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Category not found',
            ]);
        }
        $monAn = MonAn::where('id_category', $id)->get();
        return response()->json([
            'status'    => 1,
            'monAn'     => $monAn,
        ]);
    }

    public function getMonAnPhoBien()
    {
        $monAnPhoBien = MonAn::join('chi_tiet_hoa_don_ban_hangs', 'mon_ans.id', '=', 'chi_tiet_hoa_don_ban_hangs.id_mon_an')
            ->select(
                'mon_ans.id',
                'mon_ans.food_name',
                'mon_ans.status',
                'mon_ans.price',
                'mon_ans.image',
                DB::raw('SUM(chi_tiet_hoa_don_ban_hangs.so_luong) as total_sold')
            )
            ->groupBy('mon_ans.id', 'mon_ans.food_name', 'mon_ans.status', 'mon_ans.price', 'mon_ans.image')
            ->orderBy('total_sold', 'DESC')
            ->take(8) // Lấy ra chỉ 12 món
            ->get();

        return response()->json([
            'status' => true,
            'data' => $monAnPhoBien
        ], 200);
    }




}
