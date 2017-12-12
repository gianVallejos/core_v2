@extends('layouts.default')

@section('content')

    <div class="container-fluid">
      <div class="row">

          <div class="col-md-12">
              <div class="panel panel-default">
                  <div class="panel-heading text-center title">
                    <div class="row container-big-arrow">
                        <div class="col-md-12">
                            GESTIONAR CITAS
                        </div>
                        <div class="container-arrow">
                          <button id="gestion-citas-down" class="btn-toggle" data-toggle="collapse" data-target="#gestion-citas">
                              <img src="{{ asset('images/icons/flecha-down.svg') }}" width="25">
                          </button>
                          <button id="gestion-citas-up" class="btn-toggle" style="display: none;">
                              <img src="{{ asset('images/icons/flecha-up.svg') }}" width="25">
                          </button>
                        </div>
                    </div>
                  </div>
                  <div id="gestion-citas" class="panel-body collapse">
                      <div id="table-wrapper">
                          <div id="table-scroll">
                              <table class="table table-responsive table-hover">
                                  <thead>
                                  <tr>
                                      <th class="text-center">#</th>
                                      <th class="text-center">HC</th>
                                      <th class="text-center">Paciente</th>
                                      <th class="text-center">Doctor</th>
                                      <th class="text-center">Tratamiento</th>
                                      <th class="text-center">Celular</th>
                                      <th class="text-center">Desde</th>
                                      <th class="text-center">Hasta</th>
                                      <th></th>
                                      <th></th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                  <?php $i = 1; ?>
                                  @foreach( $citas as $row )
                                      <tr>
                                          <th scope="row" class="text-center">{{ $i }}</th>
                                          <td class="text-center">@if( $row->hc == -1 ) nuevo  @else {{ $row->hc }} @endif</td>
                                          <td class="text-center">{{ $row->title }}</td>
                                          <td class="text-center">{{ $row->nombres }} {{ $row->apellidos }}</td>
                                          <td class="text-center">{{ $row->tratamiento }}</td>
                                          <td class="text-center">{{ $row->celular }}</td>
                                          <td class="text-center">{{ $row->desde }}</td>
                                          <td class="text-center">{{ $row->hasta }}</td>
                                          <td class="text-center">
                                              <button class="btn btn-xs btn-warning"
                                                      onclick="editarCita('{{ json_encode($row) }}')"
                                                      data-toggle="modal" data-target="#myModalEdit">Editar
                                              </button>
                                          </td>
                                          @if(Auth::user()->rolid == 1)
                                              <td class="text-center">
                                                  <form action="{{ route('agendas.destroy', $row->id) }}"
                                                        method="post">
                                                      <input type="hidden" name="_method" value="DELETE">
                                                      <input type="hidden" name="_token"
                                                             value="{{ csrf_token() }}">
                                                      <button type="submit" class="btn btn-xs btn-danger">
                                                          Eliminar
                                                      </button>
                                                  </form>
                                              </td>
                                          @endif
                                      </tr>
                                      <?php $i++; ?>
                                  @endforeach
                                  </tbody>
                              </table>
                          </div>
                      </div>
                  </div>
              </div>
          </div>

          <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading text-center title">AGREGAR CITA</div>
                <div class="panel-body">
                    <div class="row">
                      <div id="calendar-agenda" class="col-lg-7 col-md-8 col-xs-12">
                        <div class="form-group">
                            <label for="doctor" class="col-md-2 control-label"
                                   style="padding-top: 5px;">Doctor</label>
                            <div class="col-md-8">
                                <select class="form-control" name="doctor" id="selectDoctor">
                                    <option value="0">Seleccionar Doctor</option>
                                    @foreach( $doctores as $dc )
                                        <option value="{{ $dc->id }}" {{ Auth::user()->id == $dc->id ? 'selected="selected"' : '' }} >
                                            {{ $dc->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                              <button id="imprimir-agenda" class="btn-core">Imprimir</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-xs-12" style="margin-top: 45px;">
                                <div id="calendar"></div>
                            </div>
                        </div>
                      </div>
                      <div id="add-data-agenda" class="col-lg-5 col-md-4 col-xs-12">
                        <h3>Nueva Cita</h3>
                          <form id="cita-form" class="form-horizontal">
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">

                              <div class="row">

                                  <div class="col-md-12 col-xs-12">
                                    <label class="control-label">Paciente</label>
                                    <input type="text" class="form-control" id="paciente" name="paciente"
                                               placeholder="Paciente" disabled>
                                  </div>
                              </div>

                              <div class="row form-group">

                                <div id="group-hc-class" class="col-md-4">
                                    <label class="control-label">HC</label>
                                    <input type="text" class="form-control" id="hc" name="hc" placeholder="HC" disabled>
                                </div>
                                <div id="group-celular-class" class="col-md-8">
                                    <label class="control-label">Celular</label>
                                    <input type="text" class="form-control" id="celular" name="celular"
                                         placeholder="Celular" disabled>
                                </div>

                              </div>

                              <div class="row form-group">
                                  <div class="col-md-12 col-xs-12 text-center">
                                      <button class="btn btn-default nuevoPaciente" data-toggle="modal"
                                              data-target="#nuevoPaciente" type="button">Nuevo
                                      </button>
                                      <button class="btn btn-default buscarPaciente" data-toggle="modal"
                                              data-target="#buscarPaciente" type="button">Buscar
                                      </button>
                                  </div>
                              </div>

                              <div class="form-group">
                                  <label for="tratamiento" class="col-md-12 control-label">Tratamiento</label>
                                  <div class="col-md-12">
                                      <input class="form-control" type="text" name="tratamiento" id="tratamiento"
                                             placeholder="Escribir Tratamiento">
                                  </div>

                                  <label for="tratamiento" class="col-md-12 control-label">Médico</label>
                                  <div class="col-md-12">
                                      <select class="form-control" name="doctor" id="doctor">
                                          <option value="-1">Seleccionar Doctor</option>
                                          @foreach( $doctores as $dc )
                                              <option value="{{ $dc->id }}" {{ Auth::user()->id == $dc->id ? 'selected="selected"' : '' }} >
                                                  {{ $dc->name }}
                                              </option>
                                          @endforeach
                                      </select>
                                  </div>

                                  <label for="dia" class="col-md-12 control-label">Día</label>
                                  <div class="col-md-12">
                                      <input class="form-control" type="date" name="dia" id="dia" value="<?php echo date('Y-m-d'); ?>">
                                  </div>

                                  <label for="desde" class="col-md-12 control-label">Desde</label>
                                  <div class="col-md-12">
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

                                  <label for="hasta" class="col-md-12 control-label">Hasta</label>
                                  <div class="col-md-12">
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
                <div class="modal-body text-center" style="margin-top: 15px;">

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
                                    <th class="text-center">HC</th>
                                    <th class="text-center">Nombres</th>
                                    <th class="text-center">Celular</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1; ?>
                                @foreach( $data as $row )
                                    <tr>
                                        <td class="text-center">{{ $row->id }}</td>
                                        <td class="text-center">{{ $row->nombres }} {{ $row->apellidos }}</td>
                                        <td class="text-center">{{ $row->celular }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-xs btn-info"
                                                    onclick="agregarACitaPaciente('{{ $row->id }}', '{{ $row->nombres }} {{ $row->apellidos }}', '{{ $row->celular }}')">
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

    <!-- Modal Edit Cita -->
    <div id="myModalEdit" class="modal fade"  role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-center">
                        <strong>
                            <div id="title-txto"></div>
                        </strong>
                    </h4>
                </div>
                <div class="modal-body">

                    <form id="editar-cita" class="form-horizontal" name="edit">

                        <div class="form-group">
                            <input id="idAgenda" type="hidden" class="form-control" name="idAgenda">
                            <input id="hc-2" type="hidden" name="hc">

                            <label for="celular" class="col-md-2 col-xs-2 control-label">Paciente</label>
                            <div class="col-md-10 col-xs-10">
                                <input id="paciente-2" type="text" class="form-control" name="paciente" placeholder="Paciente" required autofocus>
                                @if ($errors->has('celular'))
                                    <span class="help-block">
                                      <strong>{{ $errors->first('celular')}}</strong>
                                  </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="celular" class="col-md-2 col-xs-2 control-label">Celular</label>
                            <div class="col-md-4 col-xs-8">
                                <input type="text" class="form-control" name="celular" placeholder="Celular" required
                                       autofocus>
                                @if ($errors->has('celular'))
                                    <span class="help-block">
                                      <strong>{{ $errors->first('celular')}}</strong>
                                  </span>
                                @endif

                            </div>
                            <label class="col-md-1 col-xs-2 control-label">Día</label>
                            <div class="col-md-4 col-xs-9">
                                <input type="date" class="form-control" name="dia" required autofocus>

                                @if ($errors->has('desde'))
                                    <span class="help-block">
                                      <strong>{{ $errors->first('desde')}}</strong>
                                  </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 col-xs-2 control-label">Desde</label>
                            <div class="col-md-4 col-xs-9">
                                <select class="form-control" name="desde" id="desde">
                                    <option value="-1" name="desde"></option>
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
                                @if ($errors->has('desde'))
                                    <span class="help-block">
                                      <strong>{{ $errors->first('desde')}}</strong>
                                  </span>
                                @endif
                            </div>

                            <label class="col-md-1 control-label">Hasta</label>
                            <div class="col-md-4 col-xs-9">
                                <select class="form-control" name="hasta" id="hasta">
                                    <option value="-1" name="hasta"></option>
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
                                @if ($errors->has('desde'))
                                    <span class="help-block">
                                      <strong>{{ $errors->first('desde')}}</strong>
                                  </span>
                                @endif
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="idDoctor" class="ccol-md-2 col-xs-2 control-label">Médico</label>
                            <div class="col-md-9 col-xs-9">
                                <select name="idDoctor" id="idDoctor" class="form-control">

                                    <?php           foreach($doctores as $doctor){                          ?>
                                    <option value="{{ $doctor->id }}" {{ $doctor->id == $doctor->id ? 'selected="selected"' : '' }} > {{ $doctor->name }}</option>
                                    <?php           }                                                 ?>
                                </select>
                            </div>

                        </div>

                        <div class="form-group">

                            <label id="tratamiento" for="tratamiento"
                                   class="col-md-2 col-xs-2 control-label">Tratamiento</label>
                            <div class="col-md-9 col-xs-9">
                                <input type="text" class="form-control" name="tratamiento" placeholder="Tratamiento"
                                       required
                                       autofocus>
                                @if ($errors->has('tratamiento'))
                                    <span class="help-block">
                                      <strong>{{ $errors->first('tratamiento')}}</strong>
                                  </span>
                                @endif

                            </div>
                        </div>

                    </form>

                </div>
                <div class="modal-footer">

                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button onclick="editarAgenda()" class="btn btn-core">Modificar</button>
                            <button type="button" class="btn btn-core" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
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
<script src="{{ asset('js/citas.js?v=1.0.10') }}"></script>
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
