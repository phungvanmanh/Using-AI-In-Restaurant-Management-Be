<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReViewMonAn extends Model
{
    use HasFactory;
    protected $table ='re_view_mon_ans';
    protected $fillable=[
        'id_khach_hang',
        'id_mon_an',
        'binh_luan',
    ];
}
