<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VetementController;
use App\Http\Controllers\TenueController;
use App\Http\Controllers\FavorisController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/index.html', function () {
    return view('welcome');
});

Route::get('/contact', function () {
    return view('pages.public.contact-web');
});

Route::get('/pages/public/about-web.html', function () {
    return view('pages.public.about-web');
});

Route::get('/pages/public/auth.html', function () {
    return view('pages.public.auth');
});

Route::get('/pages/public/change-password-mobile.html', function () {
    return view('pages.public.change-password-mobile');
});

Route::get('/pages/public/change-password-web.html', function () {
    return view('pages.public.change-password-web');
});

Route::get('/pages/public/contact-web.html', function () {
    return view('pages.public.contact-web');
});

Route::get('/pages/public/dashboard_mobile.html', function () {
    return view('pages.public.dashboard_mobile');
});

Route::get('/pages/public/dashboard-web.html', function () {
    return view('pages.public.dashboard-web');
});

Route::get('/pages/public/edit-profile-mobile.html', function () {
    return view('pages.public.edit-profile-mobile');
});

Route::get('/pages/public/edit-profile-web.html', function () {
    return view('pages.public.edit-profile-web');
});

Route::get('/pages/public/favoris_mobile.html', function () {
    return view('pages.public.favoris_mobile');
});

Route::get('/pages/public/favoris-web.html', function () {
    return view('pages.public.favoris-web');
});

Route::get('/pages/public/garde-robe_mobile.html', function () {
    return view('pages.public.garde-robe_mobile');
});

Route::get('/pages/public/garde-robe-web.html', function () {
    return view('pages.public.garde-robe-web');
});

Route::get('/pages/public/profile_mobile.html', function () {
    return view('pages.public.profile_mobile');
});

Route::get('/pages/public/profile-web.html', function () {
    return view('pages.public.profile-web');
});

Route::get('/pages/public/stats_mobile.html', function () {
    return view('pages.public.stats_mobile');
});

Route::resource('vetements', VetementController::class);
Route::resource('tenues', TenueController::class);
Route::resource('favoris', FavorisController::class);
