<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\RegistrationController as AdminRegistrationController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\ProgressReportController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [LandingController::class, 'index'])->name('home');
Route::post('/pendaftaran', [RegistrationController::class, 'store'])->name('pendaftaran.store');
Route::get('/pendaftaran/status/{code?}', [RegistrationController::class, 'status'])->name('pendaftaran.status');
Route::post('/pembayaran/snap/{code}', [PaymentController::class, 'getSnapToken'])->name('pembayaran.snap');
Route::post('/pembayaran/notification', [PaymentController::class, 'handleNotification'])->name('pembayaran.notification');

// Auth Redirect Alias
Route::get('/login', fn() => redirect()->route('admin.login'))->name('login');

// Admin Auth Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Protected Admin Routes
    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Modul Jadwal
        Route::resource('jadwal', ScheduleController::class)->except(['create', 'edit', 'show']);
        Route::post('jadwal/{id}/toggle', [ScheduleController::class, 'toggleStatus'])->name('jadwal.toggle');

        // Modul Pendaftaran
        Route::resource('pendaftaran', AdminRegistrationController::class);
        Route::put('pendaftaran/{id}/status', [AdminRegistrationController::class, 'updateStatus'])->name('pendaftaran.update-status');

        // Modul Siswa
        Route::resource('siswa', StudentController::class)->except(['create', 'store']);

        // Modul Absensi
        Route::resource('absensi', AttendanceController::class);

        // Modul Laporan Perkembangan
        Route::resource('laporan-perkembangan', ProgressReportController::class);
        Route::get('laporan-perkembangan/{id}/pdf', [ProgressReportController::class, 'downloadPdf'])->name('laporan-perkembangan.pdf');

        // Modul Pembayaran
        Route::get('pembayaran/{id}/receipt', [AdminPaymentController::class, 'receipt'])->name('pembayaran.receipt');
        Route::resource('pembayaran', AdminPaymentController::class)->only(['index', 'create', 'store', 'destroy']);
        Route::put('pembayaran/{id}/status', [AdminPaymentController::class, 'updateStatus'])->name('pembayaran.update-status');
        Route::put('pembayaran/{id}/confirm', [AdminPaymentController::class, 'confirm'])->name('pembayaran.confirm');

        // Modul Pengaturan
        Route::get('pengaturan', [SettingController::class, 'index'])->name('pengaturan.index');
        Route::put('pengaturan', [SettingController::class, 'update'])->name('pengaturan.update');
    });
});
