<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class Petugas  extends  Authenticatable implements JWTSubject 
{
    use HasFactory, Notifiable;

    protected $table = "tb_petugas";
    public $timestamps = false;
    protected $primaryKey = 'id_petugas';

    protected $fillable = [
        // 'name',
        // 'email',
        // 'password',
        'nama_lengkap',
        'user',
        'password',
        // 'id_petugas',
        // 'no_ktp',
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
