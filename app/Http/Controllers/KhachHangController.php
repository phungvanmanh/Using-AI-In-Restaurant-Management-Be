<?php

namespace App\Http\Controllers;

use App\Models\KhachHang;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateKhachHang;
use Illuminate\Http\Request;

class KhachHangController extends Controller
{
    public function getdata()
    {
        $data = KhachHang::get();
        return response()->json([
            'data'   => $data,
        ]);
    }
    public function createKhachHang(CreateKhachHang $request)
    {
        $data = $request->all();
        KhachHang::create($data);

        return response()->json([
            'status'    => 1,
            'message'   => 'New customer added successfully!',
        ]);
    }
    public function updateKhachHang(Request $request)
    {
        $data = $request->all();
        $khach_hang = KhachHang::where('id', $request->id)->first();

        $khach_hang->update($data);

        return response()->json([
            'status'    => 1,
            'message'   => 'Updated successfully!',
        ]);
    }
    public function deleteKhachHang(Request $request)
    {
        $khach_hang = KhachHang::find($request->id);
        $ten_khach_hang = $khach_hang->ten_khach_hang;
        $khach_hang->delete();

        return response()->json([
            'status'    => 1,
            'message'   => $ten_khach_hang .' removed successfully!',
        ]);
    }
    public function searchKhachHang(Request $request)
{
    // Lấy từ khóa tìm kiếm từ request
    $keyword = $request->input('keyword');

    // Tìm kiếm khách hàng có tên hoặc số điện thoại chứa từ khóa tìm kiếm
    $data = KhachHang::where('ten_khach_hang', 'LIKE', "%$keyword%")
                             ->orWhere('so_dien_thoai', 'LIKE', "%$keyword%")
                             ->get();

    // Trả về kết quả tìm kiếm dưới dạng JSON
    return response()->json([
        'status'    => 1,
        'data'      => $data,
    ]);
}
}
