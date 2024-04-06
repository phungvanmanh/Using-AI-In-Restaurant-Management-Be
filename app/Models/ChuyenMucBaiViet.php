<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChuyenMucBaiViet extends Model
{   
    use HasFactory;
    protected $table = "chuyen_muc_bai_viets";
    protected $fillable = [
        'ten_chuyen_muc',
        'slug_chuyen_muc',
        'tinh_trang',
    ];
}
