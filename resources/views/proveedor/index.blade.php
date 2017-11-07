@extends('layouts.default')

@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading text-center title">AGREGAR PROVEEDOR - LABORATORIO</div>
                <div class="panel-body" >
                  <form class="form-horizontal" action="/core_v2/proveedors" method="POST">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">

                      <div class="form-group">
                          <label for="nombres" class="col-md-1 col-xs-1 control-label">Nombres</label>
                          <div class="col-md-5 col-xs-5">
                              <input id="nombres" type="text" class="form-control" name="nombres" value="{{ old('nombres')}}" placeholder="Nombres" required autofocus>

                              @if ($errors->has('nombres'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nombres')}}</strong>
                                </span>
                              @endif

                          </div>

                          <label for="email" class="col-md-1 col-xs-1 control-label">Email</label>
                          <div class="col-md-5 col-xs-5">
                              <input id="email" type="text" class="form-control" name="email" value="{{ old('email')}}" placeholder="E-mail">

                              @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email')}}</strong>
                                </span>
                              @endif

                          </div>
                      </div>

                      <div class="form-group">

                          <label for="direccion" class="col-md-1 col-xs-1 control-label">Dirección</label>
                          <div class="col-md-5 col-xs-5">
                              <input id="direccion" type="text" class="form-control" name="direccion" value="{{ old('direccion')}}" placeholder="Dirección" autofocus>

                              @if ($errors->has('direccion'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('direccion')}}</strong>
                                </span>
                              @endif

                          </div>

                          <label for="dni" class="col-md-1 col-xs-1 control-label">DNI</label>
                          <div class="col-md-2 col-xs-2">
                              <input id="dni" type="text" class="form-control" name="dni" value="{{ old('dni')}}" placeholder="DNI" minlength="8" maxlength="8">

                              @if ($errors->has('dni'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('dni')}}</strong>
                                </span>
                              @endif

                          </div>

                          <label for="ruc" class="col-md-1 col-xs-1 control-label">RUC</label>
                          <div class="col-md-2 col-xs-2">
                              <input id="ruc" type="text" class="form-control" name="ruc" value="{{ old('ruc')}}" placeholder="RUC" minlength="11" maxlength="11">

                              @if ($errors->has('ruc'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('ruc')}}</strong>
                                </span>
                              @endif

                          </div>

                      </div>

                      <div class="form-group">

                          <label for="telefono" class="col-md-1 col-xs-1 control-label">Teléfono</label>
                          <div class="col-md-2 col-xs-2">
                              <input id="telefono" type="text" class="form-control" placeholder="Teléfono" name="telefono" value="{{ old('telefono')}}" autofocus>

                              @if ($errors->has('telefono'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('telefono')}}</strong>
                                </span>
                              @endif

                          </div>

                          <label for="celular" class="col-md-1 col-xs-1 control-label">Celular</label>
                          <div class="col-md-2 col-xs-2">
                              <input id="celular" type="text" class="form-control" placeholder="Celular" name="celular" value="{{ old('celular')}}" autofocus>

                              @if ($errors->has('celular'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('celular')}}</strong>
                                </span>
                              @endif

                          </div>

                          <label for="insumo_id" class="col-md-1 col-xs-1 control-label">Insumos</label>
                          <div class="col-md-2 col-xs-2">
                              <select name="insumo_id" id="insumo_id" class="form-control">
                              <?php
                                  $insumos = array('Materiales', 'Equipos', 'Instrumentos', 'Otros');
                                  $ind = 0;
                               ?>
                                  @foreach( $insumos as $ins )
                                      <option value="{{ $ind++ }}"  @if(old('insumo_id') == '{{ $ins }}')selected @endif>{{ $ins }}</option>
                                  @endforeach
                              </select>

                              @if ($errors->has('insumo_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('insumo_id')}}</strong>
                                </span>
                              @endif
                          </div>

                          <label for="tipo_id" class="col-md-1 col-xs-1 control-label">Tipo</label>
                          <div class="col-md-2 col-xs-2">
                              <select name="tipo_id" id="tipo_id" class="form-control">
                              <?php
                                  $tipo = array('Proveedor', 'Laboratorio', 'Otros'); //0: Proveedor, 1: Laboratorio
                                  $ind = 0;
                               ?>
                                  @foreach( $tipo as $tip )
                                      <option value="{{ $ind++ }}"  @if(old('tipo_id') == '{{ $tip }}')selected @endif>{{ $tip }}</option>
                                  @endforeach
                              </select>

                              @if ($errors->has('tipo_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('tipo_id')}}</strong>
                                </span>
                              @endif
                          </div>

                      </div>

                      <div class="form-group">
                        <label for="banco" class="col-md-1 col-xs-1 control-label">Banco</label>
                        <div class="col-md-4 col-xs-4">
                            <input id="banco" type="text" class="form-control" placeholder="Banco" name="banco" value="{{ old('banco')}}" autofocus>

                            @if ($errors->has('banco'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('banco')}}</strong>
                              </span>
                            @endif

                        </div>

                        <label for="nrocuenta" class="col-md-2 col-xs-2 control-label">Nro de Cuenta</label>
                        <div class="col-md-5 col-xs-5">
                            <input id="nrocuenta" type="text" class="form-control" placeholder="Número de Cuenta" name="nrocuenta" value="{{ old('nrocuenta')}}" autofocus>

                            @if ($errors->has('nrocuenta'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('nrocuenta')}}</strong>
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


@if( $numProveedores != 0 )
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading text-center title">PROVEEDORES - LABORATORIOS</div>
                <div class="panel-body" style="padding-bottom: 60px;">

                  <input type="text" class="form-control" id="myInput" onkeyup="buscarProveedor()" placeholder=" Buscar por Nombres y Apellidos"><br>

                  <div id="table-wrapper">
                      <div id="table-scroll" style="height: 50vh;">
                        <table id="tablaProveedor" class="table table-responsive table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Nombres</th>
                                    <th class="text-center">Empresa</th>
                                    <th class="text-center">Ciudad</th>
                                    <th class="text-center">Insumo</th>
                                    <th class="text-center">Tipo</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach( $proveedor as $row )
                                  <tr>
                                    <td class="text-center">{{ $row->id }}</td>
                                    <td class="text-center">{{ $row->nombres }}</td>
                                    <td class="text-center">{{ $row->empresa }}</td>
                                    <td class="text-center">{{ $row->ciudad }}</td>
                                    <td class="text-center">{{ $insumos[$row->insumo_id] }}</td>
                                    <td class="text-center">{{ $tipo[$row->tipo_id] }}</td>
                                    <td class="text-center"><button class="btn btn-xs btn-info" onclick="mostrarInfo('{{ $row->id }}', '{{ $row->nombres }}')" data-toggle="modal" data-target="#modal-info">Info</button></td>
                                    <td class="text-center"><button class="btn btn-xs btn-success" onclick="mostrarDetalle('{{ json_encode($proveedor[$i]) }}')" data-toggle="modal" data-target="#myModal">Detalle</button></td>
                                    <td class="text-center"><a href="{{ route('proveedors.edit', $row->id) }}" class="btn btn-xs btn-warning">Editar</a></td>
                                    <td class="text-center">
                                      <form action="{{ route('proveedors.destroy', $row->id) }}" method="post">
                                          <input type="hidden" name="_method" value="DELETE">
                                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                          <button type="submit" class="btn btn-xs btn-danger">Eliminar</button>
                                      </form>
                                    </td>
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
    </div>
</div>

<!-- Modal Detalle Info -->
<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title text-center"><b>Información de Proveedor - Laboratorio</b></h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <label for="email-txt" class="col-md-2 col-md-offset-1 control-label">E-mail:</label>
          <div id="email-txt" class="col-md-4"></div>
        </div>

        <div class="row">
          <label for="direccion-txt" class="col-md-2 col-md-offset-1 control-label">Dirección:</label>
          <div id="direccion-txt" class="col-md-9"></div>
        </div>

        <div class="row">
          <label for="dni-txt" class="col-md-2 col-md-offset-1 control-label">DNI:</label>
          <div id="dni-txt" class="col-md-3"></div>

          <label for="ruc-txt" class="col-md-2 control-label">RUC:</label>
          <div id="ruc-txt" class="col-md-3"></div>
        </div>

        <div class="row">
          <label for="telefono-txt" class="col-md-2 col-md-offset-1 control-label">Teléfono:</label>
          <div id="telefono-txt" class="col-md-3"></div>

          <label for="celular-txt" class="col-md-2 control-label">Celular:</label>
          <div id="celular-txt" class="col-md-2"></div>
        </div>

        <div class="row">
          <label for="banco-txt" class="col-md-2 col-md-offset-1 control-label">Banco:</label>
          <div id="banco-txt" class="col-md-9"></div>
        </div>

        <div class="row">
          <label for="nrocta-txt" class="col-md-3 col-md-offset-1 control-label">Nro Cuenta:</label>
          <div id="nrocta-txt" class="col-md-8"></div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

  <!-- Modal Info -->
  <div class="modal fade" id="modal-info" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <center><h4><b>AGREGAR DETALLE PROVEEDOR</b></h4></center>
        </div>
        <div class="modal-body" style="padding-top: 60px;">
              <!-- <h4 class="modal-title text-center" style="display: inline-block; width: 100%;"><b>Proveedor-Lab: </b><div id="title-info" style="display: inline-block;"></div></h4> -->

              <form id="form-detalle-proveedor" class="form-horizontal" method="post">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <input id="id-info" type="hidden" class="form-control" name="id-info" disabled>

                  <div class="form-group">
                      <label for="title-info" class="col-md-1 col-xs-2 col-md-offset-2 control-label">Nombre</label>
                      <div class="col-md-7 col-xs-10">
                          <input id="title-info" type="text" class="form-control" name="nombre"  placeholder="Nombre" required autofocus disabled>

                          @if ($errors->has('nombre'))
                            <span class="help-block">
                                <strong>{{ $errors->first('nombre')}}</strong>
                            </span>
                          @endif

                      </div>
                  </div>

                  <div class="form-group">
                      <label for="detalles" class="col-md-1 col-xs-2 col-md-offset-2 control-label">Detalles</label>
                      <div class="col-md-7 col-xs-10">
                          <input id="detalles" type="text" class="form-control" name="detalles" value="{{ old('detalles')}}" placeholder="Detalles" required autofocus>

                          @if ($errors->has('detalles'))
                            <span class="help-block">
                                <strong>{{ $errors->first('detalles')}}</strong>
                            </span>
                          @endif

                      </div>
                  </div>

                  <div class="form-group">
                      <label for="monto" class="col-md-1 col-xs-2 col-md-offset-2 control-label">Monto</label>
                      <div class="col-md-7 col-xs-10">
                          <input id="monto" type="text" class="form-control" name="monto" value="{{ old('monto')}}" placeholder="Monto">

                          @if ($errors->has('monto'))
                            <span class="help-block">
                                <strong>{{ $errors->first('monto')}}</strong>
                            </span>
                          @endif

                      </div>
                  </div>

                  <div class="form-group">
                      <div class="col-md-12 text-center" style="padding-top: 25px;">
                          <button id="btn-agregar-detalle-proveedor" type="submit" class="btn-core">
                              Agregar
                          </button>
                      </div>
                  </div>

              </form>

              <!-- <hr> -->

              <!--  Table -->
              <table id="tablaDetalleProveedor" class="table table-responsive table-hover" style="margin-top: 45px; margin-bottom: 45px;">
                  <thead>

                  </thead>
                  <tbody>

                  </tbody>
                </table>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
@endif

<!-- <script type="text/javascript">

</script> -->

@endsection
