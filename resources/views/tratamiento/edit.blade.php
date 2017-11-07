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

                    <form class="form-horizontal" action="/core_v2/tratamientos/{{ $tratamiento->id }}" method="POST">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label for="detalle" class="col-md-1 col-xs-2 col-md-offset-2 control-label">Detalles</label>
                            <div class="col-md-7 col-xs-9">
                                <input id="detalle" type="text" class="form-control" name="detalle" value="{{ $tratamiento->detalle }}" placeholder="Nombre del Tratamiento" required autofocus>

                                @if ($errors->has('detalle'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('detalle')}}</strong>
                                  </span>
                                @endif

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 text-center" style="padding-top: 25px;">
                                <button type="submit" class="btn-core">
                                    Editar
                                </button>
                                <a href="/core_v2/{{ 'tratamientos'}}" class="btn-core">
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
