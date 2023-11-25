<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'address', 'cif', 'mail', 'phone', 'estatus'];

    public static function total_clientes(){
        return Cliente::where('estatus',1)->count();
    }
}
