<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaksiPinjamanCicilan extends Model
{
    protected $table = 'transaksi_pinjaman_cicilans';

    protected $fillable = [
        'transaksi_pinjaman_id',
        'transaksi_harian_id',
        'simpanan_transaksi_harian_id',
        'angsuran_ke',
        'jatuh_tempo',
        'pokok',
        'bunga',
        'tabungan',
    ];

    protected $casts = [
        'jatuh_tempo' => 'date',
        'pokok' => 'integer',
        'bunga' => 'integer',
        'tabungan' => 'integer',
    ];

    public function pinjaman()
    {
        return $this->belongsTo(TransaksiPinjaman::class, 'transaksi_pinjaman_id');
    }

    public function transaksiHarian()
    {
        return $this->belongsTo(TransaksiHarian::class, 'transaksi_harian_id');
    }

    public function transaksiSimpanan()
    {
        return $this->belongsTo(TransaksiHarian::class, 'simpanan_transaksi_harian_id');
    }
}
