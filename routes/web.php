<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Pendaftar\DashboardPendaftarController;
use App\Http\Controllers\Pendaftar\ProfilController;
use App\Http\Controllers\Pendaftar\PendaftaranController;
use App\Http\Controllers\Pendaftar\PengumumanController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\KelolaPendaftarController;
use App\Http\Controllers\Admin\KelolaPerhitunganController;
use App\Http\Controllers\Admin\KelolaKriteriaController;
use App\Http\Controllers\Admin\KelolaPeriodeController;
use App\Http\Controllers\Admin\KelolaPengaturanController;
use App\Http\Controllers\Admin\LaporanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Landing Page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ====================================================
// Pendaftar Routes
// Prefix: /pendaftar | Name: pendaftar.
// ====================================================
Route::middleware(['auth', 'role:pendaftar'])->prefix('pendaftar')->name('pendaftar.')->group(function () {
    Route::get('/dashboard', [DashboardPendaftarController::class, 'index'])->name('dashboard');

    // Profil (Logic: GET=View, POST=Create, PUT=Update)
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil'); // pendaftar.profil
    Route::post('/profil', [ProfilController::class, 'store'])->name('profil.store'); // pendaftar.profil.store
    Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update'); // pendaftar.profil.update

    // Pendaftaran
    Route::get('/pendaftaran', [PendaftaranController::class, 'index'])->name('pendaftaran');
    Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
    Route::get('/cetak-kartu/{id}', [PendaftaranController::class, 'cetakKartu'])->name('cetak-kartu');

    // Pengumuman
    Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman');
    Route::get('/download-sk/{id}', [PengumumanController::class, 'downloadSK'])->name('download-sk');
});

// ====================================================
// Admin Routes
// Prefix: /admin | Name: admin.
// ====================================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('dashboard');

    // Kelola Pendaftar
    Route::get('/pendaftar', [KelolaPendaftarController::class, 'index'])->name('pendaftar');
    Route::get('/pendaftar/{id}', [KelolaPendaftarController::class, 'show'])->name('pendaftar.show');
    Route::put('/pendaftar/{id}/verifikasi', [KelolaPendaftarController::class, 'verifikasi'])->name('pendaftar.verifikasi');
    Route::delete('/pendaftar/{id}', [KelolaPendaftarController::class, 'destroy'])->name('pendaftar.destroy');

    // Kelola Perhitungan SMART
    Route::get('/perhitungan', [KelolaPerhitunganController::class, 'index'])->name('perhitungan');
    Route::get('/perhitungan/input-nilai', [KelolaPerhitunganController::class, 'inputNilai'])->name('perhitungan.input-nilai');
    Route::post('/perhitungan/simpan-nilai', [KelolaPerhitunganController::class, 'simpanNilai'])->name('perhitungan.simpan-nilai');
    Route::post('/perhitungan/hitung-smart', [KelolaPerhitunganController::class, 'hitungSmart'])->name('perhitungan.hitung-smart');
    Route::get('/perhitungan/hasil', [KelolaPerhitunganController::class, 'hasilPerhitungan'])->name('perhitungan.hasil');
    Route::post('/perhitungan/tentukan-kelulusan', [KelolaPerhitunganController::class, 'tentukanKelulusan'])->name('perhitungan.tentukan-kelulusan');
    Route::post('/perhitungan/publish', [KelolaPerhitunganController::class, 'publishPengumuman'])->name('perhitungan.publish');

    // Kelola Kriteria (Resource)
    Route::resource('kriteria', KelolaKriteriaController::class);

    // Kelola Periode (Resource + Custom)
    Route::resource('periode', KelolaPeriodeController::class);
    Route::put('/periode/{id}/toggle-status', [KelolaPeriodeController::class, 'toggleStatus'])->name('periode.toggle-status');

    // Kelola Pengaturan
    Route::get('/pengaturan', [KelolaPengaturanController::class, 'index'])->name('pengaturan');
    Route::put('/pengaturan', [KelolaPengaturanController::class, 'update'])->name('pengaturan.update');
    Route::post('/pengaturan/upload-logo', [KelolaPengaturanController::class, 'uploadLogo'])->name('pengaturan.upload-logo');
    Route::post('/pengaturan/banner', [KelolaPengaturanController::class, 'storeBanner'])->name('pengaturan.banner.store');
    Route::delete('/pengaturan/banner/{id}', [KelolaPengaturanController::class, 'destroyBanner'])->name('pengaturan.banner.destroy');

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
    Route::get('/laporan/pendaftaran', [LaporanController::class, 'laporanPendaftaran'])->name('laporan.pendaftaran');
    Route::get('/laporan/hasil-seleksi', [LaporanController::class, 'laporanHasilSeleksi'])->name('laporan.hasil-seleksi');
    Route::get('/laporan/export-excel', [LaporanController::class, 'exportExcel'])->name('laporan.export-excel');
});
