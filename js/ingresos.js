let monto_actual = -1;

function mostrarDetalleIngreso(php_data){
    data = JSON.parse(php_data);

    $('#hc-txt').text(data["hc"]);
    $('#fecha-txt').text(data["fecha"]);
    $('#paciente-txt').text(data["pacientes"]);
    $('#doctor-txt').text(data["doctor"]);
    $('#cantidad-txt').text(data["cantidad"]);
    $('#tratamiento-txt').text(data["tratamiento"]);

    $('#montoUnitario-txt').text('S/ ' + data["monto"]);

    mt = round(parseFloat(data["monto"]) * parseFloat(data["cantidad"]));
    $('#montoTotal-txt').text('S/ ' + mt);

    var mg = parseFloat(data["mg"]);
    var md = mt * mg/100;
    $('#montoDoctor-txt').text( 'S/ ' + md );

    $('#montoCORE-txt').text('S/ ' + round(mt - md));
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
        var montoTotal = round(parseFloat(data[ind]["monto"]) * parseFloat(data[ind]["cantidad"]));
        var montoMedico = round(montoTotal * (parseFloat(data[ind]["mg"])/100));
        var montoCore = round(montoTotal - montoMedico);

        var theaderContent = '';
        theaderContent += '<tr>' +
                              '<th class="text-center">Fecha</th>' +
                              '<th class="text-center">HC</th>' +
                              '<th class="text-center">Paciente</th>' +
                              '<th class="text-center">Doctor</th>' +
                              '<th class="text-center">Tratamiento</th>' +
                              '<th class="text-center print-ignore">Cant</th>' +
                              '<th class="text-center print-ignore">Precio Unit</th>' +
                              '<th class="text-center print-ignore">Total</th>' +
                              '<th class="text-center">M. Doc.</th>' +
                              '<th class="text-center print-ignore">CORE</th>' +
                          '</tr>';

        rowsContent  += '<tr>' +
                              // '<td scope="row" class="text-center">' + (ind+1) + '</td>' +
                              '<td class="text-center">'+ data[ind]["fecha"] +'</td>' +
                              '<td class="text-center">' + data[ind]["hc"] + '</td>' +
                              '<td class="text-center">' + data[ind]["pacientes"] + '</td>' +
                              '<td class="text-center">' + data[ind]["ap_doctor"] + '</td>' +
                              '<td class="text-center">' + data[ind]["tratamiento"] + '</td>' +
                              '<td class="text-center print-ignore">' + data[ind]["cantidad"] + '</td>' +
                              '<td class="text-center print-ignore">' + data[ind]["monto"] +'</td>' +
                              '<td class="text-center print-ignore">' + montoTotal +'</td>' +
                              '<td class="text-center">' + montoMedico + '</td>' +
                              '<td class="text-center print-ignore">' + montoCore + '</td>' +
                              // '<td class="text-center"></td>' +
                        '</tr>';
        mdoc += parseFloat(montoMedico);
        mcore += parseFloat(montoCore);
        mtotal += parseFloat(montoTotal);
    }
    
    $('#mtotal-footer').text(round(mtotal));
    $('#mdoc-footer').text(round(mdoc));
    $('#mcore-footer').text(round(mcore));

    $('#' + table_id + ' thead').empty();
    $('#' + table_id + ' thead').append(theaderContent);

    $('#' + table_id + ' tbody').empty();
    $('#' + table_id + ' tbody').append(rowsContent);


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

function agregarAIngresoPaciente(hc, paciente){
    $('#paciente_id').val(hc);
    $('#paciente_nombre').val(paciente);

    restartTratamientosInputs();
    calcularTratamientosPorPaciente(hc);

    $('#buscarPaciente').modal('hide');
}

function restartTratamientosInputs(){
    $('#tratamiento').val('');
    $('#monto').val('');
    $('#cantidad').val('1');
}

function calcularTratamientosPorPaciente(idPaciente){

  $.ajax({
      type: 'GET',
      url: '/core_v2/api-v1/obtener-tratamientos-id-paciente/' + idPaciente,
      success: function(data){
          tratamientos = JSON.parse(data);
          mostrarTratamientosEnModal(tratamientos);
      },
      error: function(){
          alertMessage('Error', 'Error al conseguir tratamientos. Comunicar al webmaster', 'error');
      }
  });
}

function mostrarTratamientosEnModal(tratamientos){
    console.log(tratamientos);
    str = "";
    for( let ind = 0; ind < tratamientos.length; ind++ ){
      const id = tratamientos[ind]["id"];
      const detalle = tratamientos[ind]["detalle"];
      const monto = tratamientos[ind]["monto"];

      str += '<tr>' +
                   '<td>'+ (ind + 1) +'</td>' +
                   '<td>' + detalle +'</td>' +
                   '<td>' + monto  +'</td>' +
                   '<td><button class="btn btn-xs btn-info" ' +
                           'onclick="agregarTratamientoADOM(\''+ id +'\', \''+ detalle +'\', \''+ monto +'\')" >' +
                        'Aceptar</button></td>' +
            '</tr>';
    }
    $('#tablaTratamiento > tbody').empty();
    $('#tablaTratamiento > tbody').append(str);
}

function agregarTratamientoADOM(id, detalle, monto){
    monto_actual = monto;

    $('#tratamiento_id').val(id);
    $('#tratamiento').val(detalle);
    $('#monto').val(calcularMontoCantidad());

    $('#buscarTratamiento').modal('hide');
}

$('#openBuscarPaciente').on('click', function(){
    $('#buscarPaciente').modal('show');
});

$('#openBuscarTratamiento').on('click', function(){
    let paciente_id = $('#paciente_id').val();
    if( paciente_id.length == 0 ){
        swal('Alerta', 'Primero debe seleccionar un paciente', 'warning');
    }else{
        $('#buscarTratamiento').modal('show');
    }
});

$('#cantidad').on('change', function(){
    let val = $('#cantidad').val();
    if( val == '' ){
        $('#cantidad').val('1');
    }

    $('#monto').val(calcularMontoCantidad());
});

function getMontoActual(){
    let val = parseFloat($('#cantidad').val());
    if( monto_actual == -1 && !isNaN($('#monto').val()) ){
        monto_actual = parseFloat($('#monto').val() / val);
    }
    // alert(monto_actual);
}
getMontoActual();

function calcularMontoCantidad(){
    let val = parseFloat($('#cantidad').val());

    let monto = parseFloat(monto_actual);

    if( !isNaN(monto) ){ //Existe monto
        let total = val * monto;
        return total;
    }

    return '';
}
