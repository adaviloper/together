<?php

use App\Http\Controllers\OrganizationSwitcherController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect('/admin');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::put('organization/current', [OrganizationSwitcherController::class, 'update'])
    ->middleware(['auth'])
    ->name('organization.current.update');

require __DIR__.'/settings.php';
