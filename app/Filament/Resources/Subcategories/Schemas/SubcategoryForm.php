<?php

namespace App\Filament\Resources\Subcategories\Schemas;

use App\Casts\SplitStrategyCast;
use App\Models\Category;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SubcategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->label('Category')
                    ->options(Category::query()->pluck('name', 'id')),
                TextInput::make('name')
                    ->required(),
                TextInput::make('monthly_budgeted')
                    ->label('Monthly Budget')
                    ->numeric()
                    ->prefix('$')
                    ->helperText('Amount in cents'),
                Select::make('split_strategy')
                    ->label('Split Strategy')
                    ->options(
                        collect(SplitStrategyCast::options())
                            ->mapWithKeys(fn ($strategy, $key) => [$key => $strategy->label()])
                            ->all()
                    )
                    ->default('income')
                    ->live()
                    ->formatStateUsing(fn ($state) => $state instanceof \App\SplitStrategies\SplitStrategyInterface ? $state::key() : $state)
                    ->helperText(fn ($state) => SplitStrategyCast::options()[$state]?->description() ?? ''),
                TextInput::make('fixed_split_ratio')
                    ->label('Fixed Split Ratio')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(1)
                    ->step(0.01)
                    ->placeholder('0.50')
                    ->helperText('Enter the ratio for the first user (e.g., 0.60 means 60% / 40% split)')
                    ->visible(fn ($get) => $get('split_strategy') === 'fixed'),
            ]);
    }
}
