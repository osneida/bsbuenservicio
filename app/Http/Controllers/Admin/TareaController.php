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

use Illuminate\Support\Facades\Log;

class TareaController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        $is_admin = $user->is_admin;
        $heads = [
            '#',
            'Tarea',
            'Estatus',
            'Fecha',
            'Horas',
            'Empleado',
            'Cliente',
            ['label' => 'Acciones', 'no-export' => true, 'width' => 5],
        ];

        $tareas = Tarea::with('cliente')->with('user')->get();
        return view('admin.tareas.index', compact('heads', 'tareas','is_admin'));
    }

    public function misTareas(): View
    {

        $user = auth()->user();
        $is_admin = $user->is_admin;

        $heads = [
            '#',
            'Tarea',
            'Estatus',
            'Fecha',
            'Horas',
            'Empleado',
            'Cliente',
            ['label' => 'Acciones', 'no-export' => true, 'width' => 5],
        ];

        $tareas = Tarea::with('cliente')->with('user')->where('user_id', $user->id)->get();
        return view('admin.tareas.index', compact('heads', 'tareas', 'is_admin'));
    }

    public function create(): view
    {
        $clientes  = Cliente::select('id', 'name')->where('estatus', 1)->orderBy('name')->get();
        $empleados = User::select('id', 'name')->orderBy('name')->get();

        return view('admin.tareas.create', compact('clientes', 'empleados'));
    }

    public function store(TareaRequest $request)
    {

        //Log::info('mensaje de llegada de empleados ',['data'=>request()->all()]);

        try {
            DB::beginTransaction();
            $data = $request->all();
            $mensaje = '';

            if (array_key_exists('user_id', $data)) {
                foreach ($data['user_id'] as $user) {
                    $data['user_id'] = $user;
                    $existe = Tarea::where('tarea', $data['tarea'])
                        ->where('fecha',      $data['fecha'])
                        ->where('user_id',    $data['user_id'])
                        ->where('cliente_id', $data['cliente_id'])
                        ->exists();

                       // Log::info('mensaje existe la tarea ',['data'=>$existe]);

                    if($existe){
                        $trabajador = User::findOrFail($user);
                        $mensaje = $mensaje.' - Ya existe tarea: '.$data['tarea'].
                                            ' creada para este cliente, asignada al trabajador: '.
                                              $trabajador->name.'  en la fecha: '.$data['fecha']. ' === ';
                       
                    }    
                    else{
                        $mensaje = 'Tarea creada con éxito';
                        $tareas = Tarea::create($data); 
                    }  
                }
            } else {
                $existe = Tarea::where('fecha', $data['fecha'])
                ->where('tarea',    $data['tarea'])
                ->where('cliente_id', $data['cliente_id'])
                ->exists();

                //Log::info('mensaje existe la tarea 22222222222',['data'=>$existe]);

                if(!$existe){
                    $mensaje = 'Tarea creada con éxito';
                    $tareas = Tarea::create($request->all());
                }    
                else{
                    $mensaje = 'Ya existe la tarea: '.$data['tarea'].' creada para este cliente en la fecha: '.$data['fecha'];
                }
            }

            DB::commit();
            return redirect()->route('tareas.index')->with('info',  $mensaje);
        } catch (\Exception $exception) {
            Log::info('Erorr',['data'=>$exception]);
            DB::rollback();
            return redirect()->route('tareas.index')->with('danger', 'La tarea NO se pudo crear');
        }
    }


    public function edit(Tarea $tarea): View
    {
        $clientes  = Cliente::select('id', 'name')->where('estatus', 1)->orderBy('name')->get();
        $empleados = User::select('id', 'name')->orderBy('name')->get();

        return view('admin.tareas.edit', compact('tarea', 'clientes', 'empleados'));
    }

    public function update(TareaRequest $request, Tarea $tarea)
    {
        $data = $request->all();
        if ($data['user_id'] == 0) {
            $data['user_id'] = NULL;
        }
        if ($data['cliente_id'] == 0) {
            $data['cliente_id'] = NULL;
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
