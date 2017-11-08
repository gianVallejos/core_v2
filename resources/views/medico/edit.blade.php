@extends('layouts.default')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <!-- <div class="alert alert-success text-center">
                    Nuevo paciente agregado correctamente.
                </div> -->

                <div class="panel panel-default">
                    <div class="panel-heading text-center title">MODIFICAR DOCTOR</div>
                    <div class="panel-body">

                        <form class="form-horizontal" action="/core_v2/medicos/{{ $medico->id }}" method="POST">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label for="nombres" class="col-md-1 col-xs-1 control-label">Nombres</label>
                                <div class="col-md-5 col-xs-5">
                                    <input id="nombres" type="text" class="form-control" name="nombres"
                                           value="{{ $medico->nombres }}" placeholder="Nombres" required autofocus>

                                    @if ($errors->has('nombres'))
                                        <span class="help-block">
                                      <strong>{{ $errors->first('nombres')}}</strong>
                                  </span>
                                    @endif

                                </div>

                                <label for="apellidos" class="col-md-1 col-xs-1 control-label">Apellidos</label>
                                <div class="col-md-5 col-xs-5">
                                    <input id="apellidos" type="text" class="form-control" name="apellidos"
                                           value="{{ $medico->apellidos }}" placeholder="Apellidos" required autofocus>

                                    @if ($errors->has('apellidos'))
                                        <span class="help-block">
                                      <strong>{{ $errors->first('apellidos')}}</strong>
                                  </span>
                                    @endif

                                </div>

                            </div>

                            <div class="form-group">

                                <label for="dni" class="col-md-1 col-xs-1 control-label">DNI</label>
                                <div class="col-md-2 col-xs-2">
                                    <input id="dni" type="text" class="form-control" name="dni"
                                           value="{{ $medico->dni }}" placeholder="DNI" minlength="8" maxlength="8"
                                           required autofocus>

                                    @if ($errors->has('dni'))
                                        <span class="help-block">
                                      <strong>{{ $errors->first('dni')}}</strong>
                                  </span>
                                    @endif

                                </div>

                                <label for="email" class="col-md-1 col-xs-1 control-label">Email</label>
                                <div class="col-md-4 col-xs-3">
                                    <input id="email" type="text" class="form-control" name="email"
                                           value="{{ $medico->email }}" placeholder="E-mail">

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                      <strong>{{ $errors->first('email')}}</strong>
                                  </span>
                                    @endif

                                </div>

                                <label for="direccion" class="col-md-1 col-xs-2 control-label">Dirección</label>
                                <div class="col-md-3 col-xs-3">
                                    <input id="direccion" type="text" class="form-control" name="direccion"
                                           value="{{ $medico->direccion }}" placeholder="Dirección" required autofocus>

                                    @if ($errors->has('direccion'))
                                        <span class="help-block">
                                      <strong>{{ $errors->first('direccion')}}</strong>
                                  </span>
                                    @endif

                                </div>

                            </div>

                            <div class="form-group">

                                <label for="genero" class="col-md-1 col-xs-1 control-label">Género</label>
                                <div class="col-md-3 col-xs-2">
                                    <?php
                                    $genero = array('Masculino', 'Femenino');
                                    ?>
                                    <select name="genero" id="genero" class="form-control">
                                        <?php           foreach($genero as $gr){                          ?>
                                        <option value="{{ $gr }}" {{ $medico->genero == $gr ? 'selected="selected"' : '' }} > {{ $gr }}</option>
                                        <?php           }                                                 ?>
                                    </select>

                                </div>

                                <label for="estado" class="col-md-1 col-xs-1 control-label">E. Civil</label>
                                <div class="col-md-3 col-xs-3">
                                    <?php
                                    $estado = array('Soltero', 'Casado', 'Viudo', 'Divorciado');
                                    ?>
                                    <select name="estado" id="estado" class="form-control">
                                        <?php           foreach($estado as $stdo){                          ?>
                                        <option value="{{ $stdo }}" {{ $medico->estado == $stdo ? 'selected="selected"' : '' }} > {{ $stdo }}</option>
                                        <?php           }                                                 ?>
                                    </select>

                                </div>

                                <label for="margen_ganancia" class="col-md-2 col-xs-2 control-label">Margen de
                                    Ganancia</label>
                                <div class="col-md-2 col-xs-2">
                                    <input id="margen_ganancia" type="number" min="0" max="100" class="form-control"
                                           name="margen_ganancia" value="{{ $medico->margen_ganancia }}"
                                           placeholder="Margen (%)"
                                           @if(Auth::user()->rolid != 1) disabled  @endif>

                                    @if ($errors->has('margen_ganancia'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('margen_ganancia')}}</strong>
                                    </span>
                                    @endif

                                </div>

                            </div>

                            <div class="form-group">

                                <label for="fechanacimiento" class="col-md-1 col-xs-1 control-label">Nacimiento</label>
                                <div class="col-md-2 col-xs-2">
                                    <input id="fechanacimiento" type="date" class="form-control" name="fechanacimiento"
                                           value="{{ $medico->fechanacimiento }}" required autofocus>

                                    @if ($errors->has('fechanacimiento'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('fechanacimiento')}}</strong>
                                </span>
                                    @endif

                                </div>

                                <label for="telefono" class="col-md-1 col-xs-1 control-label">Teléfono</label>
                                <div class="col-md-2 col-xs-2">
                                    <input id="telefono" type="text" class="form-control" name="telefono"
                                           value="{{ $medico->telefono }}" placeholder="Teléfono">

                                    @if ($errors->has('telefono'))
                                        <span class="help-block">
                                      <strong>{{ $errors->first('telefono')}}</strong>
                                  </span>
                                    @endif

                                </div>

                                <label for="celular" class="col-md-1 col-xs-1 control-label">Celular</label>
                                <div class="col-md-2 col-xs-2">
                                    <input id="celular" type="text" class="form-control" name="celular"
                                           value="{{ $medico->celular }}" placeholder="Número de Celular">

                                    @if ($errors->has('celular'))
                                        <span class="help-block">
                                      <strong>{{ $errors->first('celular')}}</strong>
                                  </span>
                                    @endif

                                </div>

                                <label for="celular_aux" class="col-md-1 col-xs-1 control-label">Celular 2</label>
                                <div class="col-md-2 col-xs-2">
                                    <input id="celular_aux" type="text" class="form-control" name="celular_aux"
                                           value="{{ $medico->celular_aux }}" placeholder="Número de Celular">

                                    @if ($errors->has('celular_aux'))
                                        <span class="help-block">
                                      <strong>{{ $errors->first('celular_aux')}}</strong>
                                  </span>
                                    @endif

                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12 text-center" style="padding-top: 25px;">
                                    <button type="submit" class="btn-core">
                                        Modificar
                                    </button>
                                    <a href="/core_v2/medicos" type="button" class="btn-core">
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
