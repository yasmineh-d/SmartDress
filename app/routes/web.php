<?php

use App\Http\Controllers\ApiController;

Route::get('/', [ApiController::class, 'getData']);
Route::get('/products', [ApiController::class, 'getData']);

