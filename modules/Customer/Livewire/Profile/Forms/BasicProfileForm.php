<?php

namespace Modules\Customer\Livewire\Profile\Forms;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Modules\Customer\Models\Customer;

/**
 * Class BasicProfileForm
 *
 * Livewire form for editing a customer's basic info.
 */
class BasicProfileForm extends Form
{

    #[Validate]
    public $name = '';

    /**
     * Update the customer's basic information.
     *
     * @return void
     */
    public function save(): void
    {
        $this->validate();

        Auth::guard('customer')->user()->update([
            'name' => $this->name,
        ]);
    }

    /**
     * Set the customer for the form.
     *
     * @param  Customer $customer
     * @return void
     */
    public function setCustomer(Customer $customer): void
    {
        $this->name = $customer->name;
    }

    /**
     * Get validation rules for the model.
     *
     * @return array
     */
    protected function rules(): array
    {
        return Arr::only(
            Customer::rules(),
            ['name'],
        );
    }
}
