<?php

namespace Modules\Admin\Livewire\Profile\Forms;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Modules\Admin\Models\Admin;

/**
 * Class PasswordProfileForm
 *
 * Livewire form for editing an admin's password.
 */
class PasswordProfileForm extends Form
{

    #[Validate]
    public $current_password = '';

    #[Validate]
    public $password = '';

    public $password_confirmation = '';

    /**
     * Update the admin's basic information.
     *
     * @return void
     */
    public function save(): void
    {
        $this->validate();

        Auth::guard('admin')->user()->update([
            'password' => Hash::make($this->password),
        ]);

        $this->reset();
    }

    /**
     * Get validation rules for the model.
     *
     * @return array
     */
    protected function rules(): array
    {
        return Admin::passwordUpdateRules();
    }
}
