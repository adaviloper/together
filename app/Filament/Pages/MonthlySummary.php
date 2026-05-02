<?php

namespace App\Filament\Pages;

use App\Filament\Resources\Categories\Widgets\MonthlyIncomePie;
use App\Filament\Resources\Categories\Widgets\MonthlyOutflowPie;
use App\Filament\Widgets\MonthlyCategorySummary;
use App\Filament\Widgets\MonthlyCashFlowSummary;
use App\Filament\Resources\Categories\Widgets\MonthlyCategoryPie;
use App\Filament\Widgets\MonthlyIncomeSummary;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Livewire\Attributes\Url;

class MonthlySummary extends Page
{
    /* protected static ?string $navigationLabel = 'Monthly Summary'; */

    protected static ?string $slug = 'monthly-review';

    protected string $view = 'filament.app.pages.january';

    #[Url]
    public ?int $year = null;

    #[Url]
    public ?int $month = null;

    public function mount(): void
    {
        $this->year ??= now()->year;
        $this->month ??= now()->month;
    }

    public function getTitle(): string
    {
        return Carbon::create($this->year, $this->month)->format('F Y');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('selectMonth')
                ->label($this->getMonthLabel() . ' ' . $this->year)
                ->schema([
                    Select::make('month')
                        ->label('Select Month')
                        ->options($this->getMonthOptions())
                        ->default($this->month)
                        ->required(),
                    Select::make('year')
                        ->label('Select Year')
                        ->options($this->getYearOptions())
                        ->default($this->year)
                        ->required(),
                ])
                ->action(fn (array $data) => $this->redirect(static::getUrl([
                    'month' => $data['month'],
                    'year' => $data['year'],
                ]))),
        ];
    }

    protected function getMonthLabel(): string
    {
        return Carbon::create(null, $this->month)->format('F');
    }

    protected function getMonthOptions(): array
    {
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[$i] = Carbon::create(null, $i)->format('F');
        }
        return $months;
    }

    protected function getYearOptions(): array
    {
        $startYear = 2021;
        $currentYear = now()->year;
        $years = [];
        for ($i = $startYear; $i <= $currentYear + 1; $i++) {
            $years[$i] = (string) $i;
        }
        return $years;
    }

    public function getHeaderWidgets(): array
    {
        return [
            MonthlyCashFlowSummary::make([
                'month' => $this->month,
                'year' => $this->year,
            ]),
            MonthlyOutflowPie::make([
                'month' => $this->month,
                'year' => $this->year,
                'categories' => [
                    'Bill',
                    'Expense',
                    'Debt',
                    'Saving Goal',
                ],
            ]),

            MonthlyIncomeSummary::make([
                'month' => $this->month,
                'year' => $this->year,
            ])

        ];
    }
}
