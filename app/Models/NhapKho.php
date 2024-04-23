<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NhapKho extends Model
{
    use HasFactory;
    protected $table="nhap_khos";
    protected $fillable=[
                'id_nguyen_lieu',
                'so_luong',
                'don_gia',
                'thanh_tien',
                'id_hoa_don_nhap_kho',
                'id_nhan_vien',
    ];
}
