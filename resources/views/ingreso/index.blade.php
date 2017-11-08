@extends('layouts.default')

@section('content')

    <div class="container">
        <div class="row">

            <div class="col-md-12">

                <!-- <div class="alert alert-success text-center">
                    Nuevo paciente agregado correctamente.
                </div> -->

                <div class="panel panel-default">
                    <div class="panel-heading text-center title">AGREGAR INGRESO</div>
                    <div class="panel-body">

                        <form class="form-horizontal" action="/core_v2/ingresos" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label for="paciente_id" class="col-md-1 col-xs-1 col-md-offset-1 control-label">Paciente</label>
                                <div class="col-md-4 col-xs-5">
                                    <select name="paciente_id" id="paciente_id" class="form-control">
                                        @foreach( $pacientes as $stdo )
                                            <option value="{{ $stdo->id }}" )selected>{{ $stdo->id }}
                                                - {{ $stdo->apellidos }} {{ $stdo->nombres }}</option>
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
                                            <option value="{{ $stdo->id }}"
                                                    )selected>{{ $stdo->apellidos }} {{ $stdo->nombres }}</option>
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
                                    <input id="descripcion" type="text" class="form-control" name="descripcion"
                                           value="{{ old('descripcion')}}" placeholder="Descripcion">

                                    @if ($errors->has('descripcion'))
                                        <span class="help-block">
                                      <strong>{{ $errors->first('descripcion')}}</strong>
                                  </span>
                                    @endif

                                </div>


                                <label for="monto" class="col-md-1 col-xs-1 control-label">Monto</label>
                                <div class="col-md-2 col-xs-2">
                                    <input id="monto" type="number" class="form-control" name="monto"
                                           value="{{ old('monto')}}" placeholder="Monto" min="0" step=".1" required>

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

    @if( $numIngresos != 0 )
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center title">INGRESOS</div>
                        <div class="panel-body" style="padding-bottom: 60px;">

                            <div class="row" style="padding-bottom: 14px;">
                                <div class="col-md-1 col-md-offset-1" style="padding-top: 5px;">
                                    <strong>BUSCAR:</strong>
                                </div>
                                <div class="col-md-9">

                                    <div class="row">
                                        <form id="form-buscar-ingreso" method="get">
                                        <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
                                            <div class="col-md-3 col-xs-4">
                                                <input id="date_inicio" type="date" name="date_inicio" value=""
                                                       class="form-control">
                                            </div>
                                            <div class="col-md-3 col-xs-4">
                                                <input id="date_fin" type="date" name="date_fin" value=""
                                                       class="form-control">
                                            </div>
                                            <div class="col-md-4 col-xs-4">
                                                <select name="doctor_id" id="doctor_id" class="form-control">
                                                    <option value="-1" selected>Todos los Doctores</option>
                                                    @foreach( $medicos as $stdo )
                                                        <option value="{{ $stdo->id }}"
                                                                )>{{ $stdo->apellidos }} {{ $stdo->nombres }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2 col-xs-4">
                                                <button type="submit" name="button" class="btn-core">Buscar</button>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>

                            <div id="table-wrapper">
                                <div id="table-scroll">
                                    <table id="tablaIngresos" class="table table-responsive table-hover">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Nombres Doctor</th>
                                            <th class="text-center">HC</th>
                                            <th class="text-center">Doctor</th>
                                            <th class="text-center">CORE</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">Fecha</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $i = 0; ?>
                                        <?php $mdoc = 0; $mcore = 0; $mtotal = 0; ?>
                                        @foreach( $ingresos as $row )
                                            <tr>
                                                <td scope="row" class="text-center">{{ $i + 1 }}</td>
                                                <td class="text-center">{{ $row->doctor }}</td>
                                                <td class="text-center">{{ $row->hc }}</td>
                                                <?php $montoMedico = $row->monto * ((float)$row->mg / 100); ?>
                                                <td class="text-center">{{ 'S/ ' . $montoMedico }}</td>
                                                <?php $montoCore = $row->monto - $montoMedico; ?>
                                                <td class="text-center">{{ 'S/ ' . $montoCore }}</td>
                                                <td class="text-center">{{ 'S/ ' . $row->monto }}</td>
                                                <td class="text-center">{{ $row->fecha }}</td>
                                                <td class="text-center">
                                                    <button class="btn btn-xs btn-success"
                                                            onclick="mostrarDetalleIngreso('{{ json_encode($ingresos[$i]) }}')"
                                                            data-toggle="modal" data-target="#myModal">Detalle
                                                    </button>
                                                </td>
                                                <td class="text-center"><a href="{{ route('ingresos.edit', $row->id) }}"
                                                                           class="btn btn-xs btn-warning">Editar</a>
                                                </td>
                                                @if(Auth::user()->rolid == 1)
                                                    <td class="text-center">
                                                        <form action="{{ route('ingresos.destroy', $row->id) }}"
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
                                            <?php $mdoc += $montoMedico; $mcore += $montoCore; $mtotal += $row->monto; ?>
                                            <?php $i++; ?>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td class="text-center"></td>
                                            <td class="text-center"></td>
                                            <td class="text-center"></td>
                                            <td class="text-center"><b><?php echo 'S/ ' . $mdoc; ?></b></td>
                                            <td class="text-center"><b><?php echo 'S/ ' . $mcore; ?></b></td>
                                            <td class="text-center"><b><?php echo 'S/ ' . $mtotal; ?></b></td>
                                            <td class="text-center"></td>
                                            <td class="text-center"></td>
                                            <td class="text-center"></td>
                                        </tr>
                                        </tfoot>
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
                            <label for="hc" class="col-md-2 col-md-offset-1 control-label">HC:</label>
                            <div id="hc-txt" class="col-md-3"></div>

                            <label for="fecha" class="col-md-2 control-label">Fecha:</label>
                            <div id="fecha-txt" class="col-md-3"></div>
                        </div>
                        <div class="row">
                            <label for="paciente" class="col-md-2 col-md-offset-1 control-label">Paciente:</label>
                            <div id="paciente-txt" class="col-md-9"></div>
                        </div>
                        <div class="row">
                            <label for="doctor" class="col-md-2 col-md-offset-1 control-label">Doctor:</label>
                            <div id="doctor-txt" class="col-md-9"></div>
                        </div>
                        <div class="row">
                            <label for="montoDoctor" class="col-md-2 col-md-offset-1 control-label">Monto
                                Doctor:</label>
                            <div id="montoDoctor-txt" class="col-md-3" style="padding-top: 12px;"></div>

                            <label for="montoTotal" class="col-md-2 control-label">Monto Total:</label>
                            <div id="montoTotal-txt" class="col-md-3" style="padding-top: 12px;"></div>
                        </div>
                        <div class="row">
                            <label for="descripcion" class="col-md-2 col-md-offset-1 control-label">Descripción:</label>
                            <div id="descripcion-txt" class="col-md-9"></div>
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
