<?php

namespace Tests\Unit;

use App\Support\PinjamanCalculator;
use PHPUnit\Framework\TestCase;

class PinjamanCalculatorTest extends TestCase
{
    public function test_it_calculates_flat_interest_and_savings_with_remainder_in_last_installment()
    {
        $schedule = PinjamanCalculator::schedule(1000, 3, '2026-01-15');

        $this->assertCount(3, $schedule);
        $this->assertSame([333, 333, 334], array_column($schedule, 'pokok'));
        $this->assertSame([10, 10, 10], array_column($schedule, 'bunga'));
        $this->assertSame([5, 5, 5], array_column($schedule, 'tabungan'));
        $this->assertSame([348, 348, 349], array_column($schedule, 'total'));
        $this->assertSame(1000, array_sum(array_column($schedule, 'pokok')));
    }

    public function test_it_clamps_monthly_due_date_to_the_last_day_of_shorter_months()
    {
        $schedule = PinjamanCalculator::schedule(1200, 2, '2026-01-31');

        $this->assertSame('2026-02-28', $schedule[0]['jatuh_tempo']->format('Y-m-d'));
        $this->assertSame('2026-03-31', $schedule[1]['jatuh_tempo']->format('Y-m-d'));
    }

    public function test_it_returns_an_empty_schedule_for_non_positive_inputs()
    {
        $this->assertSame([], PinjamanCalculator::schedule(0, 3, '2026-01-15'));
        $this->assertSame([], PinjamanCalculator::schedule(1000, 0, '2026-01-15'));
    }
}
