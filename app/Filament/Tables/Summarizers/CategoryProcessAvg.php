<?php

namespace App\Filament\Tables\Summarizers;

use App\Models\Subcategory;
use App\Models\Transaction;
use Filament\Tables\Columns\Summarizers\Summarizer;

class CategoryProcessAvg extends Summarizer
{
    public function getState(): float
    {
        $categoryIds = $this->getQuery()->select('id');

        $expected = Subcategory::query()
            ->whereIn('category_id', $categoryIds)
            ->sum('monthly_budgeted');

        if ($expected === 0) {
            return 0.0;
        }

        $actual = Transaction::query()
            ->whereIn('category_id', $categoryIds)
            ->sum('debit');

        $actual += Transaction::query()
            ->whereIn('category_id', $categoryIds)
            ->sum('credit');

        return floor(($actual / $expected) * 100) / 100;
    }

    public function getFormattedState(): string
    {
        return $this->getState() . '%';
    }
}
