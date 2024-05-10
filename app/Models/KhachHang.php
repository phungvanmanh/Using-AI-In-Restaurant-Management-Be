<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class KhachHang extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $table = "khach_hangs";
    protected $fillable = [
        'ten_khach_hang',
        'email',
        'so_dien_thoai',
        'otp',
        'password'
    ];

    protected $hidden = [
        'password',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
