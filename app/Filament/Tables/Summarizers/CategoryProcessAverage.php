<?php

namespace App\Filament\Tables\Summarizers;

use App\Models\Category;
use Filament\Tables\Columns\Summarizers\Summarizer;

class CategoryProcessAverage extends Summarizer
{
    public function getState(): float
    {
        $categories = Category::query()
            ->whereIn('id', $this->getQuery()->select('id'))
            ->with(['subcategories', 'transactions'])
            ->get();

        if ($categories->isEmpty()) {
            return 0.0;
        }

        $percentages = $categories->map(function ($category) {
            $expected = $category->subcategories->sum('monthly_budgeted');

            if ($expected === 0) {
                return 0.0;
            }

            $actual = $category->transactions->sum('debit');
            $actual += $category->transactions->sum('credit');

            return floor(($actual / $expected) * 100) / 100;
        });

        return round($percentages->average(), 2);
    }

    public function getFormattedState(): string
    {
        return $this->getState() . '%';
    }
}
