<div>
    <x-adminlte-card title="Listado de Clientes">
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

            <div class="form-group row">   
            <div class="col-sm-6">        </div>
            <div class="col-sm-3">
            
                <input type="search" class="form-control form-control-sm float-start" wire:model.live="search" placeholder="buscar ..." class="mb-2">
            </div>
            <div class="col-sm-3">
            <a class="btn btn-primary btn-ms float-right" href="{{ route('clientes.create') }}">Nuevo Cliente</a>
            </div>
            </div>
        </div>
        <div class="card-body">
       
            
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Dirección</th>
                        <th scope="col">CIF</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Teléfono</th>
                        <th scope="col">Estatus</th>
                        <th scope="col" width="20%">Acciones</th> <!--//width="20%" -->


                    </tr>
                </thead>
                <tbody>
                    @forelse ($clientes as $cliente)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $cliente->name }}</td>
                        <td>{{ $cliente->address }}</td>
                        <td>{{ $cliente->cif }}</td>
                        <td>{{ $cliente->mail }}</td>
                        <td>{{ $cliente->phone }}</td>
                        <td>
                            <input wire:click="status({{$cliente->id}})" type="checkbox" @if ($cliente->estatus) @checked(true) title = "Activo" @else title = "Inactivo" @endif>
                        </td>
                        <td>
                            <a href="{{ route('clientes.edit',$cliente) }}" type="button" title="Editar" class="btn btn-primary btn-sm">
                                <i class="fas fa-pencil-alt"></i></a>
                            <button wire:click="delete({{ $cliente->id }})" type="button" onclick="confirm('¿Está seguro que desea eliminar permanentemente el cliente: {{$cliente->name}} ?') || event.stopImmediatePropagation()" title="Eliminar Permanente" class="btn btn-danger btn-sm">
                                <i class="far fa-trash-alt"></i></button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">No hay Clientes registrados </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </x-adminlte-card>
</div>