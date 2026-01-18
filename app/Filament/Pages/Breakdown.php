<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Breakdown extends Page
{
    protected string $view = 'filament.pages.breakdown';

    public string $myVar = 'lijslksjef';

    public function getString(): string
    {
        return 'hit';
    }
}
