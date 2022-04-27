var formSubmitted = false;
$(document).ready(function() {

    $("#divAnulacion").css("display", "none");

    var alistamiento_salida_id = $("#alistamiento_salida_id").val();

    if (alistamiento_salida_id.length > 0) {
        setDataFormWithResponse1();
    }

    $("#deleteDetalle").click(function() {
        window.frames[0].deleteDetalles();
    });

    $('#placa').keypress(function() {
        $('#wms_vehiculo_id').val('');
    });

    var url = "detallesDespachoClass.php?alistamiento_salida_id=" + alistamiento_salida_id + "&rand=" + Math.random();
    $("#detallesDespacho").attr("src", url);

    $("#guardar,#actualizar").click(function() {

        var formulario = document.getElementById('DespachoAlistamientoForm');

        if (ValidaRequeridos(formulario)) {
            if (this.id == 'guardar') {
                if (!formSubmitted) {
                    formSubmitted = true;
                    Send(formulario, 'onclickSave', null, DespachoAlistamientoOnSave);
                }
            } else {
                Send(formulario, 'onclickUpdate', null, DespachoAlistamientoOnUpdate);
            }
        }
        formSubmitted = false;

    });


    $("#saveDetalle").click(function() {
        var formulario = document.getElementById('DespachoAlistamientoForm');
        window.frames[0].saveDetalles(formulario);
        setDataFormWithResponse();
    });


});

function viewDoc(despacho_id) {

    $('#despacho_id').val(despacho_id);
    setDataFormWithResponse();
}

function setDataFormWithResponse() {

    var despacho_id = document.getElementById("despacho_id").value;

    RequiredRemove();
    FindRow(
        [{ campos: "despacho_id", valores: despacho_id }],
        document.forms[0], "DespachoAlistamientoClass.php",
        null,
        function(resp) {
            try {

                var data = $.parseJSON(resp);
                var estado = data[0]['estado'];
                var alistamiento_salida_id = data[0]['alistamiento_salida_id'];

                var url = "detallesDespachoClass.php?alistamiento_salida_id=" + alistamiento_salida_id + "&estado=" + estado + "&rand=" + Math.random();
                $("#detallesDespacho").attr("src", url);

                if (estado == 'A') {

                    if ($("#guardar")) $("#guardar").attr("disabled", "true");
                    if ($("#actualizar")) $("#actualizar").attr("disabled", "");
                    if ($("#anular")) $("#anular").attr("disabled", "");
                    if ($("#borrar")) $("#borrar").attr("disabled", "");
                    if ($("#limpiar")) $("#limpiar").attr("disabled", "");
                }

                if (estado == 'AN') {

                    if ($("#guardar")) $("#guardar").attr("disabled", "true");
                    if ($("#actualizar")) $("#actualizar").attr("disabled", "true");
                    if ($("#anular")) $("#anular").attr("disabled", "true");
                    if ($("#borrar")) $("#borrar").attr("disabled", "");
                    if ($("#limpiar")) $("#limpiar").attr("disabled", "");
                }

                if (estado == 'D') {

                    if ($("#guardar")) $("#guardar").attr("disabled", "true");
                    if ($("#actualizar")) $("#actualizar").attr("disabled", "true");
                    if ($("#anular")) $("#anular").attr("disabled", "");
                    if ($("#borrar")) $("#borrar").attr("disabled", "");
                    if ($("#limpiar")) $("#limpiar").attr("disabled", "");
                }

                if (estado == 'EN') {

                    if ($("#guardar")) $("#guardar").attr("disabled", "true");
                    if ($("#actualizar")) $("#actualizar").attr("disabled", "true");
                    if ($("#anular")) $("#anular").attr("disabled", "");
                    if ($("#borrar")) $("#borrar").attr("disabled", "");
                    if ($("#limpiar")) $("#limpiar").attr("disabled", "");
                }




            } catch (e) {
                alertJquery(resp, "Error :" + e);
            }
        }
    );
}

function setDataFormWithResponse1() {

    var alistamiento_salida_id = document.getElementById("alistamiento_salida_id").value;
    var formulario = document.getElementById('DespachoAlistamientoForm');

    RequiredRemove();

    var QueryString = "ACTIONCONTROLER=onclickFindAlistamiento&alistamiento_salida_id=" + alistamiento_salida_id;

    $.ajax({
        url: "DespachoAlistamientoClass.php?rand=" + Math.random(),
        data: QueryString,
        beforeSend: function() {
            showDivLoading();
        },
        success: function(resp) {
            try {

                var data = $.parseJSON(resp);

                var alistamiento_salida_id = data[0]['alistamiento_salida_id'];
                var despacho_id = data[0]['despacho_id'];
                var estado = data[0]['estado'];
                var muelle = data[0]['muelle'];
                var muelle_id = data[0]['muelle_id'];
                var turno = data[0]['turno'];
                var placa = data[0]['placa'];
                var fecha = data[0]['fecha'];


                $('#despacho_id').val(despacho_id);
                $('#muelle').val(muelle);
                $('#muelle_id').val(muelle_id);
                $('#turno').val(turno);
                $('#fecha').val(fecha);
                $('#placa').val(placa);
                $('#estado').val(estado);
                setFormWithJSON(document.forms[0], resp, true);
                removeDivLoading();

                var url = "detallesDespachoClass.php?alistamiento_salida_id=" + alistamiento_salida_id + "&estado=" + estado + "&rand=" + Math.random();
                $("#detallesDespacho").attr("src", url);

                if (alistamiento_salida_id > 0 && despacho_id == '') {

                    if (estado == 'A') {

                        if ($("#guardar")) $("#guardar").attr("disabled", "");
                        if ($("#actualizar")) $("#actualizar").attr("disabled", "true");
                        if ($("#anular")) $("#anular").attr("disabled", "true");
                        if ($("#borrar")) $("#borrar").attr("disabled", "true");
                        if ($("#limpiar")) $("#limpiar").attr("disabled", "");
                    }
                } else if (alistamiento_salida_id > 0 && despacho_id > 0) {

                    if (estado == 'A') {

                        if ($("#guardar")) $("#guardar").attr("disabled", "true");
                        if ($("#actualizar")) $("#actualizar").attr("disabled", "");
                        if ($("#anular")) $("#anular").attr("disabled", "");
                        if ($("#borrar")) $("#borrar").attr("disabled", "");
                        if ($("#limpiar")) $("#limpiar").attr("disabled", "");
                    }
                }


            } catch (e) {
                alertJquery(resp, "Error :" + e);
            }


        }

    });

}

function setDataVehiculo(wms_vehiculo_id, placa) {

    if (parseInt(wms_vehiculo_id) > 0) {

        var QueryString = "ACTIONCONTROLER=setDataVehiculo&wms_vehiculo_id=" + wms_vehiculo_id;

        $.ajax({
            url: "DespachoAlistamientoClass.php?rand=" + Math.random(),
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

function onclickAnular(formulario) {

    var despacho_id = $("#despacho_id").val();

    if ($("#divAnulacion").is(":visible")) {

        var formulario = document.getElementById('DespachoAlistamientoForm');
        var fecha_anula_turno = $("#fecha_anula_turno").val();
        var observacion_anulacion = $("#observacion_anulacion").val();

        if (ValidaRequeridos(formulario)) {


            if (!formSubmitted) {

                var QueryString = "ACTIONCONTROLER=onclickAnular&despacho_id=" + despacho_id + "&fecha_anula_turno=" + fecha_anula_turno +
                    "&observacion_anulacion=" + observacion_anulacion;

                $.ajax({
                    url: "DespachoAlistamientoClass.php?rand=" + Math.random(),
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
                            /* document.getElementById('placa').disabled = false;
                            document.getElementById('muelle').disabled = false; */
                            if ($("#guardar")) $("#guardar").attr("disabled", "");
                            if ($("#actualizar")) $("#actualizar").attr("disabled", "true");
                            if ($("#anular")) $("#anular").attr("disabled", "");
                            if ($("#borrar")) $("#borrar").attr("disabled", "");
                            if ($("#limpiar")) $("#limpiar").attr("disabled", "");

                            alertJquery('Anulado Exitosamente', 'Despacho');

                        } else {
                            alertJquery(response, 'Inconsistencia Anulando');
                        }


                    }

                });

            }

        }

    } else {

        var despacho_id = $("#despacho_id").val();
        // var estado = document.getElementById("estado").value;

        if (parseInt(despacho_id) > 0) {

            $("input[name=anular]").each(function() { this.disabled = false; });

            $("#divAnulacion").dialog({
                title: 'Anulacion Despacho',
                width: 450,
                height: 280,
                closeOnEscape: true
            });

        } else {
            alertJquery('Debe Seleccionar primero un despacho', 'Anulacion');
        }

    }


}

function DespachoAlistamientoOnSave(formulario, resp) {
    //Reset(formulario);
    //clearFind();
    var despacho_id = resp;

    if (despacho_id > 0) {

        //$('#consecutivo_factura').val(consecutivo_final);
        var url = "detallesDespachoClass.php?despacho_id=" + despacho_id + "&rand=" + Math.random();
        $("#despacho_id").val(despacho_id);
        $("#detallesDespacho").attr("src", url);
        $("#refresh_QUERYGRID_wms_despacho").click();


        if ($("#guardar")) $("#guardar").attr("disabled", "true");
        if ($("#actualizar")) $("#actualizar").attr("disabled", "");
        if ($("#anular")) $("#anular").attr("disabled", "true");
        if ($("#borrar")) $("#borrar").attr("disabled", "true");
        if ($("#limpiar")) $("#limpiar").attr("disabled", "");


        alertJquery('Guardado Exitosamente', "Despacho");
    } else {
        alertJquery('Inconsistencia Guardando', "Despacho");
    }

}

function DespachoAlistamientoOnUpdate(formulario, resp) {
    Reset(formulario);
    clearFind();
    var despacho_id = resp;

    if (despacho_id > 0) {

        var url = "detallesDespachoClass.php?despacho_id=" + despacho_id + "&rand=" + Math.random();

        $("#detallesDespacho").attr("src", url);
        $("#refresh_QUERYGRID_wms_despacho").click();

        /*         document.getElementById('placa').disabled = false;
                document.getElementById('muelle').disabled = false; */
        if ($("#guardar")) $("#guardar").attr("disabled", "");
        if ($("#actualizar")) $("#actualizar").attr("disabled", "true");
        if ($("#anular")) $("#anular").attr("disabled", "");
        if ($("#borrar")) $("#borrar").attr("disabled", "");
        if ($("#limpiar")) $("#limpiar").attr("disabled", "");

        alertJquery('Actualizado Exitosamente', "Despacho");
    } else {
        alertJquery('Inconsistencia Actualizando', "Despacho");
    }

}


/* function DespachoAlistamientoOnCancellation(formulario, resp) {
    Reset(formulario);
    clearFind();
    var despacho_id = resp;

    if (despacho_id > 0) {

        var url = "detallesDespachoClass.php?despacho_id=" + despacho_id + "&rand=" + Math.random();

        $("#detallesDespacho").attr("src", url);
        $("#refresh_QUERYGRID_wms_despacho").click();

               document.getElementById('placa').disabled = false;
                document.getElementById('muelle').disabled = false; 
        if ($("#guardar")) $("#guardar").attr("disabled", "");
        if ($("#actualizar")) $("#actualizar").attr("disabled", "true");
        if ($("#anular")) $("#anular").attr("disabled", "");
        if ($("#borrar")) $("#borrar").attr("disabled", "");
        if ($("#limpiar")) $("#limpiar").attr("disabled", "");

        alertJquery('Anulado Exitosamente', "Despacho");
    } else {
        alertJquery('Inconsistencia Anulando', "Despacho");
    }

} */

function DespachoAlistamientoOnDelete(formulario, resp) {
    Reset(formulario);

    clearFind();

    $("#DetalleAlistamiento").attr("src", "sistemas_informaticos/framework/tpl/blank.html");
    $("#refresh_QUERYGRID_wms_DespachoAlistamiento").click();
    if ($("#guardar")) $("#guardar").attr("disabled", "");
    if ($("#actualizar")) $("#actualizar").attr("disabled", "true");
    if ($("#anular")) $("#anular").attr("disabled", "true");
    if ($("#borrar")) $("#borrar").attr("disabled", "true");
    if ($("#limpiar")) $("#limpiar").attr("disabled", "");
    alertJquery($.trim(resp), "Despacho");

}


function DespachoAlistamientoOnReset(formulario) {
    Reset(formulario);
    clearFind();


    if ($("#guardar")) $("#guardar").attr("disabled", "");
    if ($("#actualizar")) $("#actualizar").attr("disabled", "true");
    if ($("#borrar")) $("#borrar").attr("disabled", "true");
    if ($("#limpiar")) $("#limpiar").attr("disabled", "");
    $("#detallesDespacho").attr("src", "sistemas_informaticos/framework/tpl/blank.html");
}

function onclickSalir(formulario) {

    var DespachoAlistamiento_id = $("#DespachoAlistamiento_id").val();

    if ($("#divAnulacion").is(":visible")) {

        var formulario = document.getElementById('DespachoAlistamientoForm');
        var fecha_salida_turno = $("#fecha_salida_turno").val();
        var observacion_salida = $("#observacion_salida").val();

        if (ValidaRequeridos(formulario)) {


            if (!formSubmitted) {

                var QueryString = "ACTIONCONTROLER=onclickSalida&DespachoAlistamiento_id=" + DespachoAlistamiento_id + "&fecha_salida_turno=" + fecha_salida_turno +
                    "&observacion_salida=" + observacion_salida;

                $.ajax({
                    url: "DespachoAlistamientoClass.php?rand=" + Math.random(),
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
                            $("#detallesDespachoAlistamiento").attr("src", "sistemas_informaticos/framework/tpl/blank.html");
                            alertJquery('¡Salida de Turno Exitosamente!', 'Salida Turno');

                        } else {
                            alertJquery(response, 'Inconsistencia En la Salida');
                        }


                    }

                });

            }

        }

    } else {

        var DespachoAlistamiento_id = $("#DespachoAlistamiento_id").val();
        // var estado = document.getElementById("estado").value;

        if (parseInt(DespachoAlistamiento_id) > 0) {

            $("input[name=salir]").each(function() { this.disabled = false; });

            $("#divAnulacion").dialog({
                title: 'Salida Turno',
                width: 450,
                height: 280,
                closeOnEscape: true
            });

        } else {
            alertJquery('Debe Seleccionar primero un DespachoAlistamiento', 'Salida');
        }

    }


}