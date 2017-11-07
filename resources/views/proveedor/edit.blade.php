@extends('layouts.default')

@section('content')

<div class="container">
    <div class="row">

        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading text-center title">AGREGAR PROVEEDOR/LABORATORIO</div>
                <div class="panel-body" >
                  <form class="form-horizontal" action="/core_v2/proveedors/{{ $proveedor->id }}" method="POST">
                      <input type="hidden" name="_method" value="PUT">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">

                      <div class="form-group">
                          <label for="nombres" class="col-md-1 col-xs-1 control-label">Nombres</label>
                          <div class="col-md-5 col-xs-3">
                              <input id="nombres" type="text" class="form-control" name="nombres" value="{{ $proveedor->nombres }}" placeholder="Nombres" required autofocus>

                              @if ($errors->has('nombres'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nombres')}}</strong>
                                </span>
                              @endif

                          </div>

                          <label for="email" class="col-md-1 col-xs-1 control-label">Email</label>
                          <div class="col-md-5 col-xs-3">
                              <input id="email" type="text" class="form-control" name="email" value="{{ $proveedor->email }}" placeholder="E-mail">

                              @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email')}}</strong>
                                </span>
                              @endif

                          </div>
                      </div>

                      <div class="form-group">

                          <label for="direccion" class="col-md-1 col-xs-1 control-label">Dirección</label>
                          <div class="col-md-5 col-xs-3">
                              <input id="direccion" type="text" class="form-control" name="direccion" value="{{ $proveedor->direccion }}" placeholder="Dirección" autofocus>

                              @if ($errors->has('direccion'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('direccion')}}</strong>
                                </span>
                              @endif

                          </div>

                          <label for="dni" class="col-md-1 col-xs-1 control-label">DNI</label>
                          <div class="col-md-2 col-xs-2">
                              <input id="dni" type="text" class="form-control" name="dni" value="{{ $proveedor->dni }}" placeholder="DNI" minlength="8" maxlength="8">

                              @if ($errors->has('dni'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('dni')}}</strong>
                                </span>
                              @endif

                          </div>

                          <label for="ruc" class="col-md-1 col-xs-1 control-label">RUC</label>
                          <div class="col-md-2 col-xs-2">
                              <input id="ruc" type="text" class="form-control" name="ruc" value="{{ $proveedor->ruc }}" placeholder="RUC" minlength="11" maxlength="11">

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
                              <input id="telefono" type="text" class="form-control" placeholder="Teléfono" name="telefono" value="{{ $proveedor->telefono }}" autofocus>

                              @if ($errors->has('telefono'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('telefono')}}</strong>
                                </span>
                              @endif

                          </div>

                          <label for="celular" class="col-md-1 col-xs-1 control-label">Celular</label>
                          <div class="col-md-2 col-xs-2">
                              <input id="celular" type="text" class="form-control" placeholder="Celular" name="celular" value="{{ $proveedor->celular }}" autofocus>

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
                                      <option value="{{ $ind }}"  {{ $proveedor->insumo_id == $ind ? 'selected="selected"' : '' }} > {{ $ins }}</option>
                                      {{ $ind++ }}
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
                                      <option value="{{ $ind }}"  {{ $proveedor->tipo_id == $ind ? 'selected="selected"' : '' }} > {{ $tip }}</option>
                                      {{ $ind++ }}
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
                        <div class="col-md-4 col-xs-2">
                            <input id="banco" type="text" class="form-control" placeholder="Banco" name="banco" value="{{ $proveedor->banco }}" autofocus>

                            @if ($errors->has('banco'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('banco')}}</strong>
                              </span>
                            @endif

                        </div>

                        <label for="nrocuenta" class="col-md-2 col-xs-1 control-label">Nro de Cuenta</label>
                        <div class="col-md-5 col-xs-2">
                            <input id="nrocuenta" type="text" class="form-control" placeholder="Número de Cuenta" name="nrocuenta" value="{{ $proveedor->nrocuenta }}" autofocus>

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
                                  Editar
                              </button>
                              <a href="/core_v2/proveedors" type="button" class="btn-core">
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
