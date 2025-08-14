<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductInController;
use App\Http\Controllers\SalesDetailController;
use App\Http\Controllers\WorkScheduleController;
use App\Http\Controllers\EmployeeAttendanceController;
use App\Http\Controllers\EmploymentStatusController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\NotificationController;

Route::get('/', function () {
    return view('welcome');
});


// ==========================
// Verifikasi Email
// ==========================
// Route::get('/email/verify', function () {
//     return view('auth.verify-email');
// })->middleware('auth')->name('verification.notice');

// Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {
//     $user = \App\Models\User::findOrFail($id);

//     if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
//         abort(403, 'Link verifikasi tidak valid.');
//     }

//     Auth::login($user);

//     if (!$user->hasVerifiedEmail()) {
//         $user->markEmailAsVerified();
//         event(new \Illuminate\Auth\Events\Verified($user));
//     }

//     // 🔄 Pakai method redirectByRole dari controller
//     return app(AuthController::class)->redirectByRole($user)->with('success', 'Email berhasil diverifikasi!');
// })->middleware(['signed'])->name('verification.verify');

// Kirim ulang email verifikasi
// Route::post('/email/verification-notification', function (Request $request) {
//     $request->user()->sendEmailVerificationNotification();
//     return back()->with('success', 'Link verifikasi email telah dikirim ulang.');
// })->middleware(['auth', 'throttle:6,1'])->name('verification.send');


// ==========================
// Halaman Dashboard
// ==========================
Route::middleware(['auth', 'role:superadmin,manager'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('employment_status', EmploymentStatusController::class);
    Route::resource('department', DepartmentController::class);
    Route::resource('position', PositionController::class);
    Route::get('report/penjualan', [ReportController::class, 'penjualan'])->name('report.penjualan');
    Route::get('report/penjualan/pdf', [ReportController::class, 'penjualanPdf'])->name('report.penjualan.pdf');
});

// User Management (hanya Superadmin)
Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::resource('user', UserController::class);
});

// Produk (Superadmin)
Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::resource('product', ProductController::class);
    Route::post('/product/export', [ProductController::class, 'export'])->name('product.export');
    Route::delete('/products/bulk-delete', [ProductController::class, 'bulkDelete'])->name('product.bulkDelete');
    Route::post('/product/download-pdf', [ProductController::class, 'downloadPdf'])->name('product.downloadPdf');
    Route::post('/product/download-excel', [ProductController::class, 'downloadExcel'])->name('product.downloadExcel');
    Route::get('/export/pdf', [ExportController::class, 'pdf'])->name('export.pdf');
    Route::get('/export/excel', [ExportController::class, 'excel'])->name('export.excel');
    Route::get('/get-product-details/{productId}', [ProductController::class, 'getProductDetails']);
});

Route::middleware(['auth', 'role:admin_gudang'])->group(function () {
    Route::resource('productin', ProductInController::class);
    Route::post('/productin/bulk-delete', [ProductInController::class, 'bulkDelete'])->name('productin.bulkDelete');
    Route::post('/productin/store', [ProductInController::class, 'storeProductIn'])->name('productin.storeProductIn');
    Route::post('/productin/add-stock/{id}', [ProductInController::class, 'addStock'])->name('productin.addStock');
    Route::post('/productin/add-stock-toko/{id}', [ProductInController::class, 'addStockKeToko'])->name('productin.addStockKeToko');
    Route::put('/productin/update-status/{id}', [ProductInController::class, 'updateStatus'])->name('productin.updateStatus');
});



Route::middleware(['auth', 'role:superadmin,admin_gudang'])->group(function () {
    Route::get('/product-in/{id}/confirm', [ProductInController::class, 'showConfirmation'])->name('product.confirmation');
    Route::post('/product-in/{id}/approve', [ProductInController::class, 'approve'])->name('product.approve');
    Route::post('/product-in/{id}/reject', [ProductInController::class, 'reject'])->name('product.reject');
    // Notifikasi Superadmin
    Route::get('/notifications/superadmin', [NotificationController::class, 'superadminIndex'])
        ->name('notifications.superadmin');

    Route::get('/notifications/admin-gudang', [NotificationController::class, 'adminGudangIndex'])->name('notifications.admin_gudang');
    Route::get('/notifications/admin-gudang/{id}', [NotificationController::class, 'showAdminGudang'])->name('notifications.admin_gudang.show');
});


// Kategori & Supplier
Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::resource('category', CategoryController::class);
    Route::resource('supplier', SupplierController::class);
    Route::resource('bahan_baku', BahanBakuController::class);
});

// Penjualan & Diskon (Kasir & Superadmin)
Route::middleware(['auth', 'role:kasir,superadmin,admin_gudang'])->group(function () {
    Route::resource('sales', SalesController::class);
    Route::post('/set-wishlist', [CheckoutController::class, 'setWishlist'])->name('set.wishlist');
    Route::get('/detail-cekout', [CheckoutController::class, 'showCheckout'])->name('detail-cekout');
    Route::post('/proses-pembayaran', [SalesDetailController::class, 'processPayment'])->name('process.payment');
    Route::post('/store-sales-detail', [SalesDetailController::class, 'storeSalesDetail'])->name('store.sales.detail');
    Route::get('/print-receipt/{transaction_number}', [SalesDetailController::class, 'printReceipt'])->name('print.receipt');
    Route::resource('discounts', DiscountController::class);
});



// Karyawan & Absensi
Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::resource('employees', EmployeeController::class);
    Route::resource('employee-attendance', EmployeeAttendanceController::class)->except(['show']);
    Route::get('employee-attendance/scan', [EmployeeAttendanceController::class, 'scanQR'])->name('employee-attendance.scan');
    Route::post('/employee-attendance/scan/upload', [EmployeeAttendanceController::class, 'processUpload'])->name('employee-attendance.processUpload');
    Route::post('/employee-attendance/qr-store', [EmployeeAttendanceController::class, 'qrStore'])->name('employee-attendance.qrStore');
    Route::get('/employees/{id}/download-qr', [EmployeeController::class, 'downloadQrCode'])->name('employees.downloadQr');

    Route::resource('work-schedules', WorkScheduleController::class);
});


// ==========================
// Auth: Login & Register
// ==========================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
