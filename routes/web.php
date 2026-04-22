<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\CustomerProfileController;
use App\Http\Controllers\FrontController;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontController::class, 'index'])->name('front.index');
Route::get('/test', function () {
    return view('welcome');
})->name('test');



Route::get('/search', [FrontController::class, 'search'])->name('front.search');

Route::get('/browse/{category:slug}', [FrontController::class, 'category'])->name('front.category');

Route::get('/details/{product:slug}', [FrontController::class, 'details'])->name('front.details');
Route::get('/produk', [FrontController::class, 'produk'])->name('produk');
Route::get('/category', [FrontController::class, 'allcategory'])->name('category');

Route::post('/midtrans/callback', [CheckoutController::class, 'handleMidtransCallback'])->withoutMiddleware([VerifyCsrfToken::class]);


// Route::get('/check-booking', [OrderController::class, 'checkBooking']) -> name('front.check_booking');
// Route::post('/check-booking/details', [OrderController::class, 'checkBookingDetails']) -> name('front.check_booking_details');

// Route::post('/order/begin/{product:slug}', [OrderController::class, 'saveOrder'])->name('front.save_order');

// Route::get('/order/booking/', [OrderController::class, 'booking'])->name('front.booking');

// Route::get('/order/booking/customer-data', [OrderController::class, 'customerData'])->name('front.customer_data');
// Route::post('/order/booking/customer-data/save', [OrderController::class, 'saveCustomerData'])->name('front.save_customer_data');

// Route::get('/order/payment', [OrderController::class, 'payment'])->name('front.payment');
// Route::post('/order/payment/confirm', [OrderController::class, 'paymentConfirm'])->name('front.payment_confirm');

// Route::get('/order/finished/{productTransaction:id}', [OrderController::class, 'orderFinished'])->name('front.order_finished');





Route::middleware('guest:customer')->group(function () {

    // LOGIN
    Route::get('/login', [CustomerAuthController::class, 'showLogin'])->name('customer.auth.login');
    Route::post('/login', [CustomerAuthController::class, 'login']);

    // REGISTER
    Route::get('/register', [CustomerAuthController::class, 'showRegister'])->name('customer.auth.register');
    Route::post('/register', [CustomerAuthController::class, 'register']);
});

Route::middleware(['auth:customer'])->group(function () {

    // SETUP PROFILE (tidak memakai check.customer.profile)
    Route::get('/setup-profile', [CustomerProfileController::class, 'showSetupProfile'])
        ->name('customer.setupProfile');

    Route::get('/datail-profile', [CustomerProfileController::class, 'showdatailProfile'])
        ->name('customer.detail.profile');

    Route::post('/setup-profile', [CustomerProfileController::class, 'storeSetupProfile']);

    Route::get('/profile', [CustomerProfileController::class, 'showProfile'])
        ->name('customer.profile');

    Route::put('/profile', [CustomerProfileController::class, 'updateProfile'])
        ->name('customer.profile.update');


    // ROUTE YANG BUTUH PROFIL LENGKAP
    Route::middleware(['check.customer.profile'])->group(function () {

        Route::get('/dashboard', function () {})->name('customer.dashboard');
    });

    Route::post('/logout', [CustomerAuthController::class, 'logout'])
        ->name('customer.logout');

    Route::post('/cart/add', [FrontController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [FrontController::class, 'cart'])->name('cart.index')->middleware('auth');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

    Route::get('/order.success', [FrontController::class, 'order_success'])->name('order.success');
    Route::get('/orders', [CustomerOrderController::class, 'index'])->name('customer.orders')->middleware('auth');


    // Route::get('/orders/{order}', [CustomerOrderController::class, 'show'])
    //     ->name('customer.orders.show');

    // Route::get('/orders/{order}/track', [CustomerOrderController::class, 'track'])
    //     ->name('customer.orders.track');

    // Route::put('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');

    Route::post('/cart/{cart}/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');

    Route::get('/orders/{order}', [CustomerOrderController::class, 'showDetail'])->name('orders.show');
});
