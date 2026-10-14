<?php

namespace App\Imports;

use App\TransaksiHarian;
use Maatwebsite\Excel\Concerns\ToModel;
use Tanggal;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\TransaksiHarianAnggota;
use App\Anggota;
use App\TransaksiHarianBiaya;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\TransaksiPinjaman;
use App\ProdukPinjaman;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;


class PinjamanKredit implements ToCollection, WithStartRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    protected $periode;
	protected $anggota;

    public function __construct($periode)
    {
        $this->periode = $periode;
    }

    public function startRow(): int
    {
        return 2;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            $produkPinjaman = ProdukPinjaman::where('name', $row[7])
                ->where('is_active', true)
                ->where('nominal', '>', 0)
                ->firstOrFail();
            $transaksiHarian = TransaksiHarian::create([
                'divisi_id' => '2',
                'tgl' => Tanggal::transformDate($row[1]),
                'jenis_pembayaran' => $row[2],
                'keterangan' => $row[3],
                'jenis_transaksi' => '2',
                'periode_id' => $this->periode->id,
            ]);
            $this->anggota = Anggota::select()->where('nik', '=', $row[4])->value('id');
            TransaksiHarianAnggota::create([
                'transaksi_harian_id' => $transaksiHarian->id,
                'anggota_id' => $this->anggota,
            ]);
            $transaksi_biaya = TransaksiHarianBiaya::create([
                'transaksi_harian_id' => $transaksiHarian->id,
                'biaya_id' => '8',
                'nominal' => $produkPinjaman->nominal
            ]);

            TransaksiPinjaman::create([
                'transaksi_harian_biaya_id' => $transaksi_biaya->id,
                'lama_cicilan' => $row[6],
                'produk_pinjaman_id' => $produkPinjaman->id,
                'produk_pinjaman_nama' => $produkPinjaman->name,
                'bunga_persen' => 1,
                'tabungan_persen' => 0.5,
            ]);
        }
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            foreach ($validator->getData() as $index => $row) {
                $product = ProdukPinjaman::where('name', $row[7] ?? null)
                    ->where('is_active', true)
                    ->first();

                if ($product) {
                    if (!$product->nominal || $product->nominal <= 0) {
                        $validator->errors()->add($index . '.7', 'Nominal produk pinjaman belum diatur.');
                    } elseif ((int) preg_replace('/\D/', '', (string) ($row[5] ?? '')) !== (int) $product->nominal) {
                        $validator->errors()->add($index . '.5', 'Nominal pada baris ini harus sama dengan nominal produk pinjaman.');
                    }

                    if (!$product->tenors()
                        ->where('lama_cicilan', $row[6] ?? null)
                        ->where('is_active', true)
                        ->exists()) {
                        $validator->errors()->add($index . '.6', 'Tenor tidak tersedia untuk produk pinjaman pada baris ini.');
                    }
                }
            }
        });
    }

    public function rules(): array
    {
        return [
            '0' => 'required',

            // Above is alias for as it always validates in batches
            '*.0' => 'required',

            '1' => 'required',

            // Above is alias for as it always validates in batches
            '*.1' => 'required',

            '2' => 'required',

            // Above is alias for as it always validates in batches
            '*.2' => 'required',
            '3' => 'required',

            // Above is alias for as it always validates in batches
            '*.3' => 'required',

            '4' => 'required',

            // Above is alias for as it always validates in batches
            '*.4' => 'required',
            '5' => 'required',

            // Above is alias for as it always validates in batches
            '*.5' => 'required',

            '6' => 'required',

            // Above is alias for as it always validates in batches
            '*.6' => 'required|integer|min:1|max:600',

            '7' => ['required', Rule::exists('produk_pinjaman', 'name')->where('is_active', true)],

            // Above is alias for as it always validates in batches
            '*.7' => ['required', Rule::exists('produk_pinjaman', 'name')->where('is_active', true)],
        ];
    }
}
