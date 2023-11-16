@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')

@stop


@section('content')

<x-adminlte-card title="Roles">
    <div class="card-header">
    </div>
    <div class="card-body">
        <x-adminlte-datatable id="rol" :heads="$heads" striped head-theme="dark" striped hoverable with-buttons>
            @forelse ($roles as $rol)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $rol->name }}</td>
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

