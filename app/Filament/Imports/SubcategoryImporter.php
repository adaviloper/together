<?php

namespace App\Filament\Imports;

use App\Models\Subcategory;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

class SubcategoryImporter extends Importer
{
    protected static ?string $model = Subcategory::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('category')
                ->requiredMapping()
                ->relationship(resolveUsing: 'name')
                ->rules(['required']),
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('monthly_budgeted')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('split_strategy')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('fixed_split_ratio')
                ->numeric()
                ->ignoreBlankState()
                ->rules(['nullable', 'integer']),
        ];
    }

    public function resolveRecord(): Subcategory
    {
        return Subcategory::firstOrNew([
            'name' => $this->data['name'],
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your subcategory import has completed and ' . Number::format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
