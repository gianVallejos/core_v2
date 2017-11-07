@extends('layouts.default')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">

          <!-- <div class="alert alert-success text-center">
              Nuevo paciente agregado correctamente.
          </div> -->

            <div class="panel panel-default">
                <div class="panel-heading text-center title">EDITAR PACIENTE</div>
                <div class="panel-body" >

                    <form class="form-horizontal" action="/core_v2/pacientes/{{ $paciente->id }}" method="POST">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label for="nombres" class="col-md-1 col-xs-1 control-label">Nombres</label>
                            <div class="col-md-4 col-xs-3">
                                <input id="nombres" type="text" class="form-control" name="nombres" value="{{ $paciente->nombres }}" placeholder="Nombres" required autofocus>

                                @if ($errors->has('nombres'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('nombres')}}</strong>
                                  </span>
                                @endif

                            </div>

                            <label for="apellidos" class="col-md-1 col-xs-2 control-label">Apellidos</label>
                            <div class="col-md-3 col-xs-3">
                                <input id="apellidos" type="text" class="form-control" name="apellidos" value="{{ $paciente->apellidos }}" placeholder="Apellidos" required autofocus>

                                @if ($errors->has('apellidos'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('apellidos')}}</strong>
                                  </span>
                                @endif

                            </div>

                            <label for="dni" class="col-md-1 col-xs-1 control-label">DNI</label>
                            <div class="col-md-2 col-xs-2">
                                <input id="dni" type="text" class="form-control" name="dni" value="{{ $paciente->dni }}" placeholder="DNI" minlength="8" maxlength="8">

                                @if ($errors->has('dni'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('dni')}}</strong>
                                  </span>
                                @endif

                            </div>

                        </div>

                        <div class="form-group">
                            <label for="email" class="col-md-1 col-xs-1 control-label">Email</label>
                            <div class="col-md-4 col-xs-3">
                                <input id="email" type="text" class="form-control" name="email" value="{{ $paciente->email }}" placeholder="E-mail">

                                @if ($errors->has('email'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('email')}}</strong>
                                  </span>
                                @endif

                            </div>

                            <label for="direccion" class="col-md-1 col-xs-2 control-label">Dirección</label>
                            <div class="col-md-3 col-xs-3">
                                <input id="direccion" type="text" class="form-control" name="direccion" value="{{ $paciente->direccion }}" placeholder="Dirección" required autofocus>

                                @if ($errors->has('direccion'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('direccion')}}</strong>
                                  </span>
                                @endif

                            </div>

                            <label for="fechanacimiento" class="col-md-1 col-xs-1 control-label">Nacimiento</label>
                            <div class="col-md-2 col-xs-2">
                                <input id="fechanacimiento" type="date" class="form-control" name="fechanacimiento" value="{{ $paciente->fechanacimiento }}" required autofocus>

                                @if ($errors->has('fechanacimiento'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('fechanacimiento')}}</strong>
                                  </span>
                                @endif

                            </div>
                        </div>

                        <div class="form-group">

                            <label for="genero" class="col-md-1 col-xs-1 control-label">Género</label>
                            <div class="col-md-2 col-xs-2">
                            <?php
                                $genero = array('Masculino', 'Femenino');
                            ?>
                                <select name="genero" id="genero" class="form-control">
                    <?php           foreach($genero as $gr){                          ?>
                                        <option value="{{ $gr }}"  {{ $paciente->genero == $gr ? 'selected="selected"' : '' }} > {{ $gr }}</option>
                    <?php           }                                                 ?>
                                </select>

                            </div>

                            <label for="estado" class="col-md-1 col-xs-1 control-label">E. Civil</label>
                            <div class="col-md-2 col-xs-2">
                    <?php
                                $estado = array('Soltero', 'Casado', 'Viudo', 'Divorciado');
                    ?>
                                <select name="estado" id="estado" class="form-control">
                                  @foreach($estado as $stdo)
                                      <option value="{{ $stdo }}" {{ $paciente->estado == $stdo ? 'selected="selected"' : '' }} > {{ $stdo }}</option>
                                  @endforeach
                                </select>

                            </div>

                            <label for="empresa_id" class="col-md-1 col-xs-1 control-label">Empresa</label>
                            <div class="col-md-2 col-xs-2">
                                <select name="empresa_id" id="empresa_id" class="form-control">
                                    @foreach( $empresas as $stdo )
                                        <option value="{{ $stdo->id }}" {{ $paciente->empresa_id == $stdo->nombre ? 'selected="selected"' : '' }} >{{ $stdo->nombre }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('empresa_id'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('empresa_id')}}</strong>
                                  </span>
                                @endif
                            </div>

                            <label for="seguro_ind" class="col-md-1 col-xs-1 control-label">Tipo</label>
                            <div class="col-md-2 col-xs-2">
                              <?php
                                          $seguro = array('Ninguno', 'Trabajador', 'Hijo/Hija', 'Padre');
                                          $ind = 0;
                              ?>
                                          <select name="seguro_ind" id="seguro_ind" class="form-control">
                                              @foreach($seguro as $stdo)
                                                  <option value="{{ $ind }}"  {{ $paciente->seguro_ind == $ind ? 'selected="selected"' : '' }} > {{ $stdo }}</option>
                                                  {{ $ind++ }}
                                              @endforeach
                                          </select>

                                @if ($errors->has('seguro_ind'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('seguro_ind')}}</strong>
                                  </span>
                                @endif

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="telefono" class="col-md-1 col-xs-1 control-label">Teléfono</label>
                            <div class="col-md-2 col-xs-2">
                                <input id="telefono" type="text" class="form-control" name="telefono" value="{{ $paciente->telefono }}" placeholder="Teléfono" >

                                @if ($errors->has('telefono'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('telefono')}}</strong>
                                  </span>
                                @endif

                            </div>

                            <label for="fax" class="col-md-1 col-xs-1 control-label">Fax</label>
                            <div class="col-md-2 col-xs-2">
                                <input id="fax" type="text" class="form-control" name="fax" value="{{ $paciente->fax }}" placeholder="Fax"  >

                                @if ($errors->has('fax'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('fax')}}</strong>
                                  </span>
                                @endif

                            </div>

                            <label for="celular" class="col-md-1 col-xs-1 control-label">Celular</label>
                            <div class="col-md-2 col-xs-2">
                                <input id="celular" type="text" class="form-control" name="celular" value="{{ $paciente->celular }}" placeholder="Número de Celular"  >

                                @if ($errors->has('celular'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('celular')}}</strong>
                                  </span>
                                @endif

                            </div>

                            <label for="celular_aux" class="col-md-1 col-xs-1 control-label">Celular 2</label>
                            <div class="col-md-2 col-xs-2">
                                <input id="celular_aux" type="text" class="form-control" name="celular_aux" value="{{ $paciente->celular_aux }}" placeholder="Número de Celular"  >

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
                                    Editar
                                </button>
                                <a href="/core_v2/pacientes">
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
