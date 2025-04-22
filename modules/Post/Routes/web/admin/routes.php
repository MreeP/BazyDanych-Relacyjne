<?php

use Illuminate\Support\Facades\Route;
use Modules\Post\Http\Controllers\Admin\CommentController;
use Modules\Post\Http\Controllers\Admin\PostController;

Route::middleware(['auth:admin'])->prefix(config('admin.admin_prefix'))->group(function () {
    # Posts
    Route::resource('posts', PostController::class);

    # Comments
    Route::put('posts/{post}/comments/{comment}', [CommentController::class, 'update'])->name('posts.comments.update');
    Route::delete('posts/{post}/comments/{comment}', [CommentController::class, 'destroy'])->name('posts.comments.destroy');
});
