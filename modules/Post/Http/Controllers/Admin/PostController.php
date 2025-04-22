<?php

namespace Modules\Post\Http\Controllers\Admin;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\View;
use Modules\Admin\Http\Controllers\AdminController;
use Modules\Post\Http\Requests\Admin\StorePostRequest;
use Modules\Post\Http\Requests\Admin\UpdatePostRequest;
use Modules\Post\Models\Post;

/**
 * Class PostController
 *
 * Admin controller for managing posts
 */
class PostController extends AdminController
{
    /**
     * Display a listing of the posts.
     *
     * @return ViewContract
     */
    public function index(): ViewContract
    {
        $posts = Post::with('author')
            ->orderByDesc('created_at')
            ->paginate(10);

        return View::make('Post::admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new post.
     *
     * @return ViewContract
     */
    public function create(): ViewContract
    {
        $customers = \Modules\Customer\Models\Customer::all()->pluck('name', 'id')->toArray();
        return View::make('Post::admin.posts.create', compact('customers'));
    }

    /**
     * Store a newly created post in storage.
     *
     * @param  StorePostRequest $request
     * @return RedirectResponse
     */
    public function store(StorePostRequest $request): RedirectResponse
    {
        $post = new Post($request->validated());
        $post->customer_id = $request->input('customer_id');

        if ($request->has('publish')) {
            $post->published_at = now();
        }

        $post->save();

        return redirect()->route('admin.posts.show', $post)
            ->with('success', __('Post created successfully'));
    }

    /**
     * Display the specified post.
     *
     * @param  Post $post
     * @return ViewContract
     */
    public function show(Post $post): ViewContract
    {
        $post->load(['author', 'comments.author', 'comments.replies.author']);

        return View::make('Post::admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified post.
     *
     * @param  Post $post
     * @return ViewContract
     */
    public function edit(Post $post): ViewContract
    {
        return View::make('Post::admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified post in storage.
     *
     * @param  UpdatePostRequest $request
     * @param  Post              $post
     * @return RedirectResponse
     */
    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        $post->fill($request->validated());

        if ($request->has('publish') && is_null($post->published_at)) {
            $post->published_at = now();
        } elseif ($request->has('unpublish')) {
            $post->published_at = null;
        }

        $post->save();

        return redirect()->route('admin.posts.show', $post)
            ->with('success', __('Post updated successfully'));
    }

    /**
     * Remove the specified post from storage.
     *
     * @param  Post $post
     * @return RedirectResponse
     */
    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', __('Post deleted successfully'));
    }
}
