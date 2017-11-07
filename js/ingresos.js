function mostrarDetalleIngreso(php_data){
    data = JSON.parse(php_data);

    $('#hc-txt').text(data["hc"]);
    $('#fecha-txt').text(data["fecha"]);
    $('#paciente-txt').text(data["pacientes"]);
    $('#doctor-txt').text(data["doctor"]);
    $('#montoTotal-txt').text('S/ ' + data["monto"]);
    $('#descripcion-txt').text(data["descripcion"]);

    var mg = parseFloat(data["mg"]);
    var md = parseFloat(data["monto"]) * mg/100;
    $('#montoDoctor-txt').text( 'S/ ' + md );
}

$('#form-buscar-ingreso').submit(function(event){
    event.preventDefault();

    var data = $('#form-buscar-ingreso').serialize();

    var date_inicio = $('#date_inicio').val();
    var date_fin = $('#date_fin').val();

    if( validarFechas(date_inicio, date_fin) ){
      $.ajax({
          type: 'GET',
          url: 'http://localhost/core_v2/api-v1/buscar-ingresos',
          dataType: 'json',
          contentType: "application/json; charset=utf-8",
          data: data,
          success: function(data){
              // var ingresos = JSON.parse(data);
              console.log(data);

              agregarATabla(data, 'tablaIngresos');

          },
          error: function(){
              alertMessage('Atención', 'Ha ocurrido un problema. Contactar con el webmaster', 'error');
          }
        });
    }

});

function agregarATabla(data, table_id){
    var mdoc = 0;
    var mcore = 0;
    var mtotal = 0;

    var rowsContent = '';
    for( var ind = 0; ind < data.length; ind++ ){
        var montoMedico = round(parseFloat(data[ind]["monto"]) * (parseFloat(data[ind]["mg"])/100));
        var montoCore = round(parseFloat(data[ind]["monto"]) - montoMedico);
        rowsContent  += '<tr>' +
                              '<td scope="row" class="text-center">' + (ind+1) + '</td>' +
                              '<td class="text-center">' + data[ind]["doctor"] + '</td>' +
                              '<td class="text-center">' + data[ind]["hc"] + '</td>' +
                              '<td class="text-center">' + montoMedico + '</td>' +
                              '<td class="text-center">' + montoCore + '</td>' +
                              '<td class="text-center">' + data[ind]["monto"] +'</td>' +
                              '<td class="text-center">'+ data[ind]["fecha"] +'</td>' +
                              '<td class="text-center"></td>' +
                              '<td class="text-center"></td>' +
                              '<td class="text-center"></td>' +
                        '</tr>';
        mdoc += parseFloat(montoMedico);
        mcore += parseFloat(montoCore);
        mtotal += parseFloat(data[ind]["monto"]);
    }

    var tfootContent = '';
    tfootContent += '<tr>' +
                      '<td class="text-center"></td>' +
                      '<td class="text-center"></td>' +
                      '<td class="text-center"></td>' +
                      '<td class="text-center"><b>' + round(mdoc) +'</b></td>' +
                      '<td class="text-center"><b>' + round(mcore) +'</b></td>' +
                      '<td class="text-center"><b>' + round(mtotal) +'</b></td>' +
                      '<td class="text-center"></td>' +
                      '<td class="text-center"></td>' +
                      '<td class="text-center"></td>' +
                      '<td class="text-center"></td>' +
                    '</tr>';

    $('#' + table_id + ' tbody').empty();
    $('#' + table_id + ' tbody').append(rowsContent);

    $('#' + table_id + ' tfoot').empty();
    $('#' + table_id + ' tfoot').append(tfootContent);

}

function validarFechas(date_inicio, date_fin){
    if( date_inicio == '' ){
        alertAutoMessage('Alerta', 'Para buscar debe seleccionar una fecha inicial', 'warning', 1000);
        return false;
    }

    if( date_fin == '' ){
        alertAutoMessage('Alerta', 'Para buscar debe seleccionar una fecha final', 'warning', 1000);
        $('#date_fin').focus();
        return false;
    }

    return true;
}
