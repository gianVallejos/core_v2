@extends('layouts.default')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">

          <!-- <div class="alert alert-success text-center">
              Nuevo paciente agregado correctamente.
          </div> -->

            <div class="panel panel-default">
                <div class="panel-heading text-center title">AGREGAR TRATAMIENTO</div>
                <div class="panel-body" >

                    <form class="form-horizontal" action="/core_v2/empresas/{{ $empresa->id }}" method="POST">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label for="nombre" class="col-md-1 col-xs-2 col-md-offset-1 control-label">Nombre</label>
                            <div class="col-md-4 col-xs-9">
                                <input id="nombre" type="text" class="form-control" name="nombre" value="{{ $empresa->nombre }}" placeholder="Nombre de la Empresa" required autofocus>
                                @if ($errors->has('nombre'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('nombre')}}</strong>
                                  </span>
                                @endif

                            </div>
                            <label for="ruc" class="col-md-1 col-xs-2 control-label">RUC</label>
                            <div class="col-md-4 col-xs-9">
                                <input id="ruc" type="text" minlength="11" maxlength="11" class="form-control" name="ruc" value="{{ $empresa->ruc }}" placeholder="RUC" required autofocus>

                                @if ($errors->has('ruc'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('ruc')}}</strong>
                                  </span>
                                @endif

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 text-center" style="padding-top: 25px;">
                                <button type="submit" class="btn-core">
                                    Modificar
                                </button>
                                <a href="/core_v2/empresas" class="btn-core">
                                    Atrás
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
