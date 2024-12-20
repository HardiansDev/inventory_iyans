<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductInController;

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
    Route::post('/product/download-pdf', [ProductController::class, 'downloadPdf'])->name('product.downloadPdf');
    Route::post('/product/download-excel', [ProductController::class, 'downloadExcel'])->name('product.downloadExcel');
    Route::get('/get-product-details/{productId}', [ProductController::class, 'getProductDetails']);
    Route::resource('productin', ProductInController::class);
    Route::get('/detail-cekout', [CheckoutController::class, 'showCheckout'])->name('detail-cekout');
    Route::post('/productin/store', [ProductInController::class, 'storeProductIn'])->name('productin.storeProductIn');
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
Route::middleware(['auth', 'role:kasir,superadmin'])->group(function () {
    Route::resource('sales', SalesController::class);
    Route::get('/detail-cekout', [CheckoutController::class, 'showCheckout'])->name('detail-cekout');
});



// Rute otentikasi
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
