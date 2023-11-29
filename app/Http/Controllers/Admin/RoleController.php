<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $heads = [
            'Nro',
            'Nombre'
        ];

        $roles = Role::select('id', 'name',)->get();
        return view('admin.roles.index', compact('roles', 'heads'));

    }
}

   