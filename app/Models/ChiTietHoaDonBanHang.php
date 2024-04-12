<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietHoaDonBanHang extends Model
{
    use HasFactory;
    protected $table='chi_tiet_hoa_don_ban_hangs';
    protected $fillable=[
        'id_hoa_don',
        'id_mon_an',
        'so_luong',
        'don_gia',
        'thanh_tien',
        'phan_tram_giam',
        'is_done',
        'ghi_chu',
    ];
}
