@extends('adminlte::page')

@section('title', 'Horas Trabajadas')

@section('content_header')
@stop

@if (Session::has('info'))
<div class="alert alert-success" role="alert">
    {{ Session::get('info') }}
</div>
@endif
@if (Session::has('danger'))
<div class="alert alert-danger" role="alert">
    {{ Session::get('danger') }}
</div>
@endif

@section('content')
<x-adminlte-card title="Relación Horas Trabajador en el Mes">
    <div class="card-body">
        <x-adminlte-datatable id="tiempo_transcurrido" :heads="$heads" striped head-theme="dark" with-buttons>
            @forelse ($tiempo_transcurrido as $horas)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $horas->user->name }}</td>
                <td class="text-center">{{ $horas->fecha_inicio }}</td>
                <td>{{ $horas->hora_inicio }}</td>
                <td>{{ $horas->hora_fin }}</td>
                <td>{{ $horas->horas_transcurridas }} : {{ $horas->minutos_transcurridos}}</td>
                <td>{{ $horas->tarea->cliente->name}}</td>
                <td>{{ $horas->tarea->tarea}}</td>
                <td>{{ $horas->observacion}}</td>
                @if (auth()->user()->is_admin)
                <td>
                    <div class="btn-group">
                        <div class="mr-1 ml-1">
                            <a href="{{ route('jornada_laborals_fron.edit',$horas) }}" title="Editar" class="btn btn-primary btn-sm"> <i class="fas fa-pencil-alt"></i></a>
                        </div>
                    </div>
                </td>
                @endif
            </tr>
      
            @empty
            <tr>
                <td colspan="6">No hay registros </td>
            </tr>
            @endforelse
        </x-adminlte-datatable>
    </div>
</x-adminlte-card>

@stop