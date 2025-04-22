<?php

namespace Modules\Post\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Post\Models\Post;

/**
 * Class StorePostRequest
 *
 * Admin request for storing a post
 */
class StorePostRequest extends FormRequest
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
        return array_merge(Post::rules(), [
            'customer_id' => ['required', 'exists:customers,id'],
        ]);
    }
}
