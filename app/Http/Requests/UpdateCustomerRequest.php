<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
{
    public function authorize()
    {
        // return auth()->check();
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:customers,email',
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'O email informado já está em uso.',
            'name.required' => 'O nome é obrigatório.',
            'email.required' => 'O email é obrigatório.',
        ];
    }
}
