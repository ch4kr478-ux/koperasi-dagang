<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PinjamanKreditTemplate implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [];
    }

    public function headings(): array
    {
        return [
            'Nomor',
            'Tanggal (DD-MM-YYYY)',
            'Jenis Pembayaran (1=Cash, 2=Bank)',
            'Keterangan',
            'NIK Anggota',
            'Nominal produk (harus sesuai produk)',
            'Tenor (bulan)',
            'Produk Pinjaman',
        ];
    }
}
