@extends('adminlte::page')

@section('title', 'Listado de Tareas')

@section('content')
    <x-adminlte-card title="Tareas">
        <livewire:tareas-search  />
    </x-adminlte-card>
@stop

