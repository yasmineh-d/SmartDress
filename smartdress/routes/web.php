<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VetementController;
use App\Http\Controllers\TenueController;
use App\Http\Controllers\FavorisController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('vetements', VetementController::class);
Route::resource('tenues', TenueController::class);
Route::resource('favoris', FavorisController::class);
