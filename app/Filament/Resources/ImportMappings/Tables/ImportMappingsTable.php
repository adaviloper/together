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
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ImportMappingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
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
                    ->sortable()
                    ->searchable(),
                TextColumn::make('source')
                    ->sortable()
                    ->searchable(),
                ToggleColumn::make('skip'),
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
                    }),
                Filter::make('unreviewed')
                    ->query(function(Builder $query): Builder {
                        return $query->where([
                            'skip' => false,
                            'subcategory_id' => null,
                        ]);
                    }),
                Filter::make('skipped')
                    ->query(function(Builder $query): Builder {
                        return $query->whereSkip(true);
                    }),
                Filter::make('not_skipped')
                    ->query(function(Builder $query): Builder {
                        return $query->whereSkip(false);
                    }),
                SelectFilter::make('user')
                    ->options(function () {
                        /** @var User $user */
                        $user = auth()->user();
                        $org = $user->organizations()->with('users')->first();
                        return $org->users->mapWithKeys(fn ($user) => [$user->id => $user->name]);
                    })
                    ->query(function (Builder $query, array $data) {
                        $v = $query->when(
                            $data['value'],
                            function (Builder $q, $userId) {
                                $q->where('user_id', $userId);
                            });
                    }),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
                ImportAction::make()
                    ->importer(ImportMappingImporter::class)
                    ->options(['organization_id' => session('current_organization_id')]),
                ExportAction::make()
                    ->exporter(ImportMappingExporter::class),
            ]);
    }
}
