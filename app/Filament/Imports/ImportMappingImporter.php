<?php

namespace App\Filament\Imports;

use App\Models\ImportMapping;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

class ImportMappingImporter extends Importer
{
    protected static ?string $model = ImportMapping::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('subcategory')
                ->relationship(resolveUsing: 'name'),
            ImportColumn::make('source')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('skip')
                ->requiredMapping()
                ->boolean()
                ->rules(['required', 'boolean']),
        ];
    }

    public function resolveRecord(): ImportMapping
    {
        return ImportMapping::firstOrNew(
            [
                'source' => $this->data['source'],
            ],
            [
                'user_id' => auth()->id(),
            ]
        );
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your import mapping import has completed and ' . Number::format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
