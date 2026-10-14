<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProdukPinjamanTemplate implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [];
    }

    public function headings(): array
    {
        return [
            'Nama Produk',
            'Nominal',
            'Keterangan',
            'Tenor (bulan, pisahkan dengan koma)',
            'Aktif (1=Ya, 0=Tidak)',
        ];
    }
}
