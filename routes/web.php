<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductInController;
use App\Http\Controllers\ProductOutController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

// Rute dashboard
Route::middleware(['auth', 'role:superadmin,manager'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Rute user management (khusus superadmin)
Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::resource('user', UserController::class);
});

// Rute produk (khusus superadmin dan admin_gudang)
Route::middleware(['auth', 'role:superadmin,admin_gudang'])->group(function () {
    Route::resource('product', ProductController::class);
    Route::post('/product/export', [ProductController::class, 'export'])->name('product.export');
    Route::post('/product/delete-all', [ProductController::class, 'deleteAll'])->name('product.deleteAll');
    // Route::post('/productin/create', [ProductInController::class, 'masal'])->name('productin.masal');
    Route::resource('productin', ProductInController::class);
    Route::put('/productin/update-status/{id}', [ProductInController::class, 'updateStatus'])->name('productin.updateStatus');
});

// Rute kategori (khusus superadmin dan admin_gudang)
Route::middleware(['auth', 'role:superadmin,admin_gudang'])->group(function () {
    Route::resource('category', CategoryController::class);
});

// Rute supplier (khusus superadmin dan admin_gudang)
Route::middleware(['auth', 'role:superadmin,admin_gudang'])->group(function () {
    Route::resource('supplier', SupplierController::class);
});



// Rute produk keluar (khusus kasir)
Route::middleware(['auth', 'role:kasir,superadmin'])->prefix('product-out')->group(function () {
    Route::get('', [ProductOutController::class, 'index'])->name('product-out.index');
});



// Rute otentikasi
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
