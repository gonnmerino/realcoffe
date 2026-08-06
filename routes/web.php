<?php

use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StorefrontController;
use Illuminate\Support\Facades\Route;

Route::view('/welcome', 'welcome')->name('home');
Route::get('/', [StorefrontController::class, 'index'])->name('homepage');
Route::post('/cart/add/{product}', [StorefrontController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{id}', [StorefrontController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{id}', [StorefrontController::class, 'remove'])->name('cart.remove');
Route::get('/checkout', [StorefrontController::class, 'checkout'])->name('checkout');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');

require __DIR__ . '/settings.php';

Route::middleware(['auth', 'verified'])->group(function () {

  Route::middleware(['dashboard.roles'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    Route::get('/dashboard/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/dashboard/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/dashboard/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/dashboard/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/dashboard/products/{id}', [ProductController::class, 'update'])->name('products.update');

    Route::get('/dashboard/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/dashboard/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::get('/dashboard/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/dashboard/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::post('/dashboard/categories', [CategoryController::class, 'store'])->name('categories.store');

    Route::get('/dashboard/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/dashboard/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/dashboard/users/{id}', [UserController::class, 'update'])->name('users.update');

    Route::get('/dashboard/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/dashboard/orders/{id}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::put('/dashboard/orders/{id}', [OrderController::class, 'update'])->name('orders.update');
    //Route::post('/dashboard/orders', [OrderController::class, 'store'])->name('orders.update');
    Route::get('/dashboard/orders/{id}/history', [OrderController::class, 'history'])->name('orders.history');

    Route::get('/dashboard/availability', [AvailabilityController::class, 'index'])->name('availability.index');
    Route::get('/dashboard/availability/create', [AvailabilityController::class, 'create'])->name('availability.create');
    Route::post('/dashboard/availability', [AvailabilityController::class, 'store'])->name('availability.store');
    Route::get('/dashboard/availability/{id}/edit', [AvailabilityController::class, 'edit'])->name('availability.edit');
    Route::put('/dashboard/availability/{id}', [AvailabilityController::class, 'update'])->name('availability.update');
    Route::delete('/dashboard/availability/{id}', [AvailabilityController::class, 'destroy'])->name('availability.destroy');
  });

});

//TODO: Edicion de roles,
// # Cada rol puede modificar un cambio de estado del pedido, ✔️
// # Mecanica carrito ✔️
// # Quitar botones "ver" del dashboard y revision global de comportamiento ✔️
