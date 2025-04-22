<?php

namespace Modules\Post\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Customer\Models\Customer;
use Modules\Post\Models\Comment;
use Modules\Post\Models\Like;
use Modules\Post\Models\Post;

/**
 * LikeFactory
 *
 * @extends Factory<Like>
 */
class LikeFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Like::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $likeable = $this->likeable();

        return [
            'customer_id' => Customer::factory(),
            'likeable_id' => $likeable->id,
            'likeable_type' => get_class($likeable),
        ];
    }

    /**
     * Generate a random likeable model (post or comment).
     *
     * @return Post|Comment
     */
    protected function likeable(): Post|Comment
    {
        return fake()->randomElement([
            Post::factory()->create(),
            Comment::factory()->create(),
        ]);
    }

    /**
     * Configure the like for a post.
     *
     * @param  Post $post
     * @return static
     */
    public function forPost(Post $post): static
    {
        return $this->state(fn (array $attributes) => [
            'likeable_id' => $post->id,
            'likeable_type' => Post::class,
        ]);
    }

    /**
     * Configure the like for a comment.
     *
     * @param  Comment $comment
     * @return static
     */
    public function forComment(Comment $comment): static
    {
        return $this->state(fn (array $attributes) => [
            'likeable_id' => $comment->id,
            'likeable_type' => Comment::class,
        ]);
    }
}
