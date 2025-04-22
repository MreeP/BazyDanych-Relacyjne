<?php

namespace Modules\Post\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Modules\Admin\Http\Controllers\AdminController;
use Modules\Post\Http\Requests\Admin\UpdateCommentRequest;
use Modules\Post\Models\Comment;
use Modules\Post\Models\Post;

/**
 * Class CommentController
 *
 * Admin controller for managing comments
 */
class CommentController extends AdminController
{
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
        $comment->update($request->validated());

        return redirect()->route('admin.posts.show', $post)
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
        $comment->delete();

        return redirect()->route('admin.posts.show', $post)
            ->with('success', __('Comment deleted successfully'));
    }
}
