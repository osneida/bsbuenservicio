<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TareasExport implements FromCollection, WithHeadings
{

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tarea',
            'Estatus',
            'Fecha',
            'Horas',
            'Empleado',
            'Cliente',
        ];
    }
}
