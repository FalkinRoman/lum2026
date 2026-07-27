<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    private const SUPPORTED = ['en', 'ru'];

    public function handle(Request $request, Closure $next): Response
    {
        // Админка Filament — всегда RU (не зависит от языка публичного сайта).
        if ($request->is('admin', 'admin/*')) {
            App::setLocale('ru');

            return $next($request);
        }

        $locale = $request->session()->get('locale')
            ?? $request->cookie('lum_locale')
            ?? config('app.locale', 'en');

        if (! in_array($locale, self::SUPPORTED, true)) {
            $locale = 'en';
        }

        App::setLocale($locale);

        return $next($request);
    }
}
