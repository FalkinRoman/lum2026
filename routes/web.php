<?php

use App\Http\Controllers\LocaleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/stay', function () {
    return view('stay');
})->name('stay');

Route::get('/stay/{slug}', function (string $slug) {
    $slugs = collect(trans('lum.stay.properties'))->pluck('slug');

    if (! $slugs->contains($slug)) {
        abort(404);
    }

    $villa = trans("lum.villa.{$slug}");

    if (! is_array($villa)) {
        abort(404);
    }

    return view('villa', compact('slug', 'villa'));
})->name('villa.show');

Route::get('/locale/{locale}', LocaleController::class)->name('locale.switch');
