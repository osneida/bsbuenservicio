@extends('adminlte::page')

@section('title', 'Crear Rol')

@section('content_header')
    <h1>Crear Rol</h1>
@stop

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Rol y sus Permisos</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{route('admin.roles.store')}}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="input-group mb-3">
                                    <input type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name') }}" placeholder="Ingrese el Nombre del Rol" autofocus>

                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                        </div>
                                    </div>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <h2 class="h3">Lista de Permisos</h2>
                                @foreach ($permissions as $permission)
                                    <div class="form-check">
                                        <label>
                                            <input type="checkbox" class="form-check-input" name="permissions[]" value="{{$permission->id}}">
                                            {{$permission->description}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <a href="{{ route('admin.roles.index') }}" title="Cancelar" class="btn btn-secondary"> Cancelar</a>
                            </div>
                        </form>
                    </div>

                </div>
            </div><!-- /.container-fluid -->
    </section>
@stop
