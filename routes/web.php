<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BuyerOrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellerCategoryController;
use App\Http\Controllers\SellerManagementController;
use App\Http\Controllers\SellerOrderController;
use App\Http\Controllers\SellerProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CatalogController::class, 'index'])->name('home');
Route::get('/kategori/{category:slug}', [CatalogController::class, 'category'])->name('categories.show');

Route::get('/produk/{product}', [ProductController::class, 'show'])->name('products.show');

Route::middleware(['auth', 'buyer'])->group(function () {
    Route::get('/keranjang', [CartController::class, 'index'])->name('cart');
    Route::post('/keranjang/produk/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/keranjang/item/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/keranjang/item/{item}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/pesanan', [BuyerOrderController::class, 'index'])->name('orders.index');
    Route::get('/pesanan/{order}', [BuyerOrderController::class, 'show'])->name('orders.show');
    Route::post('/pesanan/{order}/bukti-pembayaran', [BuyerOrderController::class, 'uploadPaymentProof'])->name('orders.payment-proof.store');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::get('/profil', [ProfileController::class, 'show'])->middleware('auth')->name('profile');

Route::middleware(['auth', 'seller'])->prefix('penjual')->name('seller.')->group(function () {
    Route::get('/produk', [SellerManagementController::class, 'products'])->name('products');
    Route::get('/produk/tambah', [SellerProductController::class, 'create'])->name('products.create');
    Route::post('/produk', [SellerProductController::class, 'store'])->name('products.store');
    Route::get('/produk/{product}/ubah', [SellerProductController::class, 'edit'])->name('products.edit');
    Route::put('/produk/{product}', [SellerProductController::class, 'update'])->name('products.update');
    Route::delete('/produk/{product}', [SellerProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/kategori', [SellerCategoryController::class, 'index'])->name('categories.index');
    Route::post('/kategori', [SellerCategoryController::class, 'store'])->name('categories.store');
    Route::put('/kategori/{category}', [SellerCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/kategori/{category}', [SellerCategoryController::class, 'destroy'])->name('categories.destroy');
    Route::get('/order', [SellerManagementController::class, 'orders'])->name('orders');
    Route::get('/order/{order}', [SellerOrderController::class, 'show'])->name('orders.show');
    Route::post('/order/{order}/confirm', [SellerOrderController::class, 'confirm'])->name('orders.confirm');
    Route::post('/order/{order}/reject', [SellerOrderController::class, 'reject'])->name('orders.reject');
    Route::post('/order/{order}/process', [SellerOrderController::class, 'process'])->name('orders.process');
    Route::post('/order/{order}/ship', [SellerOrderController::class, 'ship'])->name('orders.ship');
    Route::post('/order/{order}/complete', [SellerOrderController::class, 'complete'])->name('orders.complete');
});
