<?php

namespace Modules\Post\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Post\Tests\PostTestCase;
use PHPUnit\Framework\Attributes\Test;

/**
 * Class PostTest
 *
 * Test for post functionality
 */
class PostTest extends PostTestCase
{

    use RefreshDatabase;

    /**
     * Test if a user can view the posts index page.
     *
     * @return void
     */
    #[Test]
    public function user_can_view_posts_index(): void
    {
        $customer = $this->createCustomer();
        $post = $this->createPost($customer);

        $response = $this->actingAs($customer, 'customer')
            ->get(route('customer.posts.index'));

        $response->assertStatus(200);
        $response->assertSee($post->title);
    }

    /**
     * Test if a user can create a post.
     *
     * @return void
     */
    #[Test]
    public function user_can_create_post(): void
    {
        $customer = $this->createCustomer();

        $response = $this->actingAs($customer, 'customer')
            ->post(route('customer.posts.store'), [
                'title' => 'Test Post Title',
                'content' => 'Test post content',
                'publish' => '1',
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('posts', [
            'title' => 'Test Post Title',
            'content' => 'Test post content',
            'customer_id' => $customer->id,
        ]);
    }

    /**
     * Test if a user can update their own post.
     *
     * @return void
     */
    #[Test]
    public function user_can_update_own_post(): void
    {
        $customer = $this->createCustomer();
        $post = $this->createPost($customer);

        $response = $this->actingAs($customer, 'customer')
            ->put(route('customer.posts.update', $post), [
                'title' => 'Updated Post Title',
                'content' => 'Updated post content',
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Post Title',
            'content' => 'Updated post content',
        ]);
    }

    /**
     * Test if a user cannot update another user's post.
     *
     * @return void
     */
    #[Test]
    public function user_cannot_update_others_post(): void
    {
        $customer1 = $this->createCustomer();
        $customer2 = $this->createCustomer();
        $post = $this->createPost($customer1);

        $response = $this->actingAs($customer2, 'customer')
            ->put(route('customer.posts.update', $post), [
                'title' => 'Updated Post Title',
                'content' => 'Updated post content',
            ]);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
            'title' => 'Updated Post Title',
        ]);
    }

    /**
     * Test if a user can delete their own post.
     *
     * @return void
     */
    #[Test]
    public function user_can_delete_own_post(): void
    {
        $customer = $this->createCustomer();
        $post = $this->createPost($customer);

        $response = $this->actingAs($customer, 'customer')
            ->delete(route('customer.posts.destroy', $post));

        $response->assertRedirect();
        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
        ]);
    }

    /**
     * Test if a user cannot delete another user's post.
     *
     * @return void
     */
    #[Test]
    public function user_cannot_delete_others_post(): void
    {
        $customer1 = $this->createCustomer();
        $customer2 = $this->createCustomer();
        $post = $this->createPost($customer1);

        $response = $this->actingAs($customer2, 'customer')
            ->delete(route('customer.posts.destroy', $post));

        $response->assertStatus(403);
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
        ]);
    }
}
