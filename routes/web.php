<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\LogAktivitasController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\AutoFieldController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsAdminOrOperator;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman Utama -> Landing Page
Route::get('/', function () {
    return view('landing');
})->name('landing');

// GUEST (Belum Login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
});

// AUTH (Sudah Login)
Route::middleware('auth')->group(function () {
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // --- FITUR NOTIFIKASI (FASE 8) ---
    // Ini rute yang tadi error (Missing Route)
    Route::get('/notifikasi/baca/{id}', [NotifikasiController::class, 'baca'])->name('notifikasi.baca');
    // TAMBAHKAN INI:
    Route::get('/notifikasi/baca-semua', [NotifikasiController::class, 'tandaiSemuaDibaca'])->name('notifikasi.bacaSemua');

    // --- FITUR LAPORAN ---
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::post('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');
    Route::post('/laporan/check', [LaporanController::class, 'checkLaporan'])->name('laporan.check');

    // --- FITUR DOKUMEN ---
    Route::get('dokumen/{dokumen}/download', [DokumenController::class, 'download'])->name('dokumen.download');
    Route::get('dokumen/{dokumen}/preview', [DokumenController::class, 'preview'])->name('dokumen.preview');
    Route::resource('dokumen', DokumenController::class);

    // --- FITUR AUTO FIELD / CETAK SURAT (Admin + Operator) ---
    Route::prefix('cetak-surat')
        ->name('autofield.')
        ->middleware(IsAdminOrOperator::class)
        ->group(function () {
            Route::get('/', [AutoFieldController::class, 'index'])->name('index');
            Route::post('/cari-warga', [AutoFieldController::class, 'cariWarga'])->name('cariWarga');
            Route::post('/generate', [AutoFieldController::class, 'generate'])->name('generate');
            Route::get('/riwayat', [AutoFieldController::class, 'riwayat'])->name('riwayat');
        });

    // --- AREA KHUSUS ADMIN ---
    Route::prefix('admin')
        ->name('admin.')
        ->middleware(IsAdmin::class)
        ->group(function () {
        
            // CRUD Kategori
            Route::resource('kategori', KategoriController::class)->except(['show']);
            
            // CRUD User
            Route::resource('users', UserController::class)->except(['show']);

            // --- FASE 9: LOG AKTIVITAS ---
            Route::get('/logs', [LogAktivitasController::class, 'index'])->name('logs.index');

            // --- FASE 11: BACKUP SYSTEM ---
            Route::get('/backup', [BackupController::class, 'index'])->name('backup.index');
            
            // Backup Dokumen (ZIP)
            Route::post('/backup/arsip', [BackupController::class, 'backupArsip'])->name('backup.arsip');

            // TAMBAHAN: Route Cek List File (AJAX)
            Route::post('/backup/check', [BackupController::class, 'checkArsip'])->name('backup.check');
    });

});