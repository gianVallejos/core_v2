@extends('layouts.default')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="alert alert-info col-md-4 col-md-offset-1 text-center">
                    Haz clic <a href="/core_v2/tratamientos">aquí</a> para gestionar <strong>Tratamientos</strong>
                </div>
                <div class="alert alert-info col-md-4 col-md-offset-1 text-center">
                    Haz clic <a href="/core_v2/empresas">aquí</a> para gestionar <strong>Empresas</strong>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading text-center title">PRECIOS</div>
                <div class="panel-body">

                  <div class="form-group">
                    <label for="buscar" class="col-md-1 col-md-offset-2 control-label lbl">Buscar</label>
                    <div class="col-md-7">
                        <input id="myInput" type="text" class="form-control" onkeyup="buscarPrecio()" placeholder=" Buscar por Detalles">
                    </div>
                  </div>

                <div class="col-md-10 col-xs-12 col-md-offset-1" style="padding-bottom: 65px;">
                  <div id="table-wrapper">
                      <div id="table-scroll" style="height: 60vh;">
                        <table id="tablaPrecio" class="table table-responsive table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Tratamiento</th>
                                    <th class="text-center">Empresa</th>
                                    <th class="text-center">Monto</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>

                                @foreach( $montos as $row )
                                  <tr>
                                     <td class="text-center col-md-1 col-xs-1">{{ $i }}</th>
                                     <td class="text-center col-md-4 col-xs-4">
                                         <input type="hidden" name="tratamiento" id="trat-{{ $i }}" value="{{ $row->idTratamiento }}">
                                         {{ $row->tdetalle }}
                                     </td>
                                     <td class="text-center col-md-2 col-xs-3">
                                         <select class="form-control" name="empresa" id="{{ $i }}">
                                             @foreach( $empresas as $empresa )
                                                 <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
                                             @endforeach
                                         </select>
                                     </td>
                                     <td class="text-center col-md-2 col-xs-2">
                                         <input class="form-control form-control-monto" type="number" min="0" name="monto" id="{{ $i }}" value="{{ $row->monto }}">
                                     </td>
                                     <td class="text-center col-md-2" style="padding-top: 15px;">
                                         <button type="submit" class="btn btn-xs btn-success" onclick="guardarPrecio({{ $row->idTratamiento }}, {{ $i }}, '{{ csrf_token() }}' )">Guardar</button>
                                     </td>
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

@endsection
<script>
function buscarPrecio(){
    var input, filter, table, tr, td, i;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("tablaPrecio");
    tr = table.getElementsByTagName("tr");

    for(i = 0; i < tr.length; i++){
        td = tr[i].getElementsByTagName("td")[1];
        if(td){
            if(td.innerHTML.toUpperCase().indexOf(filter) > -1){
                tr[i].style.display = "";
            }else{
                tr[i].style.display = "none";
            }
        }
    }
}
</script>
