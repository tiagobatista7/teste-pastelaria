<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'client_id' => 'required|exists:clients,id',
            'product_id' => 'required|exists:products,id'
        ];
    }
}
