<?php

namespace App\Filament\Tables\Summarizers;

use App\Models\Transaction;
use Carbon\Carbon;
use Filament\Tables\Columns\Summarizers\Summarizer;
use NumberFormatter;

class ActualTotalSum extends Summarizer
{
    protected ?int $month = null;

    protected ?int $year = null;

    public function month(int $month): static
    {
        $this->month = $month;
        return $this;
    }

    public function year(int $year): static
    {
        $this->year = $year;
        return $this;
    }

    public function getState(): int
    {
        $start = Carbon::create($this->year ?? now()->year, $this->month ?? now()->month)->startOfMonth();
        $end = $start->copy()->endOfMonth();

        return (int) Transaction::query()
            ->whereIn('category_id', $this->getQuery()->select('id'))
            ->whereBetween('transaction_date', [$start, $end])
            ->selectRaw('SUM(COALESCE(amount, 0)) as total')
            ->value('total');
    }

    public function formatState(mixed $state): string
    {
        return (new NumberFormatter('en_US', NumberFormatter::CURRENCY))
            ->formatCurrency($state / 100, 'USD');
    }
}
