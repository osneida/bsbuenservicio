<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClienteStoreRequest;
use App\Models\Cliente;
use Illuminate\Contracts\View\View;

class ClienteController extends Controller
{
    public function create(): View
    {
        return view('admin.clientes.create');
    }

    public function store(ClienteStoreRequest $request)
    {
        $cliente = Cliente::create($request->all());
        return redirect()->route('clientes.index')->with('info', 'Cliente creado con éxito');
    }
}
