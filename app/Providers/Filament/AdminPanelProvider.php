<?php

namespace App\Providers\Filament;

use App\Filament\AvatarProviders\UserSilhouetteAvatarProvider;
use App\Filament\Pages\ManageAccount;
use App\Http\Middleware\SetFilamentLocale;
use Filament\Actions\Action;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\HtmlString;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        FilamentView::registerRenderHook(
            PanelsRenderHook::STYLES_AFTER,
            fn (): string => <<<'HTML'
                <link rel="preconnect" href="https://fonts.googleapis.com">
                <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500;800&family=Vollkorn:ital,wght@0,500;1,500&display=swap" rel="stylesheet">
                <style>
                    .lum-user-menu-avatar {
                        width: 1.5rem;
                        height: 1.5rem;
                        border-radius: 9999px;
                        object-fit: cover;
                        display: block;
                    }
                    .fi-dropdown-header .lum-user-menu-avatar,
                    .fi-dropdown-list-item .lum-user-menu-avatar {
                        flex-shrink: 0;
                    }

                    .fi-logo:has(.lum-admin-brand) {
                        height: auto !important;
                        overflow: visible;
                    }

                    .lum-admin-brand {
                        display: flex;
                        flex-direction: column;
                        align-items: flex-start;
                        gap: 0.15rem;
                        line-height: 1;
                    }

                    .lum-admin-brand__logo {
                        display: block;
                        height: 1.55rem;
                        width: auto;
                    }

                    .lum-admin-brand__admin {
                        font-family: 'Vollkorn', ui-serif, Georgia, serif;
                        font-style: italic;
                        font-weight: 500;
                        font-size: 0.72rem;
                        letter-spacing: 0.22em;
                        text-transform: lowercase;
                        color: #2E2720;
                        opacity: 0.72;
                        padding-left: 0.1rem;
                    }

                    /* Login page — slightly larger brand */
                    .fi-simple-layout .lum-admin-brand {
                        align-items: center;
                    }

                    .fi-simple-layout .lum-admin-brand__logo {
                        height: 2.35rem;
                    }

                    .fi-simple-layout .lum-admin-brand__admin {
                        font-size: 0.85rem;
                        letter-spacing: 0.28em;
                        opacity: 0.78;
                    }
                </style>
                HTML
        );

        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->brandName('LUM')
            ->brandLogo(fn (): \Illuminate\Contracts\View\View => view('filament.brand'))
            ->brandLogoHeight('2.75rem')
            ->login()
            ->defaultAvatarProvider(UserSilhouetteAvatarProvider::class)
            ->colors([
                'primary' => Color::Amber,
            ])
            ->navigationGroups([
                'Главная',
                'Проживание',
                'Гастрономия',
                'Отдых',
                'Путешествия',
                'Магазин',
                'Блог',
                'Настройки',
            ])
            ->userMenuItems([
                'profile' => fn (Action $action): Action => $action
                    ->label(fn (): string => filament()->getUserName(auth()->user()))
                    ->url(fn (): string => ManageAccount::getUrl())
                    ->icon(fn (): HtmlString => new HtmlString(
                        '<img src="'.e(filament()->getUserAvatarUrl(auth()->user())).'" alt="" class="lum-user-menu-avatar" width="24" height="24" />'
                    )),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                SetFilamentLocale::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
