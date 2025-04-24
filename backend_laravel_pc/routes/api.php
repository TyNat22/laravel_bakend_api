<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CustomerMiddleware;
use App\Http\Controllers\Api\RateController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\WishlistController;
use App\Http\Controllers\Api\Auth\LoginApiController;
use App\Http\Controllers\API\Auth\GoogleAuthController;
use App\Http\Controllers\Api\Auth\RegisterApiController;

Route::get('auth/google', [GoogleAuthController::class, 'redirectGoogle']);
Route::get('auth/google/callback', [GoogleAuthController::class, 'googleCallback']);
// Route::post('/google/token', [GoogleAuthController::class, 'getToken']);



Route::post('/auth/login', [LoginApiController::class, 'login']);
Route::post('/auth/register', [RegisterApiController::class, 'register']);

Route::group([
    'middleware' => 'auth:sanctum'
], function() {
    Route::group([
        'middleware' => CustomerMiddleware::class
    ], function() {
        Route::get('/products/rate&reviews', [RateController::class, 'index']);
        Route::post('/products/{product}/rate&reviews', [RateController::class, 'store']);
        Route::put('/products/{rate}/rate&reviews', [RateController::class, 'update']);
        Route::delete('/products/{rate}/rate&reviews', [RateController::class, 'destroy']);

        Route::get('/wishlist', [WishlistController::class, 'index']);
        Route::post('/wishlist', [WishlistController::class, 'store']);
        Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy']);


        //
        Route::post('/orders', [OrderController::class, 'store']);
        Route::get('/orders', [OrderController::class, 'index']);
    });

});

//Category
Route::apiResource('categories', CategoryController::class);
Route::apiResource('products', ProductController::class);

