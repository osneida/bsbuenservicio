<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TareaRequest;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Tarea;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;

class TareaController extends Controller
{
    public function index(Request $request): View
    {
        $user = auth()->user();
        $estatus = $request->get('estatus', 'pendiente');
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

        $tareasQuery = Tarea::select('id', 'tarea', 'estatus', 'fecha', 'horas', 'user_id', 'cliente_id')
            ->with('cliente:id,name')
            ->with('user:id,name');

        if ($estatus !== 'todas') {
            $tareasQuery->where('estatus', $estatus);
        }

        $tareas = $tareasQuery->orderBy('id', 'desc')->get();

        /* $tareas = Tarea::select('id', 'tarea', 'estatus', 'fecha', 'horas', 'user_id', 'cliente_id')
            ->with('cliente:id,name')
            ->with('user:id,name')
            ->where('estatus', $estatus)
            ->Orderby('id', 'desc')->get();*/

        return view('admin.tareas.index', compact('heads', 'tareas', 'is_admin', 'estatus'));
    }

    public function misTareas(): View
    {

        $user = auth()->user();
        $is_admin = $user->is_admin;
        $estatus = "";
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
        return view('admin.tareas.index', compact('heads', 'tareas', 'is_admin', 'estatus'));
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

                    if ($existe) {
                        $trabajador = User::findOrFail($user);
                        $mensaje = $mensaje . ' - Ya existe tarea: ' . $data['tarea'] .
                            ' creada para este cliente, asignada al trabajador: ' .
                            $trabajador->name . '  en la fecha: ' . $data['fecha'] . ' === ';
                    } else {
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

                if (!$existe) {
                    $mensaje = 'Tarea creada con éxito';
                    $tareas = Tarea::create($request->all());
                } else {
                    $mensaje = 'Ya existe la tarea: ' . $data['tarea'] . ' creada para este cliente en la fecha: ' . $data['fecha'];
                }
            }

            DB::commit();
            return redirect()->route('tareas.indexhtml')->with('info',  $mensaje);
        } catch (\Exception $exception) {
            Log::info('Erorr', ['data' => $exception]);
            DB::rollback();
            return redirect()->route('tareas.indexhtml')->with('danger', 'La tarea NO se pudo crear');
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
        return redirect()->route('tareas.indexhtml')->with('info', 'Tarea modificada con éxito');
    }

    public function destroy(Tarea $tarea): RedirectResponse
    {
        // Verificar si la tarea tiene registros en la tabla jornada_laboral
        if ($tarea->jornada()->exists()) {
            return redirect()->route('tareas.indexhtml')->with('danger', 'No se puede borrar la tarea porque ya tiene una jornada creada.');
        }

        // Si no tiene registros, proceder a eliminar
        $tarea->delete();
        return redirect()->route('tareas.indexhtml')->with('info', 'La tarea se eliminó con éxito');
    }

    public function indexhtml(Request $request): View
    {
        $user = auth()->user();

        $empleados = User::select('id', 'name')->orderBy('name')->get();
        $clientes  = Cliente::select('id', 'name')->where('estatus', 1)->orderBy('name')->get();
        $is_admin  = auth()->user()->is_admin;

        return view('admin.tareas.indexhtml', compact('empleados', 'clientes', 'is_admin'));
    }
}


 /*

        $perPage   = $request->get('perPage', 10); // Valor por defecto: 10
        $estatus   = $request->get('estatus',  'todas');
        $empleado  = $request->get('empleado', 'todas');
        $cliente   = $request->get('cliente',  'todas');
        $empleados = User::select('id', 'name')->orderBy('name')->get();
        $clientes  = Cliente::select('id', 'name')->where('estatus', 1)->orderBy('name')->get();
        $is_admin  = $user->is_admin;


        $tareasQuery = Tarea::select('id', 'tarea', 'estatus', 'fecha', 'horas', 'user_id', 'cliente_id')
            ->with('cliente:id,name')
            ->with('user:id,name');

        if ($estatus !== 'todas') {
            $tareasQuery->where('estatus', $estatus);
        }

        if ($empleado !== 'todas') {
            $tareasQuery->where('user_id', $empleado);
        }

        if ($cliente !== 'todas') {
            $tareasQuery->where('cliente_id', $cliente);
        }

        $tareas = $tareasQuery->orderBy('id', 'desc')->paginate($perPage);

        //$tareas = $tareasQuery->orderBy('id', 'desc')->paginate(10);

        return view('admin.tareas.indexhtml', compact('tareas', 'is_admin', 'estatus','empleado','empleados','clientes', 'cliente', 'perPage'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
*/
