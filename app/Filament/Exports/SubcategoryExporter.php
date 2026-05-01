<?php

namespace App\Filament\Exports;

use App\Models\Subcategory;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class SubcategoryExporter extends Exporter
{
    protected static ?string $model = Subcategory::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('category.name'),
            ExportColumn::make('name'),
            ExportColumn::make('monthly_budgeted'),
            ExportColumn::make('split_strategy'),
            ExportColumn::make('fixed_split_ratio'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your subcategory export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
