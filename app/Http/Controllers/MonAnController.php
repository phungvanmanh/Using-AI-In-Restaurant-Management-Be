<?php

namespace App\Http\Controllers;

use App\Http\Requests\MonAn\createMonAnRequest;
use App\Models\DanhMuc;
use App\Models\MonAn;
use App\Models\Token;
use Illuminate\Http\Request;

class MonAnController extends Controller
{

    public function createMonAn(createMonAnRequest $request)
    {
        $data = $request->all();
        MonAn::create($data);

        return response()->json([
            'status'    => 1,
            'message'   => 'Đã thêm mới món ăn thành công',
        ]);
    }
    public function getDataMonAn()
    {
        $data = MonAn::join('danh_mucs', 'mon_ans.id_category', 'danh_mucs.id')
            ->select('mon_ans.*', 'danh_mucs.name_category')
            ->get();
        return response()->json([
            'data'   => $data,
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
        $monan = MonAn::find($request->id);

        if (!$monan) {
            return response()->json([
                'status'  => 0,
                'message' => 'Không tìm thấy món ăn',
            ]);
        }
        $food_name = $monan->food_name;
        $monan->delete();
        return response()->json([
            'status'  => 1,
            'message' => 'Đã xóa món ' . $food_name . ' thành công',
        ]);
    }

    public function changeStatus(Request $request)
    {
        $monan = MonAn::find($request->id);
        $monan->status = !$monan->status;
        $monan->save();

        return response()->json([
            'status'    => 1,
            'message'   => 'Đã đổi trạng thái thành công',
        ]);
    }
    public function updateMonAn(Request $request)
    {
        $data = $request->all();
        $quyen = MonAn::where('id', $request->id)->first();

        $quyen->update($data);

        return response()->json([
            'status'    => 1,
            'message'   => 'Đã cập nhật thành công',
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
                'message'   => 'Không có ID được cung cấp',
            ]);
        }
        $danhMuc = DanhMuc::find($id);
        if (!$danhMuc) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Không tìm thấy danh mục',
            ]);
        }
        $monAn = MonAn::where('id_category', $id)->get();
        return response()->json([
            'status'    => 1,
            'monAn'     => $monAn,
        ]);
    }


}
