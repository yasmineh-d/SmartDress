<?php

use App\Http\Controllers\Api\VetementApiController;
use App\Http\Controllers\Api\TenueApiController;
use App\Http\Controllers\Api\FavorisApiController;
use Illuminate\Support\Facades\Route;

Route::prefix('vetements')->group(function (): void {
    Route::get('/', [VetementApiController::class, 'index']);
    Route::post('/', [VetementApiController::class, 'store']);
    Route::get('/{id}', [VetementApiController::class, 'show']);
    Route::put('/{vetement}', [VetementApiController::class, 'update']);
    Route::delete('/{vetement}', [VetementApiController::class, 'destroy']);
});

Route::prefix('tenues')->group(function (): void {
    Route::get('/', [TenueApiController::class, 'index']);
    Route::post('/', [TenueApiController::class, 'store']);
    Route::get('/{id}', [TenueApiController::class, 'show']);
    Route::put('/{tenue}', [TenueApiController::class, 'update']);
    Route::delete('/{tenue}', [TenueApiController::class, 'destroy']);
});

Route::prefix('favoris')->group(function (): void {
    Route::get('/', [FavorisApiController::class, 'index']);
    Route::post('/', [FavorisApiController::class, 'store']);
    Route::get('/{id}', [FavorisApiController::class, 'show']);
    Route::delete('/{favori}', [FavorisApiController::class, 'destroy']);
});
