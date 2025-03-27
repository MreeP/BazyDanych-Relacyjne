<?php

namespace App\Helpers\Menu\Contracts;

/**
 * Interface MenuItem
 *
 * Menu item contract.
 */
interface MenuItem
{

    /**
     * Get the menu item title.
     *
     * @return string
     */
    public function title(): string;

    /**
     * Get the menu item route.
     *
     * @return string
     */
    public function route(): string;

    /**
     * Get the menu item icon.
     *
     * @return null|string
     */
    public function icon(): ?string;

    /**
     * Get the menu item group.
     *
     * @return null|string
     */
    public function group(): ?string;

    /**
     * Determine if the menu item is active.
     *
     * @return string
     */
    public function isActive(): string;

    /**
     * Get the menu item href.
     *
     * @return string
     */
    public function href(): string;
}
