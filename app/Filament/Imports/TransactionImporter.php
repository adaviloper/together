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
                ->label('Posted Date')
                ->guess(['Posted Date', 'Date'])
                ->requiredMapping()
                ->fillRecordUsing(function (Transaction $record, string $state): void {
                    $record->transaction_date = Carbon::parse($state)->format('Y-m-d');
                })
                ->rules(['required', 'date']),

            ImportColumn::make('description')
                ->label('Description')
                ->guess([' Description', 'Transaction Description'])
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
                })
                ->rules(['required', 'max:255']),

            // For checking account format - single amount column
            ImportColumn::make('amount')
                ->label('Transaction Amount')
                ->rules(['numeric', 'nullable'])
                ->guess(['Debit', ' Amount', 'debit', 'amount'])
                ->fillRecordUsing(function (?string $state, array $data, Transaction $record): void {
                    $amount = $state ?? $data['credit'] ?? $data['Credit'];
                    if ($amount < 0) {
                        $amount *= -1;
                    }
                    $record->amount = (int) round((float) $amount * 100);
                })
            ,
        ];
    }

    public function resolveRecord(): ?Transaction
    {
        $mapping = ImportMapping::query()
            ->firstOrCreate([
                'source' => $this->data['description'],
                'user_id' => auth()->id(),
                'organization_id' => $this->options['organization_id'],
            ]);
        if ($mapping->skip) {
            return null;
        }
        return new Transaction([
            'user_id' => auth()->id(),
            'organization_id' => $this->options['organization_id'],
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
