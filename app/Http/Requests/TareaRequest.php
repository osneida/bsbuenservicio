<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TareaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tarea'      => 'required|string|min:3|max:255',
            'fecha'      => 'required|date',
            'cliente_id' => 'required|exists:clientes,id',
            'Horas'      => 'required|numeric',
        ];
    }
}
