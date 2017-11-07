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
                            <label for="paciente_id" class="col-md-1 col-xs-1 col-md-offset-1 control-label">Paciente</label>
                            <div class="col-md-4 col-xs-5">
                                <select name="paciente_id" id="paciente_id" class="form-control">
                                    @foreach( $pacientes as $stdo )
                                        <option value="{{ $stdo->id }}" {{ $ingresos->idPaciente == $stdo->id ? 'selected="selected"' : '' }} > {{ $stdo->apellidos }} {{ $stdo->nombres }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('paciente_id'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('paciente_id')}}</strong>
                                  </span>
                                @endif

                            </div>

                            <label for="doctor_id" class="col-md-1 col-xs-1 control-label">Doctor</label>
                            <div class="col-md-4 col-xs-5">
                                <select name="doctor_id" id="doctor_id" class="form-control">
                                    @foreach( $medicos as $stdo )
                                        <option value="{{ $stdo->id }}" {{ $ingresos->idMedico == $stdo->id ? 'selected="selected"' : '' }} >{{ $stdo->apellidos }} {{ $stdo->nombres }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('doctor_id'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('doctor_id')}}</strong>
                                  </span>
                                @endif

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="descripcion" class="col-md-1 col-xs-1 col-md-offset-1 control-label">Descripción</label>
                            <div class="col-md-6 col-xs-8">
                                <input id="descripcion" type="text" class="form-control" name="descripcion" value="{{ $ingresos->descripcion }}" placeholder="Descripcion">

                                @if ($errors->has('descripcion'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('descripcion')}}</strong>
                                  </span>
                                @endif

                            </div>


                            <label for="monto" class="col-md-1 col-xs-1 control-label">Monto</label>
                            <div class="col-md-2 col-xs-2">
                                <input id="monto" type="number" class="form-control" name="monto" value="{{ $ingresos->monto }}" placeholder="Monto" min="0" step=".1" required>

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
                                <a href="/core_v2/ingresos">
                                   <button type="submit" class="btn-core">
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
