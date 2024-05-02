@extends('adminlte::page')

@section('title', 'Listado de Tareas')

@section('content')
<x-adminlte-card title="Tareas">
    <div class="card-header">
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
        @if($is_admin)
        <a class="btn btn-primary btn-ms float-right" href="{{ route('tareas.create') }}">Nueva Tarea</a>
        @endif
    </div>
    <div class="card-body">
        <x-adminlte-datatable id="tarea" :heads="$heads" striped head-theme="dark" striped hoverable with-buttons>
            @forelse ($tareas as $tarea)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $tarea->tarea }}</td>
                <td>{{ $tarea->estatus }}</td>
                <td>{{ $tarea->fecha }}</td>
                <td>{{ $tarea->horas }}</td>

                @if($tarea->user)
                <td>{{ $tarea->user->name }}</td>
                @else
                <td>Sin Asignar </td>
                @endif

                @if($tarea->cliente)
                <td>{{ $tarea->cliente->name }}</td>
                @else
                <td>Sin Asignar </td>
                @endif
                
                @if($is_admin)
                <td>
                    <div class="btn-group">
                        <div class="mr-1 ml-1">
                            <a href="{{route('tareas.edit',$tarea)}}" title="Editar" class="btn btn-primary btn-sm"> <i class="fas fa-pencil-alt"></i></a>
                        </div>
                        <div class="mr-1 ml-1">
                            <form action="{{ route('tareas.destroy', $tarea->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Eliminar" class="btn btn-danger btn-sm" onclick="return confirm('¿Realmente desea borrar la tarea:  {{$tarea->tarea}} ?') "><i class="far fa-trash-alt"></i></button>
                            </form>
                        </div>
                    </div>
                </td>
                @endif
            </tr>
            @empty
            <tr>
                <td colspan="7">No hay registros </td>
            </tr>
            @endforelse
        </x-adminlte-datatable>
    </div>
</x-adminlte-card>
@stop