<?php

namespace App\Filament\App\Pages;

use App\Filament\App\Widgets\MonthlyIncomeSummary;
use App\Filament\App\Widgets\MonthlyOverview;
use App\Filament\Resources\Categories\Widgets\MonthlyCategoryPie;
use Filament\Pages\Page;
use App\Filament\App\Widgets\StatsOverview;

class November extends Page
{
    protected string $view = 'filament.app.pages.january';

    public function getHeaderWidgets(): array
    {
        return [
            MonthlyOverview::class,
            MonthlyCategoryPie::make([
                'month' => 11,
            ]),
            MonthlyIncomeSummary::class,
        ];
    }
}
