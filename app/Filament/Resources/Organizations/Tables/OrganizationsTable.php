<?php

namespace App\Filament\Resources\Organizations\Tables;

use App\Models\Category;
use App\Models\ImportMapping;
use App\Models\Organization;
use App\Models\Scopes\CurrentOrgScope;
use App\Models\Subcategory;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ReplicateAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OrganizationsTable
{
    public static function configure(Table $table): Table
    {
        /* dd( */
        /*     auth( */
        /*     ) ->user( */
        /*     ) ->organizations( */
        /*     ) ->where( */
        /*         'organization_id', */
        /*         '!=', */
        /*         session( */
        /*             'current_organization_id', */
        /*         ), */
        /*     ) ->get( */
        /*     ), */
        /*     __METHOD__ . ':' . __LINE__, */
        /* ); */
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $query->whereHas(
                    'users',
                    fn (Builder $q) => $q->where('users.id', auth()->id()),
                );
            })
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
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
                Action::make('transfer_hierarchical_data_to_other_org')
                    ->schema([
                        Select::make('organization_id')
                            ->required()
                            ->options(
                                auth()
                                    ->user()
                                    ->organizations()
                                    ->where('organization_id', '!=', session('current_organization_id'))
                                    ->pluck('name', 'organization_id'),
                            ),
                    ])
                    ->action(function (array $data) {
                        $organization = Organization::query()
                            ->where('id', session('current_organization_id'))
                            ->with([
                                'categories',
                                'subcategories',
                                'importMappings' => function ($query) {
                                    $query->where('user_id', auth()->id());
                                },
                            ])
                            ->first();

                        $categories = $organization->categories
                            ->mapWithKeys(function (Category $category) use ($data) {
                                return [$category->id => Category::withoutGlobalScope(CurrentOrgScope::class)->firstOrCreate([
                                    'organization_id' => $data['organization_id'],
                                    'name' => $category->name,
                                ])];
                            });

                        $subcategories = $organization->subcategories
                            ->mapWithKeys(function (Subcategory $subcategory) use ($categories, $data) {
                                return [$subcategory->id => Subcategory::firstOrCreate([
                                    'category_id' => $categories->get($subcategory->category_id)->id,
                                    'name' => $subcategory->name,
                                    'monthly_budgeted' => $subcategory->monthly_budgeted,
                                    'split_strategy' => $subcategory->split_strategy,
                                    'fixed_split_ratio' => $subcategory->fixed_split_ratio,
                                ])];
                            });

                        $importMappings = $organization->importMappings
                            ->map(function (ImportMapping $importMapping) use ($data, $subcategories) {
                                return ImportMapping::withoutGlobalScope(CurrentOrgScope::class)->firstOrCreate([
                                    'organization_id' => $data['organization_id'],
                                    'subcategory_id' => $subcategories->get($importMapping->subcategory_id)?->id,
                                    'user_id' => auth()->id(),
                                    'source' => $importMapping->source,
                                    'skip' => $importMapping->skip,
                                ]);
                            });
                    })
            ]);
    }
}
