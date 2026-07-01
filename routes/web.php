<?php

use App\Http\Controllers\LocaleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/stay', function () {
    return view('stay');
})->name('stay');

Route::get('/dining', function () {
    return view('dining');
})->name('dining');

Route::get('/relax', function () {
    return view('relax');
})->name('relax');

Route::get('/discover', function () {
    return view('discover');
})->name('discover');

Route::get('/dining/{slug}', function (string $slug) {
    $slugs = collect(trans('lum.dining.venues'))->pluck('slug');

    if (! $slugs->contains($slug)) {
        abort(404);
    }

    $restaurant = trans("lum.restaurant.{$slug}");

    if (! is_array($restaurant)) {
        abort(404);
    }

    return view('restaurant', compact('slug', 'restaurant'));
})->name('restaurant.show');

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
