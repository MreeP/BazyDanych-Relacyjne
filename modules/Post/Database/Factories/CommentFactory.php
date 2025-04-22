<?php

namespace Modules\Post\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Customer\Models\Customer;
use Modules\Post\Models\Comment;
use Modules\Post\Models\Post;

/**
 * CommentFactory
 *
 * @extends Factory<Comment>
 */
class CommentFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content' => fake()->paragraph(),
            'customer_id' => Customer::factory(),
            'post_id' => Post::factory(),
            'parent_id' => null,
        ];
    }

    /**
     * Indicate that the comment is a reply to another comment.
     *
     * @param  Comment $parent
     * @return static
     */
    public function reply(Comment $parent): static
    {
        return $this->state(fn (array $attributes) => [
            'parent_id' => $parent->id,
            'post_id' => $parent->post_id,
        ]);
    }
}
