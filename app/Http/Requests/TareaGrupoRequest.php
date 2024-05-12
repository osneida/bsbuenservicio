<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TareaGrupoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tarea'        => 'required|string|min:3|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'required|date',
            'cliente_id'   => 'required|exists:clientes,id',
            'user_id'      => 'required',
            'user_id.*'    => 'exists:users,id',
            'horas'        => 'required|numeric',
            'dias'         => 'required|array'
        ];
    }
}
