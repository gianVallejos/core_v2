$(document).ready(function(){
    $('#form-detalle-proveedor').submit(function(event){
        event.preventDefault();

        var id = $.trim($('#id-info').val());
        var detalles = $.trim($('#detalles').val());
        var monto = $.trim($('#monto').val());

        if( validarDatosDetalleProveedor(detalles, monto) ){

            $.ajax({
              type: 'GET',
              url: '/core_v2/api-v1/agregar-detalle-proveedor',
              data:{
                'id': id,
                'detalles' : detalles,
                'monto' : monto
              },
              success: function(data){
                  var estado = JSON.parse(data);

                  if( estado[0]["ESTADO"] > 0 ){
                      alertMessage('Éxito', 'Detalle de Proveedor agregado correctamente', 'success');
                      cargarDetalleProveedor(id);
                      limpiarDetallesProveedor();
                  }
                  else{
                      alertMessage('Error', 'Ha ocurrido un error. Avisar al Webmaster', 'error');
                  }
              },
              error: function(){
                  alertMessage('Error', 'Ha ocurrido un error.', 'error');
              }
            });
        }
    });

    function validarDatosDetalleProveedor(detalles, monto){
        if( detalles == "" ){
            alertMessage('Error', 'Debe escribir un detalle', 'error');
            $('#detalles').focus();
            return false;
        }

        if( monto == "" ){ //FALTA VALIDAR SI ES NÚMERO EL MONTO
            alertMessage('Error', 'Debe escribir un monto', 'error');
            $('#monto').focus();
            return false;
        }
        return true;
    }
});

function mostrarDetalle(php_data){
    data = JSON.parse(php_data);

    $('#email-txt').text(data["email"]);
    $('#direccion-txt').text(data["direccion"]);
    $('#dni-txt').text(data["dni"]);
    $('#ruc-txt').text(data["ruc"]);
    $('#telefono-txt').text(data["telefono"]);
    $('#celular-txt').text(data["celular"]);
    $('#banco-txt').text(data["banco"]);
    $('#nrocta-txt').text(data["nrocuenta"]);
}

function mostrarInfo(id, nombre){

    cargarDetalleProveedor(id);

    $('#id-info').val(id);
    $('#title-info').val(nombre);
}

function cargarDetalleProveedor(id){
    $('#tablaDetalleProveedor > thead').empty();
    $('#tablaDetalleProveedor > tbody').empty();

    $.ajax({
      type: 'GET',
      url: '/core_v2/api-v1/get-detalle-proveedor/'+id,
      data:{},
      success: function(data){
          var res = JSON.parse(data);

          var htmlbody = '';
          for( var ind = 0; ind < res.length; ind++ ){
              htmlbody +=  '<tr>' +
                              '<td class="text-center">'+ (ind+1) +'</td>' +
                              '<td class="text-center">'+ res[ind]['detalle']+'</td>' +
                              '<td class="text-center">'+ res[ind]['monto']+'</td>' +
                              '<td class="text-center">' +
                                '<a onclick="eliminarDetalleProveedor('+ res[ind]['id']+')" class="btn btn-xs btn-danger">Eliminar</a>' +
                              '</td>' +
                            '</tr>'
                          ;
          }

          var htmlhead = '<tr>' +
                            '<th class="text-center col-md-1">#</th>' +
                            '<th class="text-center">Detalles</th>' +
                            '<th class="text-center col-md-1">Monto</th>' +
                            '<th class="col-md-2"></th>' +
                          '</tr>';
          
          if( res.length != "0" ){
              $('#tablaDetalleProveedor > thead').append(htmlhead);
              $('#tablaDetalleProveedor > tbody').append(htmlbody);
          }

      },
      error: function(){
          alertMessage('Error', 'Ha ocurrido un error.', 'error');
      }
    });
}

function buscarProveedor(){
      var input, filter, table, tr, td, i;
      input = document.getElementById("myInput");
      filter = input.value.toUpperCase();
      table = document.getElementById("tablaProveedor");
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

function eliminarDetalleProveedor(idDProveedor){
    id = $('#form-detalle-proveedor #id-info').val();

    $.ajax({
        type: 'GET',
        url: '/core_v2/api-v1/eliminar-detalle-proveedor/' + idDProveedor,
        data:{},
        success: function(data){
            var estado = JSON.parse(data);

            if( estado[0]["ESTADO"] > 0 ){
                alertMessage('Éxito', 'Detalle de Proveedor eliminado correctamente', 'error');
                cargarDetalleProveedor(id);
            }
            else{
                alertMessage('Error', 'Ha ocurrido un error. Avisar al Webmaster', 'error');
            }
        },
        error: function(){
            alertMessage('Error', 'Ha ocurrido un error.', 'error');
        }
    });
}

function limpiarDetallesProveedor(){
    $('#detalles').val('');
    $('#monto').val('');
}
