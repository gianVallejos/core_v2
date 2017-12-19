@extends('layouts.default')

@section('content')

    <div class="container">
        <div class="row">

            <div class="col-md-12">

                <div class="panel panel-default">
                    <div class="panel-heading text-center title">AGREGAR PACIENTE</div>
                    <div class="panel-body">

                        <form class="form-horizontal" action="/core_v2/pacientes" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label for="nombres" class="col-md-1 col-xs-1 control-label">Nombres</label>
                                <div class="col-md-4 col-xs-3">
                                    <input id="nombres" type="text" class="form-control" name="nombres"
                                           value="{{ old('nombres')}}" placeholder="Nombres" required autofocus>

                                    @if ($errors->has('nombres'))
                                        <span class="help-block">
                                      <strong>{{ $errors->first('nombres')}}</strong>
                                  </span>
                                    @endif

                                </div>

                                <label for="apellidos" class="col-md-1 col-xs-2 control-label">Apellidos</label>
                                <div class="col-md-3 col-xs-3">
                                    <input id="apellidos" type="text" class="form-control" name="apellidos"
                                           value="{{ old('apellidos')}}" placeholder="Apellidos" required autofocus>

                                    @if ($errors->has('apellidos'))
                                        <span class="help-block">
                                      <strong>{{ $errors->first('apellidos')}}</strong>
                                  </span>
                                    @endif

                                </div>

                                <label for="dni" class="col-md-1 col-xs-1 control-label">DNI</label>
                                <div class="col-md-2 col-xs-2">
                                    <input id="dni" type="text" class="form-control" name="dni" value="{{ old('dni')}}"
                                           placeholder="DNI" minlength="8" maxlength="8">

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
                            </div>

                            <div class="form-group">

                                <label for="genero" class="col-md-1 col-xs-1 control-label">Género</label>
                                <div class="col-md-2 col-xs-2">
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
                                <div class="col-md-2 col-xs-2">
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

                                <label for="empresa_id" class="col-md-1 col-xs-1 control-label">Empresa</label>
                                <div class="col-md-2 col-xs-2">
                                    <select name="empresa_id" id="empresa_id" class="form-control">
                                        @foreach( $empresas as $stdo )
                                            <option value="{{ $stdo->id }}"
                                                    @if(old('empresa_id') == '{{ $stdo->nombre }}')selected @endif>{{ $stdo->nombre }}</option>
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
                                    $ind = 0;
                                    $seguro = array('Ninguno', 'Trabajador', 'Hijo/Hija', 'Padre');
                                    ?>
                                    <select name="seguro_ind" id="seguro_ind" class="form-control">
                                        @foreach($seguro as $stdo)
                                            <option value="{{ $ind++ }}"
                                                    @if(old('seguro_ind') == '{{ $stdo }}')selected @endif>{{ $stdo }}</option>
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
                                    <input id="telefono" type="text" class="form-control" name="telefono"
                                           value="{{ old('telefono')}}" placeholder="Teléfono">

                                    @if ($errors->has('telefono'))
                                        <span class="help-block">
                                      <strong>{{ $errors->first('telefono')}}</strong>
                                  </span>
                                    @endif

                                </div>

                                <label for="fax" class="col-md-1 col-xs-1 control-label">Fax</label>
                                <div class="col-md-2 col-xs-2">
                                    <input id="fax" type="text" class="form-control" name="fax" value="{{ old('fax')}}"
                                           placeholder="Fax">

                                    @if ($errors->has('fax'))
                                        <span class="help-block">
                                      <strong>{{ $errors->first('fax')}}</strong>
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

                                <label for="celular_aux" class="col-md-1 col-xs-1 control-label">Celular 2</label>
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


    @if( $numPacientes != 0 )
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center title">PACIENTES</div>
                        <div class="panel-body" style="padding-bottom: 60px;">

                            <input type="text" class="form-control" id="myInput2" onkeyup="buscarClte()"
                                   placeholder=" Buscar por Nombres y Apellidos"><br>

                            <div id="table-wrapper">
                                <div id="table-scroll" style="height: 50vh;">
                                    <table id="tablaClte" class="table table-responsive table-hover">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Apellidos y Nombres</th>
                                            <th class="text-center">DNI</th>
                                            <th class="text-center">Celular</th>
                                            <th class="text-center">Teléfono</th>
                                            <th class="text-center">Empresa</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $i = 0; ?>
                                        @foreach( $data as $row )
                                            <tr>
                                                <td scope="row" class="text-center">{{ $row->id }}</td>
                                                <td class="text-center">{{ $row->apellidos }} {{ $row->nombres }}</td>
                                                <td class="text-center">{{ $row->dni }}</td>
                                                <td class="text-center">{{ $row->celular }}</td>
                                                <td class="text-center">{{ $row->telefono }}</td>

                                                <td class="text-center">
                                                    @foreach($empresas as $empresa)
                                                        @if($empresa->id == $row->empresa_id)
                                                            {{$empresa->nombre}}
                                                        @endif
                                                    @endforeach
                                                </td>

                                                <td class="text-center">
                                                    <button class="btn btn-xs btn-success"
                                                            onclick="mostrarDetallePaciente('{{ json_encode($data[$i]) }}')"
                                                            data-toggle="modal" data-target="#myModal">Detalle
                                                    </button>
                                                </td>
                                                <td class="text-center"><a
                                                            href="{{ route('pacientes.edit', $row->id) }}"
                                                            class="btn btn-xs btn-warning">Editar</a></td>
                                                @if(Auth::user()->rolid == 1)
                                                    <td class="text-center">
                                                        <form action="{{ route('pacientes.destroy', $row->id) }}"
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
                            <div id="direccion-txt" class="col-md-9"></div>
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

                            <label for="telefono" class="col-md-2 col-md-offset-1 control-label">Teléfono:</label>
                            <div id="telefono-txt" class="col-md-2"></div>

                            <label for="fax" class="col-md-2 col-md-offset-1 control-label">Fax:</label>
                            <div id="fax-txt" class="col-md-2"></div>

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


@endsection
