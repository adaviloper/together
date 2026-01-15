<?php

namespace App\Filament\Imports;

use App\Models\Category;
use App\Models\ImportMapping;
use App\Models\Subcategory;
use App\Models\Transaction;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
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
                ->rules(['required', 'date']),
            ImportColumn::make('posted_date')
                ->label('Posted Date')
                ->requiredMapping()
                ->rules(['required', 'date']),
            ImportColumn::make('card_number')
                ->label('Card No.')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('description')
                ->label('Description')
                ->requiredMapping()
                ->fillRecordUsing(function (string $state, array $data, Model $record): void {
                    $mapping = ImportMapping::query()
                        ->firstOrCreate([
                            'source' => $data['description'],
                        ]);

                    $record->subcategory_id = $mapping->subcategory_id;
                    $record->category_id = $mapping->subcategory?->category_id;
                    $record->description = $state;
                })
                ->rules(['required', 'max:255']),
            ImportColumn::make('debit')
                ->label('Debit')
                ->requiredMapping()
                ->fillRecordUsing(function (Transaction $transaction, ?float $state): void {
                    if ($state) {
                        $transaction->debit = $state * 100;
                    } else {
                        $transaction->debit = null;
                    }
                })
                ->rules(['numeric', 'nullable']),
            ImportColumn::make('credit')
                ->label('Credit')
                ->requiredMapping()
                ->fillRecordUsing(function (Transaction $transaction, ?float $state): void {
                    if ($state) {
                        $transaction->credit = $state * 100;
                    } else {
                        $transaction->credit = null;
                    }
                })
                ->rules(['numeric', 'nullable']),
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
