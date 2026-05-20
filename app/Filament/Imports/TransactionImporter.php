<?php

namespace App\Filament\Imports;

use App\Models\Transaction;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

class TransactionImporter extends Importer
{
    protected static ?string $model = Transaction::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('transaction_date')
                ->requiredMapping()
                ->rules(['required', 'date']),
            ImportColumn::make('description')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('category')
                ->relationship(resolveUsing: 'name'),
            ImportColumn::make('subcategory')
                ->relationship(resolveUsing: 'name'),
            ImportColumn::make('user')
                ->requiredMapping()
                ->relationship(resolveUsing: 'name')
                ->rules(['required']),
            ImportColumn::make('amount')
                ->numeric()
                ->rules(['integer']),
        ];
    }

    public function resolveRecord(): Transaction
    {
        return Transaction::firstOrNew([
            'transaction_date' => $this->data['transaction_date'],
            'description' => $this->data['description'],
            'amount' => $this->data['amount'],
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

    protected function beforeCreate(): void
    {
        $this->record['organization_id'] = session('current_organization_id');
        \Log::debug('import row:', [
            'data' => $this->record,
            'org_id' => session('current_organization_id'),
            'line' => __METHOD__ . ':' . __LINE__
        ]);
    }
}
