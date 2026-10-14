<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    //

    protected $fillable = [
        'nama',
        'nik',
        'jabatan',
        'tgl_daftar',
        'status',
        'homebase'
    ];
}
