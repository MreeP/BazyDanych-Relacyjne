<?php

namespace Modules\Admin\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

/**
 * Class AuthLayout
 *
 * Layout for admin authentication views.
 */
class AuthLayout extends Component
{

    public const string SESSION_STATUS = 'status';

    public const string SESSION_STATUS_TYPE = 'status-type';

    public const string STATUS_ERROR = 'error';

    public const string STATUS_INFO = 'success';

    public const string STATUS_SUCCESS = 'success';

    /**
     * Create the component instance.
     *
     * @param  string      $header
     * @param  null|string $description
     */
    public function __construct(
        public string  $header,
        public ?string $description = null,
    ) {}

    /**
     * Get the view / contents that represents the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('Admin::layouts.auth');
    }
}
