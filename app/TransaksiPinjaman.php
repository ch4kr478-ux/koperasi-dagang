<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaksiPinjaman extends Model
{
    //

    protected $fillable = [
        'transaksi_harian_biaya_id',
        'lama_cicilan',
        'produk_pinjaman_id',
        'produk_pinjaman_nama',
        'bunga_persen',
        'tabungan_persen',
    ];
    
    public function transaksi_harian_biaya()
    {
        return $this->belongsTo(TransaksiHarianBiaya::class, 'transaksi_harian_biaya_id');
    }

    public function produk_pinjaman()
    {
        return $this->belongsTo(ProdukPinjaman::class, 'produk_pinjaman_id');
    }

    public function cicilanTerbayar()
    {
        return $this->hasMany(TransaksiPinjamanCicilan::class, 'transaksi_pinjaman_id');
    }
}
