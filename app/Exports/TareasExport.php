<?php

namespace App\Exports;

use App\Models\Tarea;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TareasExport implements FromCollection, FromQuery, WithHeadings
{
    protected $estatus;
    protected $empleado;
    protected $cliente;
    protected $search;
    protected $query;


    public function __construct($estatus, $empleado, $cliente, $search)
    {
        $this->estatus = $estatus;
        $this->empleado = $empleado;
        $this->cliente = $cliente;
        $this->search = $search;
    }

    public function query()
    {
        $query = Tarea::select('tareas.id', 'tareas.tarea', 'tareas.estatus', 'tareas.fecha', 'tareas.horas', 'users.name as empleado', 'clientes.name as cliente')
            ->join('clientes', 'tareas.cliente_id', '=', 'clientes.id')
            ->join('users', 'tareas.user_id', '=', 'users.id');

        if ($this->estatus !== 'todas') {
            $query->where('tareas.estatus', $this->estatus);
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
                    ->orWhere('users.name', 'like', '%' . $this->search . '%')
                    ->orWhere('clientes.name', 'like', '%' . $this->search . '%');
            });
        }

        return $query;
    }

    public function headings(): array
    {
        return ['ID', 'Tarea', 'Estatus', 'Fecha', 'Horas', 'Empleado', 'Cliente'];
    }

    public function collection()
    {
        $query = $this->query();
        return $query->get();
    }
}
