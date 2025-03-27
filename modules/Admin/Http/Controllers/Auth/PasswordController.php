<?php

namespace Modules\Admin\Http\Controllers\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Modules\Admin\Models\Admin;
use Modules\Customer\Http\Controllers\CustomerController;

/**
 * Class PasswordController
 *
 * Controller for the password
 */
class PasswordController extends CustomerController
{

    /**
     * Update the admin's password.
     *
     * @param  Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate(Admin::passwordUpdateRules());

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return Redirect::back();
    }
}
