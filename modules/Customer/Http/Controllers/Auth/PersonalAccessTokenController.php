<?php

namespace Modules\Customer\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Support\Facades\View;

/**
 * Class PersonalAccessTokenController
 *
 * Controller for managing api personal access tokens.
 */
class PersonalAccessTokenController extends Controller
{

    /**
     * Show the user API token screen.
     *
     * @return ViewContract
     */
    public function index(): ViewContract
    {
        return View::make('Customer::auth.tokens');
    }
}
