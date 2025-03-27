<?php

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => Redirect::route('guest.auth.customer.login'))->name('landing')->middleware(['guest']);
