<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NguyenLieu extends Model
{
    use HasFactory;
    protected $table='nguyen_lieus';
    protected $fillable=[
        'ten_nguyen_lieu',
        'slug_nguyen_lieu',
        'so_luong',
        'gia',
        'don_vi_tinh',
        'tinh_trang',
    ];
}
