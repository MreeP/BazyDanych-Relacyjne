<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\Dashboard\DashboardController;
use Modules\Admin\Http\Controllers\Profile\ProfileController;

Route::middleware(['auth:admin'])->group(function () {
    Route::name('auth.')->group(fn () => require __DIR__ . '/auth.php');

    Route::get('', [DashboardController::class, 'index'])->name('dashboard');

    Route::name('profile.')->prefix('profile')->group(function () {
        Route::get('', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('', [ProfileController::class, 'update'])->name('update');
        Route::delete('', [ProfileController::class, 'destroy'])->name('destroy');
    });
});
