// JavaScript Document

$(document).ready(function() {

    $("#divCierre").css("display", "none");
    if ($('#cerrar')) $('#cerrar').attr("disabled", "true");

    resetDetalle('detalleActividad');
    $("#saveDetalles").click(function() {
        window.frames[0].saveDetallesSoliServi();
    });

    $("#deleteDetalles").click(function() {
        window.frames[0].deleteDetallesSoliServi();
    });

    $("#saveTerceros").click(function() {
        window.frames[1].saveDetallesSoliServi();
    });

    $("#deleteTerceros").click(function() {
        window.frames[1].deleteDetallesSoliServi();
    });


    /*$("#ubicacion").blur(function(){
    	//alert(document.getElementById('ubicacion_id'));
    	var ubicacion_id = $('#ubicacion_hidden').val();
        getBarrio(ubicacion_id,null);
      }); */

});

function setDataFormWithResponse() {

    RequiredRemove();

    FindRow([{ campos: "actividad_id", valores: $('#actividad_id').val() }], document.forms[0], 'ActividadClass.php', null,
        function(resp) {

            try {

                var data = $.parseJSON(resp);
                var actividad_id = data[0]['actividad_id'];


                var archivo = data[0]['archivo'];
                var estado = data[0]['estado'];


                if (archivo != '' && archivo != 'NULL' && archivo != 'null' && archivo != null) {
                    $("#adjuntover").html('<a href="' + archivo + '" target="_blank">Ver Adjunto</a>');
                } else {
                    $("#adjuntover").html('&nbsp;');
                }

                if (estado == 2) {

                    if ($('#guardar')) $('#guardar').attr("disabled", "true");
                    if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
                    if ($('#borrar')) $('#borrar').attr("disabled", "");
                    if ($('#limpiar')) $('#limpiar').attr("disabled", "");
                    if ($('#cerrar')) $('#cerrar').attr("disabled", "true");

                } else {

                    if ($('#guardar')) $('#guardar').attr("disabled", "true");
                    if ($('#actualizar')) $('#actualizar').attr("disabled", "");
                    if ($('#borrar')) $('#borrar').attr("disabled", "");
                    if ($('#limpiar')) $('#limpiar').attr("disabled", "");
                    if ($('#cerrar')) $('#cerrar').attr("disabled", "");
                }

            } catch (e) {
                alertJquery(resp, "Error :" + e);
            }

        });



}

function getBarrio(valor, barrio_id) {

    var url = 'ActividadClass.php?rand=' + Math.random();
    var QueryString = 'ACTIONCONTROLER=getBarrio&ubicacion_id=' + valor + "&barrio_id=" + barrio_id;

    $.ajax({
        url: url,
        data: QueryString,
        beforeSend: function() {
            showDivLoading();
        },
        success: function(responseText) {

            try {

                if ($.trim(responseText) == 'null') {
                    alert('No existen cuentas paramtrizadas para el reporte!!');
                } else {
                    var option = $.parseJSON(responseText);

                    $("#barrio_id option").each(function(index, element) {

                        if (this.value != 'NULL') {
                            $(this).remove();
                        }

                    });

                    for (var i = 0; i < option.length; i++) {
                        $("#barrio_id").append("<option value='" + option[i]['value'] + "' selected='" + option[i]['value'] + "'>" + option[i]['text'] + "</option>");
                    }
                }

            } catch (e) {
                alert("Error :" + responseText);
            }

            removeDivLoading();
        }
    });

}

function ActividadOnSaveOnUpdateonDelete(formulario, resp) {

    Reset(formulario);
    clearFind();
    resetDetalle('detalleActividad');
    $("#refresh_QUERYGRID_Actividad").click();

    if ($('#guardar')) $('#guardar').attr("disabled", "");
    if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
    if ($('#borrar')) $('#borrar').attr("disabled", "true");
    if ($('#limpiar')) $('#limpiar').attr("disabled", "");

    alertJquery(resp, "Actividad");

}

function ActividadOnReset(formulario) {

    Reset(formulario);
    clearFind();
    resetDetalle('detalleActividad');

    $("#adjuntover").html('&nbsp;');

    if ($('#guardar')) $('#guardar').attr("disabled", "");
    if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
    if ($('#borrar')) $('#borrar').attr("disabled", "true");
    if ($('#limpiar')) $('#limpiar').attr("disabled", "");
    if ($('#cerrar')) $('#cerrar').attr("disabled", "true");
}

function onSendFile(response) {

    if ($.trim(response) == 'false') {
        alertJquery('No se ha podido adjuntar el archivo !!');
    } else {

        alertJquery("Se ha Cargado el adjunto", "Validacion Adjunto");
        setDataFormWithResponse();
    }

}

function validaSeleccionTarea() {

    var actividad_id = $("#actividad_id").val();

    if (parseInt(actividad_id) > 0) {
        return true;
    } else {
        alertJquery('Debe cargar primero una actividad, Luego adjunte de nuevo el archivo!!', 'Validacion');
        return false;
    }

}

function Cierre() {


    if ($("#divCierre").is(":visible")) {


        var actividad_id = $("#actividad_id").val();
        var fecha_cierre_real = $('#fecha_cierre_real').val();
        var observacion_cierre = $('#observacion_cierre').val();

        var QueryString = "ACTIONCONTROLER=guardarCierre&actividad_id=" + actividad_id + "&fecha_cierre_real=" + fecha_cierre_real + "&observacion_cierre=" + observacion_cierre + "&rand=" + Math.random();
        $.ajax({
            url: "ActividadClass.php",
            data: QueryString,
            success: function(resp) {

                try {
                    alertJquery(resp, 'Actividad Cerrada');
                    formSubmitted = false;
                    setDataFormWithResponse();

                } catch (e) {
                    alertJquery(e, 'Actividad');
                    formSubmitted = false;
                }

                $("#divCierre").dialog('close');
            }
        });

    } else {

        $("#divCierre").dialog({
            title: 'Cierre actividad',
            width: 450,
            height: 300,
            closeOnEscape: true
        });

    }

}