<?php

namespace Modules\Customer\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class EmailVerificationRequest
 *
 * Class used to represent the email verification request.
 */
class EmailVerificationRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        if (!hash_equals((string) $this->user()->getKey(), (string) $this->route('id'))) {
            return false;
        }

        if (!hash_equals(sha1($this->user()->getEmailForVerification()), (string) $this->route('hash'))) {
            return false;
        }

        return true;
    }
}
