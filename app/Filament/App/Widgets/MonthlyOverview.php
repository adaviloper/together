<?php

namespace App\Filament\App\Widgets;

use App\Filament\Tables\Columns\ActualTotalColumn;
use App\Filament\Tables\Columns\CategoryProcessColumn;
use App\Filament\Tables\Columns\ExpectedTotalColumn;
use App\Filament\Tables\Summarizers\ActualTotalSum;
use App\Filament\Tables\Summarizers\CategoryProcessAvg;
use App\Filament\Tables\Summarizers\ExpectedTotalSum;
use App\Models\Category;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class MonthlyOverview extends TableWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->heading('Cash Flow Summary')
            ->query(fn (): Builder => Category::query())
            ->columns([
                TextColumn::make('name'),
                ExpectedTotalColumn::make('expected')
                    ->summarize(ExpectedTotalSum::make()),
                ActualTotalColumn::make('actual')
                    ->summarize(ActualTotalSum::make()),
                CategoryProcessColumn::make('process')
                    ->summarize(CategoryProcessAvg::make()),
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
