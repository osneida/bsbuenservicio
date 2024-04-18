<div>
 
    @forelse ( $tarea_hoy as $tarea )

    <div class="card card-purple">
        <div class="card-header">
            <h3 class="card-title"> Jornada Laboral</h3>
            <p style="text-align: right;"> @php date_default_timezone_set("Europe/Madrid");
                echo(date("d/m/y") ) @endphp </p>
            <h3 class="card-title"> {{ $tarea->tarea }}</h3>
            <p style="text-align: right;"> Cliente: {{ $tarea->cliente->name . " | " . $tarea->cliente->address }}</p>
        </div>

        <div class="card-body">
            <div class="container-fluid">
                <div class="btn-group">
                    <button wire:click="guardar_hora_inicio({{$tarea->id}}, {{$tarea->id}})" class="btn btn-primary col-lg-8 col-6" data-bs-toggle="button" {{ isset($enables_inicio[$tarea->id]) ? $enables_inicio[$tarea->id] : '' }}><i class="fas fa-hourglass-start"></i> Inicio <br> Actividad</button>
                    <button wire:click="guardar_hora_fin({{$tarea->id}}, {{$tarea->id}})" class="btn btn-danger  col-lg-8 col-6" style="margin-left:5px; " data-bs-toggle="button" {{ isset($enables_fin[$tarea->id]) ? $enables_fin[$tarea->id] : '' }}><i class="fas fa-hourglass-end"></i> Fin <br> Actividad</button>
                </div>
                <div class="btn-group">
                    <input type="text" name="hora_inicio_{{ $tarea->id }}" class="form-control" readonly size="10" style="margin-top: 2px;" value="{{ isset($horas_inicio[$tarea->id]) ? $horas_inicio[$tarea->id] : '' }}">

                    <!-- Input para la hora de fin -->
                    <input type="text" name="hora_fin_{{ $tarea->id }}" class="form-control" readonly size="10" style="margin-left:8px; margin-top: 2px;" value="{{ isset($horas_fin[$tarea->id]) ? $horas_fin[$tarea->id] : '' }}">

                </div>
            </div>
        </div>
    </div>
    @empty
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
    @endforelse
</div>