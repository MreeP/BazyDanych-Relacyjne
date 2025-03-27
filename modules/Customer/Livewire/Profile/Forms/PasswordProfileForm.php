<?php

namespace Modules\Customer\Livewire\Profile\Forms;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Modules\Customer\Models\Customer;

/**
 * Class PasswordProfileForm
 *
 * Livewire form for editing a customer's password.
 */
class PasswordProfileForm extends Form
{

    #[Validate]
    public $current_password = '';

    #[Validate]
    public $password = '';

    public $password_confirmation = '';

    /**
     * Update the customer's basic information.
     *
     * @return void
     */
    public function save(): void
    {
        $this->validate();

        Auth::guard('customer')->user()->update([
            'password' => Hash::make($this->password),
        ]);
    }

    /**
     * Get validation rules for the model.
     *
     * @return array
     */
    protected function rules(): array
    {
        return Customer::passwordUpdateRules();
    }
}
