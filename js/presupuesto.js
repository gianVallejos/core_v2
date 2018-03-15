function alertMessage(titulo, texto, tipo){
  swal({
    title: titulo,
    text: texto,
    type: tipo
  })
}

function alertAutoMessage(titulo, texto, tipo, time){
  swal({
      title: titulo,
      text: texto,
      timer: time,
      showCancelButton: false,
      showConfirmButton: false,
      type: tipo
    });
}

$('#nuevo-presupuesto').click(function(){
    var idDoctorSel = $('#medico option:selected').val();
    var idPacienteSel = $('#paciente-id').val();
    if( idDoctorSel == '-1' ){
        alertMessage('','Debes seleccionar un doctor', 'warning');
    }else if( idPacienteSel == '' ){
        alertMessage('', 'Debes seleccionar un paciente', 'warning');
    }else{
        url = "/core_v2/presupuestos/create/" + idDoctorSel + '/' + idPacienteSel;
        window.location.href = url;
        // var options = "fullscreen=yes, resizable=false";
        // ventana= window.open(url, "_blank");
        // window.close();
        // ventana.focus();
    }
});


function agregarAPrespPaciente(hc, paciente){
    $('#paciente').val(paciente);
    $('#paciente-id').val(hc);
    $('#buscarPaciente').modal('hide');
}

$('#openBuscarPaciente').on('click', function(){
    $('#buscarPaciente').modal('show');
    $('#buscar-paciente').focusin();
});

$(document).ready(function(){
    $('.dropdown-toggle').dropdown();
});

function round(num){
    return Number(num).toFixed(2);
}
