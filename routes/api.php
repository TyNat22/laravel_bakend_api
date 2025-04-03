<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CategoryApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



//Category
Route::apiResource('categories', CategoryController::class);
Route::apiResource('products', ProductController::class);

