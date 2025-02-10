<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
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
            'phone' => 'required|string',
            'birth_date' => 'required|date',
            'address' => 'required|string',
            'complement' => 'nullable|string',
            'neighborhood' => 'nullable|string',
            'zip_code' => 'required|string',
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
