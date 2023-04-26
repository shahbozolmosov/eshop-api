<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('/customer')->group(function () {
    Route::post('/', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::group(['prefix' => '/', 'middleware' => ['auth:sanctum']], function () {
        Route::put('/', [AuthController::class, 'updateUser']);
        Route::put('/password', [AuthController::class, 'updatePassword']);
        Route::get('/account', [AuthController::class, 'account']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});
