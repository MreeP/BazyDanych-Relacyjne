<?php

namespace Modules\Customer\Http\Controllers\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Modules\Customer\Http\Controllers\CustomerController;
use Modules\Customer\Models\Customer;

/**
 * Class PasswordController
 *
 * Controller for the password
 */
class PasswordController extends CustomerController
{

    /**
     * Update the customer's password.
     *
     * @param  Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate(Customer::passwordUpdateRules());

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return Redirect::back();
    }
}
