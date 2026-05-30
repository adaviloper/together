<?php

namespace App\Filament\Resources\Categories\Tables;

use App\Filament\Exports\CategoryExporter;
use App\Filament\Imports\CategoryImporter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $query->orderBy('name')->withSum('subcategories', 'monthly_budgeted');
            })
            ->columns([
                TextInputColumn::make('name')
                    ->searchable(),
                TextColumn::make('subcategories_sum_monthly_budgeted')
                    ->label('Monthly Budgeted')
                    ->money('USD', 100)
                    ->default(0),
                TextColumn::make('subcategories_count')
                    ->counts('subcategories'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
                ImportAction::make()
                    ->importer(CategoryImporter::class)
                    ->options(['organization_id' => session('current_organization_id')]),
                ExportAction::make()
                    ->exporter(CategoryExporter::class),
            ]);
    }
}
