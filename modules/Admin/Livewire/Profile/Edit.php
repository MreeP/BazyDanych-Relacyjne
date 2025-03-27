<?php

namespace Modules\Admin\Livewire\Profile;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Livewire\Component;
use Modules\Admin\Livewire\Profile\Forms\BasicProfileForm;
use Modules\Admin\Livewire\Profile\Forms\PasswordProfileForm;

/**
 * Class Edit
 *
 * Livewire component for editing an admin's profile.
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
        $this->basic->setAdmin(Auth::guard('admin')->user());
    }

    /**
     * Render the component.
     *
     * @return ViewContract
     */
    public function render(): ViewContract
    {
        return View::make('Admin::livewire.profile.edit');
    }

    /**
     * Save the admin's basic information.
     *
     * @return void
     */
    public function saveBasic(): void
    {
        $this->basic->save();
        $this->dispatch('inform.user', message: __('Your profile has been updated.'), duration: 5000);
    }

    /**
     * Save the admin's password.
     *
     * @return void
     */
    public function savePassword(): void
    {
        $this->password->save();
        $this->dispatch('inform.user', message: __('Your profile has been updated.'), duration: 5000);
    }
}
