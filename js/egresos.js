
function calcPrecioTotal(){
    $cantidad = document.getElementById('cantidad');
    $precio_unitario = document.getElementById('precio_unitario');
    $precio_total = document.getElementById('precio_total');

    let pu = $precio_unitario.value;
    let cnt = $cantidad.value;
    if( pu == '' || cnt == '' ){
      $precio_total.value = 0.0;
    }else{
      $precio_total.value = parseFloat(pu) * parseFloat(cnt);
    }
}

  $('#form-buscar-egreso').submit(function(event){
      event.preventDefault();

      var data = $('#form-buscar-egreso').serialize();

      var date_inicio = $('#date_inicio').val();
      var date_fin = $('#date_fin').val();

      if( validarFechas(date_inicio, date_fin) ){
        $.ajax({
            type: 'GET',
            url: 'http://localhost/core_v2/api-v1/buscar-egresos',
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
          var montoTotal = round(parseFloat(data[ind]["cantidad"]) * parseFloat(data[ind]["precio_unitario"]));
          var obs = '';
          if(data[ind]["observacion"] != null){
            obs = data[ind]["observacion"];
          }

          var theaderContent = '';
          theaderContent += '<tr>' +
                                '<th class="text-center col-md-2">Fecha</th>' +
                                '<th class="text-center col-md-1">Cantidad</th>' +
                                '<th class="text-center">Concepto</th>' +
                                '<th class="text-center col-md-1">Precio Unit.</th>' +
                                '<th class="text-center col-md-1">Precio Total</th>' +
                                '<th class="text-center col-md-2">Observación</th>' +
                            '</tr>';

          rowsContent  += '<tr>' +
                                // '<td scope="row" class="text-center">' + (ind+1) + '</td>' +
                                '<td class="text-center">'+ data[ind]["fecha"] +'</td>' +
                                '<td class="text-center">' + data[ind]["cantidad"] + '</td>' +
                                '<td class="text-center">' + data[ind]["concepto"] + '</td>' +
                                '<td class="text-center">' + data[ind]["precio_unitario"] + '</td>' +
                                '<td class="text-center">' + montoTotal + '</td>' +

                                  '<td class="text-center">' + obs +'</td>' +

                                // '<td class="text-center"></td>' +
                          '</tr>';
          mtotal += parseFloat(montoTotal);
      }

      $('#mtotal-footer').text(' ' + round(mtotal));

      $('#' + table_id + ' thead').empty();
      $('#' + table_id + ' thead').append(theaderContent);

      $('#' + table_id + ' tbody').empty();
      $('#' + table_id + ' tbody').append(rowsContent);


  }
