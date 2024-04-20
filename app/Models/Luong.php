<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Luong extends Model
{
    use HasFactory;
    protected $table = "luongs";
    protected $fillable = [
        'id_nhan_vien',
        'so_buoi_lam',
        'hoa_hong',
        'tong_luong',
        'ngay_nhan_luong',
        'is_nhan',
    ];
}
