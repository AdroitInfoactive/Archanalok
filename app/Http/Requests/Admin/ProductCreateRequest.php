<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductCreateRequest extends FormRequest
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
            'category' => 'required|string',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products,slug',
            'description' => 'nullable|string',
            'specification' => 'nullable|string',
            'brand' => 'required|exists:brands,id',
            'material' => 'required|integer',
            'units' => 'required|integer',
            'weight_type' => 'required|integer',
            'sku' => 'required|string|unique:products,sku',
            'other_code' => 'nullable|string',
            'gst' => 'required|integer',
            'priority' => 'required|integer',
            'status' => 'required|boolean',
            'has_variants' => 'required|boolean',
            'sale_price' => 'nullable|numeric',
            'offer_price' => 'nullable|numeric',
            'distributor_price' => 'nullable|numeric',
            'wholesale_price' => 'nullable|numeric',
            'min_order_qty' => 'nullable|integer',
            'weight' => 'nullable|numeric',
            'qty' => 'nullable|integer',
            'media' => 'nullable|array',
            'media.*' => 'file|mimes:jpg,jpeg,png,webp|max:2048',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
        ];
    }
    public function messages(): array
    {
        return [
            'category.required' => 'The category field is required.',
            'name.required' => 'The product name is required.',
            'slug.required' => 'The product slug is required.',
            'slug.unique' => 'The slug must be unique.',
            'sku.required' => 'The SKU is required.',
            'sku.unique' => 'The SKU must be unique.',
            'media.*.mimes' => 'Only JPG, JPEG, PNG, and WEBP files are allowed for media.',
            'media.*.max' => 'Each media file must not exceed 2 MB.',
            'brand.required' => 'The brand field is required.',
            'brand.exists' => 'The selected brand is invalid.',
            'material.required' => 'The material field is required.',
            'units.required' => 'The units field is required.',
            'weight_type.required' => 'The weight type field is required.',
            'has_variants.required' => 'The has_variants field is required.',
            'has_variants.boolean' => 'The has_variants field must be a boolean value (true or false).',
            'status.required' => 'The status field is required.',
            'status.boolean' => 'The status field must be a boolean value (true or false).',
            'priority.required' => 'The priority field is required.',
            'priority.integer' => 'The priority field must be an integer.',
            'gst.required' => 'The GST field is required.',
            'gst.integer' => 'The GST field must be an integer.',
            'sale_price.numeric' => 'The sale price must be a numeric value.',
            'offer_price.numeric' => 'The offer price must be a numeric value.',
            'distributor_price.numeric' => 'The distributor price must be a numeric value.',
            'wholesale_price.numeric' => 'The wholesale price must be a numeric value.',
            'min_order_qty.integer' => 'The minimum order quantity must be an integer.',
            'weight.numeric' => 'The weight must be a numeric value.',
            'qty.integer' => 'The quantity must be an integer.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
    $response = response()->json([
    'status' => 'error',
    'errors' => $validator->errors()->toArray(),
    ], 422); // HTTP 422 Unprocessable Entity

    throw new HttpResponseException($response);
    }
}
