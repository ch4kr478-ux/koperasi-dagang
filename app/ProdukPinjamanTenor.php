<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProdukPinjamanTenor extends Model
{
    protected $table = 'produk_pinjaman_tenors';

    protected $fillable = [
        'produk_pinjaman_id',
        'lama_cicilan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function produk()
    {
        return $this->belongsTo(ProdukPinjaman::class, 'produk_pinjaman_id');
    }
}
