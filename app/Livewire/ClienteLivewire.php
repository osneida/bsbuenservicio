<?php

namespace App\Livewire;

use App\Models\Cliente;
use Livewire\Component;

class ClienteLivewire extends Component
{
    public $clientes;
    public $search = '';
    public function status(Cliente $cliente)
    {
        $cliente->update(['estatus' => !$cliente->estatus]);
        session()->flash('info', 'Cliente Modificada correctamente');
    }
    public function delete(Cliente $cliente)
    {

        // Verificar si la tarea tiene registros en la tabla tareas
        if ($cliente->tareas()->exists()) {
            session()->flash('danger', 'Cliente No se puede eliminar porque tiene tareas asignadas.');
        }else{
            // Si no tiene registros, proceder a eliminar
            $cliente->delete();
            session()->flash('info', 'Cliente eliminado correctamente');
        }
    }

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function render()
    {
        $this->clientes = Cliente::orWhere('name', 'LIKE', '%' . $this->search . '%')
            ->orWhere('address', 'LIKE', '%' . $this->search . '%')
            ->orWhere('cif', 'LIKE', '%' . $this->search . '%')
            ->orWhere('mail', 'LIKE', '%' . $this->search . '%')
            ->orWhere('phone', 'LIKE', '%' . $this->search . '%')
            ->OrderByDesc('estatus')->OrderBy('name')->get();
        return view('livewire.cliente-livewire');
    }
}
