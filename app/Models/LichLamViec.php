<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LichLamViec extends Model
{
    use HasFactory;
    protected $table = 'lich_lam_viecs';

    protected $fillable = [
        'id_nhan_vien',
        'buoi_lam_viec',
        'ngay_lam_viec',
        'is_done',
        'gio_bat_dau',
        'gio_ket_thuc',
    ];
}
