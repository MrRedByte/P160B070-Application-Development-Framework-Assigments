<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reg_number' => [
                'required',
            ],
            'brand' => 'required|string|max:50',
            'model' => 'required|string|max:50'
        ];
    }

    public function messages(): array
    {
        return [
            'reg_number.required' => __('validation.reg_number_required'),
            'brand.required' => __('validation.brand_required'),
            'brand.max' => __('validation.brand_max'),
            'model.required' => __('validation.model_required'),
            'model.max' => __('validation.model_max'),
        ];
    }
}
