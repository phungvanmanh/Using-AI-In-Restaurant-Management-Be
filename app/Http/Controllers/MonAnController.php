<?php

namespace App\Http\Controllers;

use App\Http\Requests\MonAn\createMonAnRequest;
use App\Models\MonAn;
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
    public function deleteMonAn(Request $request)
    {
        // Tìm món ăn với id được cung cấp
        $monan = MonAn::find($request->id);

        // Kiểm tra nếu không tìm thấy món ăn
        if (!$monan) {
            // Trả về thông báo lỗi
            return response()->json([
                'status'  => 0,
                'message' => 'Không tìm thấy món ăn',
            ]);
        }

        // Lấy tên món ăn trước khi xóa
        $food_name = $monan->food_name;

        // Xóa món ăn
        $monan->delete();

        // Trả về thông báo thành công
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
}
