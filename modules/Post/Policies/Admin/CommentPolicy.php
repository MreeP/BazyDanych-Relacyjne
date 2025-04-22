<?php

namespace Modules\Post\Policies\Admin;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Admin\Models\Admin;
use Modules\Post\Models\Comment;

/**
 * Class CommentPolicy
 *
 * Admin Policy for Comment model
 */
class CommentPolicy
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
     * @param  Admin   $admin
     * @param  Comment $comment
     * @return bool
     */
    public function view(Admin $admin, Comment $comment): bool
    {
        return true;
    }

    /**
     * Determine whether the admin can update the model.
     *
     * @param  Admin   $admin
     * @param  Comment $comment
     * @return bool
     */
    public function update(Admin $admin, Comment $comment): bool
    {
        return true;
    }

    /**
     * Determine whether the admin can delete the model.
     *
     * @param  Admin   $admin
     * @param  Comment $comment
     * @return bool
     */
    public function delete(Admin $admin, Comment $comment): bool
    {
        return true;
    }
}
