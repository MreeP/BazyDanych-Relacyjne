<?php

namespace Modules\Post\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Customer\Models\Customer;
use Modules\Post\Models\Comment;
use Modules\Post\Models\Like;
use Modules\Post\Models\Post;

/**
 * Class PostSeeder
 *
 * Seed the posts, comments, and likes tables
 */
class PostSeeder extends Seeder
{

    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create customers
        $customers = Customer::count() > 3
            ? Customer::take(3)->get()
            : Customer::factory(3)->create();

        // Create posts for each customer
        $customers->each(function ($customer) use ($customers) {
            // Create 2-5 posts per customer
            $posts = Post::factory(rand(2, 5))->create([
                'customer_id' => $customer->id,
            ]);

            // Add comments and likes to each post
            $posts->each(function ($post) use ($customers) {
                // Add 0-5 comments per post
                $comments = Comment::factory(rand(0, 5))->create([
                    'post_id' => $post->id,
                    'customer_id' => $customers->random()->id,
                ]);

                // Add replies to some comments
                $comments->each(function ($comment) use ($customers, $post) {
                    // 50% chance to have replies
                    if (rand(0, 1)) {
                        Comment::factory(rand(1, 3))->create([
                            'post_id' => $post->id,
                            'parent_id' => $comment->id,
                            'customer_id' => $customers->random()->id,
                        ]);
                    }
                });

                // Add likes to the post
                $likeCount = rand(0, $customers->count());
                $likedCustomers = $customers->random($likeCount);

                foreach ($likedCustomers as $likedCustomer) {
                    Like::factory()->create([
                        'customer_id' => $likedCustomer->id,
                        'likeable_id' => $post->id,
                        'likeable_type' => Post::class,
                    ]);
                }

                // Add likes to some comments
                $comments->each(function ($comment) use ($customers) {
                    // 30% chance to have likes
                    if (rand(0, 100) < 30) {
                        $likeCount = rand(1, $customers->count());
                        $likedCustomers = $customers->random($likeCount);

                        foreach ($likedCustomers as $likedCustomer) {
                            Like::factory()->create([
                                'customer_id' => $likedCustomer->id,
                                'likeable_id' => $comment->id,
                                'likeable_type' => Comment::class,
                            ]);
                        }
                    }
                });
            });
        });
    }
}
