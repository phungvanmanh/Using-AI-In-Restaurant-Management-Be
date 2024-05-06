<?php

namespace App\Http\Controllers;

use App\Models\HoaDonBanHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ThongKecontroller extends Controller
{
    public function getDataThongKe1(Request $request)
    {
        $data = HoaDonBanHang::where('is_done', 1)
            ->whereDate('created_at', '>=', $request->begin)
            ->whereDate('created_at', '<=', $request->end)
            ->select(
                DB::raw("SUM(tien_thuc_nhan) as total"),
                DB::raw("DATE_FORMAT(created_at,'%d/%m/%Y') as label")
            )
            ->groupBy('label')
            ->get();

        $list_label = [];
        $list_data = [];

        foreach ($data as $item) {
            $list_data[] = $item->total;
            $list_label[] = $item->label;
        }

        return response()->json([
            'list_label' => $list_label,
            'list_data' => $list_data,
        ]);
    }

}
