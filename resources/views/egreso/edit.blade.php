@extends('layouts.default')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading text-center title">EDITAR PACIENTE</div>
                <div class="panel-body" >

                  <form class="form-horizontal" name="myForm" action="/core_v2/egresos/{{ $egresos->id }}" method="POST">
                      <input type="hidden" name="_method" value="PUT">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">

                      <div class="form-group">

                          <div class="col-md-1 col-md-offset-1 col-xs-2">
                              <label for="cantidad" class="control-label">Cantidad</label>
                              <input id="cantidad" type="number" class="form-control" name="cantidad"
                                     value="{{ $egresos->cantidad }}" placeholder="Cantidad" min="1" step="1" onkeyup="calcPrecioTotal()" required>

                              @if ($errors->has('cantidad'))
                                  <span class="help-block">
                                <strong>{{ $errors->first('cantidad')}}</strong>
                            </span>
                              @endif
                          </div>


                          <div class="col-md-5 col-xs-5">
                              <label for="concepto" class="control-label">Concepto</label>
                              <input value="{{ $egresos->concepto }}" name="concepto" id="concepto" class="form-control" placeholder="Concepto" required>

                              @if ($errors->has('concepto'))
                                  <span class="help-block">
                                <strong>{{ $errors->first('concepto')}}</strong>
                            </span>
                              @endif
                          </div>

                          <div class="col-md-2 col-xs-2">
                              <label for="precio_unitario" class="control-label">Precio Unit.</label>
                              <input type="number" min="0" step=".1" name="precio_unitario" id="precio_unitario"
                                     value="{{ $egresos->precio_unitario }}" class="form-control" placeholder="Precio Unit." onkeyup="calcPrecioTotal()" required>

                              @if ($errors->has('precio_unitario'))
                                  <span class="help-block">
                                <strong>{{ $errors->first('precio_unitario')}}</strong>
                            </span>
                              @endif

                          </div>

                          <div class="col-md-2 col-xs-2">
                              <label for="precio_total" class="control-label">Precio Total</label>
                              <input name="precio_total" id="precio_total" class="form-control" value="{{ $egresos->cantidad * $egresos->precio_unitario }}" placeholder="Precio Total" disabled>

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
                              <input type="date" id="fecha" name="fecha" value="{{ $egresos->fecha }}" class="form-control" required>

                              @if ($errors->has('fecha'))
                              <span class="help-block">
                                <strong>{{ $errors->first('fecha')}}</strong>
                              </span>
                              @endif

                          </div>
                          <div class="col-md-7 col-xs-7">
                              <label for="observacion" class="control-label">Observación</label>
                              <input name="observacion" id="observacion" value="{{ $egresos->observacion }}" class="form-control" placeholder="Observación" />

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
                                  Editar
                              </button>
                              <a href="/core_v2/egresos" class="btn-core">
                                  Cancelar
                              </a>
                          </div>
                      </div>

                  </form>


                </div>
            </div>

          </div>
      </div>
</div>

@endsection
