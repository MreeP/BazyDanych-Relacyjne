<?php

namespace App\Providers;

use App\Helpers\Menu\Contracts\MenuProvider;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Modules\Admin\Models\Admin;
use Modules\Customer\Models\Customer;

/**
 * Class ServiceProvider
 *
 * Service provider for the application.
 */
class ServiceProvider extends BaseServiceProvider
{

    /**
     * Register admin menu entry.
     *
     * @param  string      $route
     * @param  string      $title
     * @param  null|string $icon
     * @param  null|string $group
     * @return void
     */
    protected function guestMenuEntry(string $route, string $title, ?string $icon = null, ?string $group = null): void
    {
        try {
            $this->app->make(MenuProvider::class)->register(
                MenuProvider::GUEST,
                $route,
                $title,
                $icon,
                $group,
            );
        } catch (BindingResolutionException) {
            // Don't do anything for now
        }
    }

    /**
     * Register admin menu entry.
     *
     * @param  string $route
     * @param  string $title
     * @param  string $icon
     * @param  string $group
     * @return void
     */
    protected function adminMenuEntry(string $route, string $title, string $icon, string $group): void
    {
        try {
            $this->app->make(MenuProvider::class)->register(
                MenuProvider::ADMIN,
                $route,
                $title,
                $icon,
                $group,
            );
        } catch (BindingResolutionException) {
            // Don't do anything for now
        }
    }

    /**
     * Register customer menu entry.
     *
     * @param  string $route
     * @param  string $title
     * @param  string $icon
     * @param  string $group
     * @return void
     */
    protected function customerMenuEntry(string $route, string $title, string $icon, string $group): void
    {
        try {
            $this->app->make(MenuProvider::class)->register(
                MenuProvider::CUSTOMER,
                $route,
                $title,
                $icon,
                $group,
            );
        } catch (BindingResolutionException) {
            // Don't do anything for now
        }
    }

    /**
     * Register admin model policy.
     *
     * @param  string $class
     * @param  string $policy
     * @param  string $userClass
     * @return void
     * @throws BindingResolutionException
     */
    protected function policy(string $class, string $policy, string $userClass = '*'): void
    {
        $this->app->make(Gate::class)->policy($class, $policy, $userClass);
    }

    /**
     * Register admin model policy.
     *
     * @param  string $class
     * @param  string $policy
     * @return void
     * @throws BindingResolutionException
     */
    protected function adminPolicy(string $class, string $policy): void
    {
        $this->policy($class, $policy, Admin::class);
    }

    /**
     * Register customer model policy.
     *
     * @param  string $class
     * @param  string $policy
     * @return void
     * @throws BindingResolutionException
     */
    protected function customerPolicy(string $class, string $policy): void
    {
        $this->policy($class, $policy, Customer::class);
    }
}
