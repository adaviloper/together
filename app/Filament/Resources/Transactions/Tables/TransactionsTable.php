<?php

namespace App\Filament\Resources\Transactions\Tables;

use App\Filament\Imports\TransactionImporter;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\ImportAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\QueryBuilder\Constraints\DateConstraint;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\SelectFilter;
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
            ->modifyQueryUsing(function (Builder $query) {
                $orgUserIds = User::query()
                    ->where('organization_id', auth()->user()->organization_id)
                    ->pluck('id');

                $query->whereIn('user_id', $orgUserIds);
            })
            ->columns([
                TextColumn::make('transaction_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('user.name'),
                TextColumn::make('description')
                    ->searchable(),
                SelectColumn::make('category_id')
                    ->label('Category')
                    ->options(Category::orderBy('name')->pluck('name', 'id')->toArray())
                    ->getStateUsing(function (Model $record): ?string {
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
                            ->orderBy('name')
                            ->where('category_id', $categoryId)
                            ->pluck('name', 'id')
                            ->toArray();
                    })
                    ->sortable(),
                TextColumn::make('amount')
                    ->numeric()
                    ->formatStateUsing(fn(int $state) => (new NumberFormatter('en_US', \NumberFormatter::CURRENCY))->formatCurrency($state / 100, 'USD'))
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
                SelectFilter::make('category')
                    ->options(function () {
                        return Category::query()->get()->mapWithKeys(fn ($category) => [$category->id => $category->name]);
                    })
                    ->query(function (Builder $query, array $data) {
                        $query->when($data['value'], function (Builder $q, $categoryId) {
                            $q->where('category_id', $categoryId);
                        });
                    }),
                SelectFilter::make('subcategory')
                    ->options(function () {
                        return Subcategory::query()->get()->mapWithKeys(fn ($subcategory) => [$subcategory->id => $subcategory->name]);
                    })
                    ->query(function (Builder $query, array $data) {
                        $query->when($data['value'], function (Builder $q, $subcategoryId) {
                            $q->where('subcategory_id', $subcategoryId);
                        });
                    }),
                SelectFilter::make('user')
                    ->options(function () {
                        /** @var User $user */
                        $user = auth()->user();
                        $org = $user->organization()->with('users')->first();
                        return $org->users->mapWithKeys(fn ($user) => [$user->id => $user->name]);
                    })
                    ->query(function (Builder $query, array $data) {
                        $v = $query->when(
                            $data['value'],
                            function (Builder $q, $userId) {
                                $q->where('user_id', $userId);
                            });
                    }),
                SelectFilter::make('month')
                    ->options([
                        '1' => 'January',
                        '2' => 'February',
                        '3' => 'March',
                        '4' => 'April',
                        '5' => 'May',
                        '6' => 'June',
                        '7' => 'July',
                        '8' => 'August',
                        '9' => 'September',
                        '10' => 'October',
                        '11' => 'November',
                        '12' => 'December',
                    ])
                    ->query(fn (Builder $query, array $data) =>
                        $query->when($data['value'], fn (Builder $q, $year) =>
                            $q->whereMonth('transaction_date', $year)
                        )
                    ),
                SelectFilter::make('year')
                    ->options(function () {
                        $currentYear = now()->year;
                        $years = [];
                        for ($i = 2022; $i <= $currentYear; $i++) {
                            $years[(string) $i] = $i;
                        }
                        return $years;
                    })
                    ->query(fn (Builder $query, array $data) =>
                        $query->when($data['value'], fn (Builder $q, $year) =>
                            $q->whereYear('transaction_date', $year)
                        )
                    ),
                QueryBuilder::make()
                    ->constraints([
                        DateConstraint::make('transaction_date')
                    ])
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
