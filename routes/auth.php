<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

// ─── REGISTER ROUTE: Sengaja dinonaktifkan ───────────────────────────────────
// Pendaftaran akun admin hanya bisa dilakukan langsung via database/seeder.
// Jangan aktifkan kembali kecuali ada kebutuhan mendesak.
// Route::get('register', ...)
// Route::post('register', ...)
// ─────────────────────────────────────────────────────────────────────────────

Route::middleware('guest')->group(function () {

    // URL login diambil dari environment variable ADMIN_LOGIN_PATH
    // sehingga tidak terekspos di source code publik.
    $loginPath = env('ADMIN_LOGIN_PATH', 'portal-admin');

    Route::get($loginPath, [AuthenticatedSessionController::class, 'create'])
        ->middleware('throttle:5,10') // Maks 5 percobaan per 10 menit
        ->name('login');

    Route::post($loginPath, [AuthenticatedSessionController::class, 'store'])
        ->middleware('throttle:5,10'); // Maks 5 percobaan per 10 menit

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

