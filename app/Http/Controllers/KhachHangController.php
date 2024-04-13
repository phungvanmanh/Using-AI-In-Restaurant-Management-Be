<?php

namespace App\Http\Controllers;

use App\Models\HoaDonBanHang;
use App\Models\KhachHang;
use Illuminate\Http\Request;

class KhachHangController extends Controller
{

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ten_khach_hang'    => 'required|string|max:255',
            'email_khach_hang'  => 'required|email|max:255',
            'so_dien_thoai'     => 'required|max:10',
            'id_hoa_don'        => 'required|exists:hoa_don_ban_hangs,id',
        ]);

        $khach_hang = KhachHang::firstOrCreate(
            [
                'email_khach_hang' => $validated['email_khach_hang'],
            ],
            [
                'ten_khach_hang'   => $validated['ten_khach_hang'],
                'so_dien_thoai'    => $validated['so_dien_thoai'],
            ]
        );

        $hoa_don = HoaDonBanHang::find($request->id_hoa_don);

        if (!$hoa_don) {
            return response()->json(['error' => 'HoaDonBanHang not found'], 404);
        }

        $hoa_don->id_khach_hang = $khach_hang->id;
        $hoa_don->save();

        return response()->json(['message' => 'Operation successful'], 201);
    }


}
