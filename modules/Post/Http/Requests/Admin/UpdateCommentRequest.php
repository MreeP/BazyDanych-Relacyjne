<?php

namespace Modules\Post\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Post\Models\Comment;

/**
 * Class UpdateCommentRequest
 *
 * Admin request for updating a comment
 */
class UpdateCommentRequest extends FormRequest
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
        return [
            'content' => Comment::rules()['content'],
        ];
    }
}
