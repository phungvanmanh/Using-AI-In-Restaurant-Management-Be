<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaiViet1 extends Model
{
    use HasFactory;
    protected $table='bai_viet1s';
    protected $fillable=[
        'tieu_de_bai_viet',
        'slug_bai_viet',
        'hinh_anh_bai_viet',
        'mo_ta_ngan_bai_viet',
        'mo_ta_chi_tiet_bai_viet',
        'id_chuyen_muc_bai_viet',
        'tinh_trang',
    ];
}
