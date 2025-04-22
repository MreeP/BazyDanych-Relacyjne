<?php

namespace Modules\Post\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Modules\Customer\Http\Controllers\CustomerController;
use Modules\Post\Http\Requests\StoreCommentRequest;
use Modules\Post\Http\Requests\UpdateCommentRequest;
use Modules\Post\Models\Comment;
use Modules\Post\Models\Post;

/**
 * Class CommentController
 *
 * Controller for managing comments
 */
class CommentController extends BasePostController
{

    /**
     * Store a newly created comment in storage.
     *
     * @param  StoreCommentRequest $request
     * @param  Post                $post
     * @return RedirectResponse
     */
    public function store(StoreCommentRequest $request, Post $post): RedirectResponse
    {
        $comment = new Comment($request->validated());
        $comment->customer_id = Auth::id();
        $comment->post_id = $post->id;
        $comment->save();

        return redirect()->route('customer.posts.show', $post)
            ->with('success', __('Comment added successfully'));
    }

    /**
     * Store a reply to a comment.
     *
     * @param  StoreCommentRequest $request
     * @param  Post                $post
     * @param  Comment             $comment
     * @return RedirectResponse
     */
    public function reply(StoreCommentRequest $request, Post $post, Comment $comment): RedirectResponse
    {
        $reply = new Comment($request->validated());
        $reply->customer_id = Auth::id();
        $reply->post_id = $post->id;
        $reply->parent_id = $comment->id;
        $reply->save();

        return redirect()->route('customer.posts.show', $post)
            ->with('success', __('Reply added successfully'));
    }

    /**
     * Update the specified comment in storage.
     *
     * @param  UpdateCommentRequest $request
     * @param  Post                 $post
     * @param  Comment              $comment
     * @return RedirectResponse
     */
    public function update(UpdateCommentRequest $request, Post $post, Comment $comment): RedirectResponse
    {
        $this->authorize('update', $comment);

        $comment->update($request->validated());

        return redirect()->route('customer.posts.show', $post)
            ->with('success', __('Comment updated successfully'));
    }

    /**
     * Remove the specified comment from storage.
     *
     * @param  Post    $post
     * @param  Comment $comment
     * @return RedirectResponse
     */
    public function destroy(Post $post, Comment $comment): RedirectResponse
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return redirect()->route('customer.posts.show', $post)
            ->with('success', __('Comment deleted successfully'));
    }
}
