<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KhachHang extends Model
{
    use HasFactory;
    protected $table = 'khach_hangs';
    protected $fillable = [
        'ten_khach_hang',
        'email_khach_hang',
        'so_dien_thoai',
        'DateofBirth',
        'rank_khach_hang',
        'history_khach_hang',
        'score_khach_hang',
    ];
}
