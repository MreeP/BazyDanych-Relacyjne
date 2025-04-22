<?php

namespace Modules\Post\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Customer\Models\Customer;
use Modules\Post\Models\Comment;

/**
 * Class CommentPolicy
 *
 * Policy for Comment model
 */
class CommentPolicy
{

    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param  Customer $customer
     * @param  Comment  $comment
     * @return bool
     */
    public function update(Customer $customer, Comment $comment): bool
    {
        return $customer->id === $comment->customer_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  Customer $customer
     * @param  Comment  $comment
     * @return bool
     */
    public function delete(Customer $customer, Comment $comment): bool
    {
        // Comment author can delete their own comment
        if ($customer->id === $comment->customer_id) {
            return true;
        }

        // Post author can delete any comment on their post
        return $customer->id === $comment->post->customer_id;
    }
}
