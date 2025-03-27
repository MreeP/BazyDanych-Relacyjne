<?php

namespace Modules\Admin\Livewire\Profile\Forms;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Modules\Admin\Models\Admin;

/**
 * Class BasicProfileForm
 *
 * Livewire form for editing an admin's basic info.
 */
class BasicProfileForm extends Form
{

    #[Validate]
    public $name = '';

    /**
     * Update the admin's basic information.
     *
     * @return void
     */
    public function save(): void
    {
        $this->validate();

        Auth::guard('admin')->user()->update([
            'name' => $this->name,
        ]);
    }

    /**
     * Set the admin for the form.
     *
     * @param  Admin $admin
     * @return void
     */
    public function setAdmin(Admin $admin): void
    {
        $this->name = $admin->name;
    }

    /**
     * Get validation rules for the model.
     *
     * @return array
     */
    protected function rules(): array
    {
        return Arr::only(
            Admin::rules(),
            ['name'],
        );
    }
}
