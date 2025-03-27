<?php

use Illuminate\Support\Facades\Route;

Route::middleware('web')->prefix(config('admin.admin_prefix'))->group(function () {
    # Logged In Admin
    Route::name('admin.')->group(fn () => require __DIR__ . '/admin/routes.php');

    # Guest
    Route::name('guest.')->group(fn () => require __DIR__ . '/guest/routes.php');
});
