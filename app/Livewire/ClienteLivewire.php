<?php

namespace App\Livewire;

use App\Models\Cliente;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class ClienteLivewire extends Component
{
    public $clientes;
  
    public function status(Cliente $cliente)
    {
        $cliente->update(['estatus' => !$cliente->estatus]);
        session()->flash('info','Cliente Modificada correctamente');

    }
    public function delete(Cliente $cliente){
        $cliente->delete();
        session()->flash('danger','Cliente eliminada correctamente');
    }

    public function render()
    {
        $this->clientes = Cliente::OrderByDesc('estatus')->OrderBy('name')->get();
        return view('livewire.cliente-livewire');
    }
}
