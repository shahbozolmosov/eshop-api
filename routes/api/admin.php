<?php

use App\Http\Controllers\admin\CategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('/admin')->group(function (){
    Route::apiResources([
        'categories' => CategoryController::class
    ]);
});
