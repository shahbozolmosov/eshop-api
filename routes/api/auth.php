<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('/customer')->group(function () {
    Route::post('/', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::put('/', [AuthController::class, 'updateUser'])->middleware('auth:sanctum');
    Route::put('/password', [AuthController::class, 'updatePassword'])->middleware('auth:sanctum');
    Route::get('/account', [AuthController::class, 'account'])->middleware('auth:sanctum');
});
