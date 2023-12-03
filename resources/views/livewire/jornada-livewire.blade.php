<div>
    @if($tarea_hoy_count > 0)
    @foreach( $tarea_hoy as $tarea )
    <div class="card card-purple">
        <div class="card-header">
            <h3 class="card-title"> Jornada Laboral</h3><p style="text-align: right;"> @php date_default_timezone_set("Europe/Madrid");
                echo(date("d/m/y") ) @endphp </p>
            <h3 class="card-title"> {{ $tarea->tarea }}</h3>
                <p style="text-align: right;"> Cliente: {{ $tarea->cliente->name }} </p>
        </div>

        <div class="card-body">
            <div class="container-fluid">
                <div class="btn-group">
                    <button wire:click="guardar_hora_inicio({{$tarea->id}})" class="btn btn-primary col-lg-8 col-6" data-bs-toggle="button" {{$enable_inicio}}><i class="fas fa-hourglass-start"></i> Inicio <br> Actividad</button>
                    <button wire:click="guardar_hora_fin({{$tarea->id}})" class="btn btn-danger  col-lg-8 col-6" style="margin-left:5px; " data-bs-toggle="button" {{$enable_fin}}><i class="fas fa-hourglass-end"></i> Fin <br> Actividad</button>
                </div>
                <div class="btn-group">
                    <input type="text" name="hora_inicio" class="form-control" readonly size="10" style="margin-top: 2px;" value="{{ $hora_inicio }}">
                    <input type="text" name="hora_fin" class="form-control" readonly size="10" style="margin-left:8px; margin-top: 2px;" wire:model="hora_fin">
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @else
    <div class="card card-purple">
        <div class="card-header">
            <h3 class="card-title"> Sin Tarea para Hoy </h3>
            <p style="text-align: right;"> @php date_default_timezone_set("Europe/Madrid");
                echo(date("d/m/y") ) @endphp </p>
        </div>

        <div class="card-body">
            <div class="container-fluid">

            </div>
        </div>
    </div>
    @endif
</div>