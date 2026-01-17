<?php

namespace App\Filament\App\Pages;

use App\Filament\Resources\Categories\Widgets\MonthlyCategoryPie;
use Filament\Pages\Page;
use Filament\Widgets\StatsOverviewWidget;

class December extends Page
{
    protected string $view = 'filament.app.pages.january';

    public function getHeaderWidgets(): array
    {
        return [
            MonthlyCategoryPie::make([
                'month' => 12,
            ]),
        ];
    }
}
