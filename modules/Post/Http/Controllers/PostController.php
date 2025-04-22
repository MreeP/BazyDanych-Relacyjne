<?php

namespace Modules\Post\Http\Controllers;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Modules\Customer\Http\Controllers\CustomerController;
use Modules\Post\Http\Requests\StorePostRequest;
use Modules\Post\Http\Requests\UpdatePostRequest;
use Modules\Post\Models\Post;

/**
 * Class PostController
 *
 * Controller for managing posts
 */
class PostController extends BasePostController
{

    /**
     * Display a listing of the posts.
     *
     * @return ViewContract
     */
    public function index(): ViewContract
    {
        $posts = Post::with('author')
            ->whereNotNull('published_at')
            ->orderByDesc('published_at')
            ->paginate(10);

        return View::make('Post::posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new post.
     *
     * @return ViewContract
     */
    public function create(): ViewContract
    {
        return View::make('Post::posts.create');
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
        $post->customer_id = Auth::id();

        if ($request->has('publish')) {
            $post->published_at = now();
        }

        $post->save();

        return redirect()->route('customer.posts.show', $post)
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

        return View::make('Post::posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified post.
     *
     * @param  Post $post
     * @return ViewContract
     */
    public function edit(Post $post): ViewContract
    {
        $this->authorize('update', $post);

        return View::make('Post::posts.edit', compact('post'));
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
        $this->authorize('update', $post);

        $post->fill($request->validated());

        if ($request->has('publish') && is_null($post->published_at)) {
            $post->published_at = now();
        } elseif ($request->has('unpublish')) {
            $post->published_at = null;
        }

        $post->save();

        return redirect()->route('customer.posts.show', $post)
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
        $this->authorize('delete', $post);

        $post->delete();

        return redirect()->route('customer.posts.index')
            ->with('success', __('Post deleted successfully'));
    }

    /**
     * Display a listing of the user's posts.
     *
     * @return ViewContract
     */
    public function myPosts(): ViewContract
    {
        $posts = Post::where('customer_id', Auth::id())
            ->orderByDesc('created_at')
            ->paginate(10);

        return View::make('Post::posts.my-posts', compact('posts'));
    }
}
