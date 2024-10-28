<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MainCategoryCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
            'image' => ['nullable', 'image', 'max:3000'],
            'logo' => ['required', 'image', 'max:3000'],
            'description' => ['nullable'],
            'seo_title' => ['nullable', 'max:255'],
            'seo_description' => ['nullable'],
            'status' => ['required', 'boolean'],
            'position' => ['required', 'max:255'],
        ];
    }
}
