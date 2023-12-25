<?php

namespace App\Order\Visitor\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|integer|exists:products,id|distinct',
            'products.*.quantity' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'products.required' => trans('validation.Products_is_required'),
            'products.array' => trans('validation.Products_must_be_an_array'),
            'products.min' => trans('validation.Products must have at least one product'),
            'products.*.product_id.required' => trans('validation.Product id is required'),
            'products.*.product_id.integer' => trans('validation.Product id must be an integer'),
            'products.*.product_id.exists' => trans('validation.Product_id_must_exists'),
            'products.*.quantity.required' => trans('validation.Product quantity is required'),
            'products.*.quantity.integer' => trans('validation.Product quantity must be an integer'),
            'products.*.quantity.min' => trans('validation.Product quantity must be at least one'),
            'products.*.product_id.distinct' => trans('validation.Product_id_must_be_distinct'),

        ];
    }
}
