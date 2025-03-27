<?php

use Illuminate\Support\Facades\Route;
use Modules\Customer\Http\Controllers\Auth\AuthenticatedCustomerSessionController;
use Modules\Customer\Http\Controllers\Auth\NewPasswordController;
use Modules\Customer\Http\Controllers\Auth\PasswordResetLinkController;
use Modules\Customer\Http\Controllers\Auth\RegisteredUserController;

Route::middleware(['guest:customer'])->name('auth.customer.')->group(function () {
    # Register Customer
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    # Login Customer
    Route::get('login', [AuthenticatedCustomerSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedCustomerSessionController::class, 'store']);

    # Forgot Password Customer
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store']);

    # Reset Password Customer
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.update');
});
