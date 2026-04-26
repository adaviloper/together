<?php

namespace App\Filament\Resources\Transactions\Schemas;

use App\Models\Category;
use App\Models\Subcategory;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class TransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        try {
            return $schema
                ->components([
                    DatePicker::make('transaction_date')
                        ->required(),
                    DatePicker::make('posted_date')
                        ->required(),
                    TextInput::make('card_number')
                        ->required(),
                    TextInput::make('description')
                        ->required(),
                    Select::make('category_id')
                        ->label('Category')
                        ->options(Category::query()->pluck('name', 'id'))
                        ->live(),
                    Select::make('subcategory_id')
                        ->label('Subcategory')
                        ->options(fn (Get $get) => Subcategory::query()
                            ->where('category_id', $get('category_id'))
                            ->pluck('name', 'id')),
                    TextInput::make('debit')
                        ->required()
                        ->numeric(),
                    TextInput::make('credit')
                        ->required()
                        ->numeric(),
                ]);
        } catch (\Throwable $th) {
            dd($th, __METHOD__ . ':' . __LINE__);
        }
    }
}
