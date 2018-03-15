@extends('layouts.default')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading text-center title">EDITAR PACIENTE</div>
                <div class="panel-body" >

                    <form class="form-horizontal" action="/core_v2/ingresos/{{ $ingresos->id }}" method="POST">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-1 col-xs-4">
                              <label for="paciente_id" class="control-label">Paciente</label>
                              <input type="hidden" name="paciente_id" id="paciente_id" value="{{ $paciente[0]->id }}">
                              <input name="paciente_nombre" id="paciente_nombre" class="form-control" value="{{ $paciente[0]->nombres }} {{ $paciente[0]->apellidos }}" disabled>

                                @if ($errors->has('paciente_id'))
                                    <span class="help-block">
                                  <strong>{{ $errors->first('paciente_id')}}</strong>
                              </span>
                                @endif

                            </div>

                            <div class="col-md-4 col-xs-4">
                                <label for="doctor_id" class="control-label">Doctor</label>
                                <select name="doctor_id" id="doctor_id" class="form-control">
                                    @foreach( $medicos as $stdo )
                                        <option value="{{ $stdo->id }}" {{ $ingresos->idMedico == $stdo->id ? 'selected="selected"' : '' }}>{{ $stdo->apellidos }} {{ $stdo->nombres }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('doctor_id'))
                                    <span class="help-block">
                                  <strong>{{ $errors->first('doctor_id')}}</strong>
                              </span>
                                @endif

                            </div>

                            <div class="col-md-2 col-xs-2">
                                <label for="fecha" class="control-label">Fecha</label>
                                <input type="date" id="fecha" name="fecha" class="form-control" value="{{ $ingresos->fecha }}" required>

                                @if ($errors->has('fecha'))
                                    <span class="help-block">
                                  <strong>{{ $errors->first('fecha')}}</strong>
                              </span>
                                @endif

                            </div>

                        </div>

                        <div class="form-group">

                            <div class="col-md-5 col-md-offset-1 col-xs-5">
                                <label for="tratamiento" class="control-label">Tratamiento</label>
                                <input id="tratamiento" type="text" class="form-control" name="tratamiento"
                                       value="{{ $ingresos->tratamiento }}" placeholder="Tratamiento" readonly>

                                @if ($errors->has('tratamiento'))
                                    <span class="help-block">
                                  <strong>{{ $errors->first('tratamiento')}}</strong>
                              </span>
                                @endif

                            </div>

                            <div class="col-md-1 col-xs-1">
                                <label for="cantidad" class="control-label">Cantidad</label>
                                <input id="cantidad" type="number" class="form-control" name="cantidad"
                                       value="{{ $ingresos->cantidad }}" placeholder="Cantidad" min="1" step="1" required>

                                @if ($errors->has('cantidad'))
                                    <span class="help-block">
                                  <strong>{{ $errors->first('cantidad')}}</strong>
                              </span>
                                @endif

                            </div>

                            <div class="col-md-2 col-xs-2">
                                <label for="monto" class="control-label">Monto</label>
                                <input id="monto" type="number" class="form-control" name="monto"
                                       value="{{ $ingresos->monto }}" placeholder="Monto" min="0" step=".1" readonly>

                                @if ($errors->has('monto'))
                                    <span class="help-block">
                                  <strong>{{ $errors->first('monto')}}</strong>
                              </span>
                                @endif

                            </div>

                            <div class="col-md-2 col-xs-2">
                                <label for="total" class="control-label">Total</label>
                                <input id="total" type="number" class="form-control" name="total"
                                       placeholder="Total" min="0" step=".1" readonly>

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
                                    Editar
                                </button>
                                <a href="/core_v2/ingresos" class="btn-core">

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
