<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonAn extends Model
{
    use HasFactory;
    protected $table = 'mon_ans';
    protected $fillable = [
        'food_name',
        'price',
        'status',
        'total_input',
        'total_ouput',
        'id_category'
    ];
}
