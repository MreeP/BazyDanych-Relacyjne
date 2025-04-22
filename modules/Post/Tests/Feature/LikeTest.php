<?php

namespace Modules\Post\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Post\Tests\PostTestCase;
use PHPUnit\Framework\Attributes\Test;

/**
 * Class LikeTest
 *
 * Test for like functionality
 */
class LikeTest extends PostTestCase
{

    use RefreshDatabase;

    /**
     * Test if a user can like a post.
     *
     * @return void
     */
    #[Test]
    public function user_can_like_post(): void
    {
        $customer = $this->createCustomer();
        $post = $this->createPost();

        $response = $this->actingAs($customer, 'customer')
            ->post(route('customer.posts.like', $post));

        $response->assertRedirect();
        $this->assertDatabaseHas('likes', [
            'customer_id' => $customer->id,
            'likeable_id' => $post->id,
            'likeable_type' => get_class($post),
        ]);
    }

    /**
     * Test if a user can unlike a post.
     *
     * @return void
     */
    #[Test]
    public function user_can_unlike_post(): void
    {
        $customer = $this->createCustomer();
        $post = $this->createPost();
        $this->createPostLike($post, $customer);

        $response = $this->actingAs($customer, 'customer')
            ->post(route('customer.posts.like', $post));

        $response->assertRedirect();
        $this->assertDatabaseMissing('likes', [
            'customer_id' => $customer->id,
            'likeable_id' => $post->id,
            'likeable_type' => get_class($post),
        ]);
    }

    /**
     * Test if a user can like a comment.
     *
     * @return void
     */
    #[Test]
    public function user_can_like_comment(): void
    {
        $customer = $this->createCustomer();
        $post = $this->createPost();
        $comment = $this->createComment($post);

        $response = $this->actingAs($customer, 'customer')
            ->post(route('customer.comments.like', [$post, $comment]));

        $response->assertRedirect();
        $this->assertDatabaseHas('likes', [
            'customer_id' => $customer->id,
            'likeable_id' => $comment->id,
            'likeable_type' => get_class($comment),
        ]);
    }

    /**
     * Test if a user can unlike a comment.
     *
     * @return void
     */
    #[Test]
    public function user_can_unlike_comment(): void
    {
        $customer = $this->createCustomer();
        $post = $this->createPost();
        $comment = $this->createComment($post);
        $this->createCommentLike($comment, $customer);

        $response = $this->actingAs($customer, 'customer')
            ->post(route('customer.comments.like', [$post, $comment]));

        $response->assertRedirect();
        $this->assertDatabaseMissing('likes', [
            'customer_id' => $customer->id,
            'likeable_id' => $comment->id,
            'likeable_type' => get_class($comment),
        ]);
    }
}
