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
            'fecha_inicio' => 'required|date|after_or_equal:today',
            'fecha_fin'    => 'required|date|after_or_equal:fecha_inicio',
            'cliente_id'   => 'required|exists:clientes,id',
            'user_id'      => 'required',
            'user_id.*'    => 'exists:users,id',
            'horas'        => 'required|numeric|min:1|max:10',
            'dias'         => 'required|array'
        ];
    }

    public function messages(){
         return [
             'tarea.required'               => 'La tarea es requerida',
             'tarea.min'                    => 'Debe tener mínimo 3 letras',
             'tarea.max'                    => 'No puede tener mas de 255 caracteres',

             'fecha_inicio.required'        => 'La fecha es requerida',
             'fecha_inicio.date'            => 'El formato de fecha debe ser AAAA/MM/DD',
             'fecha_inicio.after_or_equal'  => 'La fecha no puede ser menor a la fecha actual',

             'fecha_fin.required'           => 'La fecha es requerida',
             'fecha_fin.date'               => 'El formato de fecha debe ser AAAA/MM/DD',
             'fecha_fin.after_or_equal'     => 'La fecha no puede ser menor a la fecha Inicio',

             'cliente_id.required'          => 'El cliente es requerido',
             'horas.required'               => 'La hora es requerida',
             'horas.numeric'                => 'La hora debe ser un número positivo mayor a 0',
             'horas.min'                    => 'Debe ser mayor a 0, (del 1 al 10)',
             'horas.max'                    => 'Debe ser menor o igual a 10, (del 1 al 10)',

             'dias.required'                => 'La hora es requerida',
             'user_id.required'             => 'La hora es requerida',
         ];
     }
}
