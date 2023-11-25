<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClienteStoreRequest;
use App\Models\Cliente;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function create(): View
    {
        return view('admin.clientes.create');
    }

    public function store(ClienteStoreRequest $request)
    {
        $cliente = Cliente::create($request->all());
        return redirect()->route('clientes')->with('info', 'Cliente creado con éxito');
    }

    public function edit($id): View
    {
        $cliente  = Cliente::findOrFail($id);
        return view('admin.clientes.edit',compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        request()->validate([
            'name' => 'required|string|min:3|max:255',
            'mail' => 'nullable|email|unique:clientes,mail,'.$cliente->id,
            'cif'  =>  'nullable|unique:clientes,cif,'.$cliente->id,


        ]);
        
        $cliente->update($request->all());
        return redirect()->route('clientes')->with('info', 'Cliente Modificado con éxito');
    }


}
