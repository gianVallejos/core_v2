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
    var idPacienteSel = $('#paciente option:selected').val();
    if( idDoctorSel == '-1' ){
        alertMessage('','Debes seleccionar un doctor', 'warning');
    }else if( idPacienteSel == '-1' ){
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

$(document).ready(function(){
    $('.dropdown-toggle').dropdown();
});

function round(num){
    return Number(num).toFixed(2);
}
