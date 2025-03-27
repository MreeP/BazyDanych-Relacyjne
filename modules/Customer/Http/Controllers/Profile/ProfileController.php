<?php

namespace Modules\Customer\Http\Controllers\Profile;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Modules\Customer\Http\Controllers\CustomerController;
use Modules\Customer\Http\Requests\Profile\ProfileUpdateRequest;

/**
 * Class ProfileController
 *
 * controller for the customer's profile
 */
class ProfileController extends CustomerController
{

    /**
     * Display the user's profile form.
     *
     * @param  Request $request
     * @return ViewContract
     */
    public function edit(Request $request): ViewContract
    {
        return View::make('Customer::profile.edit', [
            'mustVerifyEmail' => $request->user('customer') instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     *
     * @param  ProfileUpdateRequest $request
     * @return RedirectResponse
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user('customer')->fill($request->validated());

        if ($request->user('customer')->isDirty('email')) {
            $request->user('customer')->email_verified_at = null;
        }

        $request->user('customer')->save();

        return Redirect::route('customer.profile.edit');
    }

    /**
     * Delete the user's account.
     *
     * @param  Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user('customer');

        Auth::guard('customer')->logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::route('landing');
    }
}
