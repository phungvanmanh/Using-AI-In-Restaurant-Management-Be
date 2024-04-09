<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoaDonBanHang extends Model
{
    use HasFactory;
    protected  $table='hoa_don_ban_hangs';
    protected $fillable=[
        'tong_tien_truoc_giam',
        'phan_tram_giam',
        'tien_thuc_nhan',
        'ghi_chu',
        'id_ban',
        'is_done',
    ];
}
