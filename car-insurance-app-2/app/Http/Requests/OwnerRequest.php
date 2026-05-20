<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OwnerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:50',
            'surname' => 'required|string|min:2|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('validation.name_required'),
            'surname.required' => __('validation.surname_required'),
            'role.required' => __('validation.role_required'),
            'name.min' => __('validation.name_min'),
            'name.max' => __('validation.name_max'),
            'surname.min' => __('validation.surname_min'),
            'surname.max' => __('validation.surname_max'),
        ];
    }
}
