<?php

namespace Modules\Customer\Http\Controllers\Auth;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\ValidationException;
use Modules\Customer\Http\Controllers\CustomerController;
use Modules\Customer\Models\Customer;

/**
 * Class RegisteredUserController
 *
 * controller for registered user
 */
class RegisteredUserController extends CustomerController
{

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate(Customer::rules());

        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered(user: $customer));

        Auth::login($customer);

        return redirect(route('customer.dashboard', absolute: false));
    }

    /**
     * Display the registration view.
     *
     * @return ViewContract
     */
    public function create(): ViewContract
    {
        return View::make('Customer::auth.register');
    }
}
