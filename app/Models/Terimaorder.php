<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terimaorder extends Model
{
    use HasFactory;

    protected $table = 'tb_penugasan_driver';
    protected $primaryKey = 'id_penugasan';
    protected $fillable = [
        'no_order',
        'id_driver',
        'id_kendaraan',
        'id_petugas',
        'tgl_penugasan',
        'jam_berangkat',
        'penjemputan',
        'tujuan',
        'kembali',
        'jml_penumpang'
    ];
    public $timestamps = false;
}
