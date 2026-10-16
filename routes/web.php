<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Login (hanya untuk tamu)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Halaman yang butuh login
Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Halaman berikut dibuat pada tahap selanjutnya.
    // Route::get('/batch', [BatchController::class, 'index'])->name('batches.index');
    // Route::get('/batch/{batch}', [BatchController::class, 'show'])->name('batches.show');
    // Route::get('/pengaturan', [SettingController::class, 'index'])->name('settings.index');
});