<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('customer')->name('customer.')->group(function(){
    Route::get('/register', [CustomerController::class, 'create'])->name('register');
    Route::post('/register', [CustomerController::class, 'store'])->name('store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/product/{product:slug}/review', [ProductReviewController::class, 'store'])->name('product-review.store');
    Route::get('/account', [AccountController::class, 'show'])->name('account.show');
    Route::post('/account/address', [AccountController::class, 'storeCustomerAddress'])->name('account.store-address');
});

Route::prefix('cart')->name('cart.')->group(function(){
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{product:slug}', [CartController::class, 'add'])->name('add');
    Route::post('/remove/{product:slug}', [CartController::class, 'removeItemFromCart'])->name('remove');
    Route::post('/update-quantity/{product:slug}', [CartController::class, 'updateQuantity'])->name('update-quantity');
});

Route::prefix('categories')->name('categories.')->group(function(){
    Route::get('/{category:slug}', [ProductController::class, 'viewProductsByCategory'])->name('view-products-by-category');
});

Route::prefix('products')->name('products.')->group(function(){
    Route::get('/{product:slug}', [ProductController::class, 'viewSingleProduct'])->name('view');
});

require __DIR__.'/auth.php';
