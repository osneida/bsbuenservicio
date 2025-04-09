<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Tarea;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class TareasSearch extends Component
{
    use WithPagination;

    public $search = '';
    public $estatus = 'todas';
    public $empleado = 'todas';
    public $cliente = 'todas';
    public $perPage = 10;
    public $sortField = 'id'; // Campo por defecto para ordenar
    public $sortDirection = 'desc'; // Dirección por defecto

    protected $updatesQueryString = ['search', 'estatus', 'empleado', 'cliente', 'perPage', 'sortField', 'sortDirection'];

    public function sortBy($field)
    {
        if ($field === 'user_id') {
            $field = 'user_name'; // Campo relacionado para cliente
        } elseif ($field === 'cliente_id') {
            $field = 'cliente_name'; // Campo relacionado para empleado
        }

        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingEstatus($value)
    {
        $this->resetPage();
    }

    public function updatingEmpleado($value)
    {
        $this->resetPage();
    }

    public function updatingCliente($value)
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function render()
    {
        $user = auth()->user();
        $is_admin = $user->is_admin;
        $query2 = Tarea::select('id', 'tarea', 'estatus', 'fecha', 'horas', 'user_id', 'cliente_id')
            ->with('cliente:id,name')
            ->with('user:id,name');

        $query = Tarea::select('tareas.id', 'tareas.tarea', 'tareas.estatus', 'tareas.fecha', 'tareas.horas', 'tareas.user_id', 'tareas.cliente_id')
            ->join('clientes', 'tareas.cliente_id', '=', 'clientes.id') // Unir con la tabla clientes
            ->join('users', 'tareas.user_id', '=', 'users.id') // Unir con la tabla users
            ->addSelect('clientes.name as cliente_name', 'users.name as user_name') // Seleccionar los nombres relacionados
            ->with('cliente:id,name')
            ->with('user:id,name');


        if ($this->estatus !== 'todas') {
            $query->where('estatus', $this->estatus);
        }

        if ($this->empleado !== 'todas') {
            $query->where('user_id', $this->empleado);
        }

        if ($this->cliente !== 'todas') {
            $query->where('cliente_id', $this->cliente);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('tarea', 'like', '%' . $this->search . '%')
                    ->orWhere('fecha', 'like', '%' . $this->search . '%')
                    ->orWhereHas('user', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('cliente', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    });
            });
        }

        // $query->orderByDesc('id');
        // Aplicar ordenación
        $query->orderBy($this->sortField, $this->sortDirection);

        $tareas = $query->paginate($this->perPage);
        $empleados = User::select('id', 'name')->orderBy('name')->get();
        $clientes  = Cliente::select('id', 'name')->where('estatus', 1)->orderBy('name')->get();

        Log::info($query->toSql());
        Log::info($query->getBindings());


        return view('livewire.tareas-search', compact('tareas', 'empleados', 'clientes', 'is_admin'));
    }
}
