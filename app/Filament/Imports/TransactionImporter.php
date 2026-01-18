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

            ImportColumn::make('card_number')
                ->label('Card/Account Number')
                ->guess(['Card No.', 'Account Number'])
                ->requiredMapping()
                ->rules(['required', 'max:255']),

            ImportColumn::make('description')
                ->label('Description')
                ->guess(['Description', 'Transaction Description'])
                ->requiredMapping()
                ->fillRecordUsing(function (string $state, array $data, Transaction $record): void {
                    $mapping = ImportMapping::query()
                        ->firstOrCreate(['source' => $state]);

                    $record->subcategory_id = $mapping->subcategory_id;
                    $record->category_id = $mapping->subcategory?->category_id;
                    $record->description = $state;
                })
                ->rules(['required', 'max:255']),

            // For credit card format - separate debit/credit columns
            ImportColumn::make('debit')
                ->label('Debit')
                ->fillRecordUsing(function (Transaction $record, ?float $state): void {
                    if ($state) {
                        $record->debit = abs($state) * 100;
                    }
                })
                ->rules(['numeric', 'nullable']),

            ImportColumn::make('credit')
                ->label('Credit')
                ->fillRecordUsing(function (Transaction $record, ?float $state): void {
                    if ($state) {
                        $record->credit = abs($state) * 100;
                    }
                })
                ->rules(['numeric', 'nullable']),

            // For checking account format - single amount column
            ImportColumn::make('transaction_amount')
                ->label('Transaction Amount')
                ->fillRecordUsing(function (Transaction $record, ?float $state, array $data): void {
                    if ($state === null) {
                        return;
                    }

                    $type = strtolower($data['transaction_type'] ?? '');

                    if ($type === 'debit' || $state < 0) {
                        $record->debit = abs($state) * 100;
                    } else {
                        $record->credit = abs($state) * 100;
                    }
                })
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
