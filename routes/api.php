<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CarouselItemsController;
use App\Http\Controllers\API\MessageController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\LoginController;


// public apis
Route::post('/register', [LoginController::class, 'register'])->name('user.register');
Route::post('/login', [LoginController::class, 'login'])->name('user.login');

// display all the listed products
Route::get('/display-products', [ProductController::class, 'DisplayAllItems']);


// sanctum middleware
Route::middleware(['auth:sanctum'])->group(function () {

    // carsumart product controllers
    Route::controller(ProductController::class)->group(function () {
        Route::post('/add-item', 'AddProduct');
        Route::get('/display-user-listing/{id}', 'displayUserListings');
        Route::delete('/delete-user-listing/{id}', 'deleteProductListings');
    });

    // lgout api endpoint
    Route::delete('/logout', [LoginController::class, 'logout']);
});
