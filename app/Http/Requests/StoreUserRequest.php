<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
            ],
            'email' => [
                'required',
                'email',
                'min:3',
                'max:255',
                // 'unique:users,email',
                Rule::unique('users'),
            ],
            'password' => [
                'required',
                'min:6',
                'max:20',
            ],
        ];
    }
}
