<?php

use Illuminate\Support\Facades\Route;
use Modules\Customer\Http\Controllers\Auth\AuthenticatedCustomerSessionController;
use Modules\Customer\Http\Controllers\Auth\ConfirmablePasswordController;
use Modules\Customer\Http\Controllers\Auth\EmailVerificationController;
use Modules\Customer\Http\Controllers\Auth\PasswordController;

Route::middleware('auth:customer')->group(function () {
    # Send Email Verification Notification
    Route::get('verify-email', [EmailVerificationController::class, 'prompt'])->name('verification.notice');
    Route::post('email/verification-notification', [EmailVerificationController::class, 'notify'])->middleware('throttle:6,1')->name('verification.send');
    Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->middleware(['signed', 'throttle:6,1'])->name('verification.verify');

    # Confirm Password
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    # Update Password
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    # Logout
    Route::post('logout', [AuthenticatedCustomerSessionController::class, 'destroy'])->name('logout');
});
