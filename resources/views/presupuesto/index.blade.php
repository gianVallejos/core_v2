@extends('layouts.default')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-default">
                    <div class="panel-heading text-center title">CREAR PRESUPUESTO</div>
                    <div class="panel-body" style="padding-bottom: 45px; padding-top: 65px;">
                        <div class="form-group">
                            <label for="medicos" class="col-md-2 col-xs-2 control-label lbl">Seleccionar
                                Doctor</label>
                            <div class="col-md-3 col-xs-4">
                                <select class="form-control" id="medico" name="medico">
                                    <option value="-1">Seleccionar Doctor</option>
                                    @foreach($medicos as $medico)
                                        <option value="{{$medico->id}}">{{$medico->nombres}} {{$medico->apellidos}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <label for="medicos" class="col-md-2 col-xs-2 control-label lbl">Seleccionar
                                Paciente</label>
                            <div class="col-md-3 col-xs-4">
                              <input class="form-control" type="text" id="paciente" name="paciente" disabled>
                              <input type="hidden" id="paciente-id">
                            </div>

                            <div class="col-md-2">
                              <button id="openBuscarPaciente" class="btn btn-default" type="button">
                                Buscar
                              </button>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 col-xs-12 text-center" style="padding-top: 35px;">
                                <button id="nuevo-presupuesto" type="submit" class="btn-core">
                                    Nuevo Presupuesto
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading text-center title">PRESUPUESTOS</div>
                    <div class="panel-body" style="padding-bottom: 45px; padding-top: 35px;">
                        <div class="row">
                            <div class="form-group">
                                <label for="buscar"
                                       class="col-md-1 col-xs-1 col-md-offset-1 col-xs-offset-1 control-label lbl">Buscar</label>
                                <div class="col-md-9 col-xs-9">
                                    <input id="myInput" type="text" class="form-control" onkeyup="buscarPresp()"
                                           placeholder=" Buscar por Pacientes">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-xs-12">
                                    <div id="table-wrapper">
                                        <div id="table-scroll">
                                            <table id="tablaPresp" class="table table-responsive table-hover">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center">Historia</th>
                                                    <th class="text-center">Paciente</th>
                                                    <th class="text-center">Doctor</th>
                                                    <th class="text-center">Fecha Hora</th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach( $presupuestos as $row )
                                                    <tr>
                                                        <td class="text-center">{{ $row->id }}</td>
                                                        <td class="text-center">{{ $row->hc }}</td>
                                                        <td class="text-center">{{ $row->papellidos }} {{ $row->pnombres }}</td>
                                                        <td class="text-center">{{ $row->mapellidos }} {{ $row->mnombres }}</td>
                                                        <td class="text-center">{{ $row->fechahora }}</td>
                                                        <td class="text-center"><a
                                                                    href="presupuestos/create/{{$row->idMedico}}/{{$row->idPaciente}}/{{$row->id }}"
                                                                    class="btn btn-xs btn-success">Detalle</button></td>
                                                        @if(Auth::user()->rolid == 1)
                                                            <td class="text-center">
                                                                <form action="{{ route('presupuestos.destroy', $row->id) }}"
                                                                      method="post">
                                                                    <input type="hidden" name="_method" value="DELETE">
                                                                    <input type="hidden" name="_token"
                                                                           value="{{ csrf_token() }}">
                                                                    <button id="{{ $row->id }}" name="eliminarpresp"
                                                                            type="submit" class="btn btn-xs btn-danger">
                                                                        Eliminar
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        @endif
                                                    </tr>
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
        </div>
    </div>

    <!-- Modal Buscar Paciente -->
        <div id="buscarPaciente" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title text-center"><b>BUSCAR PACIENTE</b></h4>
                    </div>
                    <div class="row" style="margin-top: 15px;">
                        <div class="col-md-10 col-md-offset-1"> <!-- Buscar Paciente -->
                            <input type="text" class="form-control" id="buscar-paciente" onkeyup="buscarPaciente()"
                                   placeholder=" Buscar por Nombres">
                        </div>
                    </div>
                    <div class="modal-body">
                        <div id="table-wrapper">
                            <div id="table-scroll" style="height: 50vh;">
                                <table id="tablaClte" class="table table-responsive table-hover">
                                    <thead>
                                    <tr>
                                        <th class="text-center">HC</th>
                                        <th class="text-center">Nombres</th>
                                        <th></th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 1; ?>
                                    @foreach( $pacientes as $row )
                                        <tr>
                                            <td class="text-center">{{ $row->id }}</td>
                                            <td class="text-center">{{ $row->nombres }} {{ $row->apellidos }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-xs btn-info"
                                                        onclick="agregarAPrespPaciente('{{ $row->id }}', '{{ $row->nombres }} {{ $row->apellidos }}')">
                                                    Aceptar
                                                </button>
                                            </td>
                                        </tr>
                                        <?php $i++; ?>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer text-center" style="width: 100%;">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>

            </div>
        </div>

@endsection
<script src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript">
    function buscarPresp() {
        var input, filter, table, tr, td, i;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("tablaPresp");
        tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[2];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    function buscarPaciente() {
        var input, filter, table, tr, td, i;
        input = document.getElementById("buscar-paciente");
        filter = input.value.toUpperCase();
        table = document.getElementById("tablaClte");
        tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

</script>
