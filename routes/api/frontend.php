<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\frontend\CategoryController;
use App\Http\Controllers\frontend\FavoriteController;
use App\Http\Controllers\frontend\ProductController;
use App\Http\Controllers\frontend\LocationController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::prefix('/categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::get('{category}', [CategoryController::class, 'show']);
});

Route::prefix('/products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/{product}', [ProductController::class, 'show']);
});

Route::get('/regions', [LocationController::class, 'regions']);
Route::get('/districts', [LocationController::class, 'districts']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/address/current', [AddressController::class, 'changeCurrentAddress']);

    Route::prefix('/orders')->group(function (){
       Route::get('/', [OrderController::class, 'index']);
       Route::get('/{order}', [OrderController::class, 'show']);
       Route::post('/', [OrderController::class, 'store']);
       Route::delete('/{order}', [OrderController::class, 'destroy']);
    });

    Route::apiResources([
        'favorites' => FavoriteController::class,
        'address' => AddressController::class,
    ]);
});
