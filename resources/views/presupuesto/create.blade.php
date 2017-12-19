<?php
    function obtenerFecha(){
        $now = new DateTime(null, new DateTimeZone('America/Lima'));
        return $now->format('Y-m-d H:i:s');
    }

    function existeOpcionDos($tratamientos, $nroTratamientos){
        for( $i = 0; $i < $nroTratamientos; $i++ ){
            if( $tratamientos[$i][4] == 2 ){
                return 1;
           }
        }
        return 0;
    }

    if( !isset($fechahora) ){
        $fechahora = obtenerFecha();
        $descuento = 0;
        $nroTratamientos = 0;
        $tratamientos = array();
        $modificar = 0;
    }

    $existe_opc_dos = -1;
    if( $modificar == 1 ){
        $existe_opc_dos = existeOpcionDos($tratamientos, $nroTratamientos);
    }

    $idDoctor = $doctor[0]->mid;
    $idPaciente = $paciente[0]->did;
?>

@extends('layouts.default')

@section('content')

<div id="printSection">
  <div id="header" class="container">
      <div class="row" style="margin-top: 6px; margin-bottom: 15px; color: #000;">
          <div class="col-md-12 col-xs-12 text-center no-print">
                  <h2><b>PRESUPUESTO N° {{ $nroPresupuesto }}</b></h2>
          </div>
          <div class="header-presup-print">
              <div class="row">
                <div class="col-md-12 text-right">
                  <img src="{{ asset('images/logotipo_brand.png')}}" width="285">
                </div>
                <div class="col-md-12 text-center" >
                  <h2><b>PRESUPUESTO N° {{ $nroPresupuesto }}</b></h2>
                </div>
              </div>
          </div>
      </div>
  </div>

  <div class="container" style="padding-bottom: 45px;">
      <div class="row">
          <div class="col-md-12">
  <!-- HISTORIA CLÍNICA -->
              <div class="panel panel-default">
                  <div class="panel-heading text-center title no-print">HISTORIA CLÍNICA</div>
                  <div class="panel-body" style="padding-bottom: 45px; padding-top: 38px;">

                    <div class="row">
                        <div class="form-group">
                          <label for="nombres" class="col-md-1 col-xs-1 col-md-offset-2 col-xs-offset-1 control-label">Fecha: </label>
                          <div class="col-md-3 col-xs-4">
                              {{ $fechahora }}
                          </div>

                          <label for="nombres" class="col-md-1 col-xs-1 col-md-offset-1 col-xs-offset-0 control-label">Empresa: </label>
                          <div class="col-md-4 col-xs-4">
                              {{ $paciente[0]->enombre }}
                          </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                          <label for="nombres" class="col-md-1 col-xs-1 col-md-offset-2 col-xs-offset-1 control-label">HC: </label>
                          <div class="col-md-3 col-xs-4">
                              {{ '000' }}{{ $paciente[0]->did }}
                          </div>

                          <label for="nombres" class="col-md-1 col-xs-1 col-md-offset-1 col-xs-offset-0 control-label">Paciente: </label>
                          <div class="col-md-4 col-xs-4">
                              {{ $paciente[0]->pnombres }} {{ $paciente[0]->papellidos }}
                          </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                          <label for="nombres" class="col-md-1 col-xs-1 col-md-offset-2 col-xs-offset-1 control-label">Doctor: </label>
                          <div class="col-md-3 col-xs-4">
                              {{ $doctor[0]->mnombres }} {{ $doctor[0]->mapellidos }}
                          </div>

                          <label for="nombres" class="col-md-1 col-xs-1 col-md-offset-1 col-xs-offset-0 control-label">Sede: </label>
                          <div class="col-md-4 col-xs-4">
                              {{ 'Cajamarca' }}
                          </div>
                        </div>
                    </div>

                  </div>
              </div>
  <!-- OPCIONES -->
              <div id="opciones">

                <div class="row">
                    <div class="@if($existe_opc_dos != 0) col-md-6 col-xs-6 @else col-md-12 col-xs-12  @endif">
                        <button id="opc1" class="btn btn-primary" style="width: 100%;">Opción 1</button>
                    </div>
                @if( $existe_opc_dos != 0 )
                    <div class="col-md-6 col-xs-6">
                        <button id="opc2" class="btn btn-default" style="width: 100%;">Opción 2</button>
                    </div>
                </div>
                @endif
              </div>
  <!-- ODONTOGRAMA -->
              <div class="panel panel-default" style="margin-top: 15px;">
                  <div id="title-odonto" class="panel-heading text-center title">ODONTOGRAMA</div>
                  <div class="panel-body" style="padding-bottom: 45px; padding-top: 38px;">
                        <div class="row">
                          <!-- BLOQUE 01 -->
                          <div class="col-lg-6 col-xs-6 col-md-6" style="border-right: 1px solid #BBB;">
                  <?php     for( $id = 11; $id <= 18; $id++ ){      ?>
                              <div class="diente" id="{{ $id }}">
                                  <!-- <center>{{ $id }}</center> -->
                                  <div class="d-top">
                                      <span style="font-size: 12px;"><center>{{ $id }}</center></span>
                                      <img src="{{ asset('images/presupuesto/diente_top_01.png')}}" class="diente-btn" id="{{$id}}-2">
                                  </div>
                                  <div class="d-center">
                                      <img src="{{ asset('images/presupuesto/diente_left_01.png')}}" class="diente-btn" id="{{$id}}-4">

                                      <img src="{{ asset('images/presupuesto/diente_center_01.png')}}" class="diente-btn" id="{{$id}}-1">

                                      <img src="{{ asset('images/presupuesto/diente_right_01.png')}}" class="diente-btn" id="{{$id}}-3">
                                  </div>
                                  <div class="d-bottom">
                                      <img src="{{ asset('images/presupuesto/diente_bottom_01.png')}}" class="diente-btn" id="{{$id}}-5">
                                      <br>
                                      <img src="{{ asset('images/presupuesto/diente_bottom_bottom_01.png')}}" class="diente-btn" id="{{$id}}-6">
                                  </div>
                              </div>
                  <?php       }               ?>
                          </div>

                          <!-- BLOQUE 02 -->
                          <div class="col-lg-6 col-xs-6 col-md-6">
                  <?php       for( $id = 21; $id <= 28; $id++ ){          ?>
                              <div class="diente-2" id="{{ $id }}">
                                  <!-- <center>{{ $id }}</center> -->
                                  <div class="d-top">
                                      <span style="font-size: 12px;"><center>{{ $id }}</center></span>
                                      <img src="{{ asset('images/presupuesto/diente_top_01.png')}}" class="diente-btn" id="{{$id}}-2">
                                  </div>
                                  <div class="d-center">
                                      <img src="{{ asset('images/presupuesto/diente_left_01.png')}}" class="diente-btn" id="{{$id}}-4">

                                      <img src="{{ asset('images/presupuesto/diente_center_01.png')}}" class="diente-btn" id="{{$id}}-1">

                                      <img src="{{ asset('images/presupuesto/diente_right_01.png')}}" class="diente-btn" id="{{$id}}-3">
                                  </div>
                                  <div class="d-bottom">
                                      <img src="{{ asset('images/presupuesto/diente_bottom_01.png')}}" class="diente-btn" id="{{$id}}-5">
                                      <br>
                                      <img src="{{ asset('images/presupuesto/diente_bottom_bottom_01.png')}}" class="diente-btn" id="{{$id}}-6">
                                  </div>
                              </div>
                  <?php       }               ?>
                          </div>

                      </div>
                      <div class="row">
                            <!-- BLOQUE 03 -->
                            <div class="col-lg-6 col-xs-6 col-md-6" style="border-right: 1px solid #BBB;">
                    <?php      for( $id = 51; $id <= 55; $id++ ){      ?>
                                  <div class="diente" id="{{ $id }}">
                                      <!-- <center>{{ $id }}</center> -->
                                      <div class="d-top">
                                          <img src="{{ asset('images/presupuesto/diente_top_01.png')}}" class="diente-btn" id="{{$id}}-2">
                                      </div>
                                      <div class="d-center">
                                          <img src="{{ asset('images/presupuesto/diente_left_01.png')}}" class="diente-btn" id="{{$id}}-4">

                                          <img src="{{ asset('images/presupuesto/diente_center_01.png')}}" class="diente-btn" id="{{$id}}-1">

                                          <img src="{{ asset('images/presupuesto/diente_right_01.png')}}" class="diente-btn" id="{{$id}}-3">
                                      </div>
                                      <div class="d-bottom">
                                          <img src="{{ asset('images/presupuesto/diente_bottom_01.png')}}" class="diente-btn" id="{{$id}}-5">
                                          <br>
                                          <img src="{{ asset('images/presupuesto/diente_bottom_bottom_01.png')}}" class="diente-btn" id="{{$id}}-6">
                                      </div>
                                      <span style="font-size: 12px;"><center>{{ $id }}</center></span>
                                  </div>
                    <?php      }               ?>
                            </div>

                            <!-- BLOQUE 04 -->
                            <div class="col-lg-6 col-xs-6 col-md-6">
                    <?php       for( $id = 61; $id <= 65; $id++ ){      ?>
                                  <div class="diente-2" id="{{ $id }}">
                                      <!-- <center>{{ $id }}</center> -->
                                      <div class="d-top">
                                          <img src="{{ asset('images/presupuesto/diente_top_01.png')}}" class="diente-btn" id="{{$id}}-2">
                                      </div>
                                      <div class="d-center">
                                          <img src="{{ asset('images/presupuesto/diente_left_01.png')}}" class="diente-btn" id="{{$id}}-4">

                                          <img src="{{ asset('images/presupuesto/diente_center_01.png')}}" class="diente-btn" id="{{$id}}-1">

                                          <img src="{{ asset('images/presupuesto/diente_right_01.png')}}" class="diente-btn" id="{{$id}}-3">
                                      </div>
                                      <div class="d-bottom">
                                          <img src="{{ asset('images/presupuesto/diente_bottom_01.png')}}" class="diente-btn" id="{{$id}}-5">
                                          <br>
                                          <img src="{{ asset('images/presupuesto/diente_bottom_bottom_01.png')}}" class="diente-btn" id="{{$id}}-6">
                                      </div>
                                      <span style="font-size: 12px;"><center>{{ $id }}</center></span>
                                  </div>
                    <?php       }               ?>
                            </div>
                      </div>

                      <hr>

                      <div class="row">
                          <!-- BLOQUE 05 -->
                          <div class="col-lg-6 col-xs-6 col-md-6" style="border-right: 1px solid #BBB;">
                  <?php       for( $id = 81; $id <= 85; $id++ ){      ?>
                                <div class="diente" id="{{ $id }}">
                                    <!-- <center>{{ $id }}</center> -->
                                    <div class="d-top">
                                        <span style="font-size: 12px;"><center>{{ $id }}</center></span>
                                        <img src="{{ asset('images/presupuesto/diente_top_01.png')}}" class="diente-btn" id="{{$id}}-2">
                                    </div>
                                    <div class="d-center">
                                        <img src="{{ asset('images/presupuesto/diente_left_01.png')}}" class="diente-btn" id="{{$id}}-4">

                                        <img src="{{ asset('images/presupuesto/diente_center_01.png')}}" class="diente-btn" id="{{$id}}-1">

                                        <img src="{{ asset('images/presupuesto/diente_right_01.png')}}" class="diente-btn" id="{{$id}}-3">
                                    </div>
                                    <div class="d-bottom">
                                        <img src="{{ asset('images/presupuesto/diente_bottom_01.png')}}" class="diente-btn" id="{{$id}}-5">
                                        <br>
                                        <img src="{{ asset('images/presupuesto/diente_bottom_bottom_01.png')}}" class="diente-btn" id="{{$id}}-6">
                                    </div>
                                </div>
                  <?php       }               ?>
                          </div>
                          <!-- BLOQUE 06 -->
                          <div class="col-lg-6 col-xs-6 col-md-6">
                  <?php       for( $id = 71; $id <= 75; $id++ ){      ?>
                                <div class="diente-2" id="{{ $id }}">
                                    <!-- <center>{{ $id }}</center> -->
                                    <div class="d-top">
                                        <span style="font-size: 12px;"><center>{{ $id }}</center></span>
                                        <img src="{{ asset('images/presupuesto/diente_top_01.png')}}" class="diente-btn" id="{{$id}}-2">
                                    </div>
                                    <div class="d-center">
                                        <img src="{{ asset('images/presupuesto/diente_left_01.png')}}" class="diente-btn" id="{{$id}}-4">

                                        <img src="{{ asset('images/presupuesto/diente_center_01.png')}}" class="diente-btn" id="{{$id}}-1">

                                        <img src="{{ asset('images/presupuesto/diente_right_01.png')}}" class="diente-btn" id="{{$id}}-3">
                                    </div>
                                    <div class="d-bottom">
                                        <img src="{{ asset('images/presupuesto/diente_bottom_01.png')}}" class="diente-btn" id="{{$id}}-5">
                                        <br>
                                        <img src="{{ asset('images/presupuesto/diente_bottom_bottom_01.png')}}" class="diente-btn" id="{{$id}}-6">
                                    </div>
                                </div>
                  <?php       }               ?>
                          </div>
                      </div>


                      <div class="row">
                  <!------------ BLOQUE 07 ----------->
                          <div class="col-lg-6 col-xs-6 col-md-6" style="border-right: 1px solid #BBB;">
                  <?php       for( $id = 41; $id <= 48; $id++ ){      ?>
                                <div class="diente" id="{{ $id }}">
                                    <!-- <center>{{ $id }}</center> -->
                                    <div class="d-top">
                                        <img src="{{ asset('images/presupuesto/diente_top_01.png')}}" class="diente-btn" id="{{$id}}-2">
                                    </div>
                                    <div class="d-center">
                                        <img src="{{ asset('images/presupuesto/diente_left_01.png')}}" class="diente-btn" id="{{$id}}-4">

                                        <img src="{{ asset('images/presupuesto/diente_center_01.png')}}" class="diente-btn" id="{{$id}}-1">

                                        <img src="{{ asset('images/presupuesto/diente_right_01.png')}}" class="diente-btn" id="{{$id}}-3">
                                    </div>
                                    <div class="d-bottom">
                                        <img src="{{ asset('images/presupuesto/diente_bottom_01.png')}}" class="diente-btn" id="{{$id}}-5">
                                        <br>
                                        <img src="{{ asset('images/presupuesto/diente_bottom_bottom_01.png')}}" class="diente-btn" id="{{$id}}-6">
                                    </div>
                                    <span style="font-size: 12px;"><center>{{ $id }}</center></span>
                                </div>
                  <?php       }               ?>
                          </div>

                  <!------------ BLOQUE 08 ----------->
                          <div class="col-lg-6 col-xs-6 col-md-6">
                  <?php       for( $id = 31; $id <= 38; $id++ ){      ?>
                                <div class="diente-2" id="{{ $id }}">
                                    <!-- <center>{{ $id }}</center> -->
                                    <div class="d-top">
                                        <img src="{{ asset('images/presupuesto/diente_top_01.png')}}" class="diente-btn" id="{{$id}}-2">
                                    </div>
                                    <div class="d-center">
                                        <img src="{{ asset('images/presupuesto/diente_left_01.png')}}" class="diente-btn" id="{{$id}}-4">

                                        <img src="{{ asset('images/presupuesto/diente_center_01.png')}}" class="diente-btn" id="{{$id}}-1">

                                        <img src="{{ asset('images/presupuesto/diente_right_01.png')}}" class="diente-btn" id="{{$id}}-3">
                                    </div>
                                    <div class="d-bottom">
                                        <img src="{{ asset('images/presupuesto/diente_bottom_01.png')}}" class="diente-btn" id="{{$id}}-5">
                                        <br>
                                        <img src="{{ asset('images/presupuesto/diente_bottom_bottom_01.png')}}" class="diente-btn" id="{{$id}}-6">
                                    </div>
                                    <span style="font-size: 12px;"><center>{{ $id }}</center></span>
                                </div>
                  <?php       }               ?>
                          </div>
                      </div>
                  <!-- TRATAMIENTO EXTRA -->
                      <div class="row">
                        <div class="col-md-12">
                          <div class="text-right" style="margin-top: 25px; margin-bottom: 15px;">
                                <button class="btn btn-default no-print" id="adicionalBtn">Agregar Tratamiento extra </button>
                          </div>
                        </div>
                      </div>

                      <!-- TABLA DE TRATAMIENTOS  -->
                      <div class="row">
                          <div class="col-md-12 title text-center" style="margin-top: 20px;">
                            <!-- <h3>TRATAMIENTOS CUBIERTOS</h3> -->
                          </div>
                          <div class="col-md-12 col-xs-12" style="margin-bottom: 35px;">
                            <table id="tratamientosTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">Pieza</th>
                                        <th class="text-center">Superficie</th>
                                        <th class="text-center">Tratamientos</th>
                                        <th class="text-center">Deductible</th>
                                        <th class="text-center">Monto</th>
                                        <th class="text-center">Total</th>
                                        <th class="text-center"></th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <tr>
                                    </tr>
                                </tbody>
                            </table>
                          </div>

                          <!-- BOTONES DE DESCUENTO -->
                          <div class="form-group">
                              <label for="subtotal" class="text-right col-md-2 col-md-offset-8 col-xs-2 col-xs-offset-8 control-label" style="margin-top: 5px;">Subtotal (S/): </label>
                              <div class="col-md-2 col-xs-2">
                                  <input type="text" class="presupuesto-form" id="subtotal" name="firstname" disabled="true" value="0.0" size="3">
                              </div>
                          @if( $modificar == 0 or ( $modificar == 1 and $descuento != 0 ) )
                          <div id="descuento-group">
                              <label for="descuento" class="text-right col-md-2 col-md-offset-8 col-xs-2 col-xs-offset-8 control-label" style="margin-top: 5px;">Descuento: </label>
                              <div class="col-md-2 col-xs-2">
                                  <?php $descuentos = array('0%', '5%', '10%'); ?>
                                  <select name="descuento" id="descuento" class="presupuesto-form">
                                      <?php $ind = 0; ?>
                                      @foreach( $descuentos as $desc )
                                          <option class="presp-opc" value="{{ $ind }}" {{ $descuento == $ind ? 'selected="selected"' : '' }}>{{ $desc }}</option>
                                          <?php $ind++; ?>
                                      @endforeach
                                  </select>
                              </div>
                          </div>
                          @endif

                              <label for="subtotal" class="text-right col-md-2 col-md-offset-8 col-xs-2 col-xs-offset-8 control-label" style="margin-top: 5px;">Total (S/): </label>
                              <div class="col-md-2 col-xs-2">
                                  <input type="text" class="presupuesto-form" id="total" name="firstname" disabled="true" value="0.0" size="3">
                              </div>
                          </div>
                      </div>
                      <!-- BOTONES -->
                      <div class="col-md-12 col-xs-12 text-center" style="margin-top: 25px;">
                          <button id="nuevo" class="btn btn-primary no-print">Nuevo</button>
                          <button id="guardar" class="btn btn-primary no-print">Guardar</button>
                          <button id="imprimir" onclick="window.print()" class="btn btn-primary no-print">Imprimir</button>
                          <button id="cerrar" class="btn btn-primary no-print">Regresar</button>
                      </div>
                  </div>
                </div>

              </div>
            </div>

          </div>
      </div>


<!-- MODAL PRECIOS -->
<div id="mostrarmodal" class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="false">
   <div class="modal-dialog">
      <div class="modal-content" style="background-color: #FFF;">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <center><h3><b>PRECIOS</b></h3></center>
            <div id="identificacion"></div>
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
                                <?php $i = 2; ?>
                                @foreach($precios as $precio)
                                    @if(  $i > 6 and $precio->id != 29 and $precio->id != 30 )
                                        <tr>
                                            <td>{{ $i-6 }}</td>
                                            <td>{{ $precio->detalle }}</td>
                                            <td>{{ $precio->monto }}</td>
                                            <td><a name="precio" id="{{ $i }}">Agregar</a></td>
                                        </tr>
                                    @endif
                                    <?php $i++ ?>
                                @endforeach

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
@endsection

<script src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript">


    $(document).ready(function(){
        var idDoctor, idPaciente, nroPresupuesto, fechahora, descuento;
        var montoTotal = 0;
        var nroTratamientos = 0;
        var tratamientos = new Array();
        var precios = <?php echo json_encode($precios) ?>;
        var eliminar = 1;
        var modificar = 0;
        var opc_actual = 1;


        $('#nuevo').click(function(){
              swal({
                    title: "Advertencia",
                    text: "¿Esta seguro de crear un nuevo presupuesto? Los datos actuales se perderán",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: 'Si',
                    cancelButtonText: "No",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function(isConfirm) {
                    if (isConfirm) {
                        window.location.href = "/core_v2/presupuestos/create/" + idDoctor + '/' + idPaciente;
                    }
            });
        });


        $('#cerrar').click(function(){
            window.location.href = "/core_v2/presupuestos";
        });

        $('a').click(function(event){
            if( event.target.name == 'precio' ){
              var seccion = event.target.id;
              var piezaDiente = $('#identificacion').val();
              $('#mostrarmodal').modal('hide');

              agregarPiezaSeccionATratamientos(seccion, piezaDiente);
            }else{
              $('.dropdown-toggle').dropdown();
            }
        });

        $('#guardar').click(function(){
            if( tratamientos.length == 0 ){
                alertMessage('Error',' Debe seleccionar minimo un tratamiento.', 'error');
            }else{
                  swal({
                      title: "Advertencia",
                      text: "A continuación se guardará el actual presupuesto y no podrá ser modificado. ¿Estas seguro de guardar el presupuesto?",
                      type: "warning",
                      showCancelButton: true,
                      confirmButtonColor: '#30d176',
                      confirmButtonText: 'Si, seguro',
                      cancelButtonText: "No, cancelar",
                      closeOnConfirm: true,
                      closeOnCancel: true
                  },
                  function(isConfirm) {
                      if (isConfirm) {
                          descuento = $('#descuento').val();
                          aux = JSON.stringify(tratamientos);

                          $.ajax({
                              type: 'GET',
                              url: 'http://localhost/core_v2/api-v1/save-presupuesto',
                              dataType: 'json',
                              contentType: "application/json; charset=utf-8",
                              data: {
                                  fechahora: fechahora,
                                  idPaciente: idPaciente,
                                  idDoctor: idDoctor,
                                  nroPresupuesto: nroPresupuesto,
                                  descuento: descuento,
                                  tratamientos: aux
                              },
                              success: function(data){

                                  swal({
                                          title: "",
                                          text: "Presupuesto Correctamente Creado. ¿Desea permanecer en la página?",
                                          type: "success",
                                          showCancelButton: true,
                                          confirmButtonColor: '#DD6B55',
                                          confirmButtonText: 'Si',
                                          cancelButtonText: "No",
                                          closeOnConfirm: true,
                                          closeOnCancel: true
                                      },
                                      function(isConfirm) {
                                          if (isConfirm) {
                                              $('#guardar').hide();
                                              $('#imprimir').show();
                                              if( $('#descuento').val() == '0' ){
                                                  $('#descuento-group').hide();
                                              }
                                              // $('#cerrar').show();
                                              modificar = 1;
                                              eliminar = 0;
                                              mostrarTratamientosEnTabla();
                                              $('#descuento').attr("disabled", true);
                                          } else {
                                              window.location.href = "/core_v2/presupuestos";
                                          }
                                      });
                              },
                              error: function(){
                                  // swal('Error!', 'Ha ocurrido un problema. Contactar con el webmaster', 'error');
                                  alertMessage('', 'Ha ocurrido un problema. Contactar con el webmaster', 'error');
                              }
                          });
                      }
                  });
            }
        });

        $('#cerrar').click(function(){
            window.close();
        });

        $('#adicionalBtn').click(function(){
            accionModal(0);
        });



        $('#opc1').click(function(){ //FALTA VALIDAR SI SON MODIFICAR
            opc_actual = 1;

            restartMain();

            $('#opc2').attr('class', 'btn btn-default');
            $('#opc1').attr('class', 'btn btn-primary');
        });

        $('#opc2').click(function(){ //FALTA VALIDAR SI SON MODIFICAR
            opc_actual = 2;

            restartMain();

            $('#opc1').attr('class', 'btn btn-default');
            $('#opc2').attr('class', 'btn btn-primary');
        });

        main();

        function restartMain(){
            restartDientesDefault();
            mostrarTratamientosEnTabla();
            calcularMonto();
            pintarPiezasPorSecciones();
        }

        function ocultarBotones(){
            $('#nuevo').hide();
            $('#guardar').hide();
            $('#tratExtra').hide();
        }

        function seccionValida(seccion){
            for( var i = 8; i <= 26; i++ ){
                if( i == seccion ) {
                    return true;
                }
            }
            if( seccion == 29 ){
                return true;
            }
            return false;
        }
        function pintarResinaCompuesta(piezaDiente, auxSeccion){
            if( auxSeccion != undefined ){
                pintarResina(piezaDiente, auxSeccion);
            }
        }
        function pintarResina(piezaDiente, seccion){
            var id_completo = piezaDiente + '-' + seccion;

            if( seccion == '2' ){
                $('#' + id_completo).attr('src', '/core_v2/images/presupuesto/diente_top_02.png');
            }else if(seccion == '3' ){
                $('#' + id_completo).attr('src', '/core_v2/images/presupuesto/diente_right_03.png');
            }else if(seccion == '4' ){
                $('#' + id_completo).attr('src', '/core_v2/images/presupuesto/diente_left_04.png');
            }else if(seccion == '5' ){
                $('#' + id_completo).attr('src', '/core_v2/images/presupuesto/diente_bottom_05.png');
            }else if(seccion == '6' ){
                $('#' + id_completo).attr('src', '/core_v2/images/presupuesto/diente_bottom_bottom_07.png');
            }else{
                $('#' + piezaDiente + '-1').attr('src', '/core_v2/images/presupuesto/diente_center_07.png');
            }
        }

        function mayorAMenor(a, b) {
            if (a[0] === b[0]) {
                return 0;
            }
            else {
                return (a[0] > b[0]) ? -1 : 1;
            }
        }
        function pintarPiezasPorSecciones(){
            // tratamientos.sort(mayorAMenor);
            for( var i = 0; i < nroTratamientos; i++ ){
                if( tratamientos[i][4] == opc_actual ){
                    var piezaDiente = tratamientos[i][0];
                    var seccion = tratamientos[i][1];
                    var aux_sec1 = tratamientos[i][2];
                    var aux_sec2 = tratamientos[i][3];

                    if( seccion <= 7 ){ //Resina
                        pintarResina(piezaDiente, seccion);
                        pintarResinaCompuesta(piezaDiente, aux_sec1);
                        pintarResinaCompuesta(piezaDiente, aux_sec2);
                    }else{
                        if( !seccionValida(seccion) ){
                            seccion = 1;
                        }
                        var id_completo = piezaDiente + '-1';
                        var name = '/core_v2/images/presupuesto/diente_center_0' + seccion +'.png';
                        $('#' + id_completo).attr('src', name);
                    }
                }
            }
            // tratamientos.sort(menorAMayor);
        }

        function calcularTotal(){
            var subtotal = $('#subtotal').val();
            var descuento = $("select#descuento option:checked").val();
            var desc = 0;
            var total;

            if( descuento == 1 ){
                desc = 5;
            }else if( descuento == 2 ){
                desc = 10;
            }

            total = subtotal - (subtotal * (desc/100));
            $("#total").val(total);
        }
        function descuentoFx(){
            $("#descuento").change(function(){
                calcularTotal();
            });

            $("#descuento").focusout(function(){
                if( $("#descuento").val() == '' ){
                    var subtotal = parseFloat($("#subtotal").val());
                    $("#descuento").val('0.0');
                    $("#total").val(subtotal)
                    ;
                }
            });
        }
        function calcularMonto(){
            var monto = 0.0, seccion;
            for( var i = 0; i < nroTratamientos; i++ ){
                if( tratamientos[i][4] == opc_actual ){
                    if( tratamientos[i][2] != undefined && tratamientos[i][3] == undefined ){
                        seccion = 27;
                    }else if( tratamientos[i][2] != undefined && tratamientos[i][3] != undefined ){
                        seccion = 28;
                    }else{
                        seccion = tratamientos[i][1];
                    }
                    monto += Number.parseFloat(precios[seccion-2]['monto']);
                }
            }
            $('#subtotal').val(monto);
            descuentoFx();
            if( modificar = 1 ){
                calcularTotal();
            }
        }

        function eliminarTratamiento(id){
            var flag = 0;
            if( esCaries(tratamientos[id][1]) ){ //Eliminar caries
                if( tratamientos[id][2] != undefined && tratamientos[id][3] != undefined ){
                    tratamientos[id][3] = undefined; flag = 1;
                }else if( tratamientos[id][2] != undefined && tratamientos[id][3] == undefined ){
                    tratamientos[id][2] = undefined; flag = 1;
                }else{
                    flag = 0;
                }
            }
            if( !flag ){
                tratamientos.splice(id, 1);
                nroTratamientos--;
            }
            eliminar = 0;
        }
        function restartDientesDefault(){
            for( var i = 0; i < nroTratamientos; i++ ){
                $('#' + tratamientos[i][0] + '-1').attr('src', '/core_v2/images/presupuesto/diente_center_01.png');
                $('#' + tratamientos[i][0] + '-2').attr('src', '/core_v2/images/presupuesto/diente_top_01.png');
                $('#' + tratamientos[i][0] + '-3').attr('src', '/core_v2/images/presupuesto/diente_right_01.png');
                $('#' + tratamientos[i][0] + '-4').attr('src', '/core_v2/images/presupuesto/diente_left_01.png');
                $('#' + tratamientos[i][0] + '-5').attr('src', '/core_v2/images/presupuesto/diente_bottom_01.png');
                $('#' + tratamientos[i][0] + '-6').attr('src', '/core_v2/images/presupuesto/diente_bottom_bottom_01.png');
            }
        }
        function verEliminar(){
            $('#tratamientosTable tr').click(function (event) {
                modificar = <?php echo json_encode($modificar); ?>; /* Variable temporal */

                if( modificar != 1 ){
                    var id_row = this.id;
                    swal({
                            title: "Advertencia",
                            text: "¿Esta seguro de eliminar este tratamiento? No se podrá recuperar",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: '#DD6B55',
                            confirmButtonText: 'Si',
                            cancelButtonText: "No",
                            closeOnConfirm: true,
                            closeOnCancel: true
                        },
                        function(isConfirm) {
                            if (isConfirm) {
                              restartDientesDefault();
                              eliminarTratamiento(id_row);

                              mostrarTratamientosEnTabla();
                              calcularMonto();
                              pintarPiezasPorSecciones();

                            }
                    });
                }
            });
        }
        function mostrarTablaHeaderMonto(){
            $('#tablaTratamientosCubiertos').show(true);
        }
        function tratamientosActuales(){
            var cnt = 0;
            for(var i = 0; i < nroTratamientos; i++ ){
                if( tratamientos[i][4] == opc_actual ){
                    cnt++;
                }
            }
            return cnt;
            //return (cnt < 1 && opc_actual == 1) || (cnt == 1 && opc_actual == 2); //FALTA VER SI AGREGAR EN TABLA
        }
        function eliminarTablaActual(){
            $('#tratamientosTable tbody tr').empty();

            //alert(tratamientosActuales());
        /*
            if( tratamientosActuales() == 1 && tratamientos[0][2] == undefined && eliminar ){

                $('#tratamientosTable tr:first').after('<th class="text-center">Pieza</th><th class="text-center">Superficie</th><th class="text-center">Tratamientos</th>' +
                                                  '<th class="text-center">Deductible</th><th class="text-center">Monto</th><th class="text-center">Total</th>');
            }
        */
        }
        function agregarDatosATabla(ind, seccion, pieza, tratamiento, monto){
            var id_completo = pieza + '-' + seccion;
            var pza = 'PZA';
            if( pieza == '0' ){ pieza = ''; pza = ''; }
            var content = '<tr id="'+ind+'"><td>'+pieza+'</td><td>'+pza+'</td><td>'+tratamiento+'</td><td>0</td><td>'+monto+'</td><td>S/. '+monto+'</td>';

            modificar = <?php echo json_encode($modificar); ?>; /* Variable temporal */
            if( modificar != 1 ){
                content += '<td><a href="#">Eliminar</a></td></tr>';
            }else{
                content += '</tr>';
            }

            $('#tratamientosTable tr:last').after(content);
        }

        function menorAMayor(a, b) {
            if (a[0] === b[0]) {
                return 0;
            }
            else {
                return (a[0] < b[0]) ? -1 : 1;
            }
        }
        function mostrarTratamientosEnTabla(){
            var pieza, seccion;

            eliminarTablaActual();

            tratamientos.sort(menorAMayor);

            for( var i = 0; i < nroTratamientos; i++ ){
                if( tratamientos[i][4] == opc_actual ){
                    pieza = tratamientos[i][0];
                    seccion = tratamientos[i][1];

                    if( tratamientos[i][2] == undefined && tratamientos[i][3] == undefined ){
                        agregarDatosATabla(i, seccion, pieza, precios[seccion-2]["detalle"], precios[seccion-2]["monto"]);
                    }else if( tratamientos[i][2] != undefined && tratamientos[i][3] == undefined ){
                        seccion = 27;
                        agregarDatosATabla(i, seccion, pieza, precios[seccion-2]["detalle"], precios[seccion-2]["monto"]);
                    }else if( tratamientos[i][2] != undefined && tratamientos[i][3] != undefined ){
                        seccion = 28;
                        agregarDatosATabla(i, seccion, pieza, precios[seccion-2]["detalle"], precios[seccion-2]["monto"]);
                    }
                }
            }
            verEliminar();
        }

        function esCaries(value){
            if( value <= 5 ) return true;
            if( value == 7 ) return true;
            return false;
        }
        function existeCaries(pieza){
            for( var i = 0; i < nroTratamientos; i++ ){
                if( tratamientos[i][0] == pieza && esCaries(tratamientos[i][1]) && tratamientos[i][4] == opc_actual ){ //Es caries
                    return i;
                }
            }
            return -1;
        }
        function existeTratamiento(seccion, pieza){
            for( var i = 0; i < nroTratamientos; i++ ){
               // alert( tratamientos[i][0] + '-' + pieza + ', ' + tratamientos[i][1] + '-' + seccion + ', ' + tratamientos[i][4] + '-' + opc_actual )
                if( tratamientos[i][0] == pieza && tratamientos[i][1] == seccion && tratamientos[i][4] == opc_actual ) return true;
            }
            return false;
        }
        function agregarPiezaSeccionATratamientos(seccion, pieza){
            if( isNaN(pieza) ) return;

           // mostrarArray();

            if( !existeTratamiento(seccion, pieza) ){
                var ind = existeCaries(pieza);
                var flag = 0;
                if( ind != -1 && esCaries(seccion) ){
                    if( tratamientos[ind][2] == undefined && tratamientos[ind][3] == undefined && tratamientos[ind][4] == opc_actual){
                        tratamientos[ind][2] = seccion;    flag = 1;
                    }else if( tratamientos[ind][2] != undefined && tratamientos[ind][3] == undefined && tratamientos[ind][4] == opc_actual){
                        tratamientos[ind][3] = seccion;    flag = 1;
                    }else if( tratamientos[ind][2] != undefined && tratamientos[ind][2] != undefined && tratamientos[ind][4] == opc_actual){
                        alertMessage('Advertencia', 'Sólo se admiten tres resinas por pieza', 'warning');   flag = 1;
                    }else{
                        flag = 0;
                    }
                }

                if( flag == 0 ){
                    tratamientos[nroTratamientos] = [pieza, seccion];
                    tratamientos[nroTratamientos][4] = opc_actual;
                    nroTratamientos++;
                }

                mostrarTablaHeaderMonto();
                restartMain();

            }else{
                alertMessage('Advertencia', 'No puede agregar el mismo tratamiento más de una vez', 'warning');
            }
        }

        function accionModal(piezaDiente){
        //--------- Mostrar Modal --------//
            $('#mostrarmodal').modal('show');
            $('#identificacion').val(piezaDiente);
        }
        function revisarResinasEnDientes(inicio, final){
            if( modificar != '1' ){
                for( var i = inicio; i <= final; i++ ){
                    $('#'+i).click(function(event){
                        var id_completo = event.target.id;
                        var seccionDiente = id_completo[id_completo.length - 1];
                        var piezaDiente = id_completo[0] + id_completo[1];

                        if( seccionDiente == '1' ){
                            accionModal(piezaDiente);
                        }else if(seccionDiente == '2' ){
                            agregarPiezaSeccionATratamientos(2, piezaDiente);
                        }else if(seccionDiente == '3' ){
                            agregarPiezaSeccionATratamientos(3, piezaDiente);
                        }else if(seccionDiente == '4' ){
                            agregarPiezaSeccionATratamientos(4, piezaDiente);
                        }else if(seccionDiente == '5' ){
                            agregarPiezaSeccionATratamientos(5, piezaDiente);
                        }else{
                            agregarPiezaSeccionATratamientos(6, piezaDiente);
                        }
                    });
                }
            }
        }

        function accionModificar(){
            nroTratamientos = <?php echo json_encode($nroTratamientos); ?>;
            tratamientos = <?php echo json_encode($tratamientos); ?>;
            mostrarTablaHeaderMonto();
            ocultarBotones();
            $('#descuento').attr("disabled", true);
            $('#cerrar').show();
        }
        function main(){
            idDoctor = <?php echo json_encode($idDoctor); ?>;
            idPaciente = <?php echo json_encode($idPaciente); ?>;
            nroPresupuesto = <?php echo json_encode($nroPresupuesto); ?>;
            fechahora = <?php echo json_encode($fechahora); ?>;
            modificar = <?php echo json_encode($modificar); ?>;

        /* Es nuevo o detalle */
            if( modificar == 1 ){
                accionModificar();
            }else{
                //$('#cerrar').hide();
                $('#imprimir').hide();
            }

        /* Revisar Resinas */
            revisarResinasEnDientes(11, 18); //BLOQUE 01
            revisarResinasEnDientes(21, 28); //BLOQUE 02
            revisarResinasEnDientes(51, 55); //BLOQUE 03
            revisarResinasEnDientes(61, 65); //BLOQUE 04
            revisarResinasEnDientes(81, 85); //BLOQUE 01
            revisarResinasEnDientes(71, 75); //BLOQUE 02
            revisarResinasEnDientes(41, 48); //BLOQUE 03
            revisarResinasEnDientes(31, 38); //BLOQUE 04

        /* Mostrar tratamientos en tabla, calcular montos, pintar por secciones */
            restartMain();
        }

    });

    function printElement(elem, append, delimiter) {
            var domClone = elem.cloneNode(true);

            var $printSection = document.getElementById("printSection");
            if (!$printSection) {
                $printSection = document.createElement("div");
                $printSection.id = "printSection";
                document.body.appendChild($printSection);
            }

            if (append !== true) {
                $printSection.innerHTML = "";
            }

            else if (append === true) {
                if (typeof (delimiter) === "string") {
                    $printSection.innerHTML += delimiter;
                }
                else if (typeof (delimiter) === "object") {
                    $printSection.appendChlid(delimiter);
                }
            }

            $printSection.appendChild(domClone);
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

</script>
