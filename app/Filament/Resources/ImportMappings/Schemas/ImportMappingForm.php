<?php

namespace App\Filament\Resources\ImportMappings\Schemas;

use App\Models\Category;
use App\Models\Subcategory;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class ImportMappingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('subcategory_id')
                    ->relationship('subcategory', 'name')
                    ->required(),
                TextInput::make('source')
                    ->required(),
            ]);
    }
}
