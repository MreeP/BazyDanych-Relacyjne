<?php

use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function () {
    # Customer
    Route::name('customer.')->group(fn () => require __DIR__ . '/customer/routes.php');
    
    # Admin
    Route::name('admin.')->group(fn () => require __DIR__ . '/admin/routes.php');
});
