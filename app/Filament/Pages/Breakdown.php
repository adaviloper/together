<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Breakdown extends Page
{
    /* protected static ?string $navigationIcon = 'heroicon-o-table-cells'; */

    protected static ?string $navigationLabel = 'Yearly Breakdown';

    protected static ?int $navigationSort = 2;

    protected string $view = 'filament.pages.breakdown';
}
