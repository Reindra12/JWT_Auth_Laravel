<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Tymon\JWTAuth\Contracts\JWTSubject;


class Driver extends  Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $table = "tb_driver";
    public $timestamps = false;
    protected $primaryKey = 'id_driver';

    protected $fillable = [
        // 'name',
        // 'email',
        // 'password',
        'nama_driver',
        'User',
        'password',
        'id_driver',
        'no_ktp',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }   
}
