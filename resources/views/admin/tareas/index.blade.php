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
            @if ($is_admin)
                <!-- Filtro de estatus -->
                <form method="GET" action="{{ route('tareas.index') }}" class="form-inline mb-3" id="filterForm">
                    <label for="estatus" class="mr-2">Filtrar por estatus:</label>
                    <select name="estatus" id="estatus" class="form-control mr-2"
                        onchange="document.getElementById('filterForm').submit();">
                        <option value="pendiente" {{ $estatus == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="iniciada" {{ $estatus == 'iniciada' ? 'selected' : '' }}>Iniciada</option>
                        <option value="finalizada" {{ $estatus == 'finalizada' ? 'selected' : '' }}>Finalizada</option>
                        <option value="" {{ $estatus == '' ? 'selected' : '' }}>Todas</option>
                    </select>
                </form>

                </form>
                <a class="btn btn-primary btn-ms float-right mr-3" href="{{ route('tareas.create') }}">Nueva Tarea</a>
                <a class="btn btn-primary btn-ms float-right mr-3" href="{{ route('tareasgrupo.create') }}">Nuevo Grupo
                    de
                    Tareas</a>
            @endif

            <div class="card-body">
                <x-adminlte-datatable :serverSide=true, id="tarea" :heads="$heads" striped head-theme="dark" striped
                    hoverable with-buttons>
                    @forelse ($tareas as $tarea)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $tarea->tarea }}</td>
                            <td>{{ $tarea->estatus }}</td>
                            <td>{{ $tarea->fecha }}</td>
                            <td>{{ $tarea->horas }}</td>

                            @if ($tarea->user)
                                <td>{{ $tarea->user->name }}</td>
                            @else
                                <td>Sin Asignar </td>
                            @endif

                            @if ($tarea->cliente)
                                <td>{{ $tarea->cliente->name }}</td>
                            @else
                                <td>Sin Asignar </td>
                            @endif
                            <td>
                                @if ($is_admin)
                                    <div class="btn-group">
                                        <div class="mr-1 ml-1">
                                            <a href="{{ route('tareas.edit', $tarea) }}" title="Editar"
                                                class="btn btn-primary btn-sm"> <i class="fas fa-pencil-alt"></i></a>
                                        </div>
                                        <div class="mr-1 ml-1">
                                            <form action="{{ route('tareas.destroy', $tarea->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" title="Eliminar" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('¿Realmente desea borrar la tarea:  {{ $tarea->tarea }} ?') "><i
                                                        class="far fa-trash-alt"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            </td>
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
