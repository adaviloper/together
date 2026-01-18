<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->login()
            ->colors([
                'danger' => [
                    '50' => 'oklch(96.9% 0.015 3.5482)',
                    '100' => 'oklch(92.286% 0.03423 3.7062)',
                    '200' => 'oklch(85.573% 0.06647 1.1272)',
                    '300' => 'oklch(75.559% 0.1297 2.7642)',
                    '400' => 'oklch(66.536% 0.20489 4.5542)',
                    '500' => 'oklch(60.614% 0.25507 7.5652)',
                    '600' => 'oklch(56.014% 0.25274 9.5985)',
                    '700' => 'oklch(49.38% 0.22293 8.6545)',
                    '800' => 'oklch(43.945% 0.19163 4.8232)',
                    '900' => 'oklch(40.223% 0.16081 1.3982)',
                    '950' => 'oklch(27.1% 0.105 3.2202)',
                ],
                'gray' => [
                    '50' => 'oklch(98.5% 0.002 267.08)',
                    '100' => 'oklch(97.065% 0.0026 283.79)',
                    '200' => 'oklch(93.53% 0.00519 283.78)',
                    '300' => 'oklch(88.296% 0.00879 277.58)',
                    '400' => 'oklch(72.161% 0.02038 280.57)',
                    '500' => 'oklch(56.926% 0.02498 283.61)',
                    '600' => 'oklch(46.791% 0.02757 276.05)',
                    '700' => 'oklch(39.856% 0.03117 278.98)',
                    '800' => 'oklch(30.722% 0.02976 276.09)',
                    '900' => 'oklch(24.287% 0.03036 283.91)',
                    '950' => 'oklch(13% 0.028 280.94)',
                ],
                'info' => [
                    '50' => 'oklch(97% 0.014 262.68)',
                    '100' => 'oklch(91.781% 0.03411 263.66)',
                    '200' => 'oklch(85.361% 0.06323 262.2)',
                    '300' => 'oklch(76.642% 0.11134 259.88)',
                    '400' => 'oklch(67.05% 0.17044 262.7)',
                    '500' => 'oklch(59.259% 0.21853 267.89)',
                    '600' => 'oklch(52.167% 0.24863 270.95)',
                    '700' => 'oklch(46.975% 0.24572 272.45)',
                    '800' => 'oklch(41.183% 0.20081 273.71)',
                    '900' => 'oklch(37.292% 0.14691 273.59)',
                    '950' => 'oklch(28.2% 0.091 276.01)',
                ],
                'primary' => [
                    '50' => 'oklch(97% 0.014 262.68)',
                    '100' => 'oklch(91.781% 0.03411 263.66)',
                    '200' => 'oklch(85.361% 0.06323 262.2)',
                    '300' => 'oklch(76.642% 0.11134 259.88)',
                    '400' => 'oklch(67.05% 0.17044 262.7)',
                    '500' => 'oklch(59.259% 0.21853 267.89)',
                    '600' => 'oklch(52.167% 0.24863 270.95)',
                    '700' => 'oklch(46.975% 0.24572 272.45)',
                    '800' => 'oklch(41.183% 0.20081 273.71)',
                    '900' => 'oklch(37.292% 0.14691 273.59)',
                    '950' => 'oklch(28.2% 0.091 276.01)',
                ],
                'success' => [
                    '50' => 'oklch(98.2% 0.018 144.09)',
                    '100' => 'oklch(95.757% 0.03041 145.01)',
                    '200' => 'oklch(91.614% 0.05682 144.26)',
                    '300' => 'oklch(85.77% 0.10923 142.72)',
                    '400' => 'oklch(78.06% 0.17405 139.98)',
                    '500' => 'oklch(71.35% 0.18988 137.85)',
                    '600' => 'oklch(61.94% 0.1707 137.48)',
                    '700' => 'oklch(52.13% 0.13653 138.34)',
                    '800' => 'oklch(44.42% 0.10735 139.59)',
                    '900' => 'oklch(39.11% 0.08918 140.8)',
                    '950' => 'oklch(26.6% 0.065 141.2)',
                ],
                'warning' => [
                    '50' => 'oklch(97.986% 0.01584 60.588)',
                    '100' => 'oklch(94.956% 0.02915 61.503)',
                    '200' => 'oklch(89.212% 0.05831 57.036)',
                    '300' => 'oklch(82.368% 0.10146 52.629)',
                    '400' => 'oklch(73.858% 0.16025 42.273)',
                    '500' => 'oklch(69.548% 0.19404 33.943)',
                    '600' => 'oklch(63.839% 0.20683 27.455)',
                    '700' => 'oklch(54.729% 0.18363 24.741)',
                    '800' => 'oklch(46.619% 0.14942 23.643)',
                    '900' => 'oklch(40.61% 0.11921 24.511)',
                    '950' => 'oklch(26.6% 0.079 22.598)',
                ],
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
