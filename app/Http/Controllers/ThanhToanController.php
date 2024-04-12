<?php

namespace App\Http\Controllers;

use App\Models\HoaDonBanHang;
use App\Models\ThanhToan;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ThanhToanController extends Controller
{

    public function fetchHistory()
    {
        $client = new Client();
        $response = $client->request('GET', 'https://api.zenpn.com/api/historyviettelpay/66127844c994168d28fb6debe5d7d334');
        $data = json_decode($response->getBody()->getContents());
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $payment = ThanhToan::firstOrCreate(
            ['code' => $request->code],
            [
                'so_tien' => $request->so_tien,
                'noi_dung' => $request->noi_dung,
            ]
        );
        //wasRecentlyCreated => true/false
        if ($payment->wasRecentlyCreated) {
            return response()->json([
                'status' => 1,
                'message' => "Successfully paid!"
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'message' => "Invoice has been paid"
            ]);
        }
    }
}
