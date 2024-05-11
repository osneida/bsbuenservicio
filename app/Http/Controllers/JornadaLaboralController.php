<?php

namespace App\Http\Controllers;

use App\Http\Requests\JornadaLaboralRequest;
use App\Models\JornadaLaboral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JornadaLaboralController extends Controller
{
    public function index()
    {

        $heads = [
            '#',
            'Trabajador',
            'Fecha',
            'Hora Inicio',
            'Hora Fin',
            'Horas Transcurridas',
            'Cliente',
            'Tarea',
            'Observación',
            'label' => 'Acciones',
        ];
        $tiempo_transcurrido = JornadaLaboral::with('user')->with('tarea')->select(
            'id',
            'user_id',
            'fecha_inicio',
            'hora_inicio',
            'hora_fin',
            'tarea_id',
            'observacion',
            DB::raw('HOUR(TIMEDIFF(hora_fin, hora_inicio)) as horas_transcurridas'),
            DB::raw('MINUTE(TIMEDIFF(hora_fin, hora_inicio)) as minutos_transcurridos')
        )->orderByDesc('fecha_inicio')
            ->get();


        return view('admin.jornadalaboral.index', compact('tiempo_transcurrido', 'heads'));
    }


    public function misJornadas()
    {
        $user = auth()->user();

        $heads = [
            '#',
            'Trabajador',
            'Fecha',
            'Hora Inicio',
            'Hora Fin',
            'Horas Transcurridas',
            'Cliente',
            'Tarea',
            'Observación'
        ];
        $tiempo_transcurrido = JornadaLaboral::where('user_id', $user->id)->with('user')->with('tarea')->select(
            'user_id',
            'fecha_inicio',
            'hora_inicio',
            'hora_fin',
            'tarea_id',
            'observacion',
            DB::raw('HOUR(TIMEDIFF(hora_fin, hora_inicio)) as horas_transcurridas'),
            DB::raw('MINUTE(TIMEDIFF(hora_fin, hora_inicio)) as minutos_transcurridos')
        )->orderByDesc('fecha_inicio')
            ->get();


        return view('admin.jornadalaboral.mijornada', compact('tiempo_transcurrido', 'heads'));
    }

    public function suma()
    {

        $mes = now()->month;

        $heads = [
            'Nro',
            'Mes',
            'Trabajador',
            'Total Horas',
        ];

        $tiempo_transcurrido = JornadaLaboral::with('user')->select(
            'user_id',
            DB::raw('SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(hora_fin, hora_inicio)))) as tiempo_transcurrido'),
            DB::raw("CONCAT_WS('-',MONTH(fecha_inicio),YEAR(fecha_inicio)) as mes")
        )
            ->groupby('user_id', 'mes')
            ->orderByDesc('mes')
            ->orderByDesc('user_id')
            ->get();


        /*   $tiempo_transcurrido2 = JornadaLaboral::with('user')->select(
            'user_id',
            DB::raw($mes . ' as mes'),
            DB::raw('SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(hora_fin, hora_inicio)))) as tiempo_transcurrido')
        )->whereMonth('fecha_inicio', $mes)
            ->groupBy('user_id')
            ->orderByDesc('user_id')
            ->get();*/

        return view('admin.jornadalaboral.suma', compact('tiempo_transcurrido', 'heads'));
    }

    public function store(Request $request)
    {

        date_default_timezone_set("Europe/Madrid");

        $hora_inicio  = date("H:i:s");
        $fecha_inicio = date("d/m/y");
        $hora_fin     = '';

        $user = auth()->user();
        $request['user_id']      = $user->id;
        $request['hora_inicio']  = $hora_inicio;
        $request['fecha_inicio'] = $fecha_inicio;
        $request['ubicacion'] = "Yagua";

        $jornada = JornadaLaboral::create($request->all());

        $id = $jornada->id;

        return view('admin.index', compact('hora_inicio', 'hora_fin', 'id'));
    }


    public function update(Request $request, JornadaLaboral $jornada_laboral)
    {
        $user = auth()->user();

        date_default_timezone_set("Europe/Madrid");
        $hora_fin  = date("H:i:s");
        $fecha_fin = date("d/m/y");

        $hora_inicio = $jornada_laboral->hora_inicio;
        $id = $jornada_laboral->id;

        $request['hora_fin']  = $hora_fin;
        $request['fecha_fin'] = $fecha_fin;

        $jornada_laboral->update($request->all());
        return view('admin.index', compact('hora_inicio', 'hora_fin', 'id'));
    }

    public function edit($id)
    {
        $jornada_laboral  = JornadaLaboral::with('user', 'tarea')->findOrFail($id);
        return view('admin.jornadalaboral.edit', compact('jornada_laboral'));
    }

    public function updateJornada(JornadaLaboralRequest $request, JornadaLaboral $jornada_laboral)
    {
        $jornada_laboral->update($request->all());
        return redirect()->route('jornada_laborals.horastrabajadas');

    }
}
