<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\View\PanelsRenderHook;
use Illuminate\Contracts\View\View;
use Filament\Pages;
use Filament\Widgets;
use Filament\Support\Colors\Color;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AsistenPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('asisten')
            ->path('asisten')
            ->login()
            ->authGuard('asisten')
            ->authPasswordBroker('asistens')
            ->brandName('Asisten Panel')
            ->colors([
                'primary' => Color::hex('#2f5fe0'),
                'info' => Color::hex('#0e7490'),
            ])
            ->discoverResources(in: app_path('Filament/Asisten/Resources'), for: 'App\\Filament\\Asisten\\Resources')
            ->navigationGroups([
                'Manajemen Konten',
                'Pengaturan',
            ])
            ->resources([
                \App\Filament\Asisten\Resources\LogbookResource::class,
            ])
            ->discoverPages(in: app_path('Filament/Asisten/Pages'), for: 'App\\Filament\\Asisten\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Asisten/Widgets'), for: 'App\\Filament\\Asisten\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
            ])
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn (): View => view('filament.panel-theme'),
            )
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
                \App\Http\Middleware\AsistenMiddleware::class,
            ]);
    }
}