<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductInController;
use App\Http\Controllers\ProductOutController;
use App\Http\Controllers\PicController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
// use App\Http\Controllers\LogoutController;
// use App\Models\Category;

Route::get('/', function () {
    return view('welcome');
});
// Dashboard Route
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Product Routes
Route::resource('product', ProductController::class);
Route::post('/product/export', [ProductController::class, 'export'])->name('product.export');
Route::post('/product/delete-all', [ProductController::class, 'deleteAll'])->name('product.deleteAll');





// Customer Routes
Route::prefix('customer')->name('customer.')->group(function () {
    Route::get('', [CustomerController::class, 'index'])->name('index');
    Route::get('create', [CustomerController::class, 'create'])->name('create');
    Route::post('store', [CustomerController::class, 'store'])->name('store');
});

// Product In Routes
Route::prefix('product-in')->name('product-in.')->group(function () {
    Route::get('', [ProductInController::class, 'index'])->name('index');
});

// Product Out Routes
Route::prefix('product-out')->name('product-out.')->group(function () {
    Route::get('', [ProductOutController::class, 'index'])->name('index');
});

// PIC Routes
Route::resource('pic', PicController::class);

// Category Routes
Route::resource('category', CategoryController::class);

// Supplier Routes
Route::resource('supplier', SupplierController::class);


// User Routes
Route::prefix('user')->name('user.')->group(function () {
    Route::get('', [UserController::class, 'index'])->name('index');
});

// Rute Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Rute Register
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Rute Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
