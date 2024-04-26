<?php

namespace App\Http\Controllers;

use App\Exports\KhachHangExport;
use App\Models\HoaDonBanHang;
use App\Models\KhachHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

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

    public function getData()
    {
        $data = KhachHang::get();
        return response()->json([
            'status'    => true,
            'data'   => $data,
        ]);
    }

    public function updateKh(Request $request)
    {
        return $this->changeStatusOrUpdateModel($request, KhachHang::class, 'update');
    }

    public function deleteKh(Request $request)
    {
        return $this->deleteModel($request, KhachHang::class, 'ten_khach_hang');
    }

    public function export()
    {
        $data = KhachHang::get();
        Log::info('Exporting data:', $data->toArray());
        return Excel::download(new KhachHangExport($data), 'khachhang.xlsx');
    }
}
