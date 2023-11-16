<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class RegisteredUserController extends Controller
{
    public function index(Request $request)
    {
        $heads = [
            'Nro',
            'Nombre',
            'Email',
            'Rol',
            ['label' => 'Acciones', 'no-export' => true, 'width' => 5],
        ];

        $users = User::select('id', 'name', 'email')->get();
        return view('admin.usuarios.index', compact('users', 'heads'));
    }

    public function create(): View
    {
        $roles = Role::select('id', 'name')->orderBy('name')->get();
        return view('admin.usuarios.create', compact('roles'));
    }

    public function store(UserRequest $request)
    {
        if (isset($request['password'])) {
            $request['password'] = Hash::make($request['password']);
        }

        if($request['rol']=='Admin'){
            $request['is_admin'] = 1;
        }

        //Log::info($request->all());

        $user = User::create($request->all());
        $user->assignRole($request['rol']);

        return redirect()->route('usuarios.index')->with('info', 'Empleado creado con éxito');
    }

    public function edit(User $user)
    {
        $roles = Role::select('id', 'name')->orderBy('name')->get();
        return view('admin.usuarios.edit', compact('user', 'roles'));
    }

    public function update(Request $request)
    {
  
    }

    public function show(string $id)
    {


        $user = '';
        return view('admin.usuarios.show', compact('user'));
    }

    public function destroy(string $id)
    {

        return redirect(route('admin.usuarios.index'))->with('danger', 'Usuario eliminado con éxito');
    }
}
