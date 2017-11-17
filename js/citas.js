$(document).ready(function() {
  var eventos = JSON.parse(agendas);

  loadCalendar(eventos);

  $('#cita-form').submit(function(event){
      event.preventDefault();

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
                      alertMessage('Éxito', 'Cita agregada correctamente', 'success');
                      setTimeout( function(){
                          location.reload();
                      }, 2000);
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
      $nombrePaciente = $.trim($('#nombrePaciente').val());
      $celularPaciente = $.trim($('#celularPaciente').val());

      datosAgregarPacienteForm($nombrePaciente, $celularPaciente);

  });

});

function agregarACitaPaciente(paciente, celular){
    if( celular == '' ){
        celular = '';
    }
    datosAgregarPacienteForm(paciente, celular);

}

function datosAgregarPacienteForm(paciente, celular){
    $('#paciente').val(paciente);
    $('#celular').val(celular);

    alertMessage('Éxito', 'Paciente agregado correctamente.', 'success');

    $('.nuevoPaciente').hide();
    $('.buscarPaciente').hide();

    $('#paciente-length').attr('class', 'col-md-6');

    $('.modal').modal('hide');
    // $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
}
