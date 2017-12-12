$(document).ready(function() {
  var eventos = JSON.parse(agendas);

  loadCalendar(eventos);

  $('#cita-form').submit(function(event){
      event.preventDefault();

      var hc = $.trim($('#hc').val());
      if( hc == '' ){ hc = -1; }
      var paciente = $.trim($('#paciente').val());
      var celular = $.trim($('#celular').val());
      var doctor = $.trim($('#doctor').val());
      var tratamiento = $.trim($('#tratamiento').val());
      var dia = $.trim($('#dia').val());
      var desde = $.trim($('#desde').val());
      var hasta = $.trim($('#hasta').val());

      if( validarDatos(paciente, doctor, tratamiento, dia, desde, hasta) ){
          $.ajax({
              type: 'GET',
              url: '/core_v2/api-v1/agregar-cita',
              data: {
                    'hc': hc,
                    'paciente': paciente,
                    'celular': celular,
                    'dia': dia,
                    'desde': desde,
                    'hasta': hasta,
                    'doctor':doctor,
                    'tratamiento': tratamiento
              },
              success: function(data){
                  var estado = JSON.parse(data);

                  if( estado[0]["ESTADO"] > 0 ){
                      swal({
                          title: "Éxito",
                          text: "Cita agregada correctamente.",
                          type: "success",
                          closeOnConfirm: false
                      },
                        function(){
                            location.reload();
                      });
                      // loadCalendar();
                      //RESET FIELDS & UPDATE CALENDAR
                      //Loadcalendar should get data from WsController to update live
                  }
                  else{
                      alertMessage('Error', 'Ha ocurrido un error. Avisar al Webmaster', 'error');
                  }
              },
              error: function(){
                  alertMessage('Error', 'Error al actualizar los datos', 'error');
              }
          });
      }
  });

  $('#selectDoctor').change(function(){
      var idUser = $('#selectDoctor :selected').val();
      $.ajax({
          type: 'GET',
          url: '/core_v2/api-v1/obtener-cita/' + idUser,
          data: {},
          success: function(data){
              var eventos = JSON.parse(data);
              $('#calendar').fullCalendar( 'removeEvents' );
              $('#calendar').fullCalendar('addEventSource', eventos);
          },
          error: function(){
              alertMessage('Error', 'Error al buscar agenda del doctor', 'error');
          }
      });
  });

  function validarDatos(paciente, doctor, tratamiento, dia, desde, hasta){

      if( paciente == "" ){
          alertMessage('Error', 'Debe seleccionar un paciente', 'error');
          $('#paciente').focus();
          return false;
      }

      if( tratamiento == "" ){
          alertMessage('Error', 'Debe escribir un tratamiento', 'error');
          $('#tratamiento').focus();
          return false;
      }

      if( doctor == "-1" ){
          alertMessage('Error', 'Debe seleccionar un doctor', 'error');
          $('#doctor').focus();
          return false;
      }

      if( dia == '' ){
          alertMessage('Error', 'Debe seleccionar una fecha', 'error');
          $('#dia').focus();
          return false;
      }
      if( desde == "-1" ){
          alertMessage('Error', 'Debe seleccionar una hora inicial', 'error');
          $('#desde').focus();
          return false;
      }

      if( hasta == "-1" ){
          alertMessage('Error', 'Debe seleccionar una hora final', 'error');
          $('#hasta').focus();
          return false;
      }
      return true;
  }

  function loadCalendar(eventos){
    var g = new Date();
    var month = g.getMonth()+1;
    var today = g.getFullYear() + '-' + (month<10 ? '0' : '') + month;

    $('#calendar').fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,listDay,listWeek'
      },
      buttonText: { today: 'Hoy', month: 'Mes', week: 'Sem', day: 'Día' },
      monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
      monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
      dayNames: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sábado'],
      dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mier', 'Jue', 'Vie', 'Sab'],
      views: {
				listDay: { buttonText: 'Por Dia' }
			},
			defaultView: 'month',
      defaultDate: today,
      navLinks: true, // can click day/week names to navigate views
      editable: true,
      eventLimit: true, // allow "more" link when too many events
      events: eventos
    });
  }

  $('#nuevoPacienteForm').submit(function(event){
      event.preventDefault();

      let hc = -1;
      let nombrePaciente = $.trim($('#nombrePaciente').val());
      let celularPaciente = $.trim($('#celularPaciente').val());

      if( validarNuevoPaciente(nombrePaciente, celularPaciente) ){
        datosAgregarPacienteForm(hc, nombrePaciente, celularPaciente);
      }

  });

  function validarNuevoPaciente(nombre, celular){
      if( nombre == "" ){
          alertMessage('Error', 'Debe seleccionar un nombre de paciente', 'error');
          $('#nombrePaciente').focus();
          return false;
      }
      return true;
  }

  $('#gestion-citas-down').on('click', function(){
      $('#gestion-citas-up').css('display', 'inline-block');
      $(this).css('display', 'none');
  });

  $('#gestion-citas-up').on('click', function(){
      $('#gestion-citas').collapse('hide');
      $('#gestion-citas-down').css('display', 'inline-block');
      $(this).css('display', 'none');
  });

});

function agregarACitaPaciente(hc, paciente, celular){
    if( celular == '' ){
        celular = '';
    }
    datosAgregarPacienteForm(hc, paciente, celular);

}

function datosAgregarPacienteForm(hc, paciente, celular){
    if( hc != '-1' ){
      $('#hc').val(hc);
    }else{
      $('#group-hc-class').hide();
      $('#group-celular-class').attr('class', 'col-md-12');
      hcActual = -1;
    }
    $('#paciente').val(paciente);
    $('#celular').val(celular);

    alertMessage('Éxito', 'Paciente agregado correctamente.', 'success');

    $('.nuevoPaciente').hide();
    $('.buscarPaciente').hide();

    // $('#paciente-length').attr('class', 'col-md-6');

    $('.modal').modal('hide');
    // $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
}

function editarCita(php_data) {
    data = JSON.parse(php_data);

    var idAgenda = data["id"];
    document.edit.idAgenda.value = idAgenda;

    //$('#idAgenda-txto').text(data["id"]);
    $('#title-txto').text(data["title"]);
    $('#paciente-2').val(data["title"]);

    $('#hc-2').val(data["hc"]);

    if(data["hc"] != '-1'){
        $('#paciente-2').prop('readonly', true);
    }

    var celular = data["celular"];
    document.edit.celular.value = celular;

    var desde = data["desde"];
    var dia = desde.substring(0, 10);
    var desde = desde.substring(11, 19);
    document.edit.dia.value = dia;
    document.edit.desde.value = desde;

    var hasta = data["hasta"];
    var hasta = hasta.substring(11, 19);
    document.edit.hasta.value = hasta;

    var idDoctor = data["idDoctor"];
    document.edit.idDoctor.value = idDoctor;

    var tratamiento = data["tratamiento"];
    document.edit.tratamiento.value = tratamiento;
}

function editarAgenda() {
    let citas = $('#editar-cita').serialize();
    $.ajax({
        type: 'GET',
        url: '/core_v2/api-v1/editar-cita',
        dataType: 'json',
        contentType: "application/json; charset=utf-8",
        data: citas,
        success: function (data) {
            let estado = JSON.parse(data[0]["ESTADO"]);
            if( estado == '1' ){
                swal({
                    title: "Correcto",
                    text: "Se ha modificado la cita correctamente.",
                    type: "success",
                    closeOnConfirm: false
                },
                  function(){
                      location.reload();
                });
            }else{
                swal('Error', 'Ha ocurrido un error al modificar.', 'warning');
            }
        },
        error: function () {
            swal('Atención', 'Ha ocurrido un problema. Contactar con el webmaster', 'warning');
        }
    });

}
