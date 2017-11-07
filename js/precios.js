 function guardarPrecio(idTratamiento, indice, token){
    var idEmpresa = $('select[id='+indice+'] option:selected').val();
    var idTratamiento = idTratamiento;
    var monto = $('input[id="'+indice+'"]').val();

    updatePrecios(idEmpresa, idTratamiento, monto, token);
}

function updatePrecios(idEmpresa, idTratamiento, monto, token){
    $.ajax({
        type: 'GET',
        url: '/core_v2/api-v1/update-precios/'+idEmpresa+'/'+idTratamiento+'/'+monto+'/'+token,
        data: {},
        success: function(data){
            var estado = JSON.parse(data['estado']);
            if( estado[0]["ESTADO"] > 0 ){
                alertMessage('Éxito', 'Datos actualizados correctamente', 'success');
            }
            // else{
            //     alertMessage('Error', 'Ha ocurrido un error. Avisar al Webmaster', 'error');
            // }
        },
        error: function(){
            alertMessage('Error', 'Error al actualizar los datos', 'error');
        }
    });
}

function showMontoByEmpresaSelected(idEmpresa, idTratamiento, indice){
    $.ajax({
      type: 'GET',
      url: '/core_v2/api-v1/get-monto/'+idEmpresa+'/'+idTratamiento,
      data:{},
      success: function(data){
          var monto = JSON.parse(data['monto']);
          var value = 0;
          if( monto[0]["MONTO"] !=  null ){
              value = monto[0]["MONTO"];
          }
          $('input[id="'+indice+'"]').val(value);
      },
      error: function(){
          alertMessage('Error', 'Ha ocurrido un error.', 'error');
      }
    });
    // $('input[id="'+indice+'"]').val();
}

$(document).on('change', 'select', function(){
    var idEmpresa = $(this).val();
    var indice = $(this).attr('id');
    var idTratamiento = $('#trat-'+indice).val();
    // alert($(this).attr('id'));
    if( $(this).attr('name') == 'empresa'){
      showMontoByEmpresaSelected(idEmpresa, idTratamiento, indice)
    }
});
