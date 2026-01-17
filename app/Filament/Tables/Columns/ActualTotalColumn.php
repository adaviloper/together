<?php

namespace App\Filament\Tables\Columns;

use Filament\Tables\Columns\Column;
use NumberFormatter;

/**
 * @property Category $record
 */
class ActualTotalColumn extends Column
{
    protected string $view = 'filament.tables.columns.expected-total-column';

    public function getExpectedTotal(): string
    {
        return $this->money($this->record->transactions->sum('debit'));
    }

    public function money(int $total): string
    {
        return (new NumberFormatter('en_US', \NumberFormatter::CURRENCY))
            ->formatCurrency($total / 100, 'USD');
    }
}
