<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'title'=>['required', 'max:200'],
            'category_id' => ['nullable'],
            'images.*'=>['nullable', 'image'],
            'deleted_images.*'=>['nullable', 'numeric'],
            'price'=>['required', 'numeric'],
            'description'=>['nullable', 'string']
        ];
    }
}
