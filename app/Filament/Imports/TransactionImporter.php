<?php

namespace App\Filament\Imports;

use App\Models\ImportMapping;
use App\Models\Transaction;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Carbon;
use Illuminate\Support\Number;

class TransactionImporter extends Importer
{
    protected static ?string $model = Transaction::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('transaction_date')
                ->label('Transaction Date')
                ->requiredMapping()
                ->fillRecordUsing(function (Transaction $record, string $state): void {
                    $record->transaction_date = Carbon::parse($state)->format('Y-m-d');
                })
                ->rules(['required', 'date']),

            ImportColumn::make('description')
                ->label('Description')
                ->guess(['Description', 'Transaction Description'])
                ->requiredMapping()
                ->fillRecordUsing(function (string $state, array $data, Transaction $record): void {
                    $mapping = ImportMapping::query()
                        ->firstOrCreate([
                            'source' => $state,
                            'user_id' => auth()->id(),
                        ]);

                    $record->subcategory_id = $mapping->subcategory_id;
                    $record->category_id = $mapping->subcategory?->category_id;
                    $record->description = $state;
                    $record->hidden = (bool)$mapping->hidden;
                })
                ->rules(['required', 'max:255']),

            // For checking account format - single amount column
            ImportColumn::make('amount')
                ->label('Transaction Amount')
                ->rules(['numeric', 'nullable']),

            // Capture transaction type for logic but don't store it
            ImportColumn::make('transaction_type')
                ->label('Transaction Type')
                ->fillRecordUsing(fn () => null)
                ->rules(['nullable']),
        ];
    }

    public function resolveRecord(): Transaction
    {
        return new Transaction([
            'user_id' => auth()->id(),
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your transaction import has completed and ' . Number::format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
