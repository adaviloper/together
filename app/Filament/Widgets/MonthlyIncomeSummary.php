<?php

namespace App\Filament\Widgets;

use App\Filament\Tables\Columns\ActualTotalColumn;
use App\Filament\Tables\Columns\CategoryProcessColumn;
use App\Filament\Tables\Columns\ExpectedTotalColumn;
use App\Filament\Tables\Summarizers\ActualTotalSum;
use App\Filament\Tables\Summarizers\CategoryProcessAvg;
use App\Filament\Tables\Summarizers\ExpectedTotalSum;
use App\Models\Category;
use App\Models\Transaction;
use Carbon\Carbon;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class MonthlyIncomeSummary extends TableWidget
{
    public ?int $month = null;

    public ?int $year = null;

    public function table(Table $table): Table
    {
        $year = $this->year ?? now()->year;
        $month = $this->month ?? now()->month;
        $start = Carbon::create($year, $month)->startOfMonth();
        $end = Carbon::create($year, $month)->endOfMonth();
        $incomeCategory = Category::query()
            ->where('name', 'Income')
            ->first();

        return $table
            ->heading('Income Summary')
            ->query(fn (): Builder => Transaction::query()
                ->when($incomeCategory, fn (Builder $q) => $q->where('category_id', $incomeCategory->id))
                ->when(! $incomeCategory, fn (Builder $q) => $q->whereRaw('1 = 0'))
                ->where('transaction_date', '>=', $start)
                ->where('transaction_date', '<=', $end)
                ->with('user')
                ->with('subcategory')
            )
            ->columns([
                TextColumn::make('user.name'),
                TextColumn::make('subcategory.name'),
                ExpectedTotalColumn::make('expected')
                    ->summarize(ExpectedTotalSum::make()),
                ActualTotalColumn::make('amount')
                    ->label('Actual')
                    ->summarize(ActualTotalSum::make()->month($month)->year($year)),
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
