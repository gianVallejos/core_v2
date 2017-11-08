@extends('layouts.default')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">

            <div class="alert alert-warning text-center">
                Al crear un empresa se clonarán todos los tratamientos registrados por defecto. <a href="/core_v2/tratamientos">Ver tratamientos</a>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading text-center title">AGREGAR EMPRESA</div>
                <div class="panel-body" >

                    <form class="form-horizontal" action="/core_v2/empresas" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label for="nombre" class="col-md-1 col-xs-2 col-md-offset-1 control-label">Nombre</label>
                            <div class="col-md-4 col-xs-9">
                                <input id="nombre" type="text" class="form-control" name="nombre" value="{{ old('nombre')}}" placeholder="Nombre de la Empresa" required autofocus>
                                @if ($errors->has('nombre'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('nombre')}}</strong>
                                  </span>
                                @endif

                            </div>
                            <label for="ruc" class="col-md-1 col-xs-2 control-label">RUC</label>
                            <div class="col-md-4 col-xs-9">
                                <input id="ruc" type="text" minlength="11" maxlength="11" class="form-control" name="ruc" value="{{ old('ruc')}}" placeholder="RUC" required autofocus>

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


@if( $numEmpresas != 0 )
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading text-center title">EMPRESAS</div>
                <div class="panel-body">
                  <div class="col-md-10 col-xs-12 col-md-offset-1" style="padding-bottom: 65px;">
                    <div id="table-wrapper">
                        <div id="table-scroll">
                          <table class="table table-responsive table-hover">
                              <thead>
                                  <tr>
                                      <th class="text-center">#</th>
                                      <th class="text-center">Nombres</th>
                                      <th class="text-center">RUC</th>
                                      <th></th>
                                      <th></th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php $i = 2; ?>
                                  @foreach( $data as $row )
                                    <tr>
                                      <th scope="row" class="text-center">{{ $row->id }}</th>
                                      <td class="text-center col-md-6">{{ $row->nombre }}</td>
                                      <td class="text-center col-md-2">{{ $row->ruc }}</td>
                                      <td class="text-center"><a href="{{ route('empresas.edit', $row->id) }}" class="btn btn-xs btn-warning">Editar</a></td>
                                        @if(Auth::user()->rolid == 1)
                                      <td class="text-center">
                                        @if( $i > 2 )
                                        <form action="{{ route('empresas.destroy', $row->id) }}" method="post">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="submit" class="btn btn-xs btn-danger">Eliminar</button>
                                        </form>
                                        @endif
                                      </td>
                                            @endif
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
</div>
@endif

@endsection
