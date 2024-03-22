<?php

namespace App\Http\Controllers;
use App\Http\Requests\KhachHang\CheckIdKhachHangRequest;

use App\Models\KhachHang;
use Illuminate\Http\Request;

class KhachHangController extends Controller
{
    // LoadDb User
    public function getData()
    {
        $data = KhachHang::all();
        return response()->json([
            'data' => $data
        ]);
    }// LoadDb User

    //Delete User 
    public function DeleteKhachHang(CheckIdKhachHangRequest $request)
    {
        $khach_hang = KhachHang::find($request->id);
        $ten_khach_hang = $khach_hang->name_category;
        $khach_hang->delete();
        return response()->json([
            'status' => 1,
            'message' => $ten_khach_hang .'removed successfully!',
        ]);
    }//Delete User 

}
