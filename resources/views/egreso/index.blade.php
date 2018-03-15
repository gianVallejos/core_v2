@extends('layouts.default')

@section('content')

    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">

                <div class="panel panel-default">
                    <div class="panel-heading text-center title">AGREGAR EGRESO</div>
                    <div class="panel-body">

                        <form class="form-horizontal" name="myForm" action="/core_v2/egresos" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">

                                <div class="col-md-1 col-md-offset-1 col-xs-2">
                                    <label for="cantidad" class="control-label">Cantidad</label>
                                    <input id="cantidad" type="number" class="form-control" name="cantidad"
                                           value="1" placeholder="Cantidad" min="1" step="1" onkeyup="calcPrecioTotal()" required>

                                    @if ($errors->has('cantidad'))
                                        <span class="help-block">
                                      <strong>{{ $errors->first('cantidad')}}</strong>
                                  </span>
                                    @endif
                                </div>


                                <div class="col-md-5 col-xs-5">
                                    <label for="concepto" class="control-label">Concepto</label>
                                    <input name="concepto" id="concepto" class="form-control" placeholder="Concepto" required>

                                    @if ($errors->has('concepto'))
                                        <span class="help-block">
                                      <strong>{{ $errors->first('concepto')}}</strong>
                                  </span>
                                    @endif
                                </div>

                                <div class="col-md-2 col-xs-2">
                                    <label for="precio_unitario" class="control-label">Precio Unit.</label>
                                    <input type="number" min="0" step=".1" name="precio_unitario" id="precio_unitario"
                                           value="0" class="form-control" placeholder="Precio Unit." onkeyup="calcPrecioTotal()" required>

                                    @if ($errors->has('precio_unitario'))
                                        <span class="help-block">
                                      <strong>{{ $errors->first('precio_unitario')}}</strong>
                                  </span>
                                    @endif

                                </div>

                                <div class="col-md-2 col-xs-2">
                                    <label for="precio_total" class="control-label">Precio Total</label>
                                    <input name="precio_total" id="precio_total" class="form-control" value="0" placeholder="Precio Total" disabled>

                                    @if ($errors->has('precio_total'))
                                        <span class="help-block">
                                      <strong>{{ $errors->first('precio_total')}}</strong>
                                  </span>
                                    @endif

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-3 col-md-offset-1 col-xs-3">
                                    <label for="fecha" class="control-label">Fecha</label>
                                    <input type="date" id="fecha" name="fecha" value="<?php echo date('Y-m-d'); ?>" class="form-control" required>

                                    @if ($errors->has('fecha'))
                                    <span class="help-block">
                                      <strong>{{ $errors->first('fecha')}}</strong>
                                    </span>
                                    @endif

                                </div>
                                <div class="col-md-7 col-xs-7">
                                    <label for="observacion" class="control-label">Observación</label>
                                    <input name="observacion" id="observacion" class="form-control" placeholder="Observación" />

                                    @if ($errors->has('observacion'))
                                        <span class="help-block">
                                      <strong>{{ $errors->first('observacion')}}</strong>
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

    @if( $numEgresos != 0 )
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center title">EGRESOS</div>
                        <div class="panel-body" style="padding-bottom: 60px;">

                            <div class="search-wrapper text-center">
                                <div class="inline-search-box">
                                    <strong>BUSCAR:</strong>
                                </div>
                                <div class="inline-search-box text-center">
                                    <form id="form-buscar-egreso" method="get">
                                    <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
                                        <div class="inline-search-box">
                                            <input id="date_inicio" type="date" name="date_inicio" value=""
                                                   class="form-control">
                                        </div>
                                        <div class="inline-search-box">
                                            <input id="date_fin" type="date" name="date_fin" value=""
                                                   class="form-control">
                                        </div>
                                        <div class="inline-search-box">
                                            <button type="submit" name="button" class="btn-core">Buscar</button>
                                        </div>
                                        <div class="inline-search-box text-center">
                                            <button id="print-pagos" class="btn-core" type="button" name="button">Imprimir</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div id="table-wrapper">
                                <div id="table-scroll">
                                  <div id="print-egresos-div">
                                    <table id="tablaIngresos" class="table table-responsive table-hover">
                                        <thead>
                                          <tr>
                                              <th class="text-center col-md-2">Fecha</th>
                                              <th class="text-center col-md-1">Cantidad</th>
                                              <th class="text-center">Concepto</th>
                                              <th class="text-center col-md-1">Precio Unit.</th>
                                              <th class="text-center col-md-1">Precio Total</th>
                                              <th class="text-center col-md-2">Observación</th>
                                              <th class="text-center col-md-1"></th>
                                              <th class="text-center col-md-1"></th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                        <?php $i = 0; ?>
                                        <?php $mtotal = 0; ?>
                                        @foreach( $egresos as $row )
                                            <tr>
                                                <!-- <td scope="row" class="text-center">{{ $i + 1 }}</td> -->
                                                <td class="text-center">{{ $row->fecha }}</td>
                                                <td class="text-center">{{ $row->cantidad }}</td>
                                                <td class="text-center">{{ $row->concepto }}</td>
                                                <td class="text-center">{{ $row->precio_unitario }}</td>
                                                <?php $montoTotal = ((float)$row->cantidad  * (float)$row->precio_unitario); ?>
                                                <td class="text-center">{{ $montoTotal }}</td>

                                                <td class="text-center">{{ $row->observacion }}</td>

                                                <td class="text-center print-ignore">
                                                    <a href="{{ route('egresos.edit', $row->id) }}"
                                                                           class="btn btn-xs btn-warning">Editar</a>
                                                </td>
                                                @if(Auth::user()->rolid == 1)
                                                    <td class="text-center print-ignore">
                                                        <form action="{{ route('egresos.destroy', $row->id) }}"
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
                                            <?php $mtotal += $montoTotal; ?>
                                            <?php $i++; ?>
                                        @endforeach
                                        </tbody>

                                    </table>

                                    </div>
                                </div>
                            </div>
                            <div class="row" style="padding-top: 19px; padding-right: 24px;">
                                <div class="col-md-7"></div>
                                <div class="col-md-2 print-ignore text-left">
                                  <label for="mtotal-footer">Total: </label><div id="mtotal-footer" class="inline"><?php echo '  S/' . $mtotal; ?></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endif

@endsection

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/printThis.js?v=1.0.0') }}"></script>
<script type="text/javascript">


  $(document).ready(function(){
      $('#print-pagos').click(function(){
          const $m_total = $('#mtotal-footer').text();

          $('#print-egresos-div').printThis({
              header: "<h3>Egresos CORE</h3><br><br><strong>Monto Total: </strong>"+ $m_total,
              loadCSS: "http://localhost/core_v2/css/print-report.css?v=1.0.3"
          });
      });
  });
</script>
