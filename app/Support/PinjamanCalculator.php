<?php

namespace App\Support;

class PinjamanCalculator
{
    public static function schedule($amount, $months, $loanDate, $interestPercent = 1, $savingsPercent = 0.5)
    {
        $amount = (int) $amount;
        $months = (int) $months;

        if ($amount <= 0 || $months <= 0) {
            return [];
        }

        $loanDate = $loanDate instanceof \DateTimeInterface
            ? \DateTimeImmutable::createFromInterface($loanDate)
            : new \DateTimeImmutable($loanDate);
        $loanDay = (int) $loanDate->format('j');
        $basePrincipal = intdiv($amount, $months);
        $remainingPrincipal = $amount;
        $schedule = [];

        for ($month = 1; $month <= $months; $month++) {
            $monthDate = $loanDate
                ->modify('first day of this month')
                ->modify('+' . $month . ' months');
            $dueDate = $monthDate->setDate(
                (int) $monthDate->format('Y'),
                (int) $monthDate->format('n'),
                min($loanDay, (int) $monthDate->format('t'))
            );
            $principal = $month === $months
                ? $remainingPrincipal
                : min($basePrincipal, $remainingPrincipal);
            $remainingPrincipal -= $principal;
            $interest = (int) round($amount * ($interestPercent / 100));
            $savings = (int) round($amount * ($savingsPercent / 100));

            $schedule[] = [
                'bulan' => $month,
                'jatuh_tempo' => $dueDate,
                'pokok' => $principal,
                'bunga' => $interest,
                'tabungan' => $savings,
                'total' => $principal + $interest + $savings,
            ];
        }

        return $schedule;
    }
}
