<?php

use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function () {
    # Guest
    Route::name('guest.')->group(fn () => require __DIR__ . '/guest/routes.php');

    # Logged In Customer
    Route::name('customer.')->group(fn () => require __DIR__ . '/customer/routes.php');
});
