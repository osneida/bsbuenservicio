@extends('adminlte::page')

@section('title', 'Editar Tareas')

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

    <x-adminlte-card title="Editar Tarea">
        <div class="card-body">
            <form method="POST" action="{{ route('tareas.update', $tarea) }}">
                @csrf
                @method('PUT')
                <div class="row">
                    <label>Tarea</label>
                    <textarea class="form-control" id="tarea" name="tarea" rows="2" placeholder="Descripción de la Tarea ..."
                        maxlength="255">{{ old('tarea', $tarea->tarea) }}</textarea>

                    @error('tarea')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row">
                    @php
                        $config = [
                            'format' => 'YYYY-MM-DD',
                            'dayViewHeaderFormat' => 'MMM YYYY',
                            'minDate' => "js:moment().startOf('month')",
                        ];
                    @endphp
                    <!-- 'maxDate' => "js:moment().endOf('month')", 'daysOfWeekDisabled' => [0, 6], -->
                    <x-adminlte-input-date name="fecha" label="Fecha Realización" igroup-size="sm" :config="$config"
                        :value="old('fecha', $tarea->fecha)">
                        <x-slot name="appendSlot">
                            <div class="input-group-text bg-dark">
                                <i class="fas fa-calendar-day"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input-date>
                </div>
                <div class="row">
                    <label>Horas</label>
                    <input type="number" id="horas" name="horas" error-key="horas"
                        value="{{ old('horas', $tarea->horas) }}" min="1" max="10" class="form-control">
                    @error('horas')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                </div>
                <div>
                    <x-adminlte-select2 name="cliente_id" label="Cliente">
                        @forelse($clientes as $cliente)
                            <option value={{ $cliente->id }} @if ($cliente->id == $tarea->cliente_id) selected @endif>
                                {{ $cliente->name }}</option>
                        @empty
                            <option value=0>Sin Clientes</option>
                        @endforelse
                    </x-adminlte-select2>
                </div>
                <div>

                    <x-adminlte-select2 name="user_id" label="Empleados">
                        <option value=0>Seleccione un Empleado</option>
                        @forelse($empleados as $empleado)
                            <option value={{ $empleado->id }} @if ($empleado->id == $tarea->user_id) selected @endif>
                                {{ $empleado->name }}</option>
                        @empty
                            <option value=0>Sin Empleados</option>
                        @endforelse
                    </x-adminlte-select2>
                </div>

                <div class="row">
                    <x-adminlte-button class="btn-flat mr-3" type="submit" label="Guardar" theme="primary"
                        icon="fas fa-lg fa-save" />
                    <a href="{{ route('tareas.index') }} "> <x-adminlte-button class="btn-flat" type="button"
                            label="Volver" theme="success" icon="fas fa-tasks" /> </a>
                </div>
            </form>
        </div>

    </x-adminlte-card>

@stop
