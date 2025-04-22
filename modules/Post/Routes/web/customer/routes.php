<?php

use Illuminate\Support\Facades\Route;
use Modules\Post\Http\Controllers\CommentController;
use Modules\Post\Http\Controllers\LikeController;
use Modules\Post\Http\Controllers\PostController;

Route::middleware(['auth:customer'])->group(function () {
    # Posts
    Route::get('my-posts', [PostController::class, 'myPosts'])->name('posts.my-posts');
    
    # Posts - Individual routes
    Route::get('posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::get('posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    # Comments
    Route::post('posts/{post}/comments', [CommentController::class, 'store'])->name('posts.comments.store');
    Route::post('posts/{post}/comments/{comment}/reply', [CommentController::class, 'reply'])->name('posts.comments.reply');
    Route::put('posts/{post}/comments/{comment}', [CommentController::class, 'update'])->name('posts.comments.update');
    Route::delete('posts/{post}/comments/{comment}', [CommentController::class, 'destroy'])->name('posts.comments.destroy');

    # Likes
    Route::post('posts/{post}/like', [LikeController::class, 'togglePostLike'])->name('posts.like');
    Route::post('posts/{post}/comments/{comment}/like', [LikeController::class, 'toggleCommentLike'])->name('comments.like');
});
