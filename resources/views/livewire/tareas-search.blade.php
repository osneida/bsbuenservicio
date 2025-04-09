{{-- filepath: resources/views/livewire/tareas-search.blade.php --}}
<div>
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
    <div class="form-group d-flex align-items-center">
        <input type="search" class="form-control mr-3" wire:model.live="search" placeholder="buscar ..."
            style="flex-grow: 1;">
        <a class="btn btn-primary btn-ms mr-2" href="{{ route('tareasgrupo.create') }}">Nuevo Grupo de Tareas</a>
        <a class="btn btn-primary btn-ms" href="{{ route('tareas.create') }}">Nueva Tarea</a>

    </div>

    <div class="form-group d-flex justify-content-between">
        <select wire:model.live="estatus" class="form-control w-28 mr-2">
            <option value="todas">Todos los estatus</option>
            <option value="pendiente">Pendiente</option>
            <option value="iniciada">Iniciada</option>
            <option value="finalizada">Finalizada</option>
        </select>

        <select wire:model.live="empleado" class="form-control w-28 mr-2">
            <option value="todas">Todos los empleados</option>
            @foreach ($empleados as $empleado)
                <option value="{{ $empleado->id }}">{{ $empleado->name }}</option>
            @endforeach
        </select>

        <select wire:model.live="cliente" class="form-control w-28 mr-2">
            <option value="todas">Todos los clientes</option>
            @foreach ($clientes as $cliente)
                <option value="{{ $cliente->id }}">{{ $cliente->name }}</option>
            @endforeach
        </select>

        <select wire:model.live="perPage" class="form-control w-10 " <option value="5">5 por página</option>
            <option value="10">10 por página</option>
            <option value="25">25 por página</option>
            <option value="50">50 por página</option>
        </select>
    </div>

    <table class="table table-hover"  style="table-layout: fixed; width: 100%;">
        <thead class="thead-dark">
            <tr>
                <th style="width: 5%;">
                <a href="#" wire:click.prevent="sortBy('id')">
                        #
                        @if ($sortField === 'id')
                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                        @endif
                    </a>
                    </th>
                <th style="width: 31%;"> <a href="#" wire:click.prevent="sortBy('tarea')">
                        Tarea
                        @if ($sortField === 'tarea')
                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                        @endif
                    </a></th> <!-- Ancho fijo para la columna Tarea -->
                <th style="width: 8%;"> <a href="#" wire:click.prevent="sortBy('estatus')">
                        Estatus
                        @if ($sortField === 'estatus')
                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                        @endif
                    </a></th>
                <th style="width: 8%;"> <a href="#" wire:click.prevent="sortBy('fecha')">
                        Fecha
                        @if ($sortField === 'fecha')
                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                        @endif
                    </a></th>
                <th style="width: 8%;"><a href="#" wire:click.prevent="sortBy('horas')">
                        Horas
                        @if ($sortField === 'horas')
                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                        @endif
                    </a></th>
                <th style="width: 15%;"><a href="#" wire:click.prevent="sortBy('user_id')">
                        Empleado
                        @if ($sortField === 'user_id')
                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                        @endif
                    </a></th>
                <th style="width: 15%;"> <a href="#" wire:click.prevent="sortBy('cliente_id')">
                        Cliente
                        @if ($sortField === 'cliente_id')
                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                        @endif
                    </a></th>
                <th style="width: 10%;">Acciones</th>
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
                    <td>{{ $tarea->user->name ?? 'Sin Asignar' }}</td>
                    <td>{{ $tarea->cliente->name ?? 'Sin Asignar' }}</td>
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
                    <td colspan="8">No hay registros</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-2 form-group d-flex justify-content-between align-items-center">
        <span class="float-left">
            {{ $tareas->count() }} <label>de</label> {{ $tareas->total() }} <label>total tareas</label>
        </span>
        <span class="float-right">
            {!! $tareas->links() !!}
        </span>
    </div>
</div>
