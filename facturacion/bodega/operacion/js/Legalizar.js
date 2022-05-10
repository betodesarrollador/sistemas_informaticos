var formSubmitted = false;
$(document).ready(function() {

    $("#divAnulacion").css("display", "none");
    $("#guardar,#actualizar").click(function() {

        var formulario = document.getElementById('LegalizarForm');

        if (ValidaRequeridos(formulario)) {
            if (this.id == 'guardar') {
                if (!formSubmitted) {
                    formSubmitted = true;
                    Send(formulario, 'onclickSave', null, LegalizarOnSave);
                }
            } else {
                Send(formulario, 'onclickUpdate', null, LegalizarOnUpdate);
            }
        }
        formSubmitted = false;

    });

    $("#saveDetalle").click(function() {
        var formulario = document.getElementById('LegalizarForm');
        window.frames[0].saveDetalles(formulario);
        setDataFormWithResponse();
    });


});

function viewDoc(enturnamiento_id) {

    $('#recepcion_id').val(recepcion_id);
    setDataFormWithResponse();
}

function setDataFormWithResponse() {
    RequiredRemove();

    FindRow(
        [{ campos: "recepcion_id", valores: $("#recepcion_id").val() }],
        document.forms[0], "LegalizarClass.php", null,
        function(resp) {
            try {

                var data = $.parseJSON(resp);
                var estado = data[0]['estado'];
                var recepcion_id = $('#recepcion_id').val();


                if (estado == 'P') {
                    if ($("#guardar")) $("#guardar").attr("disabled", "true");
                    if ($("#actualizar")) $("#actualizar").attr("disabled", "");
                    if ($("#borrar")) $("#borrar").attr("disabled", "");
                    if ($("#limpiar")) $("#limpiar").attr("disabled", "");
                    var url = "detallesLegalizarClass.php?recepcion_id=" + recepcion_id + "&estado=" + estado + "&rand=" + Math.random();
                    $("#detallesLegalizar").attr("src", url);
                    document.getElementById('saveDetalle').disabled = false;
                } else if (estado == 'L') {

                    if ($("#guardar")) $("#guardar").attr("disabled", "true");
                    if ($("#actualizar")) $("#actualizar").attr("disabled", "true");
                    if ($("#anular")) $("#anular").attr("disabled", "");
                    if ($("#borrar")) $("#borrar").attr("disabled", "true");
                    if ($("#limpiar")) $("#limpiar").attr("disabled", "");

                    var url = "detallesLegalizarClass.php?recepcion_id=" + recepcion_id + "&estado=" + estado + "&rand=" + Math.random();
                    $("#detallesLegalizar").attr("src", url);

                    document.getElementById('saveDetalle').disabled = true;
                } else if (estado == 'A') {
                    if ($("#guardar")) $("#guardar").attr("disabled", "true");
                    if ($("#actualizar")) $("#actualizar").attr("disabled", "true");
                    if ($("#anular")) $("#anular").attr("disabled", "true");
                    if ($("#borrar")) $("#borrar").attr("disabled", "");
                    if ($("#limpiar")) $("#limpiar").attr("disabled", "");

                    var url = "detallesLegalizarClass.php?recepcion_id=" + recepcion_id + "&estado=" + estado + "&rand=" + Math.random();
                    $("#detallesLegalizar").attr("src", url);
                    document.getElementById('saveDetalle').disabled = true;
                } else {
                    if ($("#guardar")) $("#guardar").attr("disabled", "true");
                    if ($("#actualizar")) $("#actualizar").attr("disabled", "true");
                    if ($("#anular")) $("#anular").attr("disabled", "true");
                    if ($("#borrar")) $("#borrar").attr("disabled", "true");
                    if ($("#limpiar")) $("#limpiar").attr("disabled", "");

                    var url = "detallesLegalizarClass.php?recepcion_id=" + recepcion_id + "&estado=" + estado + "&rand=" + Math.random();
                    $("#detallesLegalizar").attr("src", url);
                    document.getElementById('saveDetalle').disabled = true;
                }

            } catch (e) {
                alertJquery(resp, "Error :" + e);
            }
        }
    );
}

function onclickAnular(formulario) {

    var recepcion_id = $("#recepcion_id").val();

    if ($("#divAnulacion").is(":visible")) {

        var formulario = document.getElementById('LegalizarForm');
        var fecha_anulacion = $("#fecha_anulacion").val();
        var observacion_anulacion = $("#observacion_anulacion").val();

        if (ValidaRequeridos(formulario)) {

            if (!formSubmitted) {

                var QueryString = "ACTIONCONTROLER=onclickAnular&recepcion_id=" + recepcion_id + "&fecha_anulacion=" + fecha_anulacion +
                    "&observacion_anulacion=" + observacion_anulacion;

                $.ajax({
                    url: "LegalizarClass.php?rand=" + Math.random(),
                    data: QueryString,
                    beforeSend: function() {
                        showDivLoading();
                        formSubmitted = true;
                    },
                    success: function(response) {

                        Reset(formulario);
                        clearFind();
                        removeDivLoading();
                        $("#divAnulacion").dialog('close');

                        formSubmitted = false;

                        if ($.trim(response) == 'true') {
                            /*  document.getElementById('recepcion').disabled = false;
                             document.getElementById('muelle').disabled = false; */
                            if ($("#guardar")) $("#guardar").attr("disabled", "");
                            if ($("#actualizar")) $("#actualizar").attr("disabled", "true");
                            if ($("#anular")) $("#anular").attr("disabled", "");
                            if ($("#borrar")) $("#borrar").attr("disabled", "");
                            if ($("#limpiar")) $("#limpiar").attr("disabled", "");

                            alertJquery('Anulada Exitosamente', 'Legalizacion');

                        } else {
                            alertJquery(response, 'Inconsistencia Anulando');
                        }


                    }

                });

            }

        }

    } else {

        var recepcion_id = $("#recepcion_id").val();
        // var estado = document.getElementById("estado").value;

        if (parseInt(recepcion_id) > 0) {

            $("input[name=anular]").each(function() { this.disabled = false; });

            $("#divAnulacion").dialog({
                title: 'Anulacion Legalizacion',
                width: 450,
                height: 280,
                closeOnEscape: true
            });

        } else {
            alertJquery('Debe Seleccionar primero una Legalizacion', 'Anulacion');
        }

    }


}

function LegalizarOnSave(formulario, resp) {
    //Reset(formulario);
    //clearFind();
    try {
        var recepcion_id = $.parseJSON(resp);
        var estado = $("#estado").val();

        if (recepcion_id != '') {

            var url = "detallesLegalizarClass.php?recepcion_id=" + recepcion_id + "&estado=" + estado + "&rand=" + Math.random();
            $("#detallesLegalizar").attr("src", url);
            $("#recepcion_id").val(recepcion_id);
            $("#refresh_QUERYGRID_wms_recepcion").click();

            if ($("#guardar")) $("#guardar").attr("disabled", "true");
            if ($("#actualizar")) $("#actualizar").attr("disabled", "");
            if ($("#borrar")) $("#borrar").attr("disabled", "");
            if ($("#limpiar")) $("#limpiar").attr("disabled", "");


            alertJquery('Guardado Exitosamente', "Enturnamiento");
        } else {
            alertJquery('Inconsistencia Guardando', "Enturnamiento");
        }

    } catch (e) {
        alertJquery("¡Uno de los productos que se quiere agregar no existe creado!", "Atención");
    }

}

function LegalizarOnUpdate(formulario, resp) {
    Reset(formulario);
    clearFind();
    $("#detallesLegalizar").attr("src", "sistemas_informaticos/framework/tpl/blank.html");
    var recepcion_id = resp;

    if (recepcion_id > 0) {

        $("#refresh_QUERYGRID_wms_recepcion").click();

        if ($("#guardar")) $("#guardar").attr("disabled", "");
        if ($("#actualizar")) $("#actualizar").attr("disabled", "true");
        if ($("#borrar")) $("#borrar").attr("disabled", "true");
        if ($("#limpiar")) $("#limpiar").attr("disabled", "");

        alertJquery('Actualizado Exitosamente', "Enturnamiento");
    } else {
        alertJquery('Inconsistencia Actualizando', "Enturnamiento");
    }

}

function LegalizarOnDelete(formulario, resp) {
    Reset(formulario);
    clearFind();

    if (resp == 'true') {

        $("#detallesLegalizar").attr("src", "sistemas_informaticos/framework/tpl/blank.html");
        $("#refresh_QUERYGRID_wms_recepcion").click();

        if ($("#guardar")) $("#guardar").attr("disabled", "");
        if ($("#actualizar")) $("#actualizar").attr("disabled", "true");
        if ($("#borrar")) $("#borrar").attr("disabled", "true");
        if ($("#limpiar")) $("#limpiar").attr("disabled", "");
        $("#estado").val('P');

        alertJquery('Legalizacion Eliminada Exitosamente', "Enturnamiento");
    } else {
        alertJquery('Inconsistencia Eliminando', "Enturnamiento");
    }

}


function LegalizarOnReset(formulario) {
    Reset(formulario);
    clearFind();

    /* $('#estado').empty().append('<option selected="selected" value="NULL">( Seleccione )</option>');
    $('#estado').append('<option  value="B">BLOQUEADO</option>');
    $('#estado').append('<option  value="D">DISPONIBLE</option>'); */
    //var usuario_id = $("#usuario_id_static").val();
    //$("#usuario_id").val(usuario_id);
    var hoy = new Date();
    var fecha = hoy.getFullYear() + '-' + (hoy.getMonth() + 1) + '-' + hoy.getDate();
    var hora = hoy.getHours() + ':' + hoy.getMinutes() + ':' + hoy.getSeconds();
    var fechaHora = fecha + ' ' + hora;
    $('#fecha').val(fechaHora);
    $("#estado").val('P');
    if ($("#guardar")) $("#guardar").attr("disabled", "");
    if ($("#actualizar")) $("#actualizar").attr("disabled", "true");
    if ($("#borrar")) $("#borrar").attr("disabled", "true");
    if ($("#limpiar")) $("#limpiar").attr("disabled", "");
    $("#detallesLegalizar").attr("src", "sistemas_informaticos/framework/tpl/blank.html");
}