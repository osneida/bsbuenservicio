<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Tarea;

class Cliente extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'address', 'cif', 'mail', 'phone', 'estatus'];



    public static function total_clientes(){
        return Cliente::where('estatus',1)->count();
    }


    public function tareas(): HasMany
    {
        return $this->hasMany(Tarea::class);
    }
}
