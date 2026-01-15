<?php

namespace App\Filament\Resources\Subcategories\Schemas;

use App\Models\Category;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SubcategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->label('Category')
                    ->options(Category::query()->pluck('name', 'id')),
                TextInput::make('name')
                    ->required(),
            ]);
    }
}
