@extends('layouts.default')

@section('content')

    <div class="container">
        <div id="data-agenda" class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading text-center title">AGREGAR CITA</div>
                    <div class="panel-body">
                        <form id="cita-form" class="form-horizontal">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label for="nombres" class="col-md-1 col-md-offset-1 control-label">Paciente</label>
                                <div id="paciente-length" class="col-md-4 col-xs-12">
                                    <input type="text" class="form-control" id="paciente" name="paciente"
                                           placeholder="Paciente" disabled>
                                </div>
                                <div class="col-md-3 col-xs-12">
                                    <input type="text" class="form-control" id="celular" name="celular"
                                           placeholder="Celular" disabled>
                                </div>
                                <div class="col-md-1 col-xs-6 text-right">
                                    <button class="btn btn-success nuevoPaciente" data-toggle="modal"
                                            data-target="#nuevoPaciente" type="button">Nuevo
                                    </button>
                                </div>
                                <div class="col-md-1 col-xs-6 text-left">
                                    <button class="btn btn-warning buscarPaciente" data-toggle="modal"
                                            data-target="#buscarPaciente" type="button">Buscar
                                    </button>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="tratamiento"
                                       class="col-md-1 col-md-offset-1 control-label">Tratamiento</label>
                                <div class="col-md-4">
                                    <input class="form-control" type="text" name="tratamiento" id="tratamiento"
                                           placeholder="Escribir Tratamiento">
                                </div>
                                <label for="doctor" class="col-md-1 control-label">Doctor</label>
                                <div class="col-md-4">
                                    <select class="form-control" name="doctor" id="doctor">
                                        <option value="-1">Seleccionar Doctor</option>
                                        @foreach( $doctores as $dc )
                                            <option value="{{ $dc->id }}" {{ Auth::user()->id == $dc->id ? 'selected="selected"' : '' }} >
                                                {{ $dc->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="nombres" class="col-md-1 col-md-offset-1 control-label">Día</label>
                                <div class="col-md-3">
                                    <input class="form-control" type="date" name="dia" id="dia" value="dd/mm/aaaa">
                                </div>

                                <label for="nombres" class="col-md-1 control-label">Desde</label>
                                <div class="col-md-2">
                                    <select class="form-control" name="desde" id="desde">
                                        <option value="-1">Hora</option>
                                        <?php
                                        $hora = 8;
                                        $horas = array('07:00:00', '07:30:00', '08:00:00', '08:30:00', '09:00:00', '09:30:00', '10:00:00', '10:30:00', '11:00:00', '11:30:00',
                                            '12:00:00', '12:30:00', '13:00:00', '13:30:00', '14:00:00', '14:30:00', '15:00:00', '15:30:00', '16:00:00', '16:30:00',
                                            '17:00:00', '17:30:00', '18:00:00', '18:30:00', '19:00:00', '19:30:00', '20:00:00', '20:30:00', '21:00:00', '21:30:00',
                                            '22:00:00', '22:30:00');
                                        for ($i = 0; $i < sizeof($horas); $i++) {
                                            echo '<option value="' . $horas[$i] . '">' . $horas[$i] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <label for="nombres" class="col-md-1 control-label">Hasta</label>
                                <div class="col-md-2">
                                    <select class="form-control" name="hasta" id="hasta">
                                        <option value="-1">Hora</option>
                                        <?php
                                        $hora = 8;
                                        $horas = array('07:00:00', '07:30:00', '08:00:00', '08:30:00', '09:00:00', '09:30:00', '10:00:00', '10:30:00', '11:00:00', '11:30:00',
                                            '12:00:00', '12:30:00', '13:00:00', '13:30:00', '14:00:00', '14:30:00', '15:00:00', '15:30:00', '16:00:00', '16:30:00',
                                            '17:00:00', '17:30:00', '18:00:00', '18:30:00', '19:00:00', '19:30:00', '20:00:00', '20:30:00', '21:00:00', '21:30:00',
                                            '22:00:00', '22:30:00');
                                        for ($i = 0; $i < sizeof($horas); $i++) {
                                            echo '<option value="' . $horas[$i] . '">' . $horas[$i] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>


                            </div>
                            <div class="form-group">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn-core">
                                        Agregar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="calendar-agenda" class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading text-center title">CITAS</div>
                    <div class="panel-body">

                        <div class="form-group">
                            <label for="doctor" class="col-md-1 col-md-offset-2 control-label"
                                   style="padding-top: 5px;">Doctor</label>
                            <div class="col-md-7">
                                <select class="form-control" name="doctor" id="selectDoctor">
                                    <option value="0">Seleccionar Doctor</option>
                                    @foreach( $doctores as $dc )
                                        <option value="{{ $dc->id }}" {{ Auth::user()->id == $dc->id ? 'selected="selected"' : '' }} >
                                            {{ $dc->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-md-offset-2 col-xs-12" style="margin-top: 45px;">
                                <div id="calendar"></div>
                            </div>
                        </div>
                        <div class="text-center" style="display:block; padding-top: 18px; padding-bottom: 18px;">
                            <button id="imprimir-agenda" class="btn-core">Imprimir</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="nuevoPaciente" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-center"><b>NUEVO PACIENTE</b></h4>
                </div>
                <div class="modal-body text-center" style="margin-top: 45px;">

                    <form id="nuevoPacienteForm" class="form-horizontal" method="post">
                        <div class="form-group">
                            <label for="" class="col-md-2 col-md-offset-1 control-label">Nombre:</label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" name="nombrePaciente" id="nombrePaciente"
                                       placeholder="Nombre de Paciente">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-md-2 col-md-offset-1 control-label">Celular:</label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" name="celularPaciente" id="celularPaciente"
                                       placeholder="Celular de Paciente">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">
                                    Aceptar
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer text-center" style="width: 100%;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>

        </div>
    </div>

    <div id="buscarPaciente" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-center"><b>BUSCAR PACIENTE</b></h4>
                </div>
                <div class="row" style="margin-top: 15px;">
                    <div class="col-md-10 col-md-offset-1"> <!-- Buscar Paciente -->
                        <input type="text" class="form-control" id="buscar-paciente" onkeyup="buscarPaciente()"
                               placeholder=" Buscar por Nombres">
                    </div>
                </div>
                <div class="modal-body">
                    <div id="table-wrapper">
                        <div id="table-scroll" style="height: 50vh;">
                            <table id="tablaClte" class="table table-responsive table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Nombres</th>
                                    <th class="text-center">Celular</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 0; ?>
                                @foreach( $data as $row )
                                    <tr>
                                        <td scope="row" class="text-center">{{ $row->id }}</td>
                                        <td class="text-center">{{ $row->nombres }} {{ $row->apellidos }}</td>
                                        <td class="text-center">{{ $row->celular }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-xs btn-info"
                                                    onclick="agregarACitaPaciente('{{ $row->nombres }} {{ $row->apellidos }}', '{{ $row->celular }}')">
                                                Aceptar
                                            </button>
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="modal-footer text-center" style="width: 100%;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>

        </div>
    </div>

@endsection
<script src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript">
    var agendas = <?php echo json_encode($agendas); ?>;
</script>
<script src="{{ asset('js/printThis.js?v=1.0.0') }}"></script>
<script src="{{ asset('js/citas.js?v=1.0.5') }}"></script>
<script>
    function buscarPaciente() {
        var input, filter, table, tr, td, i;
        input = document.getElementById("buscar-paciente");
        filter = input.value.toUpperCase();
        table = document.getElementById("tablaClte");
        tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    $(document).ready(function(){
        $('#imprimir-agenda').click(function(){
            var doctor = $('#selectDoctor option:selected').text();
            var moment = $('#calendar').fullCalendar('getDate');
            $('#calendar .fc-view-container').printThis({
               importCSS: false,
               loadCSS: "http://localhost/core_v2/css/print.css?v=1.0.3",
               header: "<strong>Doctor: </strong><div class='title'>" + doctor + "</div><br><strong>Fecha: </strong><div class='fecha'>" + moment.format() + "</div><hr>"
            });
        });
    });

    function imprimirAgenda() {
        window.print();
    }
</script>
