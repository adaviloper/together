<?php

namespace App\Filament\Resources\Categories\RelationManagers;

use App\Filament\Resources\Subcategories\SubcategoryResource;
use App\Models\Subcategory;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class SubcategoryRelationManager extends RelationManager
{
    protected static string $relationship = 'subcategories';

    protected static ?string $relatedResource = SubcategoryResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
