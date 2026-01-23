<?php

namespace App\Filament\Resources\Subcategories\Schemas;

use App\Models\Subcategory;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SubcategoryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('category.name')
                    ->label('Category'),
                TextEntry::make('name'),
                TextEntry::make('monthly_budgeted')
                    ->label('Monthly Budget')
                    ->money(divideBy: 100),
                TextEntry::make('split_strategy')
                    ->label('Split Strategy')
                    ->formatStateUsing(fn (Subcategory $record) => $record->split_strategy->label()),
                TextEntry::make('fixed_split_ratio')
                    ->label('Fixed Split Ratio')
                    ->formatStateUsing(fn (?float $state) => $state !== null ? ($state * 100) . '%' : '-')
                    ->visible(fn (Subcategory $record) => $record->split_strategy::key() === 'fixed'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
