<?php

namespace App\Filament\Resources\ImportMappings\RelationManagers;

use App\Filament\Resources\Transactions\TransactionResource;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class TransactionsRelationManager extends RelationManager
{
    protected static string $relationship = 'transactions';

    protected static ?string $relatedResource = TransactionResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->filters([
                TrashedFilter::make()->default('with'),
            ]);
    }
}
