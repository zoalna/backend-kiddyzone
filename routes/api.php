<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('login', [AuthController::class, 'login'])->name('user.login');
Route::get('register', [AuthController::class, 'register'])->name('user.register');
Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('user.forgotpassword');
Route::get('/products', [ProductController::class, 'showAllProducts'])->name('products.show');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('products.show');

Route::group(['middleware' => 'auth:api'], function(){

});

?>