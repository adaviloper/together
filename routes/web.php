<?php

use App\Http\Controllers\OrganizationSwitcherController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::put('organization/current', [OrganizationSwitcherController::class, 'update'])
    ->middleware(['auth'])
    ->name('organization.current.update');

require __DIR__.'/settings.php';
