<?php

namespace App\Livewire;

use App\Models\JornadaLaboral;
use Livewire\Component;

class JornadaLivewire extends Component
{

    public $hora_inicio, $hora_fin, $id, $jornada, $enable_inicio, $enable_fin;
    public function mount()
    {
        $this->hora_inicio = '';
        $this->hora_fin    = '';
        $this->id = '';
        $this->enable_inicio = 'enabled'; 
        $this->enable_fin    = 'disabled';

        $user = auth()->user();
        $JornadaLaboral = $this->jornada = JornadaLaboral::select('id', 'hora_inicio', 'hora_fin')->where('user_id', $user->id)
            ->orderByDesc('id')
            ->take(1)
            ->get();

        $jl =  $JornadaLaboral->toArray();

        if (isset($jl[0])) {
            if ($jl[0]['hora_fin'] == null) {
                $this->hora_inicio = $jl[0]['hora_inicio'];
                $this->id = $jl[0]['id'];
                $this->enable_inicio = 'disabled'; 
                $this->enable_fin    = 'enabled';
        
            }
        }
    }

    public function guardar_hora_inicio()
    {
        date_default_timezone_set("Europe/Madrid");
        $this->hora_inicio = date("H:i:s");
        $this->hora_fin    = '';

        $user = auth()->user();
        $data['user_id']      = $user->id;
        $data['hora_inicio']  = $this->hora_inicio;
        $data['fecha_inicio'] = date("y/m/d");
            
        $jornada = JornadaLaboral::create($data);

        $this->enable_inicio = 'disabled'; 
        $this->enable_fin    = 'enabled';

        $this->id = $jornada->id;
    }

    public function guardar_hora_fin()
    {
        date_default_timezone_set("Europe/Madrid");
        $this->hora_fin = date("H:i:s");
        $fecha_fin = date("y/m/d");

        $jl = JornadaLaboral::find($this->id);

        $jl->update(['hora_fin' => $this->hora_fin, 'fecha_fin' => $fecha_fin, 'ubicacion_fin' => $ubicacion_fin]);

        $this->enable_inicio = 'disabled'; 
        $this->enable_fin    = 'disabled';

    }

    public function render()
    {
        return view('livewire.jornada-livewire');
    }
}
