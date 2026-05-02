<?php

namespace App\Filament\Tables\Columns;

use App\Models\Category;
use App\Models\Transaction;
use Filament\Tables\Columns\Column;

/**
 * @property Category $record
 */
class CategoryProcessColumn extends Column
{
    protected string $view = 'filament.tables.columns.category-process-column';

    public function getProcess(): string
    {
        $expected = match ($this->record::class) {
            Category::class => $this->record->subcategories->sum('monthly_budgeted'),
            Transaction::class => $this->record->amount,
            default => 0,
        };

        if ($expected === 0) {
            return '0.0%';
        }

        $transactions = match ($this->record::class) {
            Category::class => $this->record->transactions,
            Transaction::class => $this->record,
            default => 0,
        };

        $actual = match ($this->record::class) {
            Category::class => $this->record->transactions->sum('amount'),
            Transaction::class => $this->record->amount,
            default => 0,
        };
        ;


        $percent = floor(($actual / $expected) * 10000);


        return ($percent / 100) . '%';
    }
}
