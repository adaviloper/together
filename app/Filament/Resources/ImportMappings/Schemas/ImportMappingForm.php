<?php

namespace App\Filament\Resources\ImportMappings\Schemas;

use App\Models\Category;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Text;
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

        return $schema
            ->components([
                Select::make('subcategory_id')
                    ->options($subcategoryOptions)
                    ->searchable()
                    ->required(),
                TextInput::make('source')
                    ->required(),
            ]);
    }
}
