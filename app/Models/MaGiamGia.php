<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaGiamGia extends Model
{
    use HasFactory;
    protected $table='ma_giam_gias';
    protected $fillable=[
        'ma_giam_gia',
        'id_mon',
        'phan_tram_giam',
        'ngay_bat_dau',
        'ngay_ket_thuc',
        'status',
    ];
}
