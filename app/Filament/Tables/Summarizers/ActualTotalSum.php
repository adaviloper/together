<?php

namespace App\Filament\Tables\Summarizers;

use App\Models\Transaction;
use Filament\Tables\Columns\Summarizers\Summarizer;
use NumberFormatter;

class ActualTotalSum extends Summarizer
{
    public function getState(): int
    {
        return (int) Transaction::query()
            ->whereIn('category_id', $this->getQuery()->select('id'))
            ->selectRaw('SUM(CASE WHEN debit IS NOT NULL THEN debit ELSE COALESCE(credit, 0) END) as total')
            ->value('total');
    }

    public function formatState(mixed $state): string
    {
        return (new NumberFormatter('en_US', NumberFormatter::CURRENCY))
            ->formatCurrency($state / 100, 'USD');
    }
}
