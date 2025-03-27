<?php

namespace Modules\Admin\Http\Controllers\Auth;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Modules\Admin\Http\Controllers\AdminController;
use Modules\Admin\Http\Requests\Auth\LoginAdminRequest;

/**
 * Class AuthenticatedAdminSessionController
 *
 * controller for handling authenticated admin session
 */
class AuthenticatedAdminSessionController extends AdminController
{

    /**
     * Display the login view.
     *
     * @return ViewContract
     */
    public function create(): ViewContract
    {
        return View::make('Admin::auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  LoginAdminRequest $request
     * @return RedirectResponse
     */
    public function store(LoginAdminRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return Redirect::intended(
            URL::route('admin.dashboard', absolute: false),
        );
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return Redirect::route('guest.auth.admin.login');
    }
}
