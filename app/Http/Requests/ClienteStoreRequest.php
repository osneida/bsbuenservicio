<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteStoreRequest extends FormRequest
{
   
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'mail' => 'nullable|string|email|min:8|max:30|unique:clientes',
            'cif'  => 'nullable|unique:clientes',

        ];
    }
}
