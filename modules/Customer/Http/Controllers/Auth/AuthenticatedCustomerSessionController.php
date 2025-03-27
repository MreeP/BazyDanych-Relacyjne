<?php

namespace Modules\Customer\Http\Controllers\Auth;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Modules\Customer\Http\Controllers\CustomerController;
use Modules\Customer\Http\Requests\Auth\LoginCustomerRequest;

/**
 * Class AuthenticatedCustomerSessionController
 *
 * controller for handling authenticated customer session
 */
class AuthenticatedCustomerSessionController extends CustomerController
{

    /**
     * Display the login view.
     *
     * @return ViewContract
     */
    public function create(): ViewContract
    {
        return View::make('Customer::auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  LoginCustomerRequest $request
     * @return RedirectResponse
     */
    public function store(LoginCustomerRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('customer.dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('customer')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
