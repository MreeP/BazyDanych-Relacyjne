<?php

namespace Modules\Post\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Post\Models\Post;

/**
 * Class UpdatePostRequest
 *
 * Admin request for updating a post
 */
class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return Post::rules();
    }
}
