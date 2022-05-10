var formSubmitted = false;
$(document).ready(function() {
    document.getElementById('estado').disabled = true;
    $("#divAnulacion").css("display", "none");

    $("#deleteDetalle").click(function() {
        window.frames[0].deleteDetalles();
    });


    $("#guardar,#actualizar").click(function() {

        var formulario = document.getElementById('RecepcionProductoForm');

        if (ValidaRequeridos(formulario)) {
            if (this.id == 'guardar') {
                if (!formSubmitted) {
                    formSubmitted = true;
                    Send(formulario, 'onclickSave', null, EnturnamientoOnSave);
                }
            } else {
                Send(formulario, 'onclickUpdate', null, EnturnamientoOnUpdate);
            }
        }
        formSubmitted = false;

    });


});

function viewDoc(enturnamiento_id) {

    $('#enturnamiento_id').val(enturnamiento_id);
    setDataFormWithResponse();
}

function setDataFormWithResponse() {
    RequiredRemove();

    FindRow(
        [{ campos: "enturnamiento_id", valores: $("#enturnamiento_id").val() }],
        document.forms[0], "EnturnamientoClass.php", null,
        function(resp) {
            try {

                var data = $.parseJSON(resp);
                var estado = data[0]['estado'];
                var muelle_id = data[0]['muelle_id'];
                var enturnamiento_id = $('#enturnamiento_id').val();

                if (muelle_id > 0) {
                    if (estado == 'B') {
                        if ($("#archivo")) $("#archivo").attr("disabled", "true");
                        if ($("#guardar")) $("#guardar").attr("disabled", "true");
                        if ($("#limpiar")) $("#limpiar").attr("disabled", "");
                        $("#detallesEnturnamiento").attr("src", "sistemas_informaticos/framework/tpl/blank.html");
                    } else if (estado == 'L') {

                        if ($("#archivo")) $("#archivo").attr("disabled", "true");
                        if ($("#guardar")) $("#guardar").attr("disabled", "true");
                        if ($("#limpiar")) $("#limpiar").attr("disabled", "");
                        var url = "detallesEnturnamientoClass.php?enturnamiento_id=" + enturnamiento_id + "&rand=" + Math.random();
                        $("#detallesEnturnamiento").attr("src", url);
                        $('#estado').val('L');
                    } else if (estado == 'F') {
                        if ($("#archivo")) $("#archivo").attr("disabled", "true");
                        if ($("#guardar")) $("#guardar").attr("disabled", "true");
                        if ($("#limpiar")) $("#limpiar").attr("disabled", "");
                        var url = "detallesEnturnamientoClass.php?enturnamiento_id=" + enturnamiento_id + "&rand=" + Math.random();
                        $("#detallesEnturnamiento").attr("src", url);
                        $('#estado').val('L');
                    } else {
                        document.getElementById('estado').disabled = true;
                        if ($("#archivo")) $("#archivo").attr("disabled", "");
                        if ($("#guardar")) $("#guardar").attr("disabled", "");
                        if ($("#limpiar")) $("#limpiar").attr("disabled", "");

                        var url = "detallesEnturnamientoClass.php?enturnamiento_id=" + enturnamiento_id + "&rand=" + Math.random();
                        $("#detallesEnturnamiento").attr("src", url);
                    }
                } else {
                    if ($("#archivo")) $("#archivo").attr("disabled", "true");
                    if ($("#guardar")) $("#guardar").attr("disabled", "true");
                    if ($("#limpiar")) $("#limpiar").attr("disabled", "");

                    $("#detallesEnturnamiento").attr("src", "sistemas_informaticos/framework/tpl/blank.html");
                    alertJquery("Debe primero asiganr un muelle, puede hacerlo en el formulario 'Asignar Muelle'");
                }

            } catch (e) {
                alertJquery(resp, "Error :" + e);
            }
        }
    );
}

function EnturnamientoOnSave(formulario, resp) {
    //Reset(formulario);
    //clearFind();
    try {
        var enturnamiento_id = $.parseJSON(resp);

        if (enturnamiento_id != '') {

            //$('#consecutivo_factura').val(consecutivo_final);
            var url = "detallesEnturnamientoClass.php?enturnamiento_id=" + enturnamiento_id + "&rand=" + Math.random();
            $("#enturnamiento_id").val(enturnamiento_id);
            $("#detallesEnturnamiento").attr("src", url);
            $("#refresh_QUERYGRID_wms_enturnamiento").click();


            if ($("#guardar")) $("#guardar").attr("disabled", "true");
            /*if ($("#actualizar")) $("#actualizar").attr("disabled", "true");
            if ($("#salida")) $("#salida").attr("disabled", "");
            if ($("#borrar")) $("#borrar").attr("disabled", "true");*/
            if ($("#limpiar")) $("#limpiar").attr("disabled", "");


            alertJquery('Guardado Exitosamente', "Enturnamiento");
        } else {
            alertJquery('Inconsistencia Guardando', "Enturnamiento");
        }

    } catch (e) {
        alertJquery("¡Uno de los productos que se quiere agregar no existe creado!", "Atención");
    }

}

function EnturnamientoOnUpdate(formulario, resp) {
    Reset(formulario);
    clearFind();
    var enturnamiento_id = resp;

    if (enturnamiento_id > 0) {

        //$('#consecutivo_factura').val(consecutivo_final);
        var url = "detallesEnturnamientoClass.php?enturnamiento_id=" + enturnamiento_id + "&rand=" + Math.random();
        $("#enturnamiento_id").val(enturnamiento_id);
        $("#detallesEnturnamiento").attr("src", url);
        $("#refresh_QUERYGRID_wms_enturnamiento").click();

        document.getElementById('placa').disabled = false;
        document.getElementById('muelle').disabled = false;
        if ($("#guardar")) $("#guardar").attr("disabled", "");
        if ($("#actualizar")) $("#actualizar").attr("disabled", "true");
        if ($("#salida")) $("#salida").attr("disabled", "");
        if ($("#borrar")) $("#borrar").attr("disabled", "true");
        if ($("#limpiar")) $("#limpiar").attr("disabled", "");

        var usuario_id = $("#usuario_salida_id").val();
        $("#usuario_salida_id").val(usuario_id);
        alertJquery('Actualizado Exitosamente', "Enturnamiento");
    } else {
        alertJquery('Inconsistencia Actualizando', "Enturnamiento");
    }

}

function EnturnamientoOnDelete(formulario, resp) {
    Reset(formulario);
    clearFind();
    var enturnamiento_id = resp;

    if (enturnamiento_id > 0) {

        //$('#consecutivo_factura').val(consecutivo_final);
        var url = "detallesEnturnamientoClass.php?enturnamiento_id=" + enturnamiento_id + "&rand=" + Math.random();
        $("#enturnamiento_id").val(enturnamiento_id);
        $("#detallesEnturnamiento").attr("src", url);
        $("#refresh_QUERYGRID_wms_enturnamiento").click();


        if ($("#guardar")) $("#guardar").attr("disabled", "");
        if ($("#actualizar")) $("#actualizar").attr("disabled", "true");
        if ($("#salida")) $("#salida").attr("disabled", "");
        if ($("#borrar")) $("#borrar").attr("disabled", "true");
        if ($("#limpiar")) $("#limpiar").attr("disabled", "");

        var usuario_id = $("#usuario_salida_id").val();
        $("#usuario_salida_id").val(usuario_id);
        alertJquery('Eliminado Exitosamente', "Enturnamiento");
    } else {
        alertJquery('Inconsistencia Eliminando', "Enturnamiento");
    }

}


function EnturnamientoOnReset(formulario) {
    Reset(formulario);
    clearFind();
    document.getElementById('placa').disabled = false;
    document.getElementById('muelle').disabled = false;
    document.getElementById('fecha').disabled = false;
    document.getElementById('estado').disabled = false;
    $('#estado').empty().append('<option selected="selected" value="NULL">( Seleccione )</option>');
    $('#estado').append('<option  value="B">BLOQUEADO</option>');
    $('#estado').append('<option  value="D">DISPONIBLE</option>');
    //var usuario_id = $("#usuario_id_static").val();
    //$("#usuario_id").val(usuario_id);
    if ($("#guardar")) $("#guardar").attr("disabled", "");
    if ($("#actualizar")) $("#actualizar").attr("disabled", "true");
    if ($("#salida")) $("#salida").attr("disabled", "");
    if ($("#borrar")) $("#borrar").attr("disabled", "true");
    if ($("#limpiar")) $("#limpiar").attr("disabled", "");
    $("#detallesEnturnamiento").attr("src", "sistemas_informaticos/framework/tpl/blank.html");
}

function onclickSalir(formulario) {

    var enturnamiento_id = $("#enturnamiento_id").val();

    if ($("#divAnulacion").is(":visible")) {

        var formulario = document.getElementById('EnturnamientoForm');
        var fecha_salida_turno = $("#fecha_salida_turno").val();
        var observacion_salida = $("#observacion_salida").val();

        if (ValidaRequeridos(formulario)) {


            if (!formSubmitted) {

                var QueryString = "ACTIONCONTROLER=onclickSalida&enturnamiento_id=" + enturnamiento_id + "&fecha_salida_turno=" + fecha_salida_turno +
                    "&observacion_salida=" + observacion_salida;

                $.ajax({
                    url: "EnturnamientoClass.php?rand=" + Math.random(),
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
                            document.getElementById('placa').disabled = false;
                            document.getElementById('muelle').disabled = false;
                            if ($("#guardar")) $("#guardar").attr("disabled", "");
                            if ($("#actualizar")) $("#actualizar").attr("disabled", "true");
                            if ($("#salida")) $("#salida").attr("disabled", "");
                            if ($("#borrar")) $("#borrar").attr("disabled", "");
                            if ($("#limpiar")) $("#limpiar").attr("disabled", "");
                            $("#detallesEnturnamiento").attr("src", "sistemas_informaticos/framework/tpl/blank.html");
                            alertJquery('¡Salida de Turno Exitosamente!', 'Salida Turno');

                        } else {
                            alertJquery(response, 'Inconsistencia En la Salida');
                        }


                    }

                });

            }

        }

    } else {

        var enturnamiento_id = $("#enturnamiento_id").val();
        // var estado = document.getElementById("estado").value;

        if (parseInt(enturnamiento_id) > 0) {

            $("input[name=salir]").each(function() { this.disabled = false; });

            $("#divAnulacion").dialog({
                title: 'Salida Turno',
                width: 450,
                height: 280,
                closeOnEscape: true
            });

        } else {
            alertJquery('Debe Seleccionar primero un enturnamiento', 'Salida');
        }

    }


}