<?php

namespace Tests\Unit;

use App\Support\PinjamanInstallmentPayment;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class PinjamanInstallmentPaymentTest extends TestCase
{
    public function test_it_parses_manual_installment_and_saving_amounts(): void
    {
        $amounts = app(PinjamanInstallmentPayment::class)->parseAmounts([
            'nominal_pinjaman' => 'Rp. 1.250.000',
            'nominal_bunga' => 'Rp. 25.000',
            'nominal_simpanan_pokok' => 'Rp. 0',
            'nominal_simpanan_wajib' => 'Rp. 50.000',
            'nominal_simpanan_sukarela' => '125.000',
        ]);

        $this->assertSame([
            'pokok' => 1250000,
            'bunga' => 25000,
            'simpanan_pokok' => 0,
            'simpanan_wajib' => 50000,
            'simpanan_sukarela' => 125000,
        ], $amounts);
    }

    public function test_it_rejects_partial_installment_amounts(): void
    {
        $this->expectException(ValidationException::class);

        app(PinjamanInstallmentPayment::class)->assertMatchesSchedule(
            ['pokok' => 100000, 'bunga' => 10000],
            ['pokok' => 50000, 'bunga' => 10000]
        );
    }

    public function test_it_accepts_a_full_scheduled_installment_with_zero_savings(): void
    {
        $amounts = app(PinjamanInstallmentPayment::class)->parseAmounts([
            'nominal_pinjaman' => 'Rp. 100.000',
            'nominal_bunga' => 'Rp. 10.000',
            'nominal_simpanan_pokok' => 'Rp. 0',
            'nominal_simpanan_wajib' => 'Rp. 0',
            'nominal_simpanan_sukarela' => 'Rp. 0',
        ]);

        app(PinjamanInstallmentPayment::class)->assertMatchesSchedule(
            ['pokok' => 100000, 'bunga' => 10000],
            $amounts
        );

        $this->assertSame(0, $amounts['simpanan_wajib']);
    }

    public function test_it_rejects_invalid_or_negative_saving_amounts(): void
    {
        $this->expectException(ValidationException::class);

        app(PinjamanInstallmentPayment::class)->parseAmounts([
            'nominal_pinjaman' => 'Rp. 100.000',
            'nominal_bunga' => 'Rp. 10.000',
            'nominal_simpanan_pokok' => 'Rp. -1',
            'nominal_simpanan_wajib' => 'Rp. 0',
            'nominal_simpanan_sukarela' => 'Rp. 0',
        ]);
    }
}
