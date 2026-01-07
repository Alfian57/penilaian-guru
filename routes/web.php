<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\IndikatorController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PenilaiController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\PenugasanPenilaianController;
use App\Http\Controllers\PeriodeAkademikController;
use Illuminate\Support\Facades\Route;

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    });
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Routes for admin and kepsek only
    Route::middleware('role:admin,kepsek')->group(function () {
        Route::resource('pengguna', PenggunaController::class);
        Route::resource('guru', GuruController::class);
        Route::resource('penilai', PenilaiController::class);
        Route::resource('periode', PeriodeAkademikController::class);
        Route::post('periode/{periode}/activate', [PeriodeAkademikController::class, 'activate'])->name('periode.activate');
        Route::resource('kriteria', KriteriaController::class);
        Route::resource('indikator', IndikatorController::class);
        Route::resource('penugasan', PenugasanPenilaianController::class);
        Route::get('penugasan-batch/create', [PenugasanPenilaianController::class, 'createBatch'])->name('penugasan.batch.create');
        Route::post('penugasan-batch', [PenugasanPenilaianController::class, 'storeBatch'])->name('penugasan.batch.store');

        // Laporan
        Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('laporan/guru/{guru}', [LaporanController::class, 'show'])->name('laporan.show');
        Route::get('laporan/guru/{guru}/cetak', [LaporanController::class, 'cetakPdf'])->name('laporan.cetak');
    });

    // Routes for penilai (guru, kepsek, siswa)
    Route::middleware('role:admin,kepsek,guru,siswa')->group(function () {
        Route::get('penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');
        Route::get('penilaian/{penugasan}/create', [PenilaianController::class, 'create'])->name('penilaian.create');
        Route::post('penilaian/{penugasan}', [PenilaianController::class, 'store'])->name('penilaian.store');
        Route::get('penilaian/hasil/{hasil}', [PenilaianController::class, 'show'])->name('penilaian.show');
    });
});
