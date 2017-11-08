@extends('layouts.default')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="alert alert-warning text-center">
                    Al crear un tratamiento se clonarán en todas las empresas registradas. <a href="/core_v2/empresas">Ver
                        Empresas</a>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading text-center title">AGREGAR TRATAMIENTO</div>
                    <div class="panel-body">

                        <form class="form-horizontal" action="/core_v2/tratamientos" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label for="detalle"
                                       class="col-md-1 col-xs-2 col-md-offset-2 control-label">Detalles</label>
                                <div class="col-md-4 col-xs-9">
                                    <input id="detalle" type="text" class="form-control" name="detalle"
                                           value="{{ old('detalle')}}" placeholder="Nombre del Tratamiento" required
                                           autofocus>

                                    @if ($errors->has('detalle'))
                                        <span class="help-block">
                                      <strong>{{ $errors->first('detalle')}}</strong>
                                  </span>
                                    @endif

                                </div>

                                <label for="monto" class="col-md-1 col-xs-2 control-label">Monto</label>
                                <div class="col-md-2 col-xs-4">
                                    <input id="monto" type="text" class="form-control" name="monto"
                                           value="{{ old('monto')}}" placeholder="Monto Default" required autofocus>

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


    @if( $numTratamientos != 0 )
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center title">TRATAMIENTOS</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="buscar" class="col-md-1 col-md-offset-2 control-label lbl">Buscar</label>
                                <div class="col-md-7">
                                    <input id="myInput" type="text" class="form-control" onkeyup="buscarTratamiento()"
                                           placeholder=" Buscar por Detalles">
                                </div>
                            </div>

                            <div class="col-md-10 col-xs-12 col-md-offset-1" style="padding-bottom: 65px;">
                                <div id="table-wrapper">
                                    <div id="table-scroll" style="height: 30vh;">
                                        <table id="tablaTratamiento" class="table table-responsive table-hover">
                                            <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">Detalles</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i = 2; ?>
                                            @foreach( $data as $row )
                                                <tr>
                                                    <td class="text-center">
                                                    {{ $row->id }}</th>
                                                    <td class="text-center col-md-8">{{ $row->detalle }}</td>
                                                    <td class="text-center"><a
                                                                href="{{ route('tratamientos.edit', $row->id) }}"
                                                                class="btn btn-xs btn-warning">Editar</a></td>
                                                    @if(Auth::user()->rolid == 1)
                                                        <td class="text-center">
                                                            @if( $i > 7 )
                                                                <form action="{{ route('tratamientos.destroy', $row->id) }}"
                                                                      method="post">
                                                                    <input type="hidden" name="_method" value="DELETE">
                                                                    <input type="hidden" name="_token"
                                                                           value="{{ csrf_token() }}">
                                                                    <button type="submit" class="btn btn-xs btn-danger">
                                                                        Eliminar
                                                                    </button>
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

<script>
    function buscarTratamiento() {
        var input, filter, table, tr, td, i;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("tablaTratamiento");
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
