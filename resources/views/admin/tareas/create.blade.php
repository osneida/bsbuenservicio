@extends('adminlte::page')

@section('title', 'Crear Tareas')

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

    <x-adminlte-card title="Crear Tareas">
        <div class="card-body">
            <form method="POST" action="{{ route('tareas.store') }}">
                @csrf
                <div class="row">
                    <label>Tarea</label>
                    <textarea class="form-control" id="tarea" name="tarea" rows="2" placeholder="Descripción de la Tarea ..."
                        maxlength="255">{{ old('tarea') }}</textarea>

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
                    <x-adminlte-input-date name="fecha" :value="old('fecha')" label="Fecha Realización" igroup-size="sm"
                        :config="$config">
                        <x-slot name="appendSlot">
                            <div class="input-group-text bg-dark">
                                <i class="fas fa-calendar-day"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input-date>
                </div>
                <div class="row">
                    <label>Horas</label>
                    <input type="number" id="horas" name="horas" error-key="horas" value="{{ old('horas',1) }}" min="1" max="10" class="form-control">
                     @error('horas')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                 <div class="row">
                    <x-adminlte-select2 name="cliente_id" label="Cliente" fgroup-class="col-md-10" >
                        @forelse($clientes as $cliente)
                            <option value={{ $cliente->id }}>{{ $cliente->name }}</option>
                        @empty
                            <option value=0>Sin Clientes</option>
                        @endforelse
                    </x-adminlte-select2>
                </div>
                <div class="row">
                    {{-- With multiple slots, and plugin config parameter --}}
                    @php
                        $config = [
                            'placeholder' => 'Selecciones los Empleados ...',
                            'allowClear' => true,
                        ];
                    @endphp
                    <x-adminlte-select2 fgroup-class="col-md-10" id="user_id" name="user_id[]" label="Empleados" label-class="text-danger"
                        igroup-size="sm" :config="$config" multiple>
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-gradient-red">
                                <i class="fas fa-tag"></i>
                            </div>
                        </x-slot>
                        <x-slot name="appendSlot">
                            <x-adminlte-button theme="outline-dark" label="Clear" icon="fas fa-lg fa-ban text-danger" />
                        </x-slot>
                        @forelse($empleados as $empleado)
                            <option value="{{ $empleado->id }}">{{ $empleado->name }}</option>
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
