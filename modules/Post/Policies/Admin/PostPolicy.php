<?php

namespace Modules\Post\Policies\Admin;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Admin\Models\Admin;
use Modules\Post\Models\Post;

/**
 * Class PostPolicy
 *
 * Admin Policy for Post model
 */
class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the admin can view any models.
     *
     * @param  Admin $admin
     * @return bool
     */
    public function viewAny(Admin $admin): bool
    {
        return true;
    }

    /**
     * Determine whether the admin can view the model.
     *
     * @param  Admin $admin
     * @param  Post  $post
     * @return bool
     */
    public function view(Admin $admin, Post $post): bool
    {
        return true;
    }

    /**
     * Determine whether the admin can create models.
     *
     * @param  Admin $admin
     * @return bool
     */
    public function create(Admin $admin): bool
    {
        return true;
    }

    /**
     * Determine whether the admin can update the model.
     *
     * @param  Admin $admin
     * @param  Post  $post
     * @return bool
     */
    public function update(Admin $admin, Post $post): bool
    {
        return true;
    }

    /**
     * Determine whether the admin can delete the model.
     *
     * @param  Admin $admin
     * @param  Post  $post
     * @return bool
     */
    public function delete(Admin $admin, Post $post): bool
    {
        return true;
    }
}
