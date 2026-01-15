<?php

namespace App\Filament\Resources\Transactions\Schemas;

use App\Models\Transaction;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TransactionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('transaction_date')
                    ->date(),
                TextEntry::make('posted_date')
                    ->date(),
                TextEntry::make('card_number'),
                TextEntry::make('description'),
                TextEntry::make('category_id')
                    ->numeric(),
                TextEntry::make('subcategory_id')
                    ->numeric(),
                TextEntry::make('debit')
                    ->numeric(),
                TextEntry::make('credit')
                    ->numeric(),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Transaction $record): bool => $record->trashed()),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
