<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePermissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'min:3',
                'max:255',
                'string',
                Rule::unique('permissions')->ignore($this->permission)
            ],
            'description' => [
                // 'nullable',
                'required',
                'min:3',
                'max:255',
                'string'
            ]
        ];
    }
}
