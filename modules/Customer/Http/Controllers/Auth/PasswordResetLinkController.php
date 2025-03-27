<?php

namespace Modules\Customer\Http\Controllers\Auth;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\ValidationException;
use Modules\Customer\Http\Controllers\CustomerController;
use Modules\Customer\View\Components\AuthLayout;

/**
 * Class PasswordResetLinkController
 *
 * Controller for the password reset link
 */
class PasswordResetLinkController extends CustomerController
{

    /**
     * Display the password reset link request view.
     *
     * @return ViewContract
     */
    public function create(): ViewContract
    {
        return View::make('Customer::auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate(['email' => ['required', 'email']]);

        // We will send the password reset link to this user. Once we
        // have attempted to send the link, we will send the basic
        // response so that client can't enumerate user existence.
        Password::sendResetLink(
            $request->only('email'),
        );

        return Redirect::back()->with([
            AuthLayout::SESSION_STATUS => __('Reset link was sent to :email', ['email' => $request->get('email')]),
            AuthLayout::SESSION_STATUS_TYPE => AuthLayout::STATUS_SUCCESS,
        ]);
    }
}
