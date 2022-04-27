

function setDataFormWithResponse() {

    RequiredRemove();

    var forma = document.forms[0];
    var QueryString = "ACTIONCONTROLER=onclickFind&wms_vehiculo_id=" + $('#wms_vehiculo_id').val();

    $.ajax({
        url: 'CrearVehiculoClass.php?random=' + Math.random(),
        data: QueryString,
        beforeSend: function () {
            showDivLoading();
        },
        success: function (resp) {

            try {
                var data = $.parseJSON(resp);
               

                setFormWithJSON(forma, data, false, function () {

                    document.getElementById('imagen_preview').src = data[0]['imagen'];
                    $('#cuadro_imagen_vehiculo').show();

                    if ($('#guardar')) $('#guardar').attr("disabled", "true");
                    if ($('#actualizar')) $('#actualizar').attr("disabled", "");
                    if ($('#borrar')) $('#borrar').attr("disabled", "");
                    if ($('#limpiar')) $('#limpiar').attr("disabled", "");
                });
            } catch (e) {
                alertJquery(resp, "Error :" + e);
            }

            removeDivLoading();

        }

    });



}


function CrearVehiculoOnSaveUpdate(formulario, resp) {
    Reset(formulario);
    clearFind();
    $("#refresh_QUERYGRID_CrearVehiculo").click();
    if ($('#guardar')) $('#guardar').attr("disabled", "");
    if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
    if ($('#borrar')) $('#borrar').attr("disabled", "true");
    if ($('#limpiar')) $('#limpiar').attr("disabled", "");
    alertJquery($.trim(resp));
}


function CrearVehiculoOnDelete(formulario, resp) {
    Reset(formulario);
    clearFind();
    $("#refresh_QUERYGRID_CrearVehiculo").click();
    if ($('#guardar')) $('#guardar').attr("disabled", "");
    if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
    if ($('#borrar')) $('#borrar').attr("disabled", "true");
    if ($('#limpiar')) $('#limpiar').attr("disabled", "");
    alertJquery($.trim(resp));
}

function CrearVehiculoOnReset() {
    clearFind();
    $('#guardar').attr("disabled", "");
    $('#actualizar').attr("disabled", "true");
    $('#borrar').attr("disabled", "true");
    $('#limpiar').attr("disabled", "");
}

//eventos asignados a los objetos
$(document).ready(function () {

    
});