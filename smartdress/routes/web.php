<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VetementController;
use App\Http\Controllers\TenueController;
use App\Http\Controllers\FavorisController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

// --- Pages Publiques ---
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/about', function () {
    return view('pages.public.about-web');
})->name('about');

Route::get('/contact', function () {
    return view('pages.public.contact-web');
})->name('contact');

Route::get('/login', function () {
    return view('pages.public.auth');
})->name('login');


// --- Pages Utilisateur (Web) ---
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('pages.public.dashboard-web');
    })->name('dashboard');

    Route::get('/garde-robe', function () {
        return view('pages.public.garde-robe-web');
    })->name('garde-robe');

    Route::get('/favoris', function () {
        return view('pages.public.favoris-web');
    })->name('favoris');

    Route::get('/profil', function () {
        return view('pages.public.profile-web');
    })->name('profile');

    Route::get('/modifier-profil', function () {
        return view('pages.public.edit-profile-web');
    })->name('profile.edit');

    Route::get('/changer-mot-de-passe', function () {
        return view('pages.public.change-password-web');
    })->name('password.change');
});


// --- Pages Admin ---
Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');


// --- Authentification (Logique) ---
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// --- Resources (API/CRUD) ---
Route::resource('vetements', VetementController::class);
Route::resource('tenues', TenueController::class);
Route::resource('favoris-api', FavorisController::class);

// --- Compatibilité Mobiles ---
Route::get('/mobile/dashboard', function () { return view('pages.public.dashboard_mobile'); })->name('mobile.dashboard');
Route::get('/mobile/edit-profile', function () { return view('pages.public.edit-profile-mobile'); })->name('mobile.profile.edit');
