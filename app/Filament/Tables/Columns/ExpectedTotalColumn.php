<?php

namespace App\Filament\Tables\Columns;

use App\Models\Category;
use App\Models\Transaction;
use Closure;
use Filament\Support\Enums\Alignment;
use Filament\Tables\Columns\Column;
use NumberFormatter;

/**
 * @property Category $record
 */
class ExpectedTotalColumn extends Column
{
    protected string $view = 'filament.tables.columns.expected-total-column';

    public function getState(): int
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

    public function getAlignment(): string
    {
        return 'start';
    }
}
