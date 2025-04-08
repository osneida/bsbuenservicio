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
                <a class="btn btn-primary btn-ms float-right mr-3 mb-2" href="{{ route('tareas.create') }}">Nueva Tarea</a>
                <a class="btn btn-primary btn-ms float-right mr-3 mb-2" href="{{ route('tareasgrupo.create') }}">Nuevo Grupo
                    de
                    Tareas</a>

                <form class="float-right mr-3" method="GET" action="{{ route('tareas.indexhtml') }}" id="filterForm">
                    <input type="hidden" name="empleado" value="{{ request('empleado', 'todas') }}">
                    <input type="hidden" name="perPage" value="{{ request('perPage', 10) }}">
                    <input type="hidden" name="cliente" value="{{ request('cliente', 'todas') }}">

                    <label for="estatus" class="mr-2">Estatus:</label>
                    <select name="estatus" id="estatus" onchange="document.getElementById('filterForm').submit();">
                        <option value="pendiente" {{ request('estatus') == 'pendiente' ? 'selected' : '' }}>Pendiente
                        </option>
                        <option value="iniciada" {{ request('estatus') == 'iniciada' ? 'selected' : '' }}>Iniciada</option>
                        <option value="finalizada" {{ request('estatus') == 'finalizada' ? 'selected' : '' }}>Finalizada
                        </option>
                        <option value="todas" {{ request('estatus') == 'todas' ? 'selected' : '' }}>Todas</option>
                    </select>
                </form>

                {{-- Filtro de empleado --}}
                <form class="float-right mr-3" method="GET" action="{{ route('tareas.indexhtml') }}"
                    id="filterFormempleado">
                    <input type="hidden" name="estatus" value="{{ request('estatus', 'todas') }}">
                    <input type="hidden" name="perPage" value="{{ request('perPage', 10) }}">
                    <input type="hidden" name="cliente" value="{{ request('cliente', 'todas') }}">

                    <label for="empleado" class="mr-2">Empleado:</label>
                    <select name="empleado" id="empleado"
                        onchange="document.getElementById('filterFormempleado').submit();">
                        @forelse ($empleados as $user)
                            <option value="{{ $user->id }}" {{ request('empleado') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @empty
                            <option value="">No hay registros</option>
                        @endforelse
                        <option value="todas" {{ request('empleado') == 'todas' ? 'selected' : '' }}>Todos</option>
                    </select>
                </form>
                {{-- Filtro de clientes --}}
                <form class="float-right mr-3" method="GET" action="{{ route('tareas.indexhtml') }}"
                    id="filterFormcliente">
                    <input type="hidden" name="estatus" value="{{ request('estatus', 'todas') }}">
                    <input type="hidden" name="perPage" value="{{ request('perPage', 10) }}">
                    <input type="hidden" name="empleado" value="{{ request('empleado', 'todas') }}">

                    <label for="cliente" class="mr-2">Filtrar por Cliente:</label>
                    <select name="cliente" id="cliente" onchange="document.getElementById('filterFormcliente').submit();">
                        @forelse ($clientes as $cliente)
                            <option value="{{ $cliente->id }}"
                                {{ request('cliente') == $cliente->id ? 'selected' : '' }}>
                                {{ $cliente->name }}
                            </option>
                        @empty
                            <option value="">No hay registros</option>
                        @endforelse
                        <option value="todas" {{ request('cliente') == 'todas' ? 'selected' : '' }}>Todos</option>
                    </select>
                </form>

                {{-- Filtro de registros por página --}}
                <form class="float-left mr-3 mb-2" method="GET" action="{{ route('tareas.indexhtml') }}">
                    <input type="hidden" name="estatus" value="{{ request('estatus', 'todas') }}">
                    <input type="hidden" name="empleado" value="{{ request('empleado', 'todas') }}">
                    <input type="hidden" name="cliente" value="{{ request('cliente', 'todas') }}">

                    <label for="perPage" class="mr-2">Registros por página:</label>
                    <select name="perPage" id="perPage" onchange="this.form.submit()">
                        <option value="5" {{ request('perPage') == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('perPage') == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </form>
            @endif

            <div class="card-body">

                <table class="table table-hover" style="table-layout: fixed; width: 100%;">
                    <thead>
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th style="width: 47%;">Tarea</th> <!-- Ancho fijo para la columna Tarea -->
                            <th style="width: 12%;">Estatus</th>
                            <th style="width: 10%;">Fecha</th>
                            <th style="width: 10%;">Horas</th>
                            <th style="width: 15%;">Empleado</th>
                            <th style="width: 15%;">Cliente</th>
                            <th style="width: 15%;">Acciones</th>

                        </tr>
                    </thead>
                    <tbody>
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

                    </tbody>
                </table>


            </div>
            <div class="mt-5 form-group">
                <span class="float-left">
                    {{ $tareas->count() }} <label>de</label> {{ $tareas->total() }} <label>total tareas</label>
                </span>
                <span class="float-right">
                    {{ $tareas->links('pagination::bootstrap-4') }}
                </span>
            </div>
        </div>
    </x-adminlte-card>
@stop
