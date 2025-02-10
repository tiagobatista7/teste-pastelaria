<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        // return auth()->check();
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'photo' => 'image|mimes:jpg,jpeg,png|max:2048'
        ];
    }
}
