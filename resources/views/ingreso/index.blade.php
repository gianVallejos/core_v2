@extends('layouts.default')

@section('content')

    <div class="container-fluid">
        <div class="row">

            <div class="col-md-10 col-md-offset-1">

                <div class="panel panel-default">
                    <div class="panel-heading text-center title">AGREGAR INGRESO</div>
                    <div class="panel-body">

                        <form class="form-horizontal" action="/core_v2/ingresos" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label for="paciente_id" class="col-md-1 col-xs-1 control-label">Paciente</label>
                                <div class="col-md-3 col-xs-3">
                                    <input type="hidden" name="paciente_id" id="paciente_id">
                                    <input name="paciente_nombre" id="paciente_nombre" class="form-control" placeholder="Paciente" disabled>

                                    @if ($errors->has('paciente_id'))
                                        <span class="help-block">
                                      <strong>{{ $errors->first('paciente_id')}}</strong>
                                  </span>
                                    @endif
                                </div>
                                <div class="col-md-1 col-xs-1">
                                  <button id="openBuscarPaciente" class="btn btn-default buscarPaciente" type="button">...</button>
                                </div>

                                <label for="doctor_id" class="col-md-1 col-xs-1 control-label">Doctor</label>
                                <div class="col-md-3 col-xs-3">
                                    <select name="doctor_id" id="doctor_id" class="form-control">
                                        @foreach( $medicos as $stdo )
                                            <option value="{{ $stdo->id }}"
                                                    )selected>{{ $stdo->apellidos }} {{ $stdo->nombres }}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('doctor_id'))
                                        <span class="help-block">
                                      <strong>{{ $errors->first('doctor_id')}}</strong>
                                  </span>
                                    @endif

                                </div>

                                <label for="fecha" class="col-md-1 col-xs-1 control-label">Fecha</label>
                                <div class="col-md-2 col-xs-2">
                                    <input type="date" id="fecha" name="fecha" value="<?php echo date('Y-m-d'); ?>" class="form-control" required>

                                    @if ($errors->has('fecha'))
                                        <span class="help-block">
                                      <strong>{{ $errors->first('fecha')}}</strong>
                                  </span>
                                    @endif

                                </div>

                            </div>

                            <div class="form-group">

                                <label for="tratamiento" class="col-md-1 col-xs-1 control-label">Tratamiento</label>
                                <div class="col-md-4 col-xs-8">
                                    <input id="tratamiento_id" type="hidden" name="tratamiento_id">
                                    <input id="tratamiento" type="text" class="form-control" name="tratamiento"
                                           placeholder="Tratamiento" readonly>

                                    @if ($errors->has('tratamiento'))
                                        <span class="help-block">
                                      <strong>{{ $errors->first('tratamiento')}}</strong>
                                  </span>
                                    @endif
                                </div>
                                <div class="col-md-1 col-xs-1">
                                  <button id="openBuscarTratamiento" class="btn btn-default buscarPaciente" type="button">...</button>
                                </div>

                                <label for="cantidad" class="col-md-1 col-xs-1 control-label">Cantidad</label>
                                <div class="col-md-2 col-xs-2">
                                    <input id="cantidad" type="number" class="form-control" name="cantidad"
                                           value="1" placeholder="Cantidad" min="1" step="1" required>

                                    @if ($errors->has('cantidad'))
                                        <span class="help-block">
                                      <strong>{{ $errors->first('cantidad')}}</strong>
                                  </span>
                                    @endif

                                </div>

                                <label for="monto" class="col-md-1 col-xs-1 control-label">Monto</label>
                                <div class="col-md-2 col-xs-2">
                                    <input id="monto" type="number" class="form-control" name="monto"
                                           placeholder="Monto" min="0" step=".1" readonly>

                                    @if ($errors->has('monto'))
                                        <span class="help-block">
                                      <strong>{{ $errors->first('monto')}}</strong>
                                  </span>
                                    @endif

                                </div>

                            </div>

                            <div class="form-group">
                                <div class="col-md-12 text-center" style="padding-top: 25px;">
                                    <button type="submit" class="btn-core">
                                        Agregar
                                    </button>
                                    <button type="reset" class="btn-core">
                                        Limpiar
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if( $numIngresos != 0 )
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center title">INGRESOS</div>
                        <div class="panel-body" style="padding-bottom: 60px;">

                            <div class="row" style="padding-bottom: 14px;">
                                <div class="col-md-1 col-md-offset-1" style="padding-top: 5px;">
                                    <strong>BUSCAR:</strong>
                                </div>
                                <div class="col-md-10">

                                    <div class="row">
                                        <form id="form-buscar-ingreso" method="get">
                                        <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
                                            <div class="col-md-3 col-xs-4">
                                                <input id="date_inicio" type="date" name="date_inicio" value=""
                                                       class="form-control">
                                            </div>
                                            <div class="col-md-3 col-xs-4">
                                                <input id="date_fin" type="date" name="date_fin" value=""
                                                       class="form-control">
                                            </div>
                                            <div class="col-md-3 col-xs-4">
                                                <select name="doctor_id" id="doctor_id" class="form-control">
                                                    <option value="-1" selected>Todos los Doctores</option>
                                                    @foreach( $medicos as $stdo )
                                                        <option value="{{ $stdo->id }}"
                                                                )>{{ $stdo->apellidos }} {{ $stdo->nombres }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-1 col-xs-4">
                                                <button type="submit" name="button" class="btn-core">Buscar</button>
                                            </div>
                                            <div class="col-md-1 text-center">
                                                <button id="print-pagos" class="btn-core" type="button" name="button">Imprimir</button>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>

                        <div id="print-pagos-div">
                            <div id="table-wrapper">
                                <!-- <div id="table-scroll"> -->
                                    <table id="tablaIngresos" class="table table-responsive table-hover">
                                        <thead>
                                          <tr>
                                              <th class="text-center col-md-1">Fecha</th>
                                              <th class="text-center">HC</th>
                                              <th class="text-center col-md-1">Paciente</th>
                                              <th class="text-center col-md-1">Doctor</th>
                                              <th class="text-center col-md-2">Tratamiento</th>
                                              <th class="text-center print-ignore">Cant</th>
                                              <th class="text-center print-ignore">Precio Unit</th>
                                              <th class="text-center print-ignore">Total</th>
                                              <th class="text-center">M. Doc.</th>
                                              <th class="text-center print-ignore">CORE</th>
                                              <th class="text-center col-md-1"></th>
                                              <th class="text-center col-md-1"></th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                        <?php $i = 0; ?>
                                        <?php $mdoc = 0; $mcore = 0; $mtotal = 0; ?>
                                        @foreach( $ingresos as $row )
                                            <tr>
                                                <!-- <td scope="row" class="text-center">{{ $i + 1 }}</td> -->
                                                <td class="text-center">{{ $row->fecha }}</td>
                                                <td class="text-center">{{ $row->hc }}</td>
                                                <td class="text-center">{{ $row->pacientes }}</td>
                                                <td class="text-center">{{ $row->ap_doctor }}</td>
                                                <td class="text-center">{{ $row->tratamiento }}</td>
                                                <td class="text-center print-ignore">{{ $row->cantidad }}</td>
                                                <td class="text-center print-ignore">{{ 'S/ ' . $row->monto }}</td>
                                                <?php $montoTotal = ((float)$row->cantidad  * (float)$row->monto); ?>
                                                <td class="text-center print-ignore">{{ 'S/ ' . $montoTotal }}</td>
                                                <?php $montoMedico = ($row->cantidad * $row->monto) * ((float)$row->mg / 100); ?>
                                                <td class="text-center">{{ 'S/ ' . $montoMedico }}</td>
                                                <?php $montoCore = ($row->cantidad * $row->monto) - $montoMedico; ?>
                                                <td class="text-center print-ignore">{{ 'S/ ' . $montoCore }}</td>
                                                <!-- <td class="text-center">
                                                    <button class="btn btn-xs btn-success"
                                                            onclick="mostrarDetalleIngreso('{{ json_encode($ingresos[$i]) }}')"
                                                            data-toggle="modal" data-target="#myModal">Detalle
                                                    </button>
                                                </td> -->
                                                <td class="text-center print-ignore">
                                                    <a href="{{ route('ingresos.edit', $row->id) }}"
                                                                           class="btn btn-xs btn-warning">Editar</a>
                                                </td>
                                                @if(Auth::user()->rolid == 1)
                                                    <td class="text-center print-ignore">
                                                        <form action="{{ route('ingresos.destroy', $row->id) }}"
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
                                            <?php $mdoc += $montoMedico; $mcore += $montoCore; $mtotal += $montoTotal; ?>
                                            <?php $i++; ?>
                                        @endforeach
                                        </tbody>

                                    </table>
                                <!-- </div> -->
                            </div>
                            <div class="row">
                                <div class="col-md-9"></div>
                                <div class="col-md-1 print-ignore text-right">
                                  <label for="">Total: </label>
                                  <div id="mtotal-footer">
                                    <?php echo 'S/' . $mtotal; ?>
                                  </div>
                                </div>
                                <div class="col-md-1 text-right">
                                  <label for="">M. Doc: </label>
                                  <div id="mdoc-footer"><?php echo 'S/' . $mdoc; ?></div>
                                </div>
                                <div class="col-md-1 print-ignore text-right">
                                  <label for="">CORE: </label>
                                  <div id="mcore-footer"><?php echo 'S/' . $mcore; ?></div>
                                </div>
                            </div>
                      </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title text-center">
                            <strong>
                                <div id="nombres-txt"></div>
                            </strong>
                        </h4>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <label for="hc" class="col-md-2 col-md-offset-1 control-label">HC:</label>
                            <div id="hc-txt" class="col-md-3"></div>

                            <label for="fecha" class="col-md-2 control-label">Fecha:</label>
                            <div id="fecha-txt" class="col-md-3"></div>
                        </div>
                        <div class="row">
                            <label for="paciente" class="col-md-2 col-md-offset-1 control-label">Paciente:</label>
                            <div id="paciente-txt" class="col-md-9"></div>
                        </div>
                        <div class="row">
                            <label for="doctor" class="col-md-2 col-md-offset-1 control-label">Doctor:</label>
                            <div id="doctor-txt" class="col-md-9"></div>
                        </div>
                        <hr>
                        <div class="row">
                            <label for="cantidad" class="col-md-2 col-md-offset-1 control-label">Cantidad:</label>
                            <div id="cantidad-txt" class="col-md-1"></div>

                            <label for="tratamiento" class="col-md-2 control-label">Tratamiento:</label>
                            <div id="tratamiento-txt" class="col-md-5"></div>
                        </div>
                        <div class="row">
                          <label for="montoUnitario" class="col-md-2 col-md-offset-1 control-label">Unitario:</label>
                            <div id="montoUnitario-txt" class="col-md-3" ></div>

                            <label for="montoTotal" class="col-md-2 control-label">Total:</label>
                            <div id="montoTotal-txt" class="col-md-3" ></div>
                        </div>
                        <div class="row">
                          <label for="montoDoctor" class="col-md-2 col-md-offset-1 control-label">Doctor:</label>
                            <div id="montoDoctor-txt" class="col-md-3" ></div>

                            <label for="montoCORE" class="col-md-2 control-label">CORE:</label>
                            <div id="montoCORE-txt" class="col-md-3" ></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>

        <!-- Modal Buscar Paciente -->
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
                                            <th></th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $i = 1; ?>
                                        @foreach( $pacientes as $row )
                                            <tr>
                                                <td class="text-center">{{ $row->id }}</td>
                                                <td class="text-center">{{ $row->nombres }} {{ $row->apellidos }}</td>
                                                <td class="text-center">
                                                    <button class="btn btn-xs btn-info"
                                                            onclick="agregarAIngresoPaciente('{{ $row->id }}', '{{ $row->nombres }} {{ $row->apellidos }}')">
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

  <!-- Modal Buscar Tratamiento -->
  <div id="buscarTratamiento" class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="false">
     <div class="modal-dialog">
        <div class="modal-content" style="background-color: #FFF;">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title text-center"><b>BUSCAR TRATAMIENTO</b></h4>
          </div>
           <div class="modal-body">
               <center><input type="text" id="myInput" onkeyup="buscarTratamiento()" placeholder=" Buscar por Concepto"></center>
               <div id="table-wrapper">
                    <div id="table-scroll">
                       <table id="tablaTratamiento" class="table table-striped text-center">
                          <thead>
                              <tr>
                                  <th class="text-center">Nro</th>
                                  <th class="text-center">Concepto</th>
                                  <th class="text-center">Precio (S/.)</th>
                                  <th class="text-center"></th>
                              </tr>
                          </thead>
                          <tbody>

                          </tbody>
                        </table>
                     </div>
                 </div>
           </div>
           <div class="text-center" style="padding: 15px;">
              <button data-dismiss="modal" class="btn btn-default">Cerrar</button>
           </div>
        </div>
     </div>
  </div>
    @endif

@endsection

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/printThis.js?v=1.0.0') }}"></script>
<script type="text/javascript">
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

  function buscarTratamiento(){
      var input, filter, table, tr, td, i;
      input = document.getElementById("myInput");
      filter = input.value.toUpperCase();
      table = document.getElementById("tablaTratamiento");
      tr = table.getElementsByTagName("tr");

      for(i = 0; i < tr.length; i++){
          td = tr[i].getElementsByTagName("td")[1];
          if(td){
              if(td.innerHTML.toUpperCase().indexOf(filter) > -1){
                  tr[i].style.display = "";
              }else{
                  tr[i].style.display = "none";
              }
          }
      }
  }

  $(document).ready(function(){
      $('#print-pagos').click(function(){
          $('#print-pagos-div').printThis({
              header: "<h3>Ingresos CORE</h3>",
              loadCSS: "http://localhost/core_v2/css/print-report.css?v=1.0.3"
          });
      });
  });
</script>
