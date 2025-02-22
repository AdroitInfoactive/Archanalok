<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BrandCreateRequest extends FormRequest
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
            'name' => ['required', 'max:255'],
            'logo' => ['required', 'image', 'max:3000'],
            'description' => ['nullable'],
            'seo_title' => ['nullable', 'max:255'],
            'seo_description' => ['nullable'],
            'status' => ['required', 'boolean'],
            'position' => ['required', 'max:255'],
        ];
    }
}
