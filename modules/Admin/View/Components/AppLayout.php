<?php

namespace Modules\Admin\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

/**
 * Class AppLayout
 *
 * Layout for admin views.
 */
class AppLayout extends Component
{

    /**
     * Create the component instance.
     *
     * @param  string $header
     */
    public function __construct(
        public string $header,
    ) {}

    /**
     * Get the view / contents that represents the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('Admin::layouts.app');
    }
}
