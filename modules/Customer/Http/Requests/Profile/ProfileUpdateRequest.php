<?php

namespace Modules\Customer\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Customer\Models\Customer;

/**
 * Class ProfileUpdateRequest
 *
 * Request class for updating the customer's profile
 */
class ProfileUpdateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(Customer::class, 'email')->ignore($this->user('customer')->id)],
        ];
    }
}
