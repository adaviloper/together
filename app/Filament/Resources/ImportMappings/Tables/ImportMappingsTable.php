<?php

namespace App\Filament\Resources\ImportMappings\Tables;

use App\Filament\Exports\ImportMappingExporter;
use App\Filament\Imports\ImportMappingImporter;
use App\Models\Subcategory;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ImportMappingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $query->where('user_id', auth()->id());
            })
            ->columns([
                SelectColumn::make('subcategory_id')
                    ->options(Subcategory::query()
                        ->orderBy('name')
                        ->get()
                        ->pluck('name', 'id')
                    )
                    ->sortable()
                    ->searchable(),
                TextColumn::make('user.name')
                    ->searchable(),
                TextColumn::make('source')
                    ->sortable()
                    ->searchable(),
                CheckboxColumn::make('skip'),
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
                    ->query(function(Builder $query): Builder {
                        return $query->whereNull('subcategory_id');
                    })
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
                ImportAction::make()
                    ->importer(ImportMappingImporter::class),
                ExportAction::make()
                    ->exporter(ImportMappingExporter::class),
            ]);
    }
}
