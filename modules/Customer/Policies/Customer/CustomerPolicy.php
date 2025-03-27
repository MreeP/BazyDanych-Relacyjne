<?php

namespace Modules\Customer\Policies\Customer;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Customer\Models\Customer;

/**
 * Class CustomerPolicy
 *
 * Policy for interacting with the Customer model by a customer.
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
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  Customer $user
     * @param  Customer $model
     * @return bool
     */
    public function view(Customer $user, Customer $model): bool
    {
        return $user->id === $model->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @return bool
     */
    public function create(): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  Customer $user
     * @param  Customer $model
     * @return bool
     */
    public function update(Customer $user, Customer $model): bool
    {
        return $user->id === $model->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  Customer $user
     * @param  Customer $model
     * @return bool
     */
    public function delete(Customer $user, Customer $model): bool
    {
        return $user->id === $model->id;
    }
}
