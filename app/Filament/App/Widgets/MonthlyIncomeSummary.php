<?php

namespace App\Filament\App\Widgets;

use App\Models\Category;
use App\Models\Subcategory;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class MonthlyIncomeSummary extends TableWidget
{
    public function table(Table $table): Table
    {
        $category = Category::query()->where('name', 'Income')->first();

        return $table
            ->query(fn (): Builder => Subcategory::query()->where([
                'category_id' => $category->id,
            ]))
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('expected')
                    ->formatStateUsing(function (string $state) {
                        return 'lij';
                    }),
                TextColumn::make('subcategory'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
