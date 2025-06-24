<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\StatisticsController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/struktur-organisasi', [AboutController::class, 'struktur_organisasi'])->name('struktur-organisasi');

Route::get('/tugas-fungsi', [AboutController::class, 'tugas_fungsi'])->name('tugas-fungsi');

Route::get('/berita', [NewsController::class, 'berita'])->name('berita');

Route::get('/berita/{slug}', [NewsController::class, 'BeritaSelengkapnya'])->name('berita-selengkapnya');

// Document routes
Route::get('/dokumen', [DocumentController::class, 'index'])->name('dokumen');
Route::get('/dokumen/{kategori}', [DocumentController::class, 'show'])->name('dokumen.kategori');
Route::get('/dokumen/download/{id}', [DocumentController::class, 'download'])->name('dokumen.download');

// // API routes untuk AJAX (opsional)
// Route::prefix('api')->group(function () {
//     Route::get('/documents', [DocumentController::class, 'index'])->name('api.documents.index');
// });

// Routes untuk statistik
Route::prefix('statistics')->name('statistics.')->group(function () {
    // Halaman utama statistik
    Route::get('/', [StatisticsController::class, 'statistics'])->name('statistics');
    
    // Widget statistik (untuk embed)
    // Route::get('/widget', [StatisticsController::class, 'widget'])->name('widget');
});

// // API Routes untuk AJAX
// Route::prefix('api/statistics')->name('api.statistics.')->group(function () {
//     // Get all statistics
//     Route::get('/', [StatisticsController::class, 'getStatistics'])->name('all');
    
//     // Get specific statistic by name
//     Route::get('/{name}', [StatisticsController::class, 'getStatistic'])->name('show');
// });