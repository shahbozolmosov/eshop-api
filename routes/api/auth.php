<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('/customers')->group(function () {
    Route::get('/', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::put('/', [AuthController::class, 'updateUser'])->middleware('auth:sanctum');
    Route::put('/password', [AuthController::class, 'updatePassword'])->middleware('auth:sanctum');
    Route::get('/account', [AuthController::class, 'account'])->middleware('auth:sanctum');
});
