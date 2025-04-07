<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\JornadaLaboral;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Tarea extends Model
{
    use HasFactory;

    protected $fillable = ['tarea', 'estatus', 'fecha', 'user_id', 'cliente_id', 'horas'];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function jornada(): HasOne
    {
        return $this->hasOne(JornadaLaboral::class);
    }

    public function jornada_sintarea()
    {
        return $this->hasOne(JornadaLaboral::class, 'tarea_id')->withDefault([
            'hora_inicio' => null,
            'hora_fin' => null,
            'tarea_id' => null,
        ]);
    }
}
