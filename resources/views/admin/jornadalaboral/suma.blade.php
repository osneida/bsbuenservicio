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

<x-adminlte-card title="Suma Horas Trabajador en el Mes">
    <div class="card-body">
        <x-adminlte-datatable id="suma" :heads="$heads" striped head-theme="dark"  striped hoverable with-buttons>
            @forelse ($tiempo_transcurrido as $horas)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $horas->mes }}</td>
                <td>{{ $horas->user->name }}</td>
                <td>{{ $horas->tiempo_transcurrido }}</td>
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