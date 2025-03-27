<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\Auth\AuthenticatedAdminSessionController;
use Modules\Admin\Http\Controllers\Auth\PasswordController;

Route::middleware('auth:admin')->group(function () {
    # Update Password
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    # Logout
    Route::post('logout', [AuthenticatedAdminSessionController::class, 'destroy'])->name('logout');
});
