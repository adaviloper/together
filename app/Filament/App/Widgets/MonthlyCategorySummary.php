<?php

namespace App\Filament\App\Widgets;

use App\Models\Category;
use App\Models\Subcategory;
use Carbon\Carbon;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class MonthlyCategorySummary extends TableWidget
{
    public ?int $month = null;

    public ?int $year = null;

    public ?string $categoryName = null;

    public function table(Table $table): Table
    {
        if ($this->categoryName === null) {
            return $table->query(fn (): Builder => Subcategory::query()->whereRaw('1 = 0'));
        }

        $category = Category::query()->where('name', $this->categoryName)->first();
        $year = $this->year ?? now()->year;
        $month = $this->month ?? now()->month;
        $start = Carbon::create($year, $month)->startOfMonth();
        $end = Carbon::create($year, $month)->endOfMonth();

        return $table
            ->query(fn (): Builder => Subcategory::query()
                ->with(['transactions' => fn ($query) => $query
                    ->where('transaction_date', '>=', $start)
                    ->where('transaction_date', '<=', $end),
                ])
                ->where([
                    'category_id' => $category->id,
                ]))
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('monthly_budgeted')
                    ->label('Expected')
                    ->money(divideBy: 100),
                TextColumn::make('actual')
                    ->state(function ($record) use ($category) {
                        return $record->transactions->sum('debit');
                    })
                ->money(divideBy: 100),
                TextColumn::make('process')
                    ->state(function ($record) use ($category) {
                        $expected = $record->monthly_budgeted;
                        $actual = $record->transactions->sum('debit');
                        return floor(($actual / $expected) * 100) . '%';
                    }),
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

    protected function getTableHeading(): ?string
    {

        return ($this->categoryName ?? 'Category') . ' Summary';
    }
}
