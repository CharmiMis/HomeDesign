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

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    //Login Register For precision feature Start

    Route::get('login-pricision', [AuthenticatedSessionController::class, 'createPricision'])
    ->name('login.pricision');

    Route::post('login-pricision', [AuthenticatedSessionController::class, 'storePricision']);

    Route::get('register-pricision', [RegisteredUserController::class, 'createPricision'])
                ->name('register.pricision');

    Route::post('register-pricision', [RegisteredUserController::class, 'storePricision']);
    //Login Register For precision feature End

    //Login Register For Paint Visualizer feature Start

    Route::get('login-paintVisulizer', [AuthenticatedSessionController::class, 'createPaintVisualizer'])
    ->name('login.paintVisulizer');

    Route::post('login-paintVisulizer', [AuthenticatedSessionController::class, 'storePaintVisualizer']);

    Route::get('register-paintVisulizer', [RegisteredUserController::class, 'createPaintVisualizer'])
                ->name('register.paintVisulizer');

    Route::post('register-paintVisulizer', [RegisteredUserController::class, 'storePaintVisualizer']);
    //Login Register For Paint Visualizer feature End

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
