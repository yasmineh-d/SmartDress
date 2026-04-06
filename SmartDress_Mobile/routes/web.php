<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/wardrobe', function () {
    return view('wardrobe');
})->name('wardrobe');

Route::get('/favorites', function () {
    return view('favorites');
})->name('favorites');

Route::get('/profile', function () {
    return view('profile');
})->name('profile');

Route::get('/stats', function () {
    return view('stats');
})->name('stats');
