function getAge(dateString) {
    var today = new Date();
    var birthDate = new Date(dateString);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age;
}

function mostrarDetalle(php_data) {
    console.log(JSON.parse(php_data));
    data = JSON.parse(php_data);
    // alert(data["nombres"]);
    $('#nombres-txt').text(data["nombres"] + " " + data["apellidos"]);
    $('#dni-txt').text(data["dni"]);
    $('#email-txt').text(data["email"]);
    $('#direccion-txt').text(data["direccion"]);
    $('#fechanacimiento-txt').text(data["fechanacimiento"]);
    $('#edad-txt').text(getAge(data["fechanacimiento"]));
    $('#genero-txt').text(data["genero"]);
    $('#estado-txt').text(data["estado"]);
    $('#telefono-txt').text(data["telefono"]);
    $('#margen_ganancia-txt').text(data["margen_ganancia"] + " %");
    $('#celular-txt').text(data["celular"]);
    $('#celular_aux-txt').text(data["celular_aux"]);
}
