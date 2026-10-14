<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProdukPinjaman extends Model
{
    protected $table = 'produk_pinjaman';

    protected $fillable = [
        'name',
        'nominal',
        'description',
        'is_active',
    ];

    protected $casts = [
        'nominal' => 'integer',
        'is_active' => 'boolean',
    ];

    public function tenors()
    {
        return $this->hasMany(ProdukPinjamanTenor::class, 'produk_pinjaman_id');
    }
}
