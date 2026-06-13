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
    Route::get('revenue', [AdminOrderController::class, 'revenue'])->name('admin.orders.revenue');

    Route::get('/users/search', [UserController::class, 'search'])->name('admin.users.search');
    Route::resource('users', UserController::class)->names('admin.users');

    Route::get('/orders/search', [AdminOrderController::class, 'search'])->name('admin.orders.search');
    Route::resource('orders', AdminOrderController::class)->names('admin.orders');

    Route::get('/products/search', [AdminProductController::class, 'search'])->name('admin.products.search');
    Route::resource('products', AdminProductController::class)->names(['index' => 'admin.products.list'])->names('admin.products');

    Route::get('/product-details/search', [ProductDetailController::class, 'search'])->name('admin.product-details.search');
    Route::resource('product-details', ProductDetailController::class)->names('admin.product-details');

    Route::resource('categories', CategoryController::class)->names(['index' => 'admin.categories.list'])->names('admin.categories');

    Route::resource('brands', BrandController::class)->names('admin.brands');
});