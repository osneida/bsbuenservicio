@extends('adminlte::page')

@section('title', 'Editar Jornada')

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

<x-adminlte-card title="Editar Jornada Laboral">
    <div class="card-body">
        <form method="POST" action="{{route('jornada_laborals_fron.update', $jornada_laboral->id)}}">
            @csrf
            @method('PUT')

            
            <div >
             <p>  <label> Empleado: {{ $jornada_laboral->user->name }}</label>  </p>
                  <label> Tarea:    {{ $jornada_laboral->tarea->tarea }}  </label>
                
            </div>
</br>
            <div class="row">
                @php
                $config = [
                'format' => 'YYYY-MM-DD',
                'dayViewHeaderFormat' => 'MMM YYYY',
                'minDate' => "js:moment().startOf('month')",
                ];
                @endphp
                <x-adminlte-input-date name="fecha_inicio" label="Fecha" igroup-size="sm" :config="$config" :value="old('fecha_inicio', $jornada_laboral->fecha_inicio)">
                    <x-slot name="appendSlot">
                        <div class="input-group-text bg-dark">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input-date>
            </div>
            <div class="row">
                <x-adminlte-input id="hora_inicio" name="hora_inicio" data-inputmask='"mask": "00:00:00"' data-mask label="Hora Inicio" error-key="hora_inicio" placeholder="00:00:00" fgroup-class="col-md-6" :value="old('hora_inicio', $jornada_laboral->hora_inicio)" required />
            </div>
            <div class="row">
                <x-adminlte-input id="hora_fin" name="hora_fin" data-inputmask='"mask": "00:00:00"' data-mask label="Hora Fin" error-key="hora_fin" placeholder="00:00:00" fgroup-class="col-md-6" :value="old('hora_fin',$jornada_laboral->hora_fin)" required />
            </div>

            <div class="row">
                <x-adminlte-button class="btn-flat mr-4" type="submit" label="Guardar" theme="primary" icon="fas fa-lg fa-save" />
                <a href="{{ route('jornada_laborals.store') }} "> <x-adminlte-button class="btn-flat" type="button" label="Volver" theme="success" icon="fas fa-walking" /> </a>
            </div>

            
        </form>
    </div>

</x-adminlte-card>

@stop

@section('js')
<script>
    $(function () {
        $('[data-mask]').inputmask();
    });
</script>
@endsection