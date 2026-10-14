<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PengajuanPinjamanKredit extends Model
{
    protected $table = 'pengajuan_pinjaman_kredit';

    protected $fillable = [
        'user_id',
        'anggota_id',
        'nominal',
        'lama_cicilan',
        'keterangan',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function anggota()
    {
        return $this->belongsTo('App\Anggota');
    }

    public function transaksiHarian()
    {
        return $this->belongsTo('App\TransaksiHarian', 'transaksi_harian_id');
    }
}
