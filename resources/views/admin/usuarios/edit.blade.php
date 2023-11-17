@extends('adminlte::page')

@section('title', 'Editar Empleados')

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

<x-adminlte-card title="Editar Empleados">
    <div class="card-body">
        <form method="POST" action="{{ route('usuarios.update',$user) }}">
            @csrf
            @method('PUT')
            <div class="row">
                <x-adminlte-input id="name" name="name" label="Nombre" error-key="name" placeholder="Nombre del Empleado" fgroup-class="col-md-6"  :value="old('name',$user->name)" required autofocus autocomplete="name" />
            </div>
            <div class="row">
                <x-adminlte-input name="email" type="email" label="Correo/Email" placeholder="mail@example.com" fgroup-class="col-md-6"  :value="old('email',$user->email)" required autocomplete="username" />
            </div>
            <label>Editar Rol </label>
            <div class="row">
                @foreach ($roles as $rol)

                <div class="icheck-primary d-inline">
                    <label class="mr-2">
                        <input class="mr-2  @error('rol') is-invalid @enderror" type="radio" id="{{ $rol->name }}" value="{{ $rol->name }}" name="rol" @if ( $rol->name == $rol_actual) checked @endif >
                        {{ $rol->name }}
                    </label>
                </div>
                @endforeach
            </div>
            <div class="row">
                <x-adminlte-button class="btn-flat mr-3" type="submit" label="Modificar" theme="primary"  icon="fas fa-lg fa-save" />
             
               <a href="{{ route('usuarios.index') }} " > <x-adminlte-button  class="btn-flat" type="button" label="Volver" theme="success"  icon="fas fa-lg fa-restroom" /> </a> 
            </div>
        </form>
    </div>

</x-adminlte-card>

@stop