<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ProductDetailController;
use App\Http\Controllers\Customer\ProductController as CustomerProductController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Customer\ProfileController;

Route::get('/', [CustomerProductController::class, 'home'])->name('home');
Route::get('/products', [CustomerProductController::class, 'index'])->name('products.index');
Route::get('/product-detail/{id}', [CustomerProductController::class, 'show'])->name('products.show');
Route::get('/category/{id}', [CustomerProductController::class, 'showbycategory'])->name('category.show');
Route::get('/search', [CustomerProductController::class, 'search'])->name('products.search');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [LoginController::class, 'register']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.index');
    Route::post('/cart/add/{productId}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::patch('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
    Route::delete('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('cart.checkout');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/my-orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
});

Route::prefix('/admin')->middleware('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::prefix('/users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('/search', [UserController::class, 'search'])->name('admin.users.search');
        Route::get('/create', [UserController::class, 'create'])->name('admin.users.create');
        Route::post('/', [UserController::class, 'store'])->name('admin.users.store');
        Route::get('/{id}', [UserController::class, 'show'])->name('admin.users.show');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    });

    Route::prefix('/orders')->group(function () {
        Route::get('/search', [AdminOrderController::class, 'search'])->name('admin.orders.search');
        Route::resource('orders', AdminOrderController::class)->names('admin.orders');
    });

    Route::get('revenue', [AdminOrderController::class, 'revenue'])->name('admin.orders.revenue');

    Route::prefix('/products')->group(function () {
        Route::get('/', [AdminProductController::class, 'index'])->name('admin.products.list');
        Route::get('/search', [AdminProductController::class, 'search'])->name('admin.products.search');
        Route::get('/create', [AdminProductController::class, 'create'])->name('admin.products.create');
        Route::post('/', [AdminProductController::class, 'store'])->name('admin.products.store');
        Route::get('/{id}', [AdminProductController::class, 'show'])->name('admin.products.show');
        Route::get('/{id}/edit', [AdminProductController::class, 'edit'])->name('admin.products.edit');
        Route::put('/{id}', [AdminProductController::class, 'update'])->name('admin.products.update');
        Route::delete('/{id}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');
    });

    Route::prefix('/product-details')->group(function () {
        Route::get('/', [ProductDetailController::class, 'index'])->name('admin.product-details.index');
        Route::get('/search', [ProductDetailController::class, 'search'])->name('admin.product-details.search');
        Route::get('/create', [ProductDetailController::class, 'create'])->name('admin.product-details.create');
        Route::post('/', [ProductDetailController::class, 'store'])->name('admin.product-details.store');
        Route::get('/{productDetail}', [ProductDetailController::class, 'show'])->name('admin.product-details.show');
        Route::get('/{productDetail}/edit', [ProductDetailController::class, 'edit'])->name('admin.product-details.edit');
        Route::put('/{productDetail}', [ProductDetailController::class, 'update'])->name('admin.product-details.update');
        Route::delete('/{productDetail}', [ProductDetailController::class, 'destroy'])->name('admin.product-details.destroy');
    });

    Route::prefix('/categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('admin.categories.list');
        Route::get('/create', [CategoryController::class, 'create'])->name('admin.categories.create');
        Route::post('/', [CategoryController::class, 'store'])->name('admin.categories.store');
        Route::get('/{id}', [CategoryController::class, 'show'])->name('admin.categories.show');
        Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');
        Route::put('/{id}', [CategoryController::class, 'update'])->name('admin.categories.update');
        Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');
    });

    Route::prefix('/brands')->group(function () {
        Route::resource('brands',  BrandController::class)->names('admin.brands');
    });
});
