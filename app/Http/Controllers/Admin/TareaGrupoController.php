<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TareaGrupoRequest;
use App\Models\Cliente;
use App\Models\Tarea;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class TareaGrupoController extends Controller
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

    public function create(): view
    {
        $dias      = [
            ['name_en' => 'monday',    'name' => 'Lunes'],
            ['name_en' => 'tuesday',   'name' => 'Martes'],
            ['name_en' => 'wednesday', 'name' => 'Miércoles'],
            ['name_en' => 'thursday',  'name' => 'Jueves'],
            ['name_en' => 'friday',    'name' => 'Viernes'],
            ['name_en' => 'saturday',  'name' => 'Sábado'],
            ['name_en' => 'sunday',    'name' => 'Domingo']
        ];

        $clientes  = Cliente::select('id', 'name')->where('estatus', 1)->orderBy('name')->get();
        $empleados = User::select('id', 'name')->orderBy('name')->get();

        return view('admin.tareasgrupo.create', compact('clientes', 'empleados', 'dias'));
    }

    public function store(TareaGrupoRequest $request)
    {
        $request->fecha_inicio;
        $request->fecha_fin;
        $request->horas;
        $request->cliente_id;
        $empleados = $request->user_id;
        $dias = $request->dias;

        foreach ($empleados as $empleado) {
            foreach ($dias as $dia) {
                $fechas_tareas = $this->obtenerFechasDiasSemana($request->fecha_inicio, $request->fecha_fin, $dia);
                foreach ($fechas_tareas as $fechas_tarea) {
                    $data['user_id']    = $empleado;
                    $data['tarea']      = $request->tarea;
                    $data['fecha']      = $fechas_tarea;
                    $data['cliente_id'] = $request->cliente_id;
                    $data['horas']      = $request->horas;

                    Tarea::create($data);
                }
            }
        }

        return redirect()->route('tareasgrupo.index')->with('info', 'Tareas creadas con éxito');
    }

    function obtenerFechasDiasSemana($fecha_inicio, $fecha_fin, $dia)
    {

        $fechas = [];

        $startDate = Carbon::parse($fecha_inicio);
        $endDate   = Carbon::parse($fecha_fin);
    
        // Ajustar `$startDate` al primer día de la semana `$dia` después de `$fecha_inicio`
        while ($startDate->format('l') !== ucfirst(strtolower($dia))) {
            $startDate->addDay(); // Avanzar un día hasta que coincida con `$dia`
        }
    
        // Mientras `$startDate` sea menor o igual que `$fecha_fin`
        while ($startDate->lte($endDate)) {
            if ($startDate->format('l') === ucfirst(strtolower($dia))) {
                $fechas[] = $startDate->toDateString(); // Agregar la fecha al array `$fechas`
            }
            $startDate->addWeek(); // Avanzar una semana
        }

        return $fechas;
    }
}
