<?php

namespace Modules\Post\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Modules\Customer\Http\Controllers\CustomerController;
use Modules\Post\Models\Comment;
use Modules\Post\Models\Like;
use Modules\Post\Models\Post;

/**
 * Class LikeController
 *
 * Controller for managing likes
 */
class LikeController extends BasePostController
{

    /**
     * Toggle like on a post.
     *
     * @param  Post $post
     * @return RedirectResponse
     */
    public function togglePostLike(Post $post): RedirectResponse
    {
        $customerId = Auth::id();

        $like = Like::where('customer_id', $customerId)
            ->where('likeable_id', $post->id)
            ->where('likeable_type', Post::class)
            ->first();

        if ($like) {
            $like->delete();
            $message = __('Post unliked successfully');
        } else {
            Like::create([
                'customer_id' => $customerId,
                'likeable_id' => $post->id,
                'likeable_type' => Post::class,
            ]);
            $message = __('Post liked successfully');
        }

        return back()->with('success', $message);
    }

    /**
     * Toggle like on a comment.
     *
     * @param  Post    $post
     * @param  Comment $comment
     * @return RedirectResponse
     */
    public function toggleCommentLike(Post $post, Comment $comment): RedirectResponse
    {
        $customerId = Auth::id();

        $like = Like::where('customer_id', $customerId)
            ->where('likeable_id', $comment->id)
            ->where('likeable_type', Comment::class)
            ->first();

        if ($like) {
            $like->delete();
            $message = __('Comment unliked successfully');
        } else {
            Like::create([
                'customer_id' => $customerId,
                'likeable_id' => $comment->id,
                'likeable_type' => Comment::class,
            ]);
            $message = __('Comment liked successfully');
        }

        return back()->with('success', $message);
    }
}
