<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'admins';
    protected $fillable = [
        'first_last_name',
        'email',
        'phone_number',
        'date_birth',
        'password',
        'status',
        'id_permission',
    ];
}
