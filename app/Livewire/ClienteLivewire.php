<?php

namespace App\Livewire;

use App\Models\Cliente;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class ClienteLivewire extends Component
{
    public $clientes;
    public $search = '';
    public function status(Cliente $cliente)
    {
        $cliente->update(['estatus' => !$cliente->estatus]);
        session()->flash('info','Cliente Modificada correctamente');

    }
    public function delete(Cliente $cliente){
        $cliente->delete();
        session()->flash('danger','Cliente eliminada correctamente');
    }

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function render()
    {
        $this->clientes = Cliente::orWhere('name', 'LIKE', '%'.$this->search.'%')
                                   ->orWhere('address', 'LIKE', '%'.$this->search.'%')
                                   ->orWhere('cif', 'LIKE', '%'.$this->search.'%')
                                   ->orWhere('mail', 'LIKE', '%'.$this->search.'%')
                                   ->orWhere('phone', 'LIKE', '%'.$this->search.'%')
                                   ->OrderByDesc('estatus')->OrderBy('name')->get();
        return view('livewire.cliente-livewire');
    }

}

