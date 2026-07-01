<?php

use App\Http\Controllers\LocaleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/stay', function () {
    return view('stay');
})->name('stay');

Route::get('/locale/{locale}', LocaleController::class)->name('locale.switch');
