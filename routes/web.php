<?php

use App\Http\Controllers\RequestLaguController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;

// Redirect root to login
Route::get('/', function () {
    return redirect('/login');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

// Google OAuth
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::delete('/request/{id}', [AdminController::class, 'destroy'])->name('admin.request.destroy');
});

// Siswa/Pengguna Routes
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->group(function () {
    Route::get('/dashboard', [SiswaController::class, 'index'])->name('siswa.dashboard');
    Route::post('/request', [SiswaController::class, 'store'])->name('siswa.request.store');
});

Route::get('/migrate-db', function () {
    \Illuminate\Support\Facades\Artisan::call('migrate:fresh', ['--force' => true]);
    return "Database berhasil dimigrasi!";
});
