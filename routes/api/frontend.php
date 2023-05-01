<?php

use App\Http\Controllers\frontend\CartController;
use App\Http\Controllers\frontend\CategoryController;
use App\Http\Controllers\frontend\FavoriteController;
use App\Http\Controllers\frontend\ProductController;
use App\Http\Controllers\frontend\RegionController;
use Illuminate\Support\Facades\Route;

Route::prefix('/categories')->group(function (){
    Route::get('/', [CategoryController::class, 'index']);
    Route::get('{category}', [CategoryController::class, 'show']);
});

Route::prefix('/products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/{product}', [ProductController::class, 'show']);
});

Route::get('/regions', [RegionController::class, 'regions']);
Route::get('/districts', [RegionController::class, 'districts']);

Route::group(['middleware' => 'auth:sanctum'], function (){
    Route::prefix('/carts')->group(function (){
       Route::get('/', [CartController::class, 'index']);
       Route::get('/{cart}', [CartController::class, 'show']);
       Route::post('/', [CartController::class, 'store']);
       Route::delete('/{cart}', [CartController::class, 'destroy']);
    });

    Route::apiResources([
        'favorites' => FavoriteController::class
    ]);
});
