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

<x-adminlte-card title="Crear Tareas por Grupos">
    <div class="card-body">
        <form method="POST" action="{{ route('tareasgrupo.store') }}">
            @csrf
            <div class="row">
            <label>Tarea</label>
                    <textarea autofocus class="form-control" id="tarea" name="tarea" rows="2" placeholder="Descripción de la Tarea ..."
                        maxlength="255">{{ old('tarea') }}</textarea>

                    @error('tarea')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

            </div>

            <div>

                @php
                $config = [
                "placeholder" => "Selecciones los días ...",
                "allowClear" => true,
                ];
                @endphp
                <x-adminlte-select2 id="dias" name="dias[]" label="Días"  igroup-size="sm" :config="$config" required multiple>
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-red">
                            <i class="fas fa-tag"></i>
                        </div>
                    </x-slot>
                    <x-slot name="appendSlot">
                        <x-adminlte-button theme="outline-dark" label="Clear" icon="fas fa-lg fa-ban text-danger" />
                    </x-slot>
                    @forelse($dias as $dia)
                    <option value="{{$dia['name_en']}}">{{$dia['name']}}</option>
                    @empty
                    <option value=0>Sin días</option>
                    @endforelse
                </x-adminlte-select2>
            </div>

            <div class="row">
                @php
                $config = [
                'format' => 'YYYY-MM-DD',
                'dayViewHeaderFormat' => 'MMM YYYY',
                'minDate' => "js:moment().startOf('month')",
                ];
                @endphp
                <x-adminlte-input-date name="fecha_inicio" label="Fecha Inicio" igroup-size="sm" :value="old('fecha_inicio')" :config="$config" placeholder="Fecha inicio" required>
                    <x-slot name="appendSlot">
                        <div class="input-group-text bg-dark">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input-date>
            </div>
            <div class="row">
                <x-adminlte-input-date name="fecha_fin" label="Fecha Fin" igroup-size="sm" :value="old('fecha_fin')" :config="$config" placeholder="Fecha fin" required>
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
            <div>
                <x-adminlte-select2 name="cliente_id" label="Cliente">
                    @forelse($clientes as $cliente)
                    <option value={{$cliente->id}}>{{$cliente->name}}</option>
                    @empty
                    <option value=0>Sin Clientes</option>
                    @endforelse
                </x-adminlte-select2>
            </div>
            <div>
                {{-- With multiple slots, and plugin config parameter --}}
                @php
                $config = [
                "placeholder" => "Selecciones los Empleados ...",
                "allowClear" => true,
                ];
                @endphp
                <x-adminlte-select2 id="user_id" name="user_id[]" label="Empleados" label-class="text-danger" igroup-size="sm" :config="$config" multiple required>
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-red">
                            <i class="fas fa-tag"></i>
                        </div>
                    </x-slot>
                    <x-slot name="appendSlot">
                        <x-adminlte-button theme="outline-dark" label="Clear" icon="fas fa-lg fa-ban text-danger" />
                    </x-slot>
                    @forelse($empleados as $empleado)
                    <option value="{{$empleado->id}}">{{$empleado->name}}</option>
                    @empty
                    <option value=0>Sin Empleados</option>
                    @endforelse
                </x-adminlte-select2>
            </div>

            <div class="row">
                <x-adminlte-button class="btn-flat mr-3" type="submit" label="Guardar" theme="primary" icon="fas fa-lg fa-save" />
                <a href="{{ route('tareas.index') }} "> <x-adminlte-button class="btn-flat" type="button" label="Volver" theme="success" icon="fas fa-tasks" /> </a>
            </div>
        </form>
    </div>

</x-adminlte-card>

@stop
