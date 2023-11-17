@extends('adminlte::page')

@section('title', 'Empleados')

@section('content_header')

@stop


@section('content')

<x-adminlte-card title="Empleados">
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
        <a class="btn btn-primary btn-ms float-right" href="{{ route('usuarios.create') }}">Nuevo Empleado</a>
    </div>
    <div class="card-body">
        <x-adminlte-datatable id="user" :heads="$heads" striped head-theme="dark" striped hoverable with-buttons>
            @forelse ($users as $user)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if(!empty($user->getRoleNames()))
                    @foreach($user->getRoleNames() as $v)
                    <label class="badge">{{ $v }}</label>
                    @endforeach
                    @endif
                </td>
             <!--   <td>
                    <input type="checkbox" name="estatus" id="" class="opcion_estatus">
                </td> -->
                <td>
                    <div class="btn-group">

                        <div class="mr-1 ml-1">
                            <a href="{{route('usuarios.edit',$user)}}" title="Editar" class="btn btn-primary btn-sm"> <i class="fas fa-pencil-alt"></i></a>
                        </div>

                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4">No hay registros </td>
            </tr>
            @endforelse
        </x-adminlte-datatable>
    </div>
</x-adminlte-card>
@stop