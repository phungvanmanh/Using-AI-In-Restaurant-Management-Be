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
            return response()->json(['message' => 'The dish does not exist'], 404);
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
            return response()->json(['message' => 'User information not found'], 404);
        }
        $idKhachHang = $user->id;
        if (!MonAn::find($request->id_mon_an)) {
            return response()->json(['message' => 'The dish does not exist'], 404);
        }
        $review = ReViewMonAn::create([
            'id_khach_hang' => $idKhachHang,
            'id_mon_an' => $request->id_mon_an,
            'binh_luan' => $request->binh_luan,
        ]);

        if ($review) {
            return response()->json([
                'status' => 1,
                'message' => 'Create a success review'
            ]);
        } else {
            return response()->json(['message' => 'Can not create reviews'], 500);
        }
    }
    // ReViewMonAnController.php
    public function deleteReView(Request $request)
    {
        $user = Auth::guard('khach_hang')->user();

        if (!$user) {
            return response()->json(['status' => 0, 'message' => 'User information not found'], 404);
        }

        $review = ReViewMonAn::find($request->id_danh_gia); // id_danh_gia là id của đánh giá cần xoá

        if (!$review) {
            return response()->json(['status' => 0, 'message' => 'No reviews found'], 404);
        }

        // Kiểm tra xem user có quyền xoá đánh giá không
        if ($review->id_khach_hang != $user->id) {
            return response()->json(['status' => 0, 'message' => 'You do not have permission to delete this review'], 403);
        }

        // Xoá đánh giá
        $review->delete();

        return response()->json(['status' => 1, 'message' => 'Delete a success review']);
    }
}
