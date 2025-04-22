<?php

namespace Modules\Post\Tests;

use Modules\Customer\Models\Customer;
use Modules\Customer\Tests\CustomerTestCase;
use Modules\Post\Models\Comment;
use Modules\Post\Models\Like;
use Modules\Post\Models\Post;

/**
 * Class PostTestCase
 *
 * Base test case for Post module tests
 */
class PostTestCase extends CustomerTestCase
{

    /**
     * Create a new post.
     *
     * @param  Customer|null $customer
     * @param  bool          $published
     * @return Post
     */
    protected function createPost(?Customer $customer = null, bool $published = true): Post
    {
        $customer = $customer ?? $this->createCustomer();

        if ($published) {
            return Post::factory()->create([
                'customer_id' => $customer->id,
            ]);
        }

        return Post::factory()->unpublished()->create([
            'customer_id' => $customer->id,
        ]);
    }

    /**
     * Create a new comment.
     *
     * @param  Post|null     $post
     * @param  Customer|null $customer
     * @param  Comment|null  $parent
     * @return Comment
     */
    protected function createComment(?Post $post = null, ?Customer $customer = null, ?Comment $parent = null): Comment
    {
        $customer = $customer ?? $this->createCustomer();
        $post = $post ?? $this->createPost($customer);

        if ($parent) {
            return Comment::factory()->reply($parent)->create([
                'customer_id' => $customer->id,
            ]);
        }

        return Comment::factory()->create([
            'post_id' => $post->id,
            'customer_id' => $customer->id,
        ]);
    }

    /**
     * Create a new like for a post.
     *
     * @param  Post|null     $post
     * @param  Customer|null $customer
     * @return Like
     */
    protected function createPostLike(?Post $post = null, ?Customer $customer = null): Like
    {
        $customer = $customer ?? $this->createCustomer();
        $post = $post ?? $this->createPost();

        return Like::factory()->forPost($post)->create([
            'customer_id' => $customer->id,
        ]);
    }

    /**
     * Create a new like for a comment.
     *
     * @param  Comment|null  $comment
     * @param  Customer|null $customer
     * @return Like
     */
    protected function createCommentLike(?Comment $comment = null, ?Customer $customer = null): Like
    {
        $customer = $customer ?? $this->createCustomer();
        $comment = $comment ?? $this->createComment();

        return Like::factory()->forComment($comment)->create([
            'customer_id' => $customer->id,
        ]);
    }
}
