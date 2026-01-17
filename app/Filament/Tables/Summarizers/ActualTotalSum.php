<?php

namespace App\Filament\Tables\Summarizers;

use App\Models\Transaction;
use Filament\Tables\Columns\Summarizers\Summarizer;
use NumberFormatter;

class ActualTotalSum extends Summarizer
{
    public function getState(): int
    {
        // Sum all transactions' debit for categories in the query
        return Transaction::query()
            ->whereIn('category_id', $this->getQuery()->select('id'))
            ->sum('debit');
    }

    public function formatState(mixed $state): string
    {
        return (new NumberFormatter('en_US', NumberFormatter::CURRENCY))
            ->formatCurrency($state / 100, 'USD');
    }
}
