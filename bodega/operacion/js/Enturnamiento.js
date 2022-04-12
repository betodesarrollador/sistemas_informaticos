var formSubmitted = false;
$(document).ready(function() {
    $("#divAnulacion").css("display", "none");

    $("#deleteDetalle").click(function() {
        window.frames[0].deleteDetalles();
    });

    $('#placa').keypress(function() {
        $('#wms_vehiculo_id').val('');
    });

    var url = "detallesEnturnamientoClass.php?enturnamiento_id=" + enturnamiento_id + "&rand=" + Math.random();
    $("#detallesEnturnamiento").attr("src", url);

    $("#guardar,#actualizar").click(function() {

        var formulario = document.getElementById('EnturnamientoForm');

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
        document.forms[0], "EnturnamientoClass.php",
        null,
        function(resp) {
            try {

                var data = $.parseJSON(resp);
                var estado = data[0]['estado'];
                var enturnamiento_id = $('#enturnamiento_id').val();


                var url = "detallesEnturnamientoClass.php?enturnamiento_id=" + enturnamiento_id + "&rand=" + Math.random();
                $("#detallesEnturnamiento").attr("src", url);

                if (estado == 'A') {
                    document.getElementById('placa').disabled = true;
                    document.getElementById('muelle').disabled = true;
                    document.getElementById('fecha').disabled = true;
                    document.getElementById('estado').disabled = true;
                    $('#estado').empty().append('<option selected="selected" value="A">ANULADO</option>');
                    if ($("#guardar")) $("#guardar").attr("disabled", "true");
                    if ($("#actualizar")) $("#actualizar").attr("disabled", "true");
                    if ($("#anular")) $("#anular").attr("disabled", "true");
                    if ($("#borrar")) $("#borrar").attr("disabled", "");
                    if ($("#limpiar")) $("#limpiar").attr("disabled", "");
                }

                if (estado == 'D') {
                    document.getElementById('placa').disabled = false;
                    document.getElementById('muelle').disabled = true;
                    document.getElementById('fecha').disabled = false;
                    document.getElementById('estado').disabled = false;
                    $('#estado').empty().append('<option value="B">BLOQUEADO</option>');
                    $('#estado').append('<option selected="selected" value="D">DISPONIBLE</option>');
                    if ($("#guardar")) $("#guardar").attr("disabled", "true");
                    if ($("#actualizar")) $("#actualizar").attr("disabled", "");
                    if ($("#anular")) $("#anular").attr("disabled", "");
                    if ($("#borrar")) $("#borrar").attr("disabled", "");
                    if ($("#limpiar")) $("#limpiar").attr("disabled", "");
                }

                if (estado == 'B') {
                    document.getElementById('placa').disabled = true;
                    document.getElementById('muelle').disabled = true;
                    document.getElementById('fecha').disabled = false;
                    document.getElementById('estado').disabled = false;
                    $('#estado').empty().append('<option selected="selected" value="B">BLOQUEADO</option>');
                    $('#estado').append('<option value="D">DISPONIBLE</option>');
                    if ($("#guardar")) $("#guardar").attr("disabled", "true");
                    if ($("#actualizar")) $("#actualizar").attr("disabled", "");
                    if ($("#anular")) $("#anular").attr("disabled", "true");
                    if ($("#borrar")) $("#borrar").attr("disabled", "");
                    if ($("#limpiar")) $("#limpiar").attr("disabled", "");
                }

                if (estado == 'L') {
                    document.getElementById('placa').disabled = true;
                    document.getElementById('muelle').disabled = true;
                    document.getElementById('fecha').disabled = true;
                    document.getElementById('estado').disabled = true;
                    $('#estado').empty().append('<option selected="selected" value="L">LEGALIZADO</option>');
                    $('#estado').append('<option value="D">DISPONIBLE</option>');
                    $('#estado').append('<option value="B">BLOQUEADO</option>');
                    if ($("#guardar")) $("#guardar").attr("disabled", "true");
                    if ($("#actualizar")) $("#actualizar").attr("disabled", "true");
                    if ($("#anular")) $("#anular").attr("disabled", "true");
                    if ($("#borrar")) $("#borrar").attr("disabled", "true");
                    if ($("#limpiar")) $("#limpiar").attr("disabled", "");
                }

                if (estado == 'F') {
                    document.getElementById('placa').disabled = true;
                    document.getElementById('muelle').disabled = true;
                    document.getElementById('fecha').disabled = true;
                    document.getElementById('estado').disabled = true;
                    $('#estado').empty().append('<option selected="selected" value="F">FINALIZADO</option>');
                    $('#estado').append('<option value="D">DISPONIBLE</option>');
                    $('#estado').append('<option value="B">BLOQUEADO</option>');
                    if ($("#guardar")) $("#guardar").attr("disabled", "true");
                    if ($("#actualizar")) $("#actualizar").attr("disabled", "true");
                    if ($("#anular")) $("#anular").attr("disabled", "true");
                    if ($("#borrar")) $("#borrar").attr("disabled", "true");
                    if ($("#limpiar")) $("#limpiar").attr("disabled", "");
                }


            } catch (e) {
                alertJquery(resp, "Error :" + e);
            }
        }
    );
}

function setDataVehiculo(wms_vehiculo_id, placa) {

    if (parseInt(wms_vehiculo_id) > 0) {

        var QueryString = "ACTIONCONTROLER=setDataVehiculo&wms_vehiculo_id=" + wms_vehiculo_id;

        $.ajax({
            url: "EnturnamientoClass.php?rand=" + Math.random(),
            data: QueryString,
            beforeSend: function() {
                showDivLoading()
            },
            success: function(resp) {
                var data = $.parseJSON(resp);
                var marca = data[0]['marca'];
                var marca_id = data[0]['marca_id'];
                var tipo_vehiculo_id = data[0]['tipo_vehiculo_id'];
                var color = data[0]['color'];
                var color_id = data[0]['color_id'];
                var soat = data[0]['soat'];
                var tecnicomecanica = data[0]['tecnicomecanica'];
                var nombre_conductor = data[0]['nombre_conductor'];
                var cedula_conductor = data[0]['cedula_conductor'];
                var telefono_conductor = data[0]['telefono_conductor'];
                var telefono_ayudante = data[0]['telefono_ayudante'];


                setFormWithJSON(document.forms[0], resp, true);


                removeDivLoading();

            }
        });

    }

}

function EnturnamientoOnSave(formulario, resp) {
    //Reset(formulario);
    //clearFind();
    var enturnamiento_id = resp;

    if (enturnamiento_id > 0) {

        //$('#consecutivo_factura').val(consecutivo_final);
        var url = "detallesEnturnamientoClass.php?enturnamiento_id=" + enturnamiento_id + "&rand=" + Math.random();
        $("#enturnamiento_id").val(enturnamiento_id);
        $("#detallesEnturnamiento").attr("src", url);
        $("#refresh_QUERYGRID_wms_enturnamiento").click();


        if ($("#guardar")) $("#guardar").attr("disabled", "true");
        if ($("#actualizar")) $("#actualizar").attr("disabled", "true");
        if ($("#salida")) $("#salida").attr("disabled", "");
        if ($("#borrar")) $("#borrar").attr("disabled", "true");
        if ($("#limpiar")) $("#limpiar").attr("disabled", "");

        var usuario_id = $("#usuario_salida_id").val();
        $("#usuario_salida_id").val(usuario_id);
        alertJquery('Guardado Exitosamente', "Enturnamiento");
    } else {
        alertJquery('Inconsistencia Guardando: Es probable que este vehiculo ya se encuentre enturnado,\n Por favor enturne una placa diferente o verifique su estado en el cuadro de SALIDA TURNO.', "Enturnamiento");
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
    var hoy = new Date();
    var fecha = hoy.getFullYear() + '-' + (hoy.getMonth() + 1) + '-' + hoy.getDate();
    var hora = hoy.getHours() + ':' + hoy.getMinutes() + ':' + hoy.getSeconds();
    var fechaHora = fecha + ' ' + hora;
    $('#fecha').val(fechaHora);
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

function onclickAnular(formulario) {

    var enturnamiento_id = $("#enturnamiento_id").val();

    if ($("#divAnulacion").is(":visible")) {

        var formulario = document.getElementById('EnturnamientoForm');
        var fecha_anula_turno = $("#fecha_anula_turno").val();
        var observacion_anulacion = $("#observacion_anulacion").val();

        if (ValidaRequeridos(formulario)) {


            if (!formSubmitted) {

                var QueryString = "ACTIONCONTROLER=onclickAnular&enturnamiento_id=" + enturnamiento_id + "&fecha_anula_turno=" + fecha_anula_turno +
                    "&observacion_anulacion=" + observacion_anulacion;

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
                            if ($("#anular")) $("#anular").attr("disabled", "");
                            if ($("#borrar")) $("#borrar").attr("disabled", "");
                            if ($("#limpiar")) $("#limpiar").attr("disabled", "");

                            alertJquery('Anulado Exitosamente', 'Enturnamiento');

                        } else {
                            alertJquery(response, 'Inconsistencia Anulando');
                        }


                    }

                });

            }

        }

    } else {

        var enturnamiento_id = $("#enturnamiento_id").val();
        // var estado = document.getElementById("estado").value;

        if (parseInt(enturnamiento_id) > 0) {

            $("input[name=anular]").each(function() { this.disabled = false; });

            $("#divAnulacion").dialog({
                title: 'Anulacion Turno',
                width: 450,
                height: 280,
                closeOnEscape: true
            });

        } else {
            alertJquery('Debe Seleccionar primero un enturnamiento', 'Anulacion');
        }

    }


}