<?php

use App\Http\Controllers\LocaleController;
use App\Models\Activity;
use App\Models\BlogPost;
use App\Models\Excursion;
use App\Models\Restaurant;
use App\Models\Villa;
use App\Support\Content;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/stay', function () {
    $properties = Content::villas();

    return view('stay', compact('properties'));
})->name('stay');

Route::get('/dining', function () {
    $venues = Content::restaurants();

    return view('dining', compact('venues'));
})->name('dining');

Route::get('/relax', function () {
    $activities = Content::activities();

    return view('relax', compact('activities'));
})->name('relax');

Route::get('/relax/{slug}', function (string $slug) {
    $activity = Content::activity($slug);
    if (! $activity) {
        abort(404);
    }

    return view('activity', compact('slug', 'activity'));
})->name('relax.show');

Route::get('/discover', function () {
    $places = Content::excursions();

    return view('discover', compact('places'));
})->name('discover');

Route::get('/discover/{slug}', function (string $slug) {
    $excursion = Content::excursion($slug);
    if (! $excursion) {
        abort(404);
    }

    return view('excursion', compact('slug', 'excursion'));
})->name('discover.show');

Route::get('/dining/{slug}', function (string $slug) {
    $restaurant = Content::restaurant($slug);
    if (! $restaurant) {
        abort(404);
    }

    $menuCategories = Content::menuCategories();

    return view('restaurant', compact('slug', 'restaurant', 'menuCategories'));
})->name('restaurant.show');

Route::get('/stay/{slug}', function (string $slug) {
    $villa = Content::villa($slug);
    if (! $villa) {
        abort(404);
    }

    return view('villa', compact('slug', 'villa'));
})->name('villa.show');

Route::get('/blog', function () {
    $posts = Content::blogPosts();

    return view('blog', compact('posts'));
})->name('blog');

Route::get('/blog/{slug}', function (string $slug) {
    $post = Content::blogPost($slug);
    if (! $post) {
        abort(404);
    }

    return view('post', compact('slug', 'post'));
})->name('blog.show');

Route::get('/contacts', function () {
    $contact = Content::contact();

    return view('contacts', compact('contact'));
})->name('contacts');

Route::get('/privacy', function () {
    $settings = \App\Support\Site::settings();
    $page = [
        'title' => $settings->privacy_title ?: __('lum.footer.privacy'),
        'body' => $settings->privacy_body ?: '',
    ];

    return view('legal', compact('page'));
})->name('privacy');

Route::get('/terms', function () {
    $settings = \App\Support\Site::settings();
    $page = [
        'title' => $settings->terms_title ?: __('lum.footer.terms'),
        'body' => $settings->terms_body ?: '',
    ];

    return view('legal', compact('page'));
})->name('terms');

Route::get('/shop', function () {
    $shopItems = Content::shopItemsKeyed();

    return view('shop', compact('shopItems'));
})->name('shop');

Route::get('/booking', function () {
    return view('booking');
})->name('booking');

Route::get('/locale/{locale}', LocaleController::class)->name('locale.switch');
