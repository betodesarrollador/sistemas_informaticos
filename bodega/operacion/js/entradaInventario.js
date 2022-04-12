var formSubmitted = false;
$(document).ready(function() {

    $("#divAnulacion").css("display", "none");

    $("#guardar,#actualizar").click(function() {

        var formulario = document.getElementById('entradaInventarioForm');

        if (ValidaRequeridos(formulario)) {
            if (this.id == 'guardar') {
                if (!formSubmitted) {
                    formSubmitted = true;
                    Send(formulario, 'onclickSave', null, entradaInventarioOnSave);
                }
            } else {
                Send(formulario, 'onclickUpdate', null, entradaInventarioOnUpdate);
            }
        }
        formSubmitted = false;

    });


    $("#saveDetalle").click(function() {
        var formulario = document.getElementById('entradaInventarioForm');
        window.frames[0].saveDetalles(formulario);
        setDataFormWithResponse();
    });

    /* $("#saveDetalleInventario").click(function () {
      var formulario = document.getElementById('entradaInventarioForm');
      window.frames[0].saveDetallesInventario(formulario);
      setDataFormWithResponse();
    }); */


});

function viewDoc(enturnamiento_id) {

    $('#entrada_id').val(entrada_id);
    setDataFormWithResponse();
}

function setDataFormWithResponse() {
    RequiredRemove();

    FindRow(
        [{ campos: "entrada_id", valores: $("#entrada_id").val() }],
        document.forms[0], "entradaInventarioClass.php", null,
        function(resp) {
            try {

                var data = $.parseJSON(resp);
                var estado = data[0]['estado'];
                var entrada_id = $('#entrada_id').val();
                var recepcion_id = $('#recepcion_id').val();

                if (estado == 'P') {

                    if ($("#guardar")) $("#guardar").attr("disabled", "true");
                    if ($("#actualizar")) $("#actualizar").attr("disabled", "");
                    if ($("#borrar")) $("#borrar").attr("disabled", "");
                    if ($("#limpiar")) $("#limpiar").attr("disabled", "");
                    var url = "detalleEntradaClass.php?recepcion_id=" + recepcion_id + "&estado=" + estado + "&rand=" + Math.random();
                    $("#DetalleEntrada").attr("src", url);
                    document.getElementById('saveDetalle').disabled = false;
                    /* document.getElementById('saveDetalleInventario').disabled = true; */

                } else if (estado == 'I') {

                    if ($("#guardar")) $("#guardar").attr("disabled", "true");
                    if ($("#actualizar")) $("#actualizar").attr("disabled", "true");
                    if ($("#anular")) $("#anular").attr("disabled", "");
                    if ($("#borrar")) $("#borrar").attr("disabled", "true");
                    if ($("#limpiar")) $("#limpiar").attr("disabled", "");

                    var url = "detalleEntradaClass.php?entrada_id=" + entrada_id + "&estado=" + estado + "&rand=" + Math.random();
                    $("#DetalleEntrada").attr("src", url);
                    /* document.getElementById('saveDetalleInventario').disabled = false; */
                    document.getElementById('saveDetalle').disabled = true;

                } else if (estado == 'IN') {

                    if ($("#guardar")) $("#guardar").attr("disabled", "true");
                    if ($("#actualizar")) $("#actualizar").attr("disabled", "true");
                    if ($("#anular")) $("#anular").attr("disabled", "");
                    if ($("#borrar")) $("#borrar").attr("disabled", "true");
                    if ($("#limpiar")) $("#limpiar").attr("disabled", "");

                    var url = "detalleEntradaClass.php?entrada_id=" + entrada_id + "&recepcion_id=" + recepcion_id + "&estado=" + estado + "&rand=" + Math.random();
                    $("#DetalleEntrada").attr("src", url);
                    /* document.getElementById('saveDetalleInventario').disabled = true; */
                    document.getElementById('saveDetalle').disabled = false;

                } else if (estado == 'A') {

                    if ($("#guardar")) $("#guardar").attr("disabled", "true");
                    if ($("#actualizar")) $("#actualizar").attr("disabled", "true");
                    if ($("#anular")) $("#anular").attr("disabled", "true");
                    if ($("#borrar")) $("#borrar").attr("disabled", "");
                    if ($("#limpiar")) $("#limpiar").attr("disabled", "");

                    var url = "detalleEntradaClass.php?entrada_id=" + entrada_id + "&estado=" + estado + "&rand=" + Math.random();
                    $("#DetalleEntrada").attr("src", url);
                    /*  document.getElementById('saveDetalleInventario').disabled = true; */
                    document.getElementById('saveDetalle').disabled = true;

                } else {
                    if ($("#guardar")) $("#guardar").attr("disabled", "true");
                    if ($("#actualizar")) $("#actualizar").attr("disabled", "true");
                    if ($("#anular")) $("#anular").attr("disabled", "true");
                    if ($("#borrar")) $("#borrar").attr("disabled", "true");
                    if ($("#limpiar")) $("#limpiar").attr("disabled", "");

                    var url = "detalleEntradaClass.php?entrada_id=" + entrada_id + "&estado=" + estado + "&rand=" + Math.random();
                    $("#DetalleEntrada").attr("src", url);
                    /* document.getElementById('saveDetalleInventario').disabled = true; */
                    document.getElementById('saveDetalle').disabled = true;
                }

            } catch (e) {
                alertJquery(resp, "Error :" + e);
            }
        }
    );
}

function onclickAnular(formulario) {

    var entrada_id = $("#entrada_id").val();

    if ($("#divAnulacion").is(":visible")) {

        var formulario = document.getElementById('entradaInventarioForm');
        var fecha_anula_entrada = $("#fecha_anula_entrada").val();
        var observacion_anulacion = $("#observacion_anulacion").val();

        if (ValidaRequeridos(formulario)) {

            if (!formSubmitted) {

                var QueryString = "ACTIONCONTROLER=onclickAnular&entrada_id=" + entrada_id + "&fecha_anula_entrada=" + fecha_anula_entrada +
                    "&observacion_anulacion=" + observacion_anulacion;

                $.ajax({
                    url: "entradaInventarioClass.php?rand=" + Math.random(),
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

                            alertJquery("Anulada Exitosamente", "Entrada");

                        } else {
                            alertJquery(response, 'Inconsistencia Anulando');
                        }


                    }

                });

            }

        }

    } else {

        var entrada_id = $("#entrada_id").val();
        // var estado = document.getElementById("estado").value;

        if (parseInt(entrada_id) > 0) {

            $("input[name=anular]").each(function() { this.disabled = false; });

            $("#divAnulacion").dialog({
                title: 'Anulacion Entrada',
                width: 450,
                height: 280,
                closeOnEscape: true
            });

        } else {
            alertJquery('Debe Seleccionar primero una Entrada', 'Anulacion');
        }

    }


}

function entradaInventarioOnSave(formulario, resp) {
    //Reset(formulario);
    //clearFind();
    try {
        var entrada_id = $.parseJSON(resp);
        var recepcion_id = $("#recepcion_id").val();
        var estado = $("#estado").val();

        if (entrada_id != '') {

            /*  var url = "detalleEntradaClass.php?recepcion_id=" + recepcion_id + "&estado=" + estado + "&rand=" + Math.random();
             $("#DetalleEntrada").attr("src", url); */
            $("#DetalleEntrada").attr("src", "sistemas_informaticos/framework/tpl/blank.html");

            $("#refresh_QUERYGRID_GRIDENTRADA").click();

            if ($("#guardar")) $("#guardar").attr("disabled", "true");
            if ($("#actualizar")) $("#actualizar").attr("disabled", "");
            if ($("#anular")) $("#anular").attr("disabled", "");
            if ($("#borrar")) $("#borrar").attr("disabled", "");
            if ($("#limpiar")) $("#limpiar").attr("disabled", "");

            alertJquery("Guardada Exitosamente", "Entrada");
        } else {

            //alertJquery(resp, "Inconsistencia Guardando");

            alertJquery("Inconsistencia Guardando", "Entrada");

        }

    } catch (e) {
        alertJquery(e + "Atención");
    }

}

function entradaInventarioOnUpdate(formulario, resp) {
    Reset(formulario);
    clearFind();
    $("#DetalleEntrada").attr("src", "sistemas_informaticos/framework/tpl/blank.html");
    var entrada_id = resp;

    if (entrada_id > 0) {

        $("#refresh_QUERYGRID_GRIDENTRADA").click();

        if ($("#guardar")) $("#guardar").attr("disabled", "");
        if ($("#actualizar")) $("#actualizar").attr("disabled", "true");
        if ($("#anular")) $("#anular").attr("disabled", "");
        if ($("#borrar")) $("#borrar").attr("disabled", "true");
        if ($("#limpiar")) $("#limpiar").attr("disabled", "");

        alertJquery('Actualizada Exitosamente', "Entrada");
    } else {
        alertJquery('Inconsistencia Actualizando', "Entrada");
    }

}

function entradaInventarioOnDelete(formulario, resp) {
    Reset(formulario);
    clearFind();

    if (resp == 'true') {

        $("#DetalleEntrada").attr("src", "sistemas_informaticos/framework/tpl/blank.html");
        $("#refresh_QUERYGRID_wms_entrada").click();

        if ($("#guardar")) $("#guardar").attr("disabled", "");
        if ($("#actualizar")) $("#actualizar").attr("disabled", "true");
        if ($("#anular")) $("#anular").attr("disabled", "true");
        if ($("#borrar")) $("#borrar").attr("disabled", "true");
        if ($("#limpiar")) $("#limpiar").attr("disabled", "");
        $("#estado").val('P');

        alertJquery('Entrada Eliminada Exitosamente', "Entrada");
    } else {
        alertJquery('Inconsistencia Eliminando', "Entrada");
    }

}


function entradaInventarioOnReset(formulario) {
    Reset(formulario);
    clearFind();

    /* $('#estado').empty().append('<option selected="selected" value="NULL">( Seleccione )</option>');
    $('#estado').append('<option  value="B">BLOQUEADO</option>');
    $('#estado').append('<option  value="D">DISPONIBLE</option>'); */
    //var usuario_id = $("#usuario_id_static").val();
    //$("#usuario_id").val(usuario_id);
    $("#estado").val('P');
    if ($("#guardar")) $("#guardar").attr("disabled", "");
    if ($("#actualizar")) $("#actualizar").attr("disabled", "true");
    if ($("#borrar")) $("#borrar").attr("disabled", "true");
    if ($("#limpiar")) $("#limpiar").attr("disabled", "");
    $("#DetalleEntrada").attr("src", "sistemas_informaticos/framework/tpl/blank.html");
}