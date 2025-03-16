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
            'horas'      => 'required|numeric|min:1|max:10',
        ];
    }

    public function messages(){
        // para cambiar los mensajes
         return [
             'tarea.required'      => 'La tarea es requerida',
             'tarea.min'           => 'Debe tener almenos 3 letras',
             'tarea.max'           => 'No puede tener mas de 255 caracteres',
             'fecha.required'      => 'La fecha es requerida',
             'fecha.date'          => 'El formato de fecha debe ser AAAA/MM/DD',
             'cliente_id.required' => 'El cliete es requerido',
             'horas.required'      => 'La hora es requerida',
             'horas.numeric'       => 'La hora debe ser un número positivo mayor a 0',
             'horas.min'           => 'Debe ser mayor a 0',
             'horas.max'           => 'Debe ser menor o igual a 10',
         ];
     }
}
