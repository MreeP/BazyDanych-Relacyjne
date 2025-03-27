<?php

namespace Modules\Customer\Policies\Admin;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Admin\Models\Admin;
use Modules\Customer\Models\Customer;

/**
 * Class CustomerPolicy
 *
 * Policy for interacting with the Customer model by an admin.
 */
class CustomerPolicy
{

    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @return bool
     */
    public function viewAny(): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  Admin    $user
     * @param  Customer $model
     * @return bool
     */
    public function view(Admin $user, Customer $model): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @return bool
     */
    public function create(): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  Admin    $user
     * @param  Customer $model
     * @return bool
     */
    public function update(Admin $user, Customer $model): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  Admin    $user
     * @param  Customer $model
     * @return bool
     */
    public function delete(Admin $user, Customer $model): bool
    {
        return true;
    }
}
