<?php

namespace App\Http\Controllers;
use App\Http\Requests\createNguyenLieu;
use App\Http\Requests\Chec;
use App\Models\NguyenLieu;
use Illuminate\Http\Request;

class NguyenLieuController extends Controller
{
    public function themNguyenLieu(createNguyenLieu $request)
{
    NguyenLieu::create([
        'ten_nguyen_lieu'       =>$request->ten_nguyen_lieu,
        'slug_nguyen_lieu'      =>$request->slug_nguyen_lieu,
        'so_luong'      =>$request->so_luong,
        'gia'       =>$request->gia,
        'don_vi_tinh'       =>$request->don_vi_tinh,
        'tinh_trang'    =>$request->tinh_trang,
    ]);
    return response()->json([
        'status' =>true,
        'message'=>'đã tạo mới nguyên liệu thành công'
    ]);
}
    public function getNguyenLieu()
    {
        $data=NguyenLieu::select('id','ten_nguyen_lieu','slug_nguyen_lieu','so_luong','gia','don_vi_tinh','tinh_trang')->get();
        return response()->json([
            'data'=>$data,
        ]);
    }
    public function capnhatNguyenLieu(Request $request)
    {
        try {
            NguyenLieu::where('id',$request->id)
            ->update([
                        'ten_nguyen_lieu'       =>$request->ten_nguyen_lieu,
                        'slug_nguyen_lieu'      =>$request->slug_nguyen_lieu,
                        'so_luong'      =>$request->so_luong,
                        'gia'       =>$request->gia,
                        'don_vi_tinh'       =>$request->don_vi_tinh,
                        'tinh_trang'    =>$request->tinh_trang,
            ]);
            return response()->json([
                'status' =>true,
                'message'=>'đã update nguyên liệu thành công'
            ]);
        } catch (Exception $e) {
            Log::info("Lỗi",$e);
            return response()->json([
                'status' =>false,
                'message'=>'đã có lỗi'
            ]);
        }
    }
    public function doiTrangThai(Request $request)
    {
       try{
            if($request->tinh_trang==1){
                $tinh_trang_moi=0;
            }else{
                $tinh_trang_moi=1;
            }
            NguyenLieu::where('id',$request->id)
                ->update([
                    'tinh_trang'=>$tinh_trang_moi,
                ]);
             return response()->json([
                'status' =>true,
                 'message'=>'đã  đổi trạng thái thành công'
            ]);
        } catch (Exception $e) {
            Log::info("Lỗi",$e);
            return response()->json([
                'status' =>false,
                'message'=>'đã có lỗi'
            ]);
       }

    }
    public function deleteNguyenLieu(CheckidNguyenLieu $request)
    {
        // Tìm món ăn với id được cung cấp
        $tennguyenlieu = NguyenLieu::find($request->id);

        // Lấy tên món ăn trước khi xóa
        $ten_nguyen_lieu = $tennguyenlieu->ten_nguyen_lieu;

        return $this->deleteModel($request, NguyenLieu::class, 'ten_nguyen_lieu', 'Đã xóa món ' . $ten_nguyen_lieu . ' thành công!',);
    }
}
