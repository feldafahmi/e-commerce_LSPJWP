<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SellerManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/produk/{product}', function (string $product) {
    return view('products.show', ['productId' => $product]);
})->name('products.show');

Route::get('/keranjang', function () {
    return view('cart.index');
})->name('cart');

Route::get('/checkout', function () {
    return view('checkout.index');
})->name('checkout');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->prefix('penjual')->name('seller.')->group(function () {
    Route::get('/produk', [SellerManagementController::class, 'products'])->name('products');
    Route::get('/order', [SellerManagementController::class, 'orders'])->name('orders');
});
