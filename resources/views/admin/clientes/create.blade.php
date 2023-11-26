@extends('adminlte::page')

@section('title', 'Crear Cliente')

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

<x-adminlte-card title="Crear Cliente">
    <div class="card-body">
        <form method="POST" action="{{ route('clientes.store') }}">
            @csrf
            <div class="row">
                <x-adminlte-input id="name" name="name" label="Nombre" error-key="name" placeholder="Nombre del Empleado" fgroup-class="col-md-6"  :value="old('name')" required autofocus autocomplete="name" />
            </div>
            <div class="row">
                <x-adminlte-input id="address" name="address" label="Dirección" error-key="address" placeholder="Dirección" fgroup-class="col-md-6"  :value="old('address')"  autocomplete="address" />
            </div>
            <div class="row">
                <x-adminlte-input id="cif" name="cif" label="CIF" error-key="cif" placeholder="CIF" fgroup-class="col-md-6"  :value="old('cif')" required  autocomplete="cif" />
            </div>
            <div class="row">
                <x-adminlte-input name="mail" type="email" label="Correo/Email" placeholder="mail@example.com" fgroup-class="col-md-6"  :value="old('mail')"  autocomplete="username" />
            </div>
            <div class="row">
                <x-adminlte-input name="phone" type="phone" label="Teléfono" placeholder="phone" fgroup-class="col-md-6"  :value="old('phone')"  autocomplete="phone" />
            </div>
            <div class="row">
                <x-adminlte-button class="btn-flat mr-4" type="submit" label="Guardar" theme="primary" icon="fas fa-lg fa-save"  />
                <a href="{{ route('clientes') }} " > <x-adminlte-button  class="btn-flat" type="button" label="Volver" theme="success"  icon="fas fa-walking" /> </a> 
            </div>
        </form>
    </div>

</x-adminlte-card>

@stop