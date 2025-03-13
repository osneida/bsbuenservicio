<?php

namespace App\Livewire;

use App\Models\JornadaLaboral;
use App\Models\Tarea;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class JornadaLivewire extends Component
{
    public $user_id, $hora_inicio, $hora_fin, $id, $jornada,  $tarea_id, $observacion, $user, $tarea_hoy_count;
    //$enable_inicio, $enable_fin,

    public $horas_inicio = []; // Array para almacenar las horas de inicio de cada tarea
    public $horas_fin    = [];   // Array para almacenar las horas de fin de cada tarea

    public $enables_inicio = [];
    public $enables_fin = [];

    public function mount()
    {
        $this->hora_inicio = '';
        $this->hora_fin    = '';
        $this->id = '';
        //   $this->enable_inicio = 'enabled';
        //   $this->enable_fin    = 'disabled';

        // Inicializa los arrays con las horas de inicio y fin vacías para cada tarea
        $this->horas_inicio = array_fill(0, $this->tarea_hoy_count, '');
        $this->horas_fin = array_fill(0, $this->tarea_hoy_count, '');

        $this->enables_inicio = array_fill(0, $this->tarea_hoy_count, 'enabled');
        $this->enables_fin = array_fill(0, $this->tarea_hoy_count, 'disabled');



        $users = auth()->user();
        $this->user = $users->id;
        date_default_timezone_set("Europe/Madrid");
        $hoy = date("y/m/d");

        //  ->orderByDesc('id')
        //  ->take(1)
        $JornadaLaboral = $this->jornada = JornadaLaboral::select('id', 'hora_inicio', 'hora_fin', 'tarea_id')
            ->where('user_id', $this->user)
            ->where('fecha_inicio', $hoy)
            ->get();

        $jl =  $JornadaLaboral->toArray();

        if (isset($jl[0])) {
            foreach ($jl as $j) {
                $this->horas_inicio[$j['tarea_id']] = $j['hora_inicio'];
                $this->horas_fin[$j['tarea_id']] = $j['hora_fin'];

                if ($j['hora_fin'] == null) {
                    $this->enables_inicio[$j['tarea_id']] = 'disabled';
                    $this->enables_fin[$j['tarea_id']] = 'enabled';
                } else {
                    $this->enables_inicio[$j['tarea_id']] = 'disabled';
                    $this->enables_fin[$j['tarea_id']] = 'disabled';
                }
            }
        }
    }

    public function guardar_hora_inicio($index, $tarea)
    {
        date_default_timezone_set("Europe/Madrid");
        $this->hora_inicio = date("H:i:s");
        $this->hora_fin    = '';

        // Actualiza la hora de inicio para la tarea específica
        $this->horas_inicio[$index] = $this->hora_inicio;

        $data['user_id']      = $this->user;
        $data['hora_inicio']  = $this->hora_inicio;
        $data['fecha_inicio'] = date("y/m/d");
        $data['tarea_id']     = $tarea;

        //$jornada = JornadaLaboral::create($data);
        $jornada = JornadaLaboral::updateOrCreate(['tarea_id' => $tarea],
        [
            'user_id'      => $this->user,
            'fecha_inicio' => date("y/m/d"),
            'hora_inicio'  => $this->hora_inicio,
            'observacion'  => ''
        ]); 


        $tarea = Tarea::find($tarea);
        $tarea->update(['estatus' => 'Iniciada']);

        $this->enables_inicio[$index] = 'disabled';
        $this->enables_fin[$index] = 'enabled';

        $this->id = $jornada->id;
    }

    public function guardar_hora_fin($index, $tarea)
    {
        date_default_timezone_set("Europe/Madrid");
        $this->hora_fin = date("H:i:s");
        $fecha_fin = date("y/m/d");

        $this->horas_fin[$index] = $this->hora_fin;
        $jl = JornadaLaboral::where('tarea_id', $tarea);

        $jl->update(['hora_fin' => $this->hora_fin, 'fecha_fin' => $fecha_fin]);

        $tarea = Tarea::find($tarea);
        $tarea->update(['estatus' => 'Finalizada']);

        $this->enables_inicio[$index] = 'disabled';
        $this->enables_fin[$index] = 'disabled';
    }

    public function render()
    {
        date_default_timezone_set("Europe/Madrid");
        $hoy = date("y/m/d");

        $tarea_hoy = Tarea::with('cliente')
            ->where('user_id', $this->user)
            ->where('fecha', $hoy)
            ->get();

        return view('livewire.jornada-livewire', compact('tarea_hoy'));
    }
}
