<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Panel;

class Dashboard extends Page
{
    protected string $view = 'filament.pages.dashboard';

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->path('app');
    }
}
