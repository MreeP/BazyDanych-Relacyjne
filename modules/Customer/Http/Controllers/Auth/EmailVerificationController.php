<?php

namespace Modules\Customer\Http\Controllers\Auth;

use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Events\Dispatcher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Modules\Customer\Http\Controllers\CustomerController;
use Modules\Customer\Http\Requests\Auth\EmailVerificationRequest;

/**
 * Class EmailVerificationController
 *
 * Controller for customer email verification
 */
class EmailVerificationController extends CustomerController
{

    /**
     * Display the email verification prompt.
     *
     * @param  Request $request
     * @return RedirectResponse|ViewContract
     */
    public function prompt(Request $request): RedirectResponse|ViewContract
    {
        if ($request->user()->hasVerifiedEmail()) {
            return Redirect::intended(URL::route('customer.dashboard', absolute: false));
        }

        return View::make('Customer::auth.verify-email', ['status' => session('status')]);
    }

    /**
     * Send a new email verification notification.
     *
     * @param  Request $request
     * @return RedirectResponse
     */
    public function notify(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return Redirect::intended(URL::route('customer.dashboard', absolute: false));
        }

        $request->user()->sendEmailVerificationNotification();

        return Redirect::back()->with(['status' => 'verification-link-sent']);
    }

    /**
     * Mark the authenticated customer's email address as verified.
     *
     * @param  EmailVerificationRequest $request
     * @param  Dispatcher               $dispatcher
     * @return RedirectResponse
     */
    public function verify(EmailVerificationRequest $request, \Illuminate\Contracts\Events\Dispatcher $dispatcher): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return Redirect::intended(URL::route('customer.dashboard', absolute: false) . '?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            $dispatcher->dispatch(new Verified($request->user()));
        }

        return Redirect::intended(URL::route('customer.dashboard', absolute: false) . '?verified=1');
    }
}
