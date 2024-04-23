<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietHoaDonNhap extends Model
{
    use HasFactory;
    protected $table = "chi_tiet_hoa_don_nhaps";
    protected $fillable=[
        'id_nguyen_lieu',
        'id_hoa_don_nhap',
        'so_luong',
        'don_gia',
        'thanh_tien',
        // 'ghi_chu',
        'is_done',
    ];
}
