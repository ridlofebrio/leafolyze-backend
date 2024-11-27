<?php

namespace App\Providers\Filament;

use App\Filament\Resources\ShopResource;
use App\Filament\Resources\ProductResource;
use Filament\Http\Middleware\Authenticate;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Http\Middleware\EnsureUserRole;

class PenjualPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('penjual')
            ->path('penjual')
            ->colors([
                'primary' => Color::hex('#B4DB46'),
            ])
            ->resources([
                ShopResource::class,
                ProductResource::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                EnsureUserRole::class.':penjual',
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->authGuard('web')
            ->login(false)
            ->registration(false)
            ->passwordReset(false)
            ->emailVerification(false)
            ->profile();
    }
}
