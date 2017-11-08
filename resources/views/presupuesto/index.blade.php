@extends('layouts.default')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-default">
                    <div class="panel-heading text-center title">CREAR PRESUPUESTO</div>
                    <div class="panel-body" style="padding-bottom: 45px; padding-top: 65px;">
                        <div class="form-group">
                            <label for="medicos" class="col-md-2 col-xs-2 col-md-offset-1 control-label lbl">Seleccionar
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
                                <select class="form-control" id="paciente" name="paciente">
                                    <option value="-1">Seleccionar Pacientes</option>
                                    @foreach($pacientes as $paciente)
                                        <option value="{{$paciente->id}}">{{$paciente->nombres}} {{$paciente->apellidos}}</option>
                                    @endforeach
                                </select>
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
                    <div class="panel-body" style="padding-bottom: 45px; padding-top: 65px;">
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
                                <div class="col-md-10 col-xs-12 col-md-offset-1"
                                     style="margin-top: 45px; margin-bottom: 45px;">
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
</script>
