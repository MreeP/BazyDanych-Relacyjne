<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\Auth\AuthenticatedAdminSessionController;

Route::middleware(['guest:admin'])->name('auth.admin.')->group(function () {
    # Login Admin
    Route::get('login', [AuthenticatedAdminSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedAdminSessionController::class, 'store']);
});
