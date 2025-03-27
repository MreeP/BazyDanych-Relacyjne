<?php

namespace Modules\Customer\Livewire\Profile;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Livewire\Component;
use Modules\Customer\Livewire\Profile\Forms\BasicProfileForm;
use Modules\Customer\Livewire\Profile\Forms\PasswordProfileForm;

/**
 * Class Edit
 *
 * Livewire component for editing a user's profile.
 */
class Edit extends Component
{

    public BasicProfileForm $basic;

    public PasswordProfileForm $password;

    /**
     * Mount the component.
     *
     * @return void
     */
    public function mount(): void
    {
        $this->basic->setCustomer(Auth::guard('customer')->user());
    }

    /**
     * Render the component.
     *
     * @return ViewContract
     */
    public function render(): ViewContract
    {
        return View::make('Customer::livewire.profile.edit');
    }

    /**
     * Save the user's basic information.
     *
     * @return void
     */
    public function saveBasic(): void
    {
        $this->basic->save();
        $this->dispatch('inform.user', message: __('Your profile has been updated.'), duration: 5000);
    }

    /**
     * Save the user's password.
     *
     * @return void
     */
    public function savePassword(): void
    {
        $this->password->save();
        $this->dispatch('inform.user', message: __('Your profile has been updated.'), duration: 5000);
    }
}
