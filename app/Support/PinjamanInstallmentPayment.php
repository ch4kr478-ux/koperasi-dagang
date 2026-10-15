<?php

namespace App\Support;

use Illuminate\Validation\ValidationException;

class PinjamanInstallmentPayment
{
    public function parseAmounts(array $values): array
    {
        return [
            'pokok' => $this->parseAmount($values['nominal_pinjaman'], 'nominal_pinjaman'),
            'bunga' => $this->parseAmount($values['nominal_bunga'], 'nominal_bunga'),
            'simpanan_pokok' => $this->parseAmount($values['nominal_simpanan_pokok'], 'nominal_simpanan_pokok'),
            'simpanan_wajib' => $this->parseAmount($values['nominal_simpanan_wajib'], 'nominal_simpanan_wajib'),
            'simpanan_sukarela' => $this->parseAmount($values['nominal_simpanan_sukarela'], 'nominal_simpanan_sukarela'),
        ];
    }

    public function assertMatchesSchedule(array $installment, array $amounts): void
    {
        $errors = [];
        if ($amounts['pokok'] !== (int) $installment['pokok']) {
            $errors['nominal_pinjaman'] = 'Nominal pokok harus sama dengan jadwal angsuran: '
                . \Money::stringToRupiah($installment['pokok']) . '.';
        }
        if ($amounts['bunga'] !== (int) $installment['bunga']) {
            $errors['nominal_bunga'] = 'Nominal bunga harus sama dengan jadwal angsuran: '
                . \Money::stringToRupiah($installment['bunga']) . '.';
        }

        if ($errors) {
            throw ValidationException::withMessages($errors);
        }
    }

    private function parseAmount($value, $field): int
    {
        if (!preg_match('/^\s*(?:Rp\.?\s*)?(\d+|\d{1,3}(?:\.\d{3})+)\s*$/', (string) $value, $matches)) {
            throw ValidationException::withMessages([
                $field => 'Nominal harus berupa angka rupiah non-negatif.',
            ]);
        }

        $digits = ltrim(str_replace('.', '', $matches[1]), '0') ?: '0';
        $amount = filter_var($digits, FILTER_VALIDATE_INT);
        if ($amount === false || $amount < 0) {
            throw ValidationException::withMessages([
                $field => 'Nominal berada di luar batas yang dapat disimpan.',
            ]);
        }

        return $amount;
    }
}
