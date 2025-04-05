<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\JornadaLaboral;
use App\Models\Cliente;
use App\Models\User;

class Tarea extends Model
{
    use HasFactory;

    protected $fillable = ['tarea', 'estatus', 'fecha', 'user_id', 'cliente_id','horas'];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function jornada(): HasMany
    {
        return $this->hasMany(JornadaLaboral::class);
    }
}
