<?php

namespace Modules\Admin\Http\Controllers\Dashboard;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Support\Facades\View;
use Modules\Admin\Http\Controllers\AdminController;

/**
 * Class DashboardController
 *
 * controller for dashboard
 */
class DashboardController extends AdminController
{

    /**
     * Show the dashboard
     *
     * @return ViewContract
     */
    public function index(): ViewContract
    {
        return View::make('Admin::dashboard');
    }
}
