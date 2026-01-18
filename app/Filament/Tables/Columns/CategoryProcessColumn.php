<?php

namespace App\Filament\Tables\Columns;

use Filament\Tables\Columns\Column;

/**
 * @property Category $record
 */
class CategoryProcessColumn extends Column
{
    protected string $view = 'filament.tables.columns.category-process-column';

    public function getProcess(): string
    {
        $expected = $this->record->subcategories->sum('monthly_budgeted');
        if ($expected === 0) {
            return '0.0%';
        }
        $transactions = $this->record->transactions;

        $actual = $this->record->transactions->sum('debit');
        $actual += $this->record->transactions->sum('credit');
        $percent = floor(($actual / $expected) * 10000);


        return ($percent / 100) . '%';
    }
}
