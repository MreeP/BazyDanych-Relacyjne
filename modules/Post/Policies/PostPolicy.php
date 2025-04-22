<?php

namespace Modules\Post\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Customer\Models\Customer;
use Modules\Post\Models\Post;

/**
 * Class PostPolicy
 *
 * Policy for Post model
 */
class PostPolicy
{

    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  Customer $customer
     * @return bool
     */
    public function viewAny(Customer $customer): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  Customer $customer
     * @param  Post     $post
     * @return bool
     */
    public function view(Customer $customer, Post $post): bool
    {
        // Published posts can be viewed by anyone
        if ($post->published_at !== null) {
            return true;
        }

        // Unpublished posts can only be viewed by their authors
        return $customer->id === $post->customer_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  Customer $customer
     * @return bool
     */
    public function create(Customer $customer): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  Customer $customer
     * @param  Post     $post
     * @return bool
     */
    public function update(Customer $customer, Post $post): bool
    {
        return $customer->id === $post->customer_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  Customer $customer
     * @param  Post     $post
     * @return bool
     */
    public function delete(Customer $customer, Post $post): bool
    {
        return $customer->id === $post->customer_id;
    }
}
