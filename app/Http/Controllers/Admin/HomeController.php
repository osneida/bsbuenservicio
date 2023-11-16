<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JornadaLaboral;
use App\Models\User;

class HomeController extends Controller
{
    public function index(){
        $hora_inicio='';
        $hora_fin = '';
        $id = '2';

        $total_jornadas = JornadaLaboral::total_jornada();
        $total_horas    = JornadaLaboral::total_horas();
        $total_usuarios = User::total_usuarios();
        
        return view('admin.index', compact('hora_inicio','hora_fin','id','total_jornadas','total_horas', 'total_usuarios'));
    }

    public function show()
    {
       return view('profile.show');
    }
}
