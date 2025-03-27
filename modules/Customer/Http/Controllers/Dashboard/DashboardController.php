<?php

namespace Modules\Customer\Http\Controllers\Dashboard;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Support\Facades\View;
use Modules\Customer\Http\Controllers\CustomerController;

/**
 * Class DashboardController
 *
 * controller for dashboard
 */
class DashboardController extends CustomerController
{

    /**
     * Show the dashboard
     *
     * @return ViewContract
     */
    public function index(): ViewContract
    {
        return View::make('Customer::dashboard');
    }
}
