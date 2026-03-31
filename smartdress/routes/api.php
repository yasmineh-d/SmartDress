<?php

use App\Http\Controllers\Api\VetementApiController;
use Illuminate\Support\Facades\Route;

Route::prefix('vetements')->group(function (): void {
    Route::get('/', [VetementApiController::class, 'index']);
    Route::post('/', [VetementApiController::class, 'store']);
    Route::get('/{id}', [VetementApiController::class, 'show']);
    Route::put('/{vetement}', [VetementApiController::class, 'update']);
    Route::delete('/{vetement}', [VetementApiController::class, 'destroy']);
});
