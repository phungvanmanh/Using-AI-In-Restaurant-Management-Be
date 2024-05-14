<?php

namespace App\Http\Controllers;

use App\Models\MonAn;
use App\Models\ReViewMonAn;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReViewMonAnController extends Controller
{
    public function getData($id_mon_an)
    {
        $monAn = MonAn::find($id_mon_an);
        if (!$monAn) {
            return response()->json(['message' => 'Món ăn không tồn tại'], 404);
        }
        $reviews = ReViewMonAn::where('id_mon_an', $id_mon_an)
            ->join('khach_hangs', 're_view_mon_ans.id_khach_hang', '=', 'khach_hangs.id')
            ->select('re_view_mon_ans.*', 'khach_hangs.ten_khach_hang')
            ->get();
        return response()->json(['reviews' => $reviews], 200);
    }
    public function createReView(Request $request)
    {
        $user = Auth::guard('khach_hang')->user();
        if (!$user) {
            return response()->json(['message' => 'Không tìm thấy thông tin người dùng'], 404);
        }
        $idKhachHang = $user->id;
        if (!MonAn::find($request->id_mon_an)) {
            return response()->json(['message' => 'Món ăn không tồn tại'], 404);
        }
        $review = ReViewMonAn::create([
            'id_khach_hang' => $idKhachHang,
            'id_mon_an' => $request->id_mon_an,
            'binh_luan' => $request->binh_luan,
        ]);

        if ($review) {
            return response()->json([
                'status' => 1,
                'message' => 'Tạo đánh giá thành công'
            ]);
        } else {
            return response()->json(['message' => 'Không thể tạo đánh giá'], 500);
        }
    }
    // ReViewMonAnController.php
    public function deleteReView(Request $request)
    {
        $user = Auth::guard('khach_hang')->user();

        if (!$user) {
            return response()->json(['status' => 0, 'message' => 'Không tìm thấy thông tin người dùng'], 404);
        }

        $review = ReViewMonAn::find($request->id_danh_gia); // id_danh_gia là id của đánh giá cần xoá

        if (!$review) {
            return response()->json(['status' => 0, 'message' => 'Không tìm thấy đánh giá'], 404);
        }

        // Kiểm tra xem user có quyền xoá đánh giá không
        if ($review->id_khach_hang != $user->id) {
            return response()->json(['status' => 0, 'message' => 'Bạn không có quyền xoá đánh giá này'], 403);
        }

        // Xoá đánh giá
        $review->delete();

        return response()->json(['status' => 1, 'message' => 'Xoá đánh giá thành công']);
    }
}
