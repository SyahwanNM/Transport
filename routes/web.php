<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComparisonController;
use App\Http\Controllers\AdminController;

// Routes untuk Sistem Perhitungan Rekomendasi Multikriteria (Project Baru)
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/hitung-tarif', [ComparisonController::class, 'index'])->name('comparison.index');
Route::post('/compare', [ComparisonController::class, 'compare'])->name('comparison.compare');
Route::get('/result', [ComparisonController::class, 'result'])->name('comparison.result');

// Routes untuk Admin
Route::prefix('admin')->name('admin.')->group(function () {
    // Login (public) dengan rate limiting
    Route::get('/login', [AdminController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminController::class, 'login'])
        ->middleware('throttle:admin-login'); // Named rate limiter: 5 percobaan per 1 menit
    
    // Protected routes (memerlukan login admin)
    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
    
        // Kelola Kota
    Route::prefix('kota')->name('kota.')->group(function () {
            Route::get('/', [AdminController::class, 'indexKota'])->name('index');
            Route::get('/create', [AdminController::class, 'createKota'])->name('create');
            Route::post('/store', [AdminController::class, 'storeKota'])->name('store');
            Route::get('/{id}/edit', [AdminController::class, 'editKota'])->name('edit');
            Route::put('/{id}', [AdminController::class, 'updateKota'])->name('update');
            Route::delete('/{id}', [AdminController::class, 'destroyKota'])->name('destroy');
        });
        
        // History
        Route::get('/history', [AdminController::class, 'history'])->name('history');
    });
});