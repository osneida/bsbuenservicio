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
            'name' => 'required|string|min:3|max:45',
            'mail' => 'nullable|string|email|min:8|max:30|unique:clientes',
            'cif'  => 'nullable|unique:clientes',

        ];
    }

    public function messages(){
       // para cambiar los mensajes
        return [
            'name.required' => 'El nombre del cliete es requerido',
            'name.min'      => 'El nombre del cliete debe tener almenos 3 letras',
            'name.max'      => 'El nombre del cliete no puede tener mas de 45',
            'mail.unique'   => 'El correo del cliete esta ingresado',
            'mail.min'      => 'El correo del cliete debe tener almenos 8 letras',
            'mail.max'      => 'El correo del cliete no puede tener mas de 30',
            'mail.email'    => 'El correo del cliete debe tener el formato de email, xxx@xxx.com',
            'cif.unique'    => 'El cif del cliete está ingresado',
        ];
    }
}
