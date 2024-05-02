<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JornadaLaboralRequest extends FormRequest
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
            'fecha_inicio' => 'required|date|max:10',
            'hora_inicio'  => 'required|string|min:8|max:8',
            'hora_fin'     => 'required|string|min:8|max:8',
        ];
    }

    public function messages(){
        // para cambiar los mensajes
         return [
             'fecha_inicio.required' => 'La fecha de inicio es requerido',
             'fecha_inicio.date'     => 'La fecha de inicio debe ser una fecha',
             'hora_inicio.required'  => 'La hora de inicio es requerido',
             'hora_inicio.max'       => 'La hora de inicio debe tener minimo y máximo 8 caracteres con el formato 00:00:00',
             'hora_inicio.min'       => 'La hora de inicio debe tener minimo y máximo 8 caracteres con el formato 00:00:00',
             'hora_fin.required'     => 'La hora de fin es requerido',
             'hora_fin.max'          => 'La hora de fin debe tener minimo y máximo 8 caracteres con el formato 00:00:00',
             'hora_fin.min'          => 'La hora de fin debe tener minimo y máximo 8 caracteres con el formato 00:00:00',
         ];
     }
}
