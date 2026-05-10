<?php

namespace App\Filament\Resources\Subcategories\Tables;

use App\Casts\SplitStrategyCast;
use App\Filament\Exports\SubcategoryExporter;
use App\Filament\Imports\SubcategoryImporter;
use App\Models\Subcategory;
use App\SplitStrategies\FixedSplitStrategy;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SubcategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $orgId = session('current_organization_id');

                if ($orgId) {
                    $query->whereHas('category', fn (Builder $q) => $q->where('organization_id', $orgId));
                }

                $query->orderBy('name');
            })
            ->defaultPaginationPageOption('all')
            ->columns([
                SelectColumn::make('category_id')
                    ->optionsRelationship('category', 'name')
                    ->sortable(),
                TextInputColumn::make('name')
                    ->sortable()
                    ->searchable(),
                TextInputColumn::make('monthly_budgeted')
                    ->sortable()
                    ->searchable(),
                SelectColumn::make('split_strategy')
                    ->label('Split')
                    ->options(
                        collect(SplitStrategyCast::options())
                            ->mapWithKeys(fn ($strategy, $key) => [$key => $strategy->label()])
                            ->all()
                    )
                    ->getStateUsing(fn (Subcategory $record) => $record->split_strategy::key())
                    ->sortable(),
                TextInputColumn::make('fixed_split_ratio')
                    ->label('Fixed Split Ratio')
                    ->disabled(function (Subcategory $record) {
                        return $record->split_strategy->key() !== FixedSplitStrategy::key();
                    })
                    ->sortable(),
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
                Filter::make('uncategorized')
                    ->label('Uncategorized')
                    ->query(fn (Builder $query) => $query->whereNull(['category_id'])),
                SelectFilter::make('split_strategy')
                    ->label('Split Strategy')
                    ->options(
                        collect(SplitStrategyCast::options())
                            ->mapWithKeys(fn ($strategy, $key) => [$key => $strategy->label()])
                            ->all()
                    ),
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
                    ->importer(SubcategoryImporter::class),
                ExportAction::make()
                    ->exporter(SubcategoryExporter::class),
            ]);
    }
}
