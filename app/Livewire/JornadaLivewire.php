<?php

namespace App\Livewire;

use App\Models\JornadaLaboral;
use App\Models\Tarea;
use Livewire\Component;

class JornadaLivewire extends Component
{
    public $user_id, $hora_inicio, $hora_fin, $id, $jornada, $enable_inicio, $enable_fin, $tarea_id, $observacion, $user;
    public function mount()
    {
        $this->hora_inicio = '';
        $this->hora_fin    = '';
        $this->id = '';
        $this->enable_inicio = 'enabled';
        $this->enable_fin    = 'disabled';

        $users = auth()->user();
        $this->user = $users->id;
        date_default_timezone_set("Europe/Madrid");
        $hoy = date("y/m/d");

        //  ->orderByDesc('id')
        //  ->take(1)
        $JornadaLaboral = $this->jornada = JornadaLaboral::select('id', 'hora_inicio', 'hora_fin')
            ->where('user_id', $this->user)
            ->where('fecha_inicio', $hoy)
            ->get();

        $jl =  $JornadaLaboral->toArray();

        if (isset($jl[0])) {
            $this->hora_inicio = $jl[0]['hora_inicio'];
            $this->hora_fin    = $jl[0]['hora_fin'];
            if ($jl[0]['hora_fin'] == null) {
                $this->enable_inicio = 'disabled';
                $this->enable_fin    = 'enabled';
            }else{
                $this->enable_inicio = 'disabled';
                $this->enable_fin    = 'disabled';
            }
        }     
    }

    public function guardar_hora_inicio($tarea)
    {
        date_default_timezone_set("Europe/Madrid");
        $this->hora_inicio = date("H:i:s");
        $this->hora_fin    = '';

        $data['user_id']      = $this->user;
        $data['hora_inicio']  = $this->hora_inicio;
        $data['fecha_inicio'] = date("y/m/d");
        $data['tarea_id']     = $tarea;

        $jornada = JornadaLaboral::create($data);
        $tarea = Tarea::find($tarea);
        $tarea->update(['estatus' => 'Iniciada']);

        $this->enable_inicio = 'disabled';
        $this->enable_fin    = 'enabled';

        $this->id = $jornada->id;
    }

    public function guardar_hora_fin($tarea)
    {
        date_default_timezone_set("Europe/Madrid");
        $this->hora_fin = date("H:i:s");
        $fecha_fin = date("y/m/d");

        $jl = JornadaLaboral::where('tarea_id', $tarea);

        $jl->update(['hora_fin' => $this->hora_fin, 'fecha_fin' => $fecha_fin]);

        $tarea = Tarea::find($tarea);
        $tarea->update(['estatus' => 'Finalizada']);

        $this->enable_inicio = 'disabled';
        $this->enable_fin    = 'disabled';
    }

    public function render()
    {
        date_default_timezone_set("Europe/Madrid");
        $hoy = date("y/m/d");

        $tarea_hoy_count = Tarea::where('user_id', $this->user)
            ->where('fecha', $hoy)
            ->count();

        $tarea_hoy = Tarea::with('cliente')
            ->where('user_id', $this->user)
            ->where('fecha', $hoy)
            ->get();

        return view('livewire.jornada-livewire', compact('tarea_hoy', 'tarea_hoy_count'));
    }
}
