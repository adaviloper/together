<?php

namespace App\Filament\Tables\Columns;

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
        return $this->record->subcategories->sum('monthly_budgeted');
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
