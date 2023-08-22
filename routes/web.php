<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PicController;
use App\Http\Controllers\ProductController;



Route::get('/', function () {
    return view('home');
});


Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
Route::post('/category/simpan', [CategoryController::class, 'simpan'])->name('category.simpan');
Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
Route::put('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
Route::get('/category/hapus/{id}', [CategoryController::class, 'delete'])->name('category.hapus');


Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier.index');
Route::post('/supplier/simpan', [SupplierController::class, 'simpan'])->name('supplier.simpan');
Route::get('/supplier/edit/{id}', [SupplierController::class, 'edit'])->name('supplier.edit');
Route::put('/supplier/update/{id}', [SupplierController::class, 'update'])->name('supplier.update');
Route::get('/supplier/hapus/{id}', [SupplierController::class, 'delete'])->name('supplier.hapus');


Route::get('/pic', [PicController::class, 'index'])->name('pic.index');
Route::post('/pic/simpan', [PicController::class, 'simpan'])->name('pic.simpan');
Route::get('/pic/edit/{id}', [PicController::class, 'edit'])->name('pic.edit');
Route::put('/pic/update/{id}', [PicController::class, 'update'])->name('pic.update');
Route::get('/pic/hapus/{id}', [PicController::class, 'delete'])->name('pic.delete');

Route::get('/product', [ProductController::class, 'index'])->name('product.index');
Route::get('/product/tambah', [ProductController::class, 'tambah'])->name('product.tambah');
Route::post('/product/simpan', [ProductController::class, 'simpan'])->name('product.simpan');
Route::get('/product/detail_product/{id}', [ProductController::class, 'detail'])->name('product.detail');
Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
Route::put('/product/update/{id}', [ProductController::class, 'update'])->name('product.update');
Route::get('/product/hapus/{id}', [ProductController::class, 'delete'])->name('product.delete');
Route::post('/product/export', [ProductController::class, 'export'])->name('product.export');
