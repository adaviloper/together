<?php

namespace App\Filament\Tables\Summarizers;

use App\Models\Subcategory;
use Filament\Tables\Columns\Summarizers\Summarizer;
use NumberFormatter;

class ExpectedTotalSum extends Summarizer
{
    public function getState(): int
    {
        // Sum all subcategories' monthly_budgeted directly
        // This avoids N+1 queries
        return Subcategory::query()
            ->whereIn('category_id', $this->getQuery()->select('id'))
            ->sum('monthly_budgeted');
    }

    public function formatState(mixed $state): string
    {
        return (new NumberFormatter('en_US', NumberFormatter::CURRENCY))
            ->formatCurrency($state / 100, 'USD');
    }
}
