<?php

namespace App\Helpers\Menu;

use App\Helpers\Menu\Contracts\MenuItem as MenuItemInterface;
use App\Helpers\Menu\Contracts\MenuProvider as MenuProviderInterface;
use Illuminate\Support\Arr;

/**
 * Class MenuProvider
 *
 * Menu provider.
 */
class MenuProvider implements MenuProviderInterface
{

    /**
     * MenuProvider constructor.
     *
     * @param  array $items
     * @return void
     */
    public function __construct(
        protected array $items = [],
    ) {}

    /**
     * Get the menu items.
     *
     * @param  string $key
     * @return array<MenuItemInterface>
     */
    public function menu(string $key): array
    {
        return Arr::get($this->items, $key, []);
    }

    /**
     * Register menu item.
     *
     * @param  string      $key
     * @param  string      $route
     * @param  string      $title
     * @param  null|string $icon
     * @param  null|string $group
     */
    public function register(string $key, string $route, string $title, ?string $icon = null, ?string $group = null): void
    {
        $this->items[$key][] = new MenuItem($route, $title, $icon, $group);
    }
}
