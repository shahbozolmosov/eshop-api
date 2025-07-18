<?php

use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\DistrictController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\RegionController;
use Illuminate\Support\Facades\Route;

Route::prefix('/admin')->group(function (){
    Route::apiResources([
        'categories' => CategoryController::class,
        'products' => ProductController::class,
        'regions' => RegionController::class,
        'districts' => DistrictController::class,
    ]);
});
