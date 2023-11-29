<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Tarea;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    public function index(): View
    {
        $heads = [
            '#',
            'Tarea',
            'Estatus',
            'Fecha',
            'Empleado',
            'Cliente',
            ['label' => 'Acciones', 'no-export' => true, 'width' => 5],
        ];
        
        $tareas = Tarea::with('cliente')->with('user')->get();
        return view('admin.tareas.index', compact('heads','tareas'));
    }

    public function create():view
    {
        $clientes  = Cliente::select('id','name')->where('estatus',1)->orderBy('name')->get();
        $empleados = User::select('id','name')->orderBy('name')->get();

        return view('admin.tareas.create', compact('clientes','empleados'));
    }

    
}
