<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NhanVien extends Model
{
    use HasFactory;
    protected $table = 'nhan_viens';
    protected $fillable = [
        'ho_ten',
        'so_dien_thoai',
        'ngay_sinh',
        'email',
        'ma_nv',
        'status',
    ];
}
