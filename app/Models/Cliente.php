<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = ['name', 'address', 'cif', 'mail', 'phone', 'estatus'];
    use HasFactory;
}
