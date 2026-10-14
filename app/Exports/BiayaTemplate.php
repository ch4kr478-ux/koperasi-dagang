<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BiayaTemplate implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [];
    }

    public function headings(): array
    {
        return [
            'name',
            'jenis_biaya (1=Debet, 2=Kredit)',
            'divisi_id'
        ];
    }
}
