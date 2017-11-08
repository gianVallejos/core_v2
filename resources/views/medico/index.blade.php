@extends('layouts.default')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <!-- <div class="alert alert-success text-center">
                    Nuevo paciente agregado correctamente.
                </div> -->

                <div class="panel panel-default">
                    <div class="panel-heading text-center title">AGREGAR DOCTOR</div>
                    <div class="panel-body">

                        <form class="form-horizontal" action="/core_v2/medicos" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label for="nombres" class="col-md-1 col-xs-1 control-label">Nombres</label>
                                <div class="col-md-5 col-xs-5">
                                    <input id="nombres" type="text" class="form-control" name="nombres"
                                           value="{{ old('nombres')}}" placeholder="Nombres" required autofocus>

                                    @if ($errors->has('nombres'))
                                        <span class="help-block">
                                      <strong>{{ $errors->first('nombres')}}</strong>
                                  </span>
                                    @endif

                                </div>

                                <label for="apellidos" class="col-md-1 col-xs-1 control-label">Apellidos</label>
                                <div class="col-md-5 col-xs-5">
                                    <input id="apellidos" type="text" class="form-control" name="apellidos"
                                           value="{{ old('apellidos')}}" placeholder="Apellidos" required autofocus>

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
                                    <input id="dni" type="text" class="form-control" name="dni" value="{{ old('dni')}}"
                                           placeholder="DNI" minlength="8" maxlength="8" required autofocus>

                                    @if ($errors->has('dni'))
                                        <span class="help-block">
                                      <strong>{{ $errors->first('dni')}}</strong>
                                  </span>
                                    @endif

                                </div>

                                <label for="email" class="col-md-1 col-xs-1 control-label">Email</label>
                                <div class="col-md-4 col-xs-3">
                                    <input id="email" type="text" class="form-control" name="email"
                                           value="{{ old('email')}}" placeholder="E-mail">

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                      <strong>{{ $errors->first('email')}}</strong>
                                  </span>
                                    @endif

                                </div>

                                <label for="direccion" class="col-md-1 col-xs-2 control-label">Dirección</label>
                                <div class="col-md-3 col-xs-3">
                                    <input id="direccion" type="text" class="form-control" name="direccion"
                                           value="{{ old('direccion')}}" placeholder="Dirección" required autofocus>

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
                                        <option value="{{ $gr }}"
                                                @if(old('genero') == '{{ $gr }}')selected @endif>{{ $gr }}</option>
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
                                        <option value="{{ $stdo }}"
                                                @if(old('estado') == '{{ $stdo }}')selected @endif>{{ $stdo }}</option>
                                        <?php           }                                                 ?>
                                    </select>

                                </div>

                                <label for="margen_ganancia" class="col-md-2 col-xs-2 control-label">Margen de
                                    Ganancia</label>
                                <div class="col-md-2 col-xs-2">
                                    <input id="margen_ganancia" type="number" min="0" max="100" class="form-control"
                                           name="margen_ganancia" value="{{ old('margen_ganancia')}}"
                                           placeholder="Margen (%)"
                                    @if(Auth::user()->rolid != 1) disabled  @endif >

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
                                           value="{{ old('fechanacimiento')}}" required autofocus>

                                    @if ($errors->has('fechanacimiento'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('fechanacimiento')}}</strong>
                                </span>
                                    @endif

                                </div>

                                <label for="telefono" class="col-md-1 col-xs-1 control-label">Teléfono</label>
                                <div class="col-md-2 col-xs-2">
                                    <input id="telefono" type="text" class="form-control" name="telefono"
                                           value="{{ old('telefono')}}" placeholder="Teléfono">

                                    @if ($errors->has('telefono'))
                                        <span class="help-block">
                                      <strong>{{ $errors->first('telefono')}}</strong>
                                  </span>
                                    @endif

                                </div>

                                <label for="celular" class="col-md-1 col-xs-1 control-label">Celular</label>
                                <div class="col-md-2 col-xs-2">
                                    <input id="celular" type="text" class="form-control" name="celular"
                                           value="{{ old('celular')}}" placeholder="Número de Celular">

                                    @if ($errors->has('celular'))
                                        <span class="help-block">
                                      <strong>{{ $errors->first('celular')}}</strong>
                                  </span>
                                    @endif

                                </div>

                                <label for="celular_aux" class="col-md-1 col-xs-1 control-label">Celular</label>
                                <div class="col-md-2 col-xs-2">
                                    <input id="celular_aux" type="text" class="form-control" name="celular_aux"
                                           value="{{ old('celular_aux')}}" placeholder="Número de Celular">

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


    @if( $numMedicos != 0 )
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center title">DOCTORES</div>
                        <div class="panel-body">
                            <div id="table-wrapper">
                                <div id="table-scroll" style="height: 30vh;">
                                    <table class="table table-responsive table-hover">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Nombres</th>
                                            <th class="text-center">Apellidos</th>
                                            <th class="text-center">DNI</th>
                                            <th class="text-center">E-mail</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $i = 0; ?>
                                        @foreach( $data as $row )
                                            <tr>
                                                <th scope="row" class="text-center">{{ $row->id }}</th>
                                                <td class="text-center">{{ $row->nombres }}</td>
                                                <td class="text-center">{{ $row->apellidos }}</td>
                                                <td class="text-center">{{ $row->dni }}</td>
                                                <td class="text-center">{{ $row->email }}</td>
                                                <td class="text-center">
                                                    <button class="btn btn-xs btn-success"
                                                            onclick="mostrarDetalle('{{ json_encode($data[$i]) }}')"
                                                            data-toggle="modal" data-target="#myModal">Detalle
                                                    </button>
                                                </td>
                                                <td class="text-center"><a href="{{ route('medicos.edit', $row->id) }}"
                                                                           class="btn btn-xs btn-warning">Editar</a>
                                                </td>
                                                @if(Auth::user()->rolid == 1)
                                                    <td class="text-center">
                                                        <form action="{{ route('medicos.destroy', $row->id) }}"
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

        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title text-center">
                            <strong>
                                <div id="nombres-txt"></div>
                            </strong>
                        </h4>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <label for="dni" class="col-md-2 col-md-offset-1 control-label">DNI:</label>
                            <div id="dni-txt" class="col-md-4"></div>
                        </div>
                        <div class="row">
                            <label for="mail" class="col-md-2 col-md-offset-1 control-label">E-mail:</label>
                            <div id="email-txt" class="col-md-4"></div>
                        </div>
                        <div class="row">
                            <label for="direccion" class="col-md-2 col-md-offset-1 control-label">Dirección:</label>
                            <div id="direccion-txt" class="col-md-4"></div>
                        </div>
                        <div class="row">
                            <label for="fechanacimiento"
                                   class="col-md-2 col-md-offset-1 control-label">Nacimiento:</label>
                            <div id="fechanacimiento-txt" class="col-md-3"></div>

                            <label for="edad" class="col-md-2 control-label">Edad:</label>
                            <div id="edad-txt" class="col-md-4"></div>
                        </div>
                        <div class="row">
                            <label for="genero" class="col-md-2 col-md-offset-1 control-label">Género:</label>
                            <div id="genero-txt" class="col-md-2"></div>

                            <label for="estado" class="col-md-2 col-md-offset-1 control-label">Estado:</label>
                            <div id="estado-txt" class="col-md-2"></div>
                        </div>
                        <div class="row">

                            <label for="margen_ganancia" class="col-md-2 col-md-offset-1 control-label">MG:</label>
                            <div id="margen_ganancia-txt" class="col-md-2"></div>

                            <label for="telefono" class="col-md-2 col-md-offset-1 control-label">Teléfono:</label>
                            <div id="telefono-txt" class="col-md-2"></div>

                        </div>
                        <div class="row">

                            <label for="celular" class="col-md-2 col-md-offset-1 control-label">Celular:</label>
                            <div id="celular-txt" class="col-md-2"></div>

                            <label for="celular_aux" class="col-md-2 col-md-offset-1 control-label">Celular 2:</label>
                            <div id="celular_aux-txt" class="col-md-2"></div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
    @endif

    <script type="text/javascript">


    </script>

@endsection
