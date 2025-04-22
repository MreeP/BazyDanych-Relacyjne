<?php

namespace Modules\Post\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Post\Tests\PostTestCase;
use PHPUnit\Framework\Attributes\Test;

/**
 * Class CommentTest
 *
 * Test for comment functionality
 */
class CommentTest extends PostTestCase
{

    use RefreshDatabase;

    /**
     * Test if a user can add a comment to a post.
     *
     * @return void
     */
    #[Test]
    public function user_can_add_comment_to_post(): void
    {
        $customer = $this->createCustomer();
        $post = $this->createPost();

        $response = $this->actingAs($customer, 'customer')
            ->post(route('customer.posts.comments.store', $post), [
                'content' => 'Test comment content',
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('comments', [
            'content' => 'Test comment content',
            'customer_id' => $customer->id,
            'post_id' => $post->id,
        ]);
    }

    /**
     * Test if a user can reply to a comment.
     *
     * @return void
     */
    #[Test]
    public function user_can_reply_to_comment(): void
    {
        $customer = $this->createCustomer();
        $post = $this->createPost();
        $comment = $this->createComment($post);

        $response = $this->actingAs($customer, 'customer')
            ->post(route('customer.posts.comments.reply', [$post, $comment]), [
                'content' => 'Test reply content',
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('comments', [
            'content' => 'Test reply content',
            'customer_id' => $customer->id,
            'post_id' => $post->id,
            'parent_id' => $comment->id,
        ]);
    }

    /**
     * Test if a user can update their own comment.
     *
     * @return void
     */
    #[Test]
    public function user_can_update_own_comment(): void
    {
        $customer = $this->createCustomer();
        $post = $this->createPost();
        $comment = $this->createComment($post, $customer);

        $response = $this->actingAs($customer, 'customer')
            ->put(route('customer.posts.comments.update', [$post, $comment]), [
                'content' => 'Updated comment content',
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'content' => 'Updated comment content',
        ]);
    }

    /**
     * Test if a user cannot update another user's comment.
     *
     * @return void
     */
    #[Test]
    public function user_cannot_update_others_comment(): void
    {
        $customer1 = $this->createCustomer();
        $customer2 = $this->createCustomer();
        $post = $this->createPost();
        $comment = $this->createComment($post, $customer1);

        $response = $this->actingAs($customer2, 'customer')
            ->put(route('customer.posts.comments.update', [$post, $comment]), [
                'content' => 'Updated comment content',
            ]);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('comments', [
            'id' => $comment->id,
            'content' => 'Updated comment content',
        ]);
    }

    /**
     * Test if a user can delete their own comment.
     *
     * @return void
     */
    #[Test]
    public function user_can_delete_own_comment(): void
    {
        $customer = $this->createCustomer();
        $post = $this->createPost();
        $comment = $this->createComment($post, $customer);

        $response = $this->actingAs($customer, 'customer')
            ->delete(route('customer.posts.comments.destroy', [$post, $comment]));

        $response->assertRedirect();
        $this->assertDatabaseMissing('comments', [
            'id' => $comment->id,
        ]);
    }

    /**
     * Test if a post author can delete any comment on their post.
     *
     * @return void
     */
    #[Test]
    public function post_author_can_delete_any_comment(): void
    {
        $postAuthor = $this->createCustomer();
        $commentAuthor = $this->createCustomer();
        $post = $this->createPost($postAuthor);
        $comment = $this->createComment($post, $commentAuthor);

        $response = $this->actingAs($postAuthor, 'customer')
            ->delete(route('customer.posts.comments.destroy', [$post, $comment]));

        $response->assertRedirect();
        $this->assertDatabaseMissing('comments', [
            'id' => $comment->id,
        ]);
    }

    /**
     * Test if a user cannot delete another user's comment on a post they don't own.
     *
     * @return void
     */
    #[Test]
    public function user_cannot_delete_others_comment_on_post_they_dont_own(): void
    {
        $postAuthor = $this->createCustomer();
        $commentAuthor = $this->createCustomer();
        $otherUser = $this->createCustomer();
        $post = $this->createPost($postAuthor);
        $comment = $this->createComment($post, $commentAuthor);

        $response = $this->actingAs($otherUser, 'customer')
            ->delete(route('customer.posts.comments.destroy', [$post, $comment]));

        $response->assertStatus(403);
        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
        ]);
    }
}
