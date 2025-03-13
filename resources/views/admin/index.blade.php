@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1> <b>B & S</b> Buen Servicio</h1>
@stop

@section('content')
<section class="content">
    @if (auth()->user()->is_admin)
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="row text-center">
                        <div class="col-lg-4 col-4">
                            <h3> </h3>
                            <p> Horas Realizadas </p>
                        </div>
                        <div class="col-lg-8 col-8 mt-2">
                            <p> <b> {{$total_horas}} </b> <br>
                        </div>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ route('jornada_laborals.suma') }}" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="row text-center">
                        <div class="col-lg-8 col-8">
                            <h3> </h3>
                            <p>Jornadas Realizadas</p>
                        </div>
                        <div class="col-lg-4 col-4 mt-2">
                            <p> <b> {{$total_jornadas}} </b> <br>
                        </div>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ route('jornada_laborals.horastrabajadas') }}" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <div class="small-box" style="background-color: #7a57af; color:white">
                    <div class="row text-center">
                        <div class="col-lg-4 col-4">
                            <h3> </h3>
                            <p> Empleados Activos </p>
                        </div>
                        <div class="col-lg-8 col-8 mt-2">

                            <p> <b>{{$total_usuarios}} </b> <br>
                        </div>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ route('usuarios.index') }}" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>

                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box" style="background-color:orange; color:white">
                    <div class="row text-center">
                        <div class="col-lg-4 col-4">
                            <h3></h3>
                            <p> Clientes Activos </p>
                        </div>
                        <div class="col-lg-8 col-8 mt-2">
                            <p> <b> {{$total_clientes}} </b> <br>
                        </div>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ route('clientes') }}" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>

                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->

    </div><!-- /.container-fluid -->
    @endif

    <section class="col-lg-4 connectedSortable">
        <livewire:jornada-livewire />
    </section>

    <section class="col-lg-8 connectedSortable">
    </section>
</section>
@stop

@section('css')

@stop

@section('js')


@stop
