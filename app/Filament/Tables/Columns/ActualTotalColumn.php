<?php

namespace App\Filament\Tables\Columns;

use App\Models\Category;
use App\Models\Transaction;
use Filament\Tables\Columns\Column;
use NumberFormatter;

/**
 * @property Category $record
 */
class ActualTotalColumn extends Column
{
    protected string $view = 'filament.tables.columns.expected-total-column';

    public function getState(): string
    {
        return match ($this->record::class) {
            Category::class => $this->record->subcategories->sum('monthly_budgeted'),
            Transaction::class => $this->record->amount,
            default => 0,
        };
    }

    public function getExpectedTotal(): string
    {
        return $this->money($this->getState());
    }

    public function money(int $total): string
    {
        return (new NumberFormatter('en_US', \NumberFormatter::CURRENCY))
            ->formatCurrency($total / 100, 'USD');
    }
}
