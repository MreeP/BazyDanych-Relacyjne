<?php

namespace Modules\Admin\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Admin\Models\Admin;

/**
 * Class ProfileUpdateRequest
 *
 * Request class for updating the admin's profile
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
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(Admin::class, 'email')->ignore($this->user('admin')->id)],
        ];
    }
}
