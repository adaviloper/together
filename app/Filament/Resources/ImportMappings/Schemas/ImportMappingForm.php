<?php

namespace App\Filament\Resources\ImportMappings\Schemas;

use App\Models\Category;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ImportMappingForm
{
    public static function configure(Schema $schema): Schema
    {
        $subcategoryOptions = Category::query()
            ->orderBy('name')
            ->with('subcategories')
            ->get()
            ->mapWithKeys(fn (Category $category) => [
                $category->name => $category->subcategories->pluck('name', 'id')->toArray(),
            ])
            ->all();

        $users = auth()->user()
            ->organizations()
            ->with('users')
            ->first()->users->pluck('name', 'id');

        return $schema
            ->components([
                Select::make('subcategory_id')
                    ->options($subcategoryOptions)
                    ->searchable()
                    ->required(),
                Select::make('user_id')
                    ->options($users)
                    ->searchable()
                    ->required(),
                TextInput::make('source')
                    ->required(),
            ]);
    }
}
