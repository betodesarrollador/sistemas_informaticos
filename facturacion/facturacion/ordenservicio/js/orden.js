// JavaScript Document
function setDataFormWithResponse() {
    var ordenId = $('#orden_servicio_id').val();
    RequiredRemove();

    var parametros = new Array({ campos: "orden_servicio_id", valores: $('#orden_servicio_id').val() });
    var forma = document.forms[0];
    var controlador = 'OrdenClass.php';

    FindRow(parametros, forma, controlador, null, function (resp) {
        if ($('#guardar')) $('#guardar').attr("disabled", "true");

        if ($("#estado_orden_servicio").val() == 'A') {
            if ($('#actualizar')) $('#actualizar').attr("disabled", "");
            if ($('#anular')) $('#anular').attr("disabled", "");
            if ($('#liquidar')) $('#liquidar').attr("disabled", "");
            if ($('#saveDetallepuc')) $('#saveDetallepuc').attr("style", "display:inherit");
            if ($('#deleteDetallepuc')) $('#deleteDetallepuc').attr("style", "display:inherit");

        } else {
            if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
            if ($("#estado_orden_servicio").val() == 'L') {
                if ($('#anular')) $('#anular').attr("disabled", "");
            } else {
                if ($('#anular')) $('#anular').attr("disabled", "true");
            }
            if ($('#liquidar')) $('#liquidar').attr("disabled", "true");
            if ($('#saveDetallepuc')) $('#saveDetallepuc').attr("style", "display:none");
            if ($('#deleteDetallepuc')) $('#deleteDetallepuc').attr("style", "display:none");
        }
        if ($('#limpiar')) $('#limpiar').attr("disabled", "");
        if ($('#imprimir')) $('#imprimir').attr("disabled", "");
        configuracion(ordenId);
        getTotal(ordenId, 1);

    });


}

function showTable() {

    var frame_grid = document.getElementById('frame_grid');

    //Se valida que el iFrame no exista
    if (frame_grid == null) {

        var QueryString = 'ACTIONCONTROLER=showGrid';

        $.ajax({
            url: "OrdenClass.php?rand=" + Math.random(),
            data: QueryString,
            async: false,
            beforeSend: function () {
                showDivLoading();
            },
            success: function (resp) {
                console.log(resp);
                try {

                    var iframe = document.createElement('iframe');
                    iframe.id = 'frame_grid';
                    iframe.style.cssText = "border:0; height: 400px; background-color:transparent";
                    //iframe.scrolling   = 'no';

                    document.body.appendChild(iframe);
                    iframe.contentWindow.document.open();
                    iframe.contentWindow.document.write(resp);
                    iframe.contentWindow.document.close();

                    $('#mostrar_grid').removeClass('btn btn-warning btn-sm');
                    $('#mostrar_grid').addClass('btn btn-secondary btn-sm');
                    $('#mostrar_grid').html('Ocultar tabla');

                } catch (e) {

                    console.log(e);

                }
                removeDivLoading();
            }
        });

    } else {

        $('#frame_grid').remove();
        $('#mostrar_grid').removeClass('btn btn-secondary btn-sm');
        $('#mostrar_grid').addClass('btn btn-warning btn-sm');
        $('#mostrar_grid').html('Mostrar tabla');

    }

}


function OrdenOnSave(formulario, resp) {
    if (resp) {
        var responseArray = $.parseJSON(resp);
        var orden_servicio_id = responseArray['orden_servicio_id'];
        var consecutivo = responseArray['consecutivo'];

        if (parseInt(consecutivo) > 0 && parseInt(consecutivo) > 0) {
            $("#refresh_QUERYGRID_ordenservicio").click();
            $("#orden_servicio_id").val(orden_servicio_id);
            $("#consecutivo").val(consecutivo);
            configuracion(orden_servicio_id);
            getTotal(orden_servicio_id, 0);

            if ($('#guardar')) $('#guardar').attr("disabled", "true");
            if ($('#actualizar')) $('#actualizar').attr("disabled", "");
            if ($('#anular')) $('#anular').attr("disabled", "");
            if ($('#limpiar')) $('#limpiar').attr("disabled", "");
            if ($('#liquidar')) $('#liquidar').attr("disabled", "");
            if ($('#imprimir')) $('#imprimir').attr("disabled", "");
            if ($('#saveDetallepuc')) $('#saveDetallepuc').attr("style", "display:inherit");
            if ($('#deleteDetallepuc')) $('#deleteDetallepuc').attr("style", "display:inherit");

            alertJquery("Guardado Exitosamente", "Orden de Servicio");
        } else {
            alertJquery("Inconsistencia Guardando", "Orden de Servicio");
        }
    } else {
        alertJquery("Inconsistencia Guardando", "Orden de Servicio");
    }

}

function OrdenOnUpdate(formulario, resp) {
    if (resp) {
        var orden_servicio_id = $("#orden_servicio_id").val();
        configuracion(orden_servicio_id);
        getTotal(orden_servicio_id, 1);

    }
    $("#refresh_QUERYGRID_ordenservicio").click();

    if ($('#guardar')) $('#guardar').attr("disabled", "true");

    if ($("#estado_orden_servicio").val() == 'A') {
        if ($('#actualizar')) $('#actualizar').attr("disabled", "");
        if ($('#anular')) $('#anular').attr("disabled", "");
        if ($('#liquidar')) $('#liquidar').attr("disabled", "");
        if ($('#saveDetallepuc')) $('#saveDetallepuc').attr("style", "display:inherit");
        if ($('#deleteDetallepuc')) $('#deleteDetallepuc').attr("style", "display:inherit");

    } else {
        if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
        if ($('#anular')) $('#anular').attr("disabled", "true");
        if ($('#liquidar')) $('#liquidar').attr("disabled", "true");
        if ($('#saveDetallepuc')) $('#saveDetallepuc').attr("style", "display:none");
        if ($('#deleteDetallepuc')) $('#deleteDetallepuc').attr("style", "display:none");
    }
    if ($('#imprimir')) $('#imprimir').attr("disabled", "");
    if ($('#limpiar')) $('#limpiar').attr("disabled", "");

    alertJquery(resp, "Orden de Servicio");

}

function OrdenOnReset(formulario) {

    $("#detalles").attr("src", "../../../framework/tpl/blank.html");
    $("#subtotales").attr("src", "../../../framework/tpl/blank.html");
    if ($('#guardar')) $('#guardar').attr("disabled", "");
    if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
    if ($('#anular')) $('#anular').attr("disabled", "true");
    if ($('#liquidar')) $('#liquidar').attr("disabled", "");
    if ($('#imprimir')) $('#imprimir').attr("disabled", "true");
    if ($('#limpiar')) $('#limpiar').attr("disabled", "");
    if ($('#saveDetallepuc')) $('#saveDetallepuc').attr("style", "display:inherit");
    if ($('#deleteDetallepuc')) $('#deleteDetallepuc').attr("style", "display:inherit");
    clearFind();
    document.getElementById('usuario_id').value = document.getElementById('anul_usuario_id').value;
    document.getElementById('ingreso_orden_servicio').value = document.getElementById('anul_orden_servicio').value;
    document.getElementById('oficina_id').value = document.getElementById('anul_oficina_id').value;
    document.getElementById('estado_orden_servicio').value = 'A';


}

function beforePrint(formulario, url, title, width, height) {

    var orden_servicio_id = parseInt($("#orden_servicio_id").val());

    if (isNaN(orden_servicio_id)) {

        alertJquery('Debe seleccionar una Orden de Servicio a imprimir !!!', 'Impresion Orden de Servicio');
        return false;

    } else {
        return true;
    }
}

function getTotal(orden_servicio_id, tipo) {

    var QueryString = "ACTIONCONTROLER=getItemliquida&orden_servicio_id=" + orden_servicio_id;

    $.ajax({
        url: "OrdenClass.php",
        data: QueryString,
        beforeSend: function () {

        },
        success: function (response) {

            var totali = response;

            if (parseInt($.trim(totali)) > 0 && tipo == 1) {

                var url = "DetallesLiqClass.php?orden_servicio_id=" + orden_servicio_id + "&rand=" + Math.random();
                $("#detalles").attr("src", url);

            } else {
                var url = "DetallesClass.php?orden_servicio_id=" + orden_servicio_id + "&rand=" + Math.random();
                $("#detalles").attr("src", url);
            }


        }

    });


    var url = "SubtotalClass.php?orden_servicio_id=" + orden_servicio_id + "&rand=" + Math.random();
    $("#subtotales").attr("src", url);
}

$(document).ready(function () {


    $("#saveDetallepuc").click(function () {
        window.frames[0].saveDetalles();
    });


    $("#deleteDetallepuc").click(function () {
        window.frames[0].deleteDetalles();
    });


    $("#guardar,#actualizar").click(function () {

        var formulario = document.getElementById('OrdenForm');

        if (ValidaRequeridos(formulario)) {
            if (this.id == 'guardar') {
                Send(formulario, 'onclickSave', null, OrdenOnSave)
            } else {
                Send(formulario, 'onclickUpdate', null, OrdenOnUpdate)
            }
        }

    });

});

function setDataCliente(cliente_id) {

    var QueryString = "ACTIONCONTROLER=setDataCliente&cliente_id=" + cliente_id;

    $.ajax({
        url: "OrdenClass.php?rand=" + Math.random(),
        data: QueryString,
        beforeSend: function () {

        },
        success: function (response) {

            try {

                var responseArray = $.parseJSON(response);
                var cliente_tele = responseArray[0]['cliente_tele'];
                var cliente_direccion = responseArray[0]['cliente_direccion'];
                var cliente_contacto = responseArray[0]['cliente_contacto'];
                var cliente_ciudad = responseArray[0]['cliente_ciudad'];
                var cliente_correo = responseArray[0]['cliente_correo'];

                $("#cliente_tele").val(cliente_tele);
                $("#cliente_direccion").val(cliente_direccion);
                $("#cliente_contacto").val(cliente_contacto);
                $("#cliente_ciudad").val(cliente_ciudad);
                $("#cliente_correo").val(cliente_correo);

            } catch (e) {
                alertJquery(e);
            }

        }

    });

}

function onclickCancellation(formulario) {

    if ($("#divAnulacion").is(":visible")) {

        var causal_anulacion_id = $("#causal_anulacion_id").val();
        var desc_anul_orden_servicio = $("#desc_anul_orden_servicio").val();
        var anul_orden_servicio = $("#anul_orden_servicio").val();

        if (ValidaRequeridos(formulario)) {

            var QueryString = "ACTIONCONTROLER=onclickCancellation&" + FormSerialize(formulario) + "&orden_servicio_id=" + $("#orden_servicio_id").val();

            $.ajax({
                url: "OrdenClass.php",
                data: QueryString,
                beforeSend: function () {
                    showDivLoading();
                },
                success: function (response) {

                    if ($.trim(response) == 'true') {
                        alertJquery('Orden de Servicio Anulada', 'Anulado Exitosamente');
                        $("#refresh_QUERYGRID_ordenservicio").click();
                        setDataFormWithResponse();
                    } else {
                        alertJquery(response, 'Inconsistencia Anulando');
                    }

                    removeDivLoading();
                    $("#divAnulacion").dialog('close');

                }

            });

        }

    } else {

        var orden_servicio_id = $("#orden_servicio_id").val();
        var estado_orden_servicio = $("#estado_orden_servicio").val();

        if (parseInt(orden_servicio_id) > 0) {

            var QueryString = "ACTIONCONTROLER=getEstadoEncabezadoRegistro&orden_servicio_id=" + orden_servicio_id;

            $.ajax({
                url: "OrdenClass.php",
                data: QueryString,
                beforeSend: function () {
                    showDivLoading();
                },
                success: function (response) {

                    var estado = response;

                    if ($.trim(estado) == 'A' || $.trim(estado) == 'L') {

                        $("#divAnulacion").dialog({
                            title: 'Anulacion Orden de Servicio',
                            width: 450,
                            height: 280,
                            closeOnEscape: true
                        });

                    } else {
                        alertJquery('Solo se permite anular orden de servicio en estado : <b>ACTIVO</b>', 'Anulacion');
                    }

                    removeDivLoading();
                }

            });


        } else {
            alertJquery('Debe Seleccionar primero una Orden de Servicio', 'Anulacion');
        }

    }


}

function configuracion(ordenId) {

    var QueryString = "ACTIONCONTROLER=Checkconfig&orden_servicio_id=" + ordenId;

    $.ajax({
        url: "OrdenClass.php",
        data: QueryString,
        beforeSend: function () {
            showDivLoading();
        },
        success: function (resp) {
            try {
                var estado = $.parseJSON(resp);

                if (estado['mensaje'] == 'no') {
                    if (estado['contra'] > 1) {
                        alertJquery('¡Existe más de una contrapartida parametrizada en el tipo de servicio! \nLas siguientes cuentas estan parametrizadas como contrapartida: \n\n' + estado['contra_cuenta'], 'Atencion');
                    } else if (estado['contra'] == 0) {
                        alertJquery('¡El Tipo de Servicio no tiene ninguna contrapartida configurada!', 'Atencion');
                    } else if (estado['subtotal'] > 1) {
                        alertJquery('<b>¡Existe más de un subtotal parametrizado en el tipo de servicio!</b> \n\nEsto puede suceder ya que el impuesto no está parametrizado para el periodo o existe una cuenta como ingreso para terceros, recuerde que en la orden de servicio no se puede utilizar los ingresos para terceros. \n\nLas siguientes cuentas estan parametrizadas como subtotal: \n\n<b>' + estado['subtotal_cuenta'] + '</b>', 'Atencion');
                    } else if (estado['subtotal'] == 0) {
                        alertJquery('¡El Tipo de Servicio no tiene ningun subtotal configurado!', 'Atencion');
                    }
                }
                removeDivLoading();
            } catch (error) {
                alertJquery('ERROR: \n' + resp, 'error');
            }

        }
    });
}

function onclickLiquidar(formulario) {

    if ($("#divLiquidar").is(":visible")) {

        var descrip_liq_orden_servicio = $("#descrip_liq_orden_servicio").val();
        var fec_liq_orden_servicio = $("#fec_liq_orden_servicio").val();
        var liq_usuario_id = $("#liq_usuario_id").val();

        if (ValidaRequeridos(formulario)) {

            $("#liquidar").attr('disabled', 'true');

            var QueryString = "ACTIONCONTROLER=onclickLiquidar&" + FormSerialize(formulario) + "&orden_servicio_id=" + $("#orden_servicio_id").val();

            $.ajax({
                url: "OrdenClass.php",
                data: QueryString,
                beforeSend: function () {
                    showDivLoading();
                },
                success: function (response) {

                    if ($.trim(response) == 'true') {
                        alertJquery('Orden de Servicio Liquidada', 'Liquidado Exitosamente');
                        $("#refresh_QUERYGRID_ordenservicio").click();
                        setDataFormWithResponse();
                    } else {
                        alertJquery(response, 'Inconsistencia Liquidando');
                    }

                    removeDivLoading();
                    $("#liquidar").removeAttr('disabled');
                    $("#divLiquidar").dialog('close');

                }

            });

        }

    } else {

        var orden_servicio_id = $("#orden_servicio_id").val();
        var estado_orden_servicio = $("#estado_orden_servicio").val();

        if (parseInt(orden_servicio_id) > 0) {

            var QueryString = "ACTIONCONTROLER=getEstadoEncabezadoRegistro&orden_servicio_id=" + orden_servicio_id;

            $.ajax({
                url: "OrdenClass.php",
                data: QueryString,
                beforeSend: function () {
                    showDivLoading();
                },
                success: function (response) {

                    var estado = response;

                    if ($.trim(estado) == 'A') {

                        $("#divLiquidar").dialog({
                            title: 'Liquidacion Orden de Servicio',
                            width: 450,
                            height: 280,
                            closeOnEscape: true
                        });

                    } else {
                        alertJquery('Solo se permite Liquidar orden de servicio en estado : <b>ACTIVO</b>', 'Liquidacion');
                    }

                    removeDivLoading();
                }

            });


        } else {
            alertJquery('Debe Seleccionar primero una Orden de Servicio', 'Liquidacion');
        }

    }


}