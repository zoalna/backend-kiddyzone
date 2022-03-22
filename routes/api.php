<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CheckoutController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login'])->name('user.login');
Route::post('register', [AuthController::class, 'register'])->name('user.register');
Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('user.forgotpassword');
Route::get('/show-all', [ProductController::class, 'showAll'])->name('landing.show');
Route::get('/product/{slug}', [ProductController::class, 'productDetails'])->name('product.details');

//Cart routes



Route::group(['middleware' => 'auth:api'], function(){

        Route::get('cart', [CartController::class, 'cartList'])->name('cart.list');
        Route::post('clear-cart', [CartController::class, 'clearAllCart'])->name('cart.clear');
        Route::post('remove-cart', [CartController::class, 'removeCart'])->name('cart.remove');
        Route::post('update-cart', [CartController::class, 'updateCart'])->name('cart.update');
        Route::post('add-to-cart', [CartController::class, 'addToCart'])->name('cart.store');
        Route::post('cart-checkout',[CheckoutController::class,'cartCheckout'])->name('cart.checkout');
        Route::get('/my-order', [ProductController::class, 'myOrders'])->name('order.show');
        Route::get('/profile', [ProductController::class, 'profile'])->name('user.profile');
        
});

?>