<?php

namespace Modules\Admin\Http\Controllers\Profile;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Modules\Admin\Http\Controllers\AdminController;
use Modules\Admin\Http\Requests\Profile\ProfileUpdateRequest;

/**
 * Class ProfileController
 *
 * controller for the admin's profile
 */
class ProfileController extends AdminController
{

    /**
     * Display the admin's profile form.
     *
     * @param  Request $request
     * @return ViewContract
     */
    public function edit(Request $request): ViewContract
    {
        return View::make('Admin::profile.edit', [
            'mustVerifyEmail' => $request->user('admin') instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the admin's profile information.
     *
     * @param  ProfileUpdateRequest $request
     * @return RedirectResponse
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user('admin')->fill($request->validated());

        if ($request->user('admin')->isDirty('email')) {
            $request->user('admin')->email_verified_at = null;
        }

        $request->user('admin')->save();

        return Redirect::route('admin.profile.edit');
    }

    /**
     * Delete the admin's account.
     *
     * @param  Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user('admin');

        Auth::guard('admin')->logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::route('auth.admin.login');
    }
}
