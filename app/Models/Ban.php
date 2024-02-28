<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ban extends Model
{
    use HasFactory;
    protected $table = "bans";
    protected $fillable = [
        'name_table',
        'slug_table',
        'id_area',
        'status',
        'is_open_table',
    ];
}
