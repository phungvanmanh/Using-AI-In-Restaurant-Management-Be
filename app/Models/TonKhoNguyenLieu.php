<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TonKhoNguyenLieu extends Model
{
    use HasFactory;

    protected $table = "ton_kho_nguyen_lieus";
    protected $fillable = [
        'id_nguyen_lieu',
        'so_luong',
        'so_luong_ton',
        'ngay',
    ];
}
