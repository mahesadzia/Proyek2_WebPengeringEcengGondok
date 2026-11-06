<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengaturanController;
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

    // Batch
    Route::get('/batch', [BatchController::class, 'index'])->name('batches.index');
    Route::post('/batch', [BatchController::class, 'store'])->name('batches.store');
    Route::get('/batch/{batch}', [BatchController::class, 'show'])->name('batches.show');

    // Pengaturan
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::put('/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');
});