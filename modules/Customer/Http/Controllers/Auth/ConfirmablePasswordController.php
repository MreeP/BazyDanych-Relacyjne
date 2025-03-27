<?php

namespace Modules\Customer\Http\Controllers\Auth;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\ValidationException;
use Modules\Customer\Http\Controllers\CustomerController;

/**
 * Class ConfirmablePasswordController
 *
 * Controller for the confirmable password
 */
class ConfirmablePasswordController extends CustomerController
{

    /**
     * Show the confirm password view.
     *
     * @return ViewContract
     */
    public function show(): ViewContract
    {
        return View::make('Customer::auth.confirm-password');
    }

    /**
     * Confirm the user's password.
     *
     * @param  Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        if (!Auth::guard('customer')->validate([
            'email' => $request->user()->email,
            'password' => $request->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        $request->session()->put('auth.password_confirmed_at', time());

        return redirect()->intended(route('customer.dashboard', absolute: false));
    }
}
