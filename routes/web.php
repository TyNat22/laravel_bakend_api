<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\OrderCartController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\API\Auth\GoogleAuthController;
use App\Http\Controllers\BannerController;

Route::get('/', function () {
    return view('auth.login');
});

// Auth::routes();
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login',[LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register',[RegisterController::class, 'register']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('auth/google', [GoogleAuthController::class, 'redirectGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleAuthController::class, 'googleCallback'])->name('auth.google.callback');
// Route::group([
//     'middleware' => 'auth:sanctum'
// ], function() {

    Route::group([
        'middleware' => AdminMiddleware::class
    ], function() {
       Route::get('/admin/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
       //Category
       Route::get('/admin/category', [CategoryController::class, 'category'])->name('admin.category');
       Route::get('/admin/category/create', [CategoryController::class, 'create'])->name('admin.category.create');
       Route::get('/admin/category/{id}/show', [CategoryController::class, 'show'])->name('admin.category.show');
       Route::post('/admin/category/store', [CategoryController::class, 'store'])->name('admin.category.store');
       Route::delete('/admin/category/destroy/{id}', [CategoryController::class, 'destory'])->name('admin.category.destroy');
       Route::get('/admin/category/{id}/edit', [CategoryController::class, 'edit'])->name('admin.category.edit');
       Route::put('/admin/category/update/{id}', [CategoryController::class, 'update'])->name('admin.category.update');

       //product
         Route::get('/admin/product', [ProductController::class, 'index'])->name('admin.product');
         Route::get('/admin/product/create', [ProductController::class, 'create'])->name('admin.product.create');
         Route::post('/admin/product/store', [ProductController::class, 'store'])->name('admin.product.store');
         Route::get('/admin/product/{id}/edit', [ProductController::class, 'edit'])->name('admin.product.edit');
         Route::put('/admin/product/{id}/update', [ProductController::class, 'update'])->name('admin.product.update');
         Route::delete('/admin/product/{id}/delete', [ProductController::class, 'destroy'])->name('admin.product.destroy');
        //  Route::get('/admin/product/search', [ProductController::class, 'search'])->name('admin.product.search');
         Route::get('/admin/product/filter', [ProductController::class, 'filter'])->name('admin.product.filter');



         //label
         Route::get('/admin/label',[LabelController::class,'index'])->name('admin.label');
         Route::get('/admin/label/create',[LabelController::class,'create'])->name('admin.label.create');
         Route::get('/admin/label/{id}/show',[LabelController::class,'show'])->name('admin.label.show');
         Route::post('/admin/label/store',[LabelController::class,'store'])->name('admin.label.store');
         Route::get('/admin/label/{id}/edit',[LabelController::class,'edit'])->name('admin.label.edit');
         Route::put('/admin/label/{id}/update',[LabelController::class,'update'])->name('admin.label.update');
         Route::delete('/admin/label/{id}/delete',[LabelController::class,'destroy'])->name('admin.label.delete');

         //wishlist
         Route::get('/admin/wishlist',[WishlistController::class,'index'])->name('admin.wishlist');
         Route::get('/admin/wishlist/{id}/user',[WishlistController::class,'showUser'])->name('admin.wishlist.user');
         Route::get('/admin/wishlist/{id}/product',[WishlistController::class,'showProduct'])->name('admin.wishlist.product');
         Route::delete('/admin/wishlist/{id}/delete',[WishlistController::class,'destroy'])->name('admin.wishlist.delete');


         //Rate
         Route::get('/admin/rate',[RateController::class,'index'])->name('admin.rate');
         Route::get('/admin/rate/user/{userId}', [RateController::class, 'showUser'])->name('admin.rate.showUser');
         Route::get('/admin/rate/product/{productId}', [RateController::class, 'showProduct'])->name('admin.rate.showProduct');

         //order_cart
        //  Route::get('admin/order',[OrderCartController::class,'index'])->name('admin.order');
        //  Route::get('admin/order/create',[OrderCartController::class,'create'])->name('admin.order.create');
        //  Route::post('admin/order/store',[OrderCartController::class,'store'])->name('admin.order.store');
        //  Route::delete('admin/order/{id}/delete',[OrderCartController::class,'destroy'])->name('admin.order.delete');

         //user
         Route::get('/admin/user',[UserController::class,'index'])->name('admin.user');
         Route::get('/admin/user/create',[UserController::class,'create'])->name('admin.user.create');
        //  Route::post('/admin/user/store',[UserController::class,'store'])->name('admin.user.store');
         Route::delete('/admin/user/{id}/delete',[UserController::class,'destroy'])->name('admin.user.delete');

         //order
         Route::get('admin/orders',[OrderController::class,'index'])->name('admin.order');
        //  Route::get('admin/orders/{id}',[OrderController::class,'show']);

        //
        Route::get('/admin/banner',[BannerController::class,'index'])->name('admin.banner');
        Route::get('/admin/banner/create',[BannerController::class,'create'])->name('admin.banner.create');
        Route::post('/admin/banner/store',[BannerController::class,'store'])->name('admin.banner.store');
        Route::get('/admin/banner/{id}/edit',[BannerController::class,'edit'])->name('admin.banner.edit');
        Route::put('/admin/banner/{id}/update',[BannerController::class,'update'])->name('admin.banner.update');
        Route::delete('/admin/banner/{id}/delete',[BannerController::class,'destroy'])->name('admin.banner.delete');


    });

// });
