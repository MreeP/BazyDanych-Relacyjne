<?php

namespace App\Helpers\Menu;

use App\Helpers\Menu\Contracts\MenuItem as MenuItemInterface;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

/**
 * Class MenuItem
 *
 * Menu item.
 */
class MenuItem implements MenuItemInterface
{

    /**
     * MenuItem constructor.
     *
     * @param  string      $route
     * @param  string      $title
     * @param  null|string $icon
     * @param  null|string $group
     * @param  null|bool   $active
     */
    public function __construct(
        readonly protected string  $route,
        readonly protected string  $title,
        readonly protected ?string $icon,
        readonly protected ?string $group,
        protected ?bool            $active = null,
    ) {}

    /**
     * Get the menu item title.
     *
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }

    /**
     * Get the menu item route.
     *
     * @return string
     */
    public function route(): string
    {
        return $this->route;
    }

    /**
     * Get the menu item icon.
     *
     * @return null|string
     */
    public function icon(): ?string
    {
        return $this->icon;
    }

    /**
     * Get the menu item group.
     *
     * @return null|string
     */
    public function group(): ?string
    {
        return $this->group;
    }

    /**
     * Determine if the menu item is active.
     *
     * @return string
     */
    public function isActive(): string
    {
        if (is_null($this->active)) {
            $this->active = Route::is($this->route());
        }

        return $this->active;
    }

    /**
     * Get the menu item href.
     *
     * @return string
     */
    public function href(): string
    {
        if ($this->isActive()) {
            return '#';
        }

        return URL::route($this->route());
    }
}
