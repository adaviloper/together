<?php

namespace App\Filament\Resources\Subcategories\RelationManagers;

use App\Filament\Resources\ImportMappings\ImportMappingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class ImportMappingsRelationManager extends RelationManager
{
    protected static string $relationship = 'importMappings';

    protected static ?string $relatedResource = ImportMappingResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
