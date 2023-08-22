<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PicController;
use App\Http\Controllers\ProductController;



Route::get('/', function () {
    return view('home');
});

Route::prefix('category')->name('category.')->group(function (){
    Route::get('', [CategoryController::class, 'index'])->name('index');
    Route::post('/simpan', [CategoryController::class, 'simpan'])->name('simpan');
    Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [CategoryController::class, 'update'])->name('update');
    Route::get('/hapus/{id}', [CategoryController::class, 'delete'])->name('hapus');
});

Route::prefix('supplier')->name('supplier.')->group(function () {
    Route::get('', [SupplierController::class, 'index'])->name('index');
    Route::post('/simpan', [SupplierController::class, 'simpan'])->name('simpan');
    Route::get('/edit/{id}', [SupplierController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [SupplierController::class, 'update'])->name('update');
    Route::get('/hapus/{id}', [SupplierController::class, 'delete'])->name('hapus');
});

Route::prefix('pic')->name('pic.')->group(function () {
    Route::get('', [PicController::class, 'index'])->name('index');
    Route::post('/simpan', [PicController::class, 'simpan'])->name('simpan');
    Route::get('/edit/{id}', [PicController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [PicController::class, 'update'])->name('update');
    Route::get('/hapus/{id}', [PicController::class, 'delete'])->name('delete');
});

Route::prefix('product')->name('product.')->group(function () {
    Route::get('', [ProductController::class, 'index'])->name('index');
    Route::get('/tambah', [ProductController::class, 'tambah'])->name('tambah');
    Route::post('/simpan', [ProductController::class, 'simpan'])->name('simpan');
    Route::get('/detail_product/{id}', [ProductController::class, 'detail'])->name('detail');
    Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [ProductController::class, 'update'])->name('update');
    Route::get('/hapus/{id}', [ProductController::class, 'delete'])->name('delete');
    Route::post('/export', [ProductController::class, 'export'])->name('export');
});



