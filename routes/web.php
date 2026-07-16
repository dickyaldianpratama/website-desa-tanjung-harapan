<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\PotensiController;
use App\Http\Controllers\TransparansiController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BeritaController as AdminBeritaController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\PotensiController as AdminPotensiController;
use App\Http\Controllers\Admin\PerangkatController;
use App\Http\Controllers\Admin\PengaduanController;
use App\Http\Controllers\Admin\ApbdesController;
use App\Http\Controllers\Admin\SettingController;

// ═══════════════════════════════════════════
//  PUBLIC ROUTES — Bebas diakses siapapun
// ═══════════════════════════════════════════
Route::get('/',              [HomeController::class, 'index'])->name('home');
Route::get('/profil',        [ProfilController::class, 'index'])->name('profil');
Route::get('/berita',        [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{slug}', [BeritaController::class, 'show'])->name('berita.show');
Route::get('/potensi',       [PotensiController::class, 'index'])->name('potensi.index');
Route::get('/potensi/{slug}',[PotensiController::class, 'show'])->name('potensi.show');
Route::get('/transparansi',  [TransparansiController::class, 'index'])->name('transparansi');
Route::get('/kontak',        [KontakController::class, 'index'])->name('kontak');
Route::post('/kontak',       [KontakController::class, 'store'])->name('kontak.store')->middleware('throttle:3,10');

// ═══════════════════════════════════════════
//  ADMIN AUTH — Login/Logout admin desa
// ═══════════════════════════════════════════
Route::get('/admin/login',   [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'create'])->name('login')->middleware('guest');
Route::post('/admin/login',  [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store'])->middleware('guest');
Route::post('/admin/logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');

// ═══════════════════════════════════════════
//  ADMIN PANEL — Khusus admin desa (butuh login)
// ═══════════════════════════════════════════
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/',                  [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('berita',        AdminBeritaController::class);
    Route::resource('slider',        SliderController::class);
    Route::resource('potensi',       AdminPotensiController::class);
    Route::resource('perangkat',     PerangkatController::class);
    Route::get('pengaduan',          [PengaduanController::class, 'index'])->name('pengaduan.index');
    Route::get('pengaduan/{id}',     [PengaduanController::class, 'show'])->name('pengaduan.show');
    Route::delete('pengaduan/{id}',  [PengaduanController::class, 'destroy'])->name('pengaduan.destroy');
    Route::resource('apbdes',        ApbdesController::class)->except(['show']);
    Route::get('setting',            [SettingController::class, 'index'])->name('setting.index');
    Route::post('setting',           [SettingController::class, 'update'])->name('setting.update');

    // Profile Account Settings
    Route::get('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
});

// Breeze auth helper (hanya profile update, tidak dipakai di publik)
require __DIR__.'/auth.php';
