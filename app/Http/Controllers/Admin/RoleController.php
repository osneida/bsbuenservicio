<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $heads = [
            'Nro',
            'Nombre'
        ];
        $roles = Role::select('id', 'name',)->get();
        return view('admin.roles.index', compact('roles', 'heads'));

    }
}

   