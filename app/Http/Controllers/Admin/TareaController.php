<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TareaRequest;
use App\Models\Cliente;
use App\Models\Tarea;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

//use Illuminate\Support\Facades\Log;

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
        return view('admin.tareas.index', compact('heads', 'tareas'));
    }

    public function create(): view
    {
        $clientes  = Cliente::select('id', 'name')->where('estatus', 1)->orderBy('name')->get();
        $empleados = User::select('id', 'name')->orderBy('name')->get();

        return view('admin.tareas.create', compact('clientes', 'empleados'));
    }

    public function store(TareaRequest $request)
    {

        // Log::info('mensaje de llegada de empleados ',['data'=>request()->all()]);

        try {
            DB::beginTransaction();
            $data = $request->all();

            if (array_key_exists('user_id', $data)) {
                foreach ($data['user_id'] as $user) {
                    $data['user_id'] = $user;
                    $tareas = Tarea::create($data);
                }
            } else {
                $tareas = Tarea::create($request->all());
            }

            DB::commit();
            return redirect()->route('tareas.index')->with('info', 'Tarea creada con éxito');
        } catch (\Exception $exception) {
            DB::rollback();
            return redirect()->route('tareas.index')->with('danger', 'La tarea NO se pudo crear');
        }
    }


    public function edit(Tarea $tarea): View
    {
        $clientes  = Cliente::select('id', 'name')->where('estatus', 1)->orderBy('name')->get();
        $empleados = User::select('id', 'name')->orderBy('name')->get();

        return view('admin.tareas.edit',compact('tarea','clientes','empleados'));
    }

    public function update(TareaRequest $request, Tarea $tarea)
    {
        $data = $request->all(); 
        if( $data['user_id'] == 0){
            $data['user_id']=NULL;
        }
        if( $data['cliente_id'] == 0){
            $data['cliente_id']=NULL;
        }
        $tarea->update($data);
        return redirect()->route('tareas.index')->with('info', 'Tarea modificada con éxito');
    }

    public function destroy(Tarea $tarea): RedirectResponse
    {
        $tarea->delete();
        return redirect()->route('tareas.index')->with('danger', 'La tarea se eliminó con éxito');
    }
}
