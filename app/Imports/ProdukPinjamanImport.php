<?php

namespace App\Imports;

use App\ProdukPinjaman;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProdukPinjamanImport implements ToCollection, WithStartRow, WithValidation, SkipsEmptyRows
{
    public function startRow(): int
    {
        return 2;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $product = ProdukPinjaman::create([
                'name' => trim((string) $row[0]),
                'nominal' => $row[1],
                'description' => empty($row[2]) ? null : trim((string) $row[2]),
                'is_active' => (int) $row[4] === 1,
            ]);

            $tenors = preg_split('/[,;\s]+/', trim((string) $row[3]), -1, PREG_SPLIT_NO_EMPTY);
            foreach ($tenors as $months) {
                $product->tenors()->create([
                    'lama_cicilan' => (int) $months,
                    'is_active' => true,
                ]);
            }
        }
    }

    public function rules(): array
    {
        return [
            '*.0' => ['required', 'string', 'max:255', Rule::unique('produk_pinjaman', 'name')],
            '*.1' => 'required|integer|min:1|max:999999999999999999',
            '*.2' => 'nullable|string',
            '*.3' => 'required|string',
            '*.4' => 'required|in:0,1',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $names = [];

            foreach ($validator->getData() as $index => $row) {
                $name = mb_strtolower(trim((string) ($row[0] ?? '')));
                if ($name !== '' && isset($names[$name])) {
                    $validator->errors()->add($index . '.0', 'Nama produk tidak boleh berulang dalam file.');
                } else {
                    $names[$name] = true;
                }

                $tenorValue = trim((string) ($row[3] ?? ''));
                $tenors = preg_split('/[,;\s]+/', $tenorValue, -1, PREG_SPLIT_NO_EMPTY);
                if ($tenorValue === '' || implode(',', $tenors) !== preg_replace('/[,;\s]+/', ',', $tenorValue)) {
                    $validator->errors()->add($index . '.3', 'Tenor harus berupa angka bulan yang dipisahkan koma, titik koma, atau spasi.');
                    continue;
                }

                $normalizedTenors = [];
                foreach ($tenors as $months) {
                    if (!ctype_digit($months) || (int) $months < 1 || (int) $months > 600) {
                        $validator->errors()->add($index . '.3', 'Setiap tenor harus berupa angka antara 1 sampai 600 bulan.');
                        continue 2;
                    }

                    if (isset($normalizedTenors[(int) $months])) {
                        $validator->errors()->add($index . '.3', 'Tenor dalam satu produk tidak boleh berulang.');
                        continue 2;
                    }

                    $normalizedTenors[(int) $months] = true;
                }
            }
        });
    }
}
