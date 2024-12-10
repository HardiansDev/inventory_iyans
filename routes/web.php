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

Route::get('/', function () {
    return view('welcome');
});

// Rute yang membutuhkan login
Route::middleware(['auth', 'roleBased'])->group(function () {

    // Superadmin: akses penuh
    Route::middleware('roleBased:superadmin')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('user', UserController::class);
        Route::resource('product', ProductController::class);
        Route::post('/product/export', [ProductController::class, 'export'])->name('product.export');
        Route::post('/product/delete-all', [ProductController::class, 'deleteAll'])->name('product.deleteAll');
        Route::resource('category', CategoryController::class);
        Route::resource('supplier', SupplierController::class);
        Route::resource('pic', PicController::class);
        Route::prefix('product-in')->group(function () {
            Route::get('', [ProductInController::class, 'index'])->name('product-in.index');
        });
        Route::prefix('product-out')->group(function () {
            Route::get('', [ProductOutController::class, 'index'])->name('product-out.index');
        });
        Route::resource('customer', CustomerController::class);
    });


    // Admin Gudang: akses terbatas ke produk, kategori, supplier, PIC, produk masuk/keluar
    Route::middleware('roleBased:admin_gudang')->group(function () {
        Route::resource('product', ProductController::class)->only(['index', 'show', 'create', 'edit', 'update', 'delete']);
        Route::resource('category', CategoryController::class)->only(['index']);
        Route::resource('supplier', SupplierController::class)->only(['index']);
        Route::resource('pic', PicController::class)->only(['index']);
        Route::prefix('product-in')->group(function () {
            Route::get('', [ProductInController::class, 'index'])->name('product-in.index');
        });
        Route::prefix('product-out')->group(function () {
            Route::get('', [ProductOutController::class, 'index'])->name('product-out.index');
        });
    });

    // Kasir: akses ke menu customer
    Route::middleware('roleBased:kasir')->group(function () {
        Route::resource('customer', CustomerController::class)->only(['index', 'create', 'store', 'edit', 'update', 'delete']);
    });

    // Manager: akses ke dashboard saja
    Route::middleware('roleBased:manager')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });
});

// Rute otentikasi
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
