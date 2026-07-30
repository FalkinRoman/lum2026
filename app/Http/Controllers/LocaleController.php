<?php

namespace App\Http\Controllers;

use App\Support\Locales;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LocaleController
{
    public function __invoke(Request $request, string $locale): RedirectResponse
    {
        if (! Locales::isSupported($locale)) {
            abort(404);
        }

        $request->session()->put('locale', $locale);

        App::setLocale($locale);

        return redirect()
            ->back(fallback: route('home'))
            ->withCookie(cookie()->forever('lum_locale', $locale));
    }
}
