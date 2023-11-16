<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class JornadaLaboral extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'fecha_inicio', 'hora_inicio', 'fecha_fin', 'hora_fin', 'ubicacion_inicio', 'ubicacion_fin'];

    //relacion uno a mucho inversa
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function jornada_user($user_id){
        return $this::where('user_id', $user_id)
         ->orderByDesc('fecha_inicio', 'hora_inicio')
         ->get();

    }

    public function jornada_actual($user_id, $fecha_inicio){
        return $this::where('user_id', $user_id)
         ->where('fecha_inicio', $fecha_inicio)
         ->orderByDesc('fecha_inicio', 'hora_inicio')
         ->get();

    }

    public static function total_jornada(){
        return JornadaLaboral::count();
    }

    public static function total_horas(){
        $total_horas = JornadaLaboral::select(DB::raw('SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(hora_fin, hora_inicio)))) as tiempo_transcurrido'))->get();
        return $total_horas[0]['tiempo_transcurrido'];
    }

    
}
