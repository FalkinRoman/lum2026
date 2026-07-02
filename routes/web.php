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

Route::get('/discover/{slug}', function (string $slug) {
    $slugs = collect(trans('lum.discover.places'))->pluck('slug');

    if (! $slugs->contains($slug)) {
        abort(404);
    }

    $excursion = trans("lum.excursion.{$slug}");

    if (! is_array($excursion)) {
        abort(404);
    }

    return view('excursion', compact('slug', 'excursion'));
})->name('discover.show');

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

Route::get('/blog', function () {
    return view('blog');
})->name('blog');

Route::get('/blog/{slug}', function (string $slug) {
    $slugs = collect(trans('lum.blog.posts'))->pluck('slug');

    if (! $slugs->contains($slug)) {
        abort(404);
    }

    $post = trans("lum.post.{$slug}");

    if (! is_array($post)) {
        abort(404);
    }

    return view('post', compact('slug', 'post'));
})->name('blog.show');

Route::get('/contacts', function () {
    return view('contacts');
})->name('contacts');

Route::get('/shop', function () {
    return view('shop');
})->name('shop');

Route::get('/locale/{locale}', LocaleController::class)->name('locale.switch');
