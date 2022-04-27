function setDataFormWithResponse() {

    var parametros = new Array({ campos: "estado_producto_id", valores: $('#estado_producto_id').val() });
    var forma = document.forms[0];
    var controlador = 'estadoClass.php';

    FindRow(parametros, forma, controlador, null, function (resp) {

        if ($('#guardar')) $('#guardar').attr("disabled", "true");
        if ($('#actualizar')) $('#actualizar').attr("disabled", "");
        if ($('#borrar')) $('#borrar').attr("disabled", "");
        if ($('#limpiar')) $('#limpiar').attr("disabled", "");

    });
}


function estadoOnSaveUpdate(formulario, resp) {
    Reset(formulario);
    clearFind();
    $("#refresh_QUERYGRID_estado").click();
    if ($('#guardar')) $('#guardar').attr("disabled", "");
    if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
    if ($('#borrar')) $('#borrar').attr("disabled", "true");
    if ($('#limpiar')) $('#limpiar').attr("disabled", "");
    alertJquery($.trim(resp));
}


function estadoOnDelete(formulario, resp) {
    Reset(formulario);
    clearFind();
    $("#refresh_QUERYGRID_estado").click();
    if ($('#guardar')) $('#guardar').attr("disabled", "");
    if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
    if ($('#borrar')) $('#borrar').attr("disabled", "true");
    if ($('#limpiar')) $('#limpiar').attr("disabled", "");
    alertJquery($.trim(resp));
}

function estadoOnReset() {
    clearFind();
    $('#guardar').attr("disabled", "");
    $('#actualizar').attr("disabled", "true");
    $('#borrar').attr("disabled", "true");
    $('#limpiar').attr("disabled", "");
}

//eventos asignados a los objetos
$(document).ready(function () {

    //evento que busca los datos ingresado
});