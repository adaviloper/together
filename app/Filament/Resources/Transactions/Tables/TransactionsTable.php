<?php

namespace App\Filament\Resources\Transactions\Tables;

use App\Filament\Imports\TransactionImporter;
use App\Models\Category;
use App\Models\Subcategory;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\ImportAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use NumberFormatter;

class TransactionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('transaction_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('user')
                    ->formatStateUsing(function (Model $record) {
                        return $record->user->name;
                    }),
                TextColumn::make('description')
                    ->searchable(),
                SelectColumn::make('category_id')
                    ->label('Category')
                    ->options(Category::pluck('name', 'id')->toArray())
                    ->getStateUsing(function (Model $record): ?int {
                        return $record->category_id
                            ?? $record->subcategory?->category_id;
                    })
                    ->afterStateUpdated(function (Model $record, $state) {
                        if ($record->category_id !== (int) $state) {
                            $record->update(['subcategory_id' => null]);
                        }
                    })
                    ->sortable(),
                SelectColumn::make('subcategory_id')
                    ->label('Subcategory')
                    ->options(function (Model $record): array {
                        $categoryId = $record->category_id
                            ?? $record->subcategory?->category_id;

                        if (!$categoryId) {
                            return [];
                        }

                        return Subcategory::query()
                            ->where('category_id', $categoryId)
                            ->pluck('name', 'id')
                            ->toArray();
                    })
                    ->sortable(),
                TextColumn::make('debit')
                    ->numeric()
                    ->formatStateUsing(fn(int $state) => (new NumberFormatter('en_US', \NumberFormatter::CURRENCY))->formatCurrency($state / 100, 'USD'))
                    ->sortable(),
                TextColumn::make('credit')
                    ->numeric()
                    ->formatStateUsing(fn(int $state) => $state / 100)
                    ->sortable(),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                TrashedFilter::make(),
                Filter::make('uncategorized')
                    ->label('Uncategorized')
                    ->query(fn (Builder $query) => $query->whereNull('category_id')->orWhereNull('subcategory_id')),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->headerActions([
                ImportAction::make()
                    ->importer(TransactionImporter::class)
            ]);
    }
}
