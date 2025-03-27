<?php

namespace App\Helpers\Menu\Contracts;

/**
 * Interface Menu
 *
 * Menu contract.
 */
interface MenuProvider
{

    public const string ADMIN = 'admin';

    public const string CUSTOMER = 'customer';

    public const string GUEST = 'guest';

    /**
     * Get the menu items.
     *
     * @param  string $key
     * @return array<MenuItem>
     */
    public function menu(string $key): array;

    /**
     * Register menu item.
     *
     * @param  string      $key
     * @param  string      $route
     * @param  string      $title
     * @param  null|string $icon
     * @param  null|string $group
     */
    public function register(string $key, string $route, string $title, ?string $icon = null, ?string $group = null): void;
}
