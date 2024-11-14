<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfilController;

// Public Routes
Route::get('/', [UserController::class, 'login'])->name('login');
Route::post('/login-proses', [UserController::class, 'login_proses'])->name('login-proses');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/register-proses', [UserController::class, 'register_proses'])->name('register-proses');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home.index');

    Route::get('/profile', [ProfilController::class, 'index'])->name('profile.index');
    Route::put('/profile/update', [ProfilController::class, 'update'])->name('profile.update');

    Route::get('/dosen', [DosenController::class, 'index'])->name('dosen.index');
    
    Route::get('/dosen/create', [DosenController::class, 'create'])->name('dosen.create');
    Route::post('/dosen/store', [DosenController::class, 'store'])->name('dosen.store');

    Route::get('/dosen/{id}/edit', [DosenController::class, 'edit'])->name('dosen.edit');
    Route::put('/dosen/{id}', [DosenController::class, 'update'])->name('dosen.update');

    Route::get('/dosen/detail/{id}', [DosenController::class, 'detail'])->name('dosen.detail');

    Route::get('/dosen/filter', [DosenController::class, 'filter']);

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/filter', [LaporanController::class, 'filter']);
    Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export-pdf');
    Route::get('/laporan/export-excel', [LaporanController::class, 'exportExcel'])->name('laporan.export-excel');
});