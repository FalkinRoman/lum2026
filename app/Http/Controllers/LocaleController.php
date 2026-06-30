<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LocaleController
{
    private const SUPPORTED = ['en', 'ru'];

    public function __invoke(Request $request, string $locale): RedirectResponse
    {
        if (! in_array($locale, self::SUPPORTED, true)) {
            abort(404);
        }

        $request->session()->put('locale', $locale);

        App::setLocale($locale);

        return redirect()
            ->back(fallback: route('home'))
            ->withCookie(cookie()->forever('lum_locale', $locale));
    }
}
