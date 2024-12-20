<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => ['required', 'exists:products,id'],
            'rating' => ['required', 'integer', 'between:1,5'],
            'review_subject' => ['required', 'string', 'max:255'],
            'review_comment' => ['required', 'string'],
            'created_by' => ['required', 'exists:users,id'],
            'updated_by' => ['required', 'exists:users,id']
        ];
    }
}
