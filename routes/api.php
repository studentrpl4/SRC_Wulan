<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CustomerAuthController;
use App\Http\Controllers\Api\CustomerProfileController;
use App\Http\Controllers\Api\FrontController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\CustomerOrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::post('/login', [CustomerAuthController::class, 'login']);
Route::post('/register', [CustomerAuthController::class, 'register']);

Route::get('/front', [FrontController::class, 'index']);
Route::get('/front/search', [FrontController::class, 'search']);
Route::get('/front/products', [FrontController::class, 'produk']);
Route::get('/front/categories', [FrontController::class, 'allcategory']);
Route::get('/front/category/{category:slug}', [FrontController::class, 'category']);
Route::get('/front/details/{product:slug}', [FrontController::class, 'details']);

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    
    // Auth
    Route::post('/logout', [CustomerAuthController::class, 'logout']);
    Route::get('/me', [CustomerAuthController::class, 'me']);

    // Profile
    Route::get('/profile', [CustomerProfileController::class, 'show']);
    Route::put('/profile', [CustomerProfileController::class, 'update']);
    Route::post('/profile/setup', [CustomerProfileController::class, 'storeSetup']);

    // Cart
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart', [CartController::class, 'store']);
    Route::put('/cart/{cart}', [CartController::class, 'update']);
    Route::delete('/cart/{cart}', [CartController::class, 'destroy']);

    // Checkouts
    Route::post('/checkout', [CheckoutController::class, 'process']);

    // Orders
    Route::get('/orders', [CustomerOrderController::class, 'index']);
    Route::get('/orders/{id}', [CustomerOrderController::class, 'show']);
});
