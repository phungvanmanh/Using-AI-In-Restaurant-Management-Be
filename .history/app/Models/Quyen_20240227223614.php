<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quyen extends Model
{
    use HasFactory;
    protected $table = 'quyens';
    protected $fillable = [
        'name_permission',
        'status',
        'list_id_function',
    ];
}
