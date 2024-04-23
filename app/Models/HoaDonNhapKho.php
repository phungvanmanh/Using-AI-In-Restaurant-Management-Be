<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoaDonNhapKho extends Model
{
    use HasFactory;
    protected $table="hoa_don_nhap_khos";
    protected $fillable=[
        'ma_hoa_don',
        'tong_tien',
        'id_nhan_vien',
        'id_nha_cung_cap',
        'ngay_nhap',
        'ghi_chu'
    ];
}
