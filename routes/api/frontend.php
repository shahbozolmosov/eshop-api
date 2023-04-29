<?php

use App\Http\Controllers\frontend\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('/products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/{product}', [ProductController::class, 'show']);
});
