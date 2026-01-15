<?php

namespace App\Filament\Resources\Transactions\RelationManagers;

use App\Filament\Resources\Categories\CategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class CategoryRelationManager extends RelationManager
{
    protected static string $relationship = 'category';

    protected static ?string $relatedResource = CategoryResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
