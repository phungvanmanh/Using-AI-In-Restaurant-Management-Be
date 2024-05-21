<?php

namespace App\Http\Controllers;

use App\Models\TonKhoNguyenLieu;
use Illuminate\Http\Request;

class TonKhoNguyenLieuController extends Controller
{
    public function getdataTonkho()
    {
        $x = $this->checkRule(94);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'data'      => [],
            ]);
        }
        $data = TonKhoNguyenLieu::join('nguyen_lieus','nguyen_lieus.id','ton_kho_nguyen_lieus.id_nguyen_lieu')
        ->select('ton_kho_nguyen_lieus.*','nguyen_lieus.ten_nguyen_lieu')
        ->get();
        return response()->json([
            'status'    => true,
            'data'   => $data,
        ]);
    }
    public function updateTonKho(Request $request)
    {
        $x = $this->checkRule(95);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'You are not authorized!',
            ]);
        }
        // First, validate the request to ensure necessary data is present and correct
        $validatedData = $request->validate([
            'id' => 'required|integer|exists:ton_kho_nguyen_lieus,id', // Check if the ID exists in the database
            'so_luong_ton' => 'required|numeric|min:0', // Ensure the provided value is numeric and non-negative
        ]);

        try {
            // Update the record
            TonKhoNguyenLieu::where('id', $validatedData['id'])->update([
                'so_luong' => $validatedData['so_luong_ton'], // Set so_luong to the same value as so_luong_ton
                'so_luong_ton' => $validatedData['so_luong_ton'], // Update so_luong_ton with the validated value
            ]);

            // Return a successful response
            return response()->json([
                'status' => true,
                'message' => 'Successfully updated'
            ]);
        } catch (\Exception $e) {
            // Handle any exceptions and return an error response
            return response()->json([
                'status' => false,
                'message' => 'Update failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
