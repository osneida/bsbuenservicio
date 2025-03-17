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
            'fecha'      => 'required|date|after_or_equal:today',
            'cliente_id' => 'required|exists:clientes,id',
            'horas'      => 'required|numeric|min:1|max:10',
        ];
    }

    public function messages(){
        // para cambiar los mensajes
         return [
             'tarea.required'      => 'La tarea es requerida',
             'tarea.min'           => 'Debe tener mínimo 3 letras',
             'tarea.max'           => 'No puede tener mas de 255 caracteres',
             'fecha.required'      => 'La fecha es requerida',
             'fecha.date'          => 'El formato de fecha debe ser AAAA/MM/DD',
             'fecha.after_or_equal'=> 'La fecha no puede ser menor a la fecha actual',
             'cliente_id.required' => 'El cliente es requerido',
             'horas.required'      => 'La hora es requerida',
             'horas.numeric'       => 'La hora debe ser un número positivo mayor a 0',
             'horas.min'           => 'Debe ser mayor a 0, (del 1 al 10)',
             'horas.max'           => 'Debe ser menor o igual a 10, (del 1 al 10)',
         ];
     }
}
