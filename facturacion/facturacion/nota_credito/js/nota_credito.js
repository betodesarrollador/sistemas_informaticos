// JavaScript Document
var formSubmitted = false;
$(document).ready(function() {

    $("#divIca").css("display", "none");

    /*     var factura_id = $("#factura_id").val();

        if (factura_id > 0 && factura_id != '') {
            setDataFormWithResponse();
        } */

    $("#saveDetallepuc").click(function() {
        window.frames[0].saveDetalles();
    });

    $("#Buscar").click(function() {
        cargardiv();

    });

    $("#guardar,#actualizar").click(function() {

        var formulario = document.getElementById("NotaCreditoForm");

        if (ValidaRequeridos(formulario)) {
            if (this.id == 'guardar') {
                $('#guardar').attr("disabled", ""); //aca
                if (!formSubmitted) {
                    formSubmitted = true;
                    Send(formulario, 'onclickSave', null, FacturaOnSave);
                }
            } else {
                Send(formulario, 'onclickUpdate', null, FacturaOnUpdate);
            }
        }
        formSubmitted = false;

    });

    parent.$("#confirmar").click(function() {

        var impuesto = parent.document.getElementById('impuesto').value;
        $("#impuesto_id").val(impuesto);
        $("#divIca").dialog('close');

    });

    $("#motivo_nota").change(function() {

        var factura_id = $("#factura_hidden").val();

        if (factura_id > 0) {

            if ($(this).val() == 1) {

                $("#detalles").contents().find("#liberar").attr('disabled', false);
                $("#detalles").contents().find("#liberar1").attr('disabled', false);
                $("#detalles").contents().find("#revocar").attr('disabled', false);
                $("#detalles").contents().find("#revocar1").attr('disabled', false);

            } else if ($(this).val() == 2) {

                $("#detalles").contents().find("#tableDetalles").find("tbody").find("tr").each(function() {

                    $(this).find("#liberar").hide();
                    $(this).find("#liberar1").hide();
                    $(this).find("#revocar").show();
                    $(this).find("#revocar1").show();


                    $(this).find("#liberar").attr("disabled", "disabled");
                    $(this).find("#revocar").attr("disabled", "disabled");
                    $(this).find("#liberar1").attr("disabled", "disabled");
                    $(this).find("#revocar1").attr("disabled", "disabled");
                });

            } else if ($(this).val() == 3 && $(this).val() == 4) {

                $("#detalles").contents().find("#tableDetalles").find("tbody").find("tr").each(function() {

                    $(this).find("#liberar").show();
                    $(this).find("#revocar").hide();
                    $(this).find("#liberar1").show();
                    $(this).find("#revocar1").hide();

                    $(this).find("#liberar").attr("disabled", "disabled");
                    $(this).find("#revocar").attr("disabled", "disabled");
                    $(this).find("#liberar1").attr("disabled", "disabled");
                    $(this).find("#revocar1").attr("disabled", "disabled");

                });


            } else {
                $("#detalles").contents().find("#liberar").attr("disabled", true);
                $("#detalles").contents().find("#liberar1").attr("disabled", true);
                $("#detalles").contents().find("#revocar").attr("disabled", true);
                $("#detalles").contents().find("#revocar1").attr("disabled", true);
            }

        }
    });


});

function showTable() {

    var frame_grid = document.getElementById('frame_grid');

    //Se valida que el iFrame no exista
    if (frame_grid == null) {

        var QueryString = 'ACTIONCONTROLER=showGrid';

        $.ajax({
            url: "NotaCreditoClass.php?rand=" + Math.random(),
            data: QueryString,
            async: false,
            beforeSend: function() {
                showDivLoading();
            },
            success: function(resp) {
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

function beforePdf() {
    var factura_id = parseInt($("#factura_id").val());

    if (isNaN(factura_id)) {
        alertJquery("Debe seleccionar una Factura  !!!", "PDF Factura");
        return false;
    } else {
        var QueryString =
            "NotaCreditoClass.php?ACTIONCONTROLER=onclickPrint&tipo=PDF&factura_id=" +
            factura_id;
        popPup(QueryString, "Impresion factura", 800, 600);
    }
}

function setDataFormWithResponse() {

    var abono_factura_id = $('#abono_factura_id').val();
    var parametros = new Array({ campos: "abono_factura_id", valores: $('#abono_factura_id').val() });
    var forma = document.forms[0];
    var controlador = 'NotaCreditoClass.php';

    FindRow(parametros, forma, controlador, null, function(resp) {

        var data = $.parseJSON(resp);

        var factura_id = data[0]['factura_id'];
        var motivo_nota = data[0]['motivo_nota'];

        if (motivo_nota == 1) {
            $("#valor_nota").removeAttr("disabled");
        }

        if (motivo_nota == 3) {

            $("#detalles").contents().find("#liberar").attr("disabled", true);
            $("#detalles").contents().find("#liberar1").attr("disabled", true);
            $("#detalles").contents().find("#revocar").attr("disabled", false);
            $("#detalles").contents().find("#revocar1").attr("disabled", false);

        }

        setDataFactura(factura_id)

        RequiredRemove();

        var url = "DetallesClass.php?factura_id=" + factura_id + "&fuente_facturacion_cod=" + $('#fuente_facturacion_cod').val() + "&rand=" + Math.random();
        $("#detalles").attr("src", url);

        var url = "SubtotalClass.php?abono_factura_id=" + abono_factura_id + "&rand=" + Math.random();
        $("#subtotales").attr("src", url);

        if ($('#guardar')) $('#guardar').attr("disabled", "true");
        if ($('#estado').val() == 'A') {
            if ($('#actualizar')) $('#actualizar').attr("disabled", "");
            if ($('#contabilizar')) $('#contabilizar').attr("disabled", "");
            if ($('#anular')) $('#anular').attr("disabled", "");
            if ($('#estado')) $('#estado').attr("disabled", "true");
            if ($('#saveDetallepuc')) $('#saveDetallepuc').attr("style", "display:inherit");
        } else if ($('#estado').val() == 'C' && ($('#numero_pagos').val() == 0 || $('#numero_pagos').val() == '')) {
            if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
            if ($('#contabilizar')) $('#contabilizar').attr("disabled", "true");
            if ($('#estado')) $('#estado').attr("disabled", "true");
            if ($('#anular')) $('#anular').attr("disabled", "");
            if ($('#saveDetallepuc')) $('#saveDetallepuc').attr("style", "display:none");

        } else {
            if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
            if ($('#contabilizar')) $('#contabilizar').attr("disabled", "true");
            if ($('#estado')) $('#estado').attr("disabled", "true");
            if ($('#anular')) $('#anular').attr("disabled", "true");
            if ($('#saveDetallepuc')) $('#saveDetallepuc').attr("style", "display:none");
        }

        if ($('#imprimir')) $('#imprimir').attr("disabled", "");
        if ($('#imprimir1')) $('#imprimir1').attr("disabled", "");
        if ($('#limpiar')) $('#limpiar').attr("disabled", "");

    });
}

function cambioSedes() {
    var sede_id = $('#sedes').val();
    var cliente_id = $('#cliente_hidden').val();
    var QueryString = "ACTIONCONTROLER=setDataClienteOpe&sede_id=" + sede_id + "&cliente_id=" + cliente_id;

    $.ajax({
        url: "NotaCreditoClass.php?rand=" + Math.random(),
        data: QueryString,
        beforeSend: function() {

        },
        success: function(response) {

            try {

                var responseArray = $.parseJSON(response);
                var cliente_direccion = responseArray[0]['cliente_direccion'];
                var cliente_tele = responseArray[0]['cliente_tele'];
                var cliente_ciudad = responseArray[0]['cliente_ciudad'];

                $("#cliente_direccion").val(cliente_direccion);
                $("#cliente_tele").val(cliente_tele);
                $("#cliente_ciudad").val(cliente_ciudad);

            } catch (e) {
                alertJquery(e);
            }

        }

    });


}


function viewDoc(factura_id) {
    $('#factura_id').val(factura_id);
    setDataFormWithResponse();
}

function FacturaOnSave(formulario, resp) {

    try {

        var responseArray = $.parseJSON(resp);

        if (responseArray.length > 0) {

            console.log("respuesta: " + responseArray[0]['abono_factura_id']);

            $("#abono_factura_id").val(responseArray[0]['abono_factura_id']);

            if (responseArray[0]['factura_id'] != 0) {

                $("#refresh_QUERYGRID_factura").click();

                if ($('#guardar')) $('#guardar').attr("disabled", "true");
                if ($('#actualizar')) $('#actualizar').attr("disabled", "");
                if ($('#contabilizar')) $('#contabilizar').attr("disabled", "");
                if ($('#anular')) $('#anular').attr("disabled", "");
                if ($('#limpiar')) $('#limpiar').attr("disabled", "");
                if ($('#imprimir')) $('#imprimir').attr("disabled", "");
                if ($('#imprimir1')) $('#imprimir1').attr("disabled", "");

                alertJquery('¡Nota Credito Guardada Exitosamente!', "Nota Credito");

            } else if (responseArray[0]['error'] != '') {
                alertJquery(responseArray[0]['error'], "Inconsistencia Factura");
            }

        }
    } catch (e) {

        $('#guardar').attr("disabled", ""); //aca
        alertJquery('No se pudo guardar la nota credito: \n ' + e, "Inconsistencia Factura");
    }



}

function FacturaOnUpdate(formulario, resp) {
    if (resp) {
        var abono_factura_id = $("#abono_factura_id").val();
        var factura_id = $("#factura_hidden").val();
        var url = "DetallesClass.php?factura_id=" + factura_id + "&rand=" + Math.random();
        $("#detalles").attr("src", url);
        var url = "SubtotalClass.php?abono_factura_id=" + abono_factura_id + "&rand=" + Math.random();
        $("#subtotales").attr("src", url);

    }
    $("#refresh_QUERYGRID_factura").click();

    if ($('#guardar')) $('#guardar').attr("disabled", "true");
    if ($("#estado").val() == 'A') {
        if ($('#actualizar')) $('#actualizar').attr("disabled", "");
        if ($('#contabilizar')) $('#contabilizar').attr("disabled", "");
        if ($('#anular')) $('#anular').attr("disabled", "");
        if ($('#saveDetallepuc')) $('#saveDetallepuc').attr("style", "display:inherit");

    } else if ($('#estado').val() == 'C' && ($('#numero_pagos').val() == 0 || $('#numero_pagos').val() == '')) {
        if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
        if ($('#contabilizar')) $('#contabilizar').attr("disabled", "true");
        if ($('#anular')) $('#anular').attr("disabled", "");
        if ($('#saveDetallepuc')) $('#saveDetallepuc').attr("style", "display:none");

    } else {
        if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
        if ($('#contabilizar')) $('#contabilizar').attr("disabled", "true");
        if ($('#anular')) $('#anular').attr("disabled", "true");
        if ($('#saveDetallepuc')) $('#saveDetallepuc').attr("style", "display:none");

    }
    if ($('#imprimir')) $('#imprimir').attr("disabled", "");
    if ($('#imprimir1')) $('#imprimir1').attr("disabled", "");
    if ($('#limpiar')) $('#limpiar').attr("disabled", "");

    alertJquery(resp, "Nota Credito");

}

function FacturaOnReset(formulario) {

    $(formulario).find("input,select,textarea").each(function() {
        this.disabled = false;
    });

    $("#detalles").attr("src", "../../../framework/tpl/blank.html");
    $("#detallesContables").attr("src", "../../../framework/tpl/blank.html");
    $("#subtotales").attr("src", "../../../framework/tpl/blank.html");
    if ($('#guardar')) $('#guardar').attr("disabled", "");
    if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
    if ($('#contabilizar')) $('#contabilizar').attr("disabled", "true");
    if ($('#anular')) $('#anular').attr("disabled", "true");
    if ($('#imprimir')) $('#imprimir').attr("disabled", "true");
    if ($('#imprimir1')) $('#imprimir1').attr("disabled", "true");
    if ($('#limpiar')) $('#limpiar').attr("disabled", "");

    if ($('#estado')) $('#estado').attr("disabled", "true");
    $("#fecha").attr("disabled", "true");
    $("#cliente").attr("disabled", "true");
    $("#documento").attr("disabled", "true");
    $("#estado").val("A");

    $("#adjuntover").html('&nbsp;');
    if ($('#saveDetallepuc')) $('#saveDetallepuc').attr("style", "display:inherit");
    clearFind();
    //Causartipo();

    document.getElementById('usuario_id').value = document.getElementById('anul_usuario_id').value;
    document.getElementById('ingreso_factura').value = document.getElementById('anul_factura').value;
    document.getElementById('oficina_id').value = document.getElementById('anul_oficina_id').value;

}

function beforePrint(formulario, url, title, width, height) {

    var encabezado_registro_id = parseInt($("#encabezado_registro_hidden").val());

    if (isNaN(encabezado_registro_id)) {

        alertJquery('Debe seleccionar una Pago o Abono Contabilizado!!!', 'Impresion Pago o Abono');
        return false;

    } else {
        return true;
    }
}



function cargardiv() {
    var cliente_id = $('#cliente_hidden').val();
    var fuente_facturacion_cod = $('#fuente_facturacion_cod').val();
    var tipo_bien_servicio_factura_os = $('#tipo_bien_servicio_factura_os').val();
    var tipo_bien_servicio_factura_rm = $('#tipo_bien_servicio_factura_rm').val();
    var tipo_bien_servicio_factura_st = $('#tipo_bien_servicio_factura_st').val();

    if (parseInt(cliente_id) > 0 && fuente_facturacion_cod != '' && fuente_facturacion_cod != 'NULL' && (parseInt(tipo_bien_servicio_factura_os) > 0 || parseInt(tipo_bien_servicio_factura_rm) > 0 || parseInt(tipo_bien_servicio_factura_st) > 0)) {
        $("#iframeSolicitud").attr("src", "SolicFacturasClass.php?cliente_id=" + cliente_id + "&fuente_facturacion_cod=" + fuente_facturacion_cod + "&tipo_bien_servicio_factura_os=" + tipo_bien_servicio_factura_os + "&tipo_bien_servicio_factura_rm=" + tipo_bien_servicio_factura_rm + "&tipo_bien_servicio_factura_st=" + tipo_bien_servicio_factura_st + "&rand=" + Math.random());
        $("#divSolicitudFacturas").dialog({
            title: 'Remesas y Ordenes de Servicios Pendientes',
            width: 950,
            height: 395,
            closeOnEscape: true,
            show: 'scale',
            hide: 'scale'
        });
    } else {
        if (fuente_facturacion_cod == '' || fuente_facturacion_cod == 'NULL') {
            alertJquery("Por Favor Seleccione una Fuente", "Factura");
        } else if ((fuente_facturacion_cod == 'OS' && !parseInt(tipo_bien_servicio_factura_os) > 0) || (fuente_facturacion_cod == 'RM' && !parseInt(tipo_bien_servicio_factura_rm) > 0) || (fuente_facturacion_cod == 'ST' && !parseInt(tipo_bien_servicio_factura_st) > 0)) {
            alertJquery("Por Favor Seleccione un Tipo de Servicio", "Factura");
        } else if (!parseInt(cliente_id) > 0) {
            alertJquery("Por Favor Seleccione un Cliente", "Factura");

        }
    }
}

function closeDialog() {
    $("#divSolicitudFacturas").dialog('close');
}

function cargardatos() {

    var detalle_concepto = '';
    var concepto_item = $('#concepto_item').val();

    var detalles = concepto_item.split(",");

    var total = 0;

    for (var i in detalles) {
        if (detalles[i] != '') {

            var detalle_frac = detalles[i].split("-");
            var detalle_id = detalle_frac[0];

            var fuente_facturacion_cod = detalle_frac[1];

            var QueryString = "ACTIONCONTROLER=setSolicitud&detalle_id=" + detalle_id + "&fuente_facturacion_cod=" + fuente_facturacion_cod + "&rand=" + Math.random();
            $.ajax({
                url: "NotaCreditoClass.php",
                data: QueryString,
                success: function(resp) {

                    var resp = $.parseJSON(resp);
                    var concepto_detalle = resp[0]['concepto_detalle'];
                    var valor = parseFloat(resp[0]['valor']);
                    detalle_concepto += concepto_detalle + " - ";
                    total = parseFloat(total + valor);


                    $("#concepto").val(detalle_concepto);
                    //$("#concepto").val('Remesas');
                    $("#valor").val(setFormatCurrency(total));


                }
            });
        }
    }

}

function ValidaIca() {

    var concepto_item = $('#concepto_item').val();
    var tipo_bien_servicio_factura_rm = $('#tipo_bien_servicio_factura_rm').val();
    var consecutivo_rem = [];
    var detalles = concepto_item.split(",");

    for (i = 0; i < detalles.length - 1; i++) {
        var detalle_frac = detalles[i].split("-");
        var detalle_id = detalle_frac[0];
        consecutivo_rem.push(detalle_id);
    }

    var QueryString = "ACTIONCONTROLER=setValidaIca&consecutivo_rem=" + consecutivo_rem + "&tipo_bien_servicio_factura_rm=" + tipo_bien_servicio_factura_rm + "&rand=" + Math.random();
    $.ajax({
        url: "NotaCreditoClass.php",
        data: QueryString,
        success: function(resp) {


            var resp = $.parseJSON(resp);

            if (resp > 0) {

                if ($("#divIca").is(":visible")) {
                    console.log("visible");
                } else {
                    $("#divIca").dialog({
                        title: 'Impuesto',
                        width: 650,
                        height: 350,
                        closeOnEscape: true
                    });

                }

            }
        }
    });



}

function ValidaOrigenDist() {

    var concepto_item = $('#concepto_item').val();
    var tipo_bien_servicio_factura_rm = $('#tipo_bien_servicio_factura_rm').val();
    var consecutivo_rem = [];
    var detalles = concepto_item.split(",");

    for (i = 0; i < detalles.length - 1; i++) {
        var detalle_frac = detalles[i].split("-");
        var detalle_id = detalle_frac[0];
        consecutivo_rem.push(detalle_id);
    }

    var QueryString = "ACTIONCONTROLER=setValidaDist&consecutivo_rem=" + consecutivo_rem + "&tipo_bien_servicio_factura_rm=" + tipo_bien_servicio_factura_rm + "&rand=" + Math.random();
    $.ajax({
        url: "NotaCreditoClass.php",
        data: QueryString,
        success: function(resp) {


            var resp = $.parseJSON(resp);

            if (resp > 0) {

                if ($("#divIca").is(":visible")) {
                    $("#impuesto").val('');
                    $("#impuesto").val(resp);
                }

            } else {
                $("#impuesto").val('');
            }
        }
    });



}

function setDataFactura(factura_id) {

    var QueryString = "ACTIONCONTROLER=setDataFactura&factura_id=" + factura_id;

    $.ajax({
        url: "NotaCreditoClass.php?rand=" + Math.random(),
        data: QueryString,
        beforeSend: function() {

        },
        success: function(response) {

            try {

                var responseArray = $.parseJSON(response);


                var factura = responseArray['factura'];
                var detalle_factura = responseArray['detalle_factura'];
                var tipo_documento = responseArray['tipo_documento'];

                var fecha = factura[0]['fecha'];
                var valor = factura[0]['valor'];
                var cliente = factura[0]['cliente'];
                var documento = factura[0]['documento'];
                var cliente_id = factura[0]['cliente_id'];
                var encabezado_registro_id = factura[0]['encabezado_registro_id'];
                var tipo_bien_servicio_factura_id = factura[0]["tipo_bien_servicio_factura_id"];

                if (tipo_documento != '') {
                    var tipo_de_documento_id = tipo_documento[0]["tipo_documento_id"];
                } else {
                    var tipo_de_documento_id = '';
                }


                $("#fecha").val(fecha);
                $("#valor").val(valor);
                $("#cliente").val(cliente);
                $("#cliente_hidden").val(cliente_id);
                $("#numero_documento").val(documento);
                $("#tipo_bien_servicio_factura").val(tipo_bien_servicio_factura_id);
                $("#tipo_de_documento_id").val(tipo_de_documento_id);

                var url = "DetallesClass.php?factura_id=" + factura_id + "&fuente_facturacion_cod=" + $('#fuente_facturacion_cod').val() + "&rand=" + Math.random();
                $("#detalles").attr("src", url);

                var url = "DetallesContablesClass.php?factura_id=" + factura_id + "&encabezado_registro_id=" + encabezado_registro_id + "&rand=" + Math.random();
                $("#detallesContables").attr("src", url);

                var remesas = [];
                var ordenes = [];
                $("#remesas").val('');
                $("#ordenes").val('');

                for (var i = 0; i < detalle_factura.length; i++) {

                    var estado = detalle_factura[i]["estado"];
                    console.log("estado: " + estado);
                    var remesa_id = detalle_factura[i]["remesa_id"];
                    var orden_servicio_id = detalle_factura[i]["orden_servicio_id"];

                    if (estado == 'LQ') {
                        remesas.push(remesa_id);
                        remesas = [...new Set(remesas)];
                        $("#remesas").val(remesas);

                    } else if (estado == 'L') {
                        ordenes.push(orden_servicio_id);
                        ordenes = [...new Set(ordenes)];
                        $("#ordenes").val(ordenes);

                    }

                }

            } catch (e) {
                alertJquery('Error: \n' + e, "Error");
            }

        }

    });

}


function Facturatipo() {
    var fuente_tipo = $("#fuente_facturacion_cod").val();

    if (fuente_tipo == 'NULL') {
        for (i = 0; i < 1; i++) {
            $('#OS' + i).attr("style", "display:none");
            $('#RM' + i).attr("style", "display:none");
            $('#ST' + i).attr("style", "display:none");
            $('#VACIO' + i).attr("style", "display:inherit");
        }
        $('#tipo_bien_servicio_factura_os').attr("class", "inputdefault form-control ");
        $('#tipo_bien_servicio_factura_rm').attr("class", "inputdefault form-control ");
        $('#tipo_bien_servicio_factura_st').attr("class", "inputdefault form-control ");

    } else if (fuente_tipo == 'OS') {

        for (i = 0; i < 1; i++) {
            $('#OS' + i).attr("style", "display:inherit");
            $('#RM' + i).attr("style", "display:none");
            $('#ST' + i).attr("style", "display:none");
            $('#VACIO' + i).attr("style", "display:none");
        }
        $('#tipo_bien_servicio_factura_os').attr("class", "obligatorio inputdefault  form-control");
        $('#tipo_bien_servicio_factura_rm').attr("class", "inputdefault form-control");
        $('#tipo_bien_servicio_factura_st').attr("class", "inputdefault form-control");

    } else if (fuente_tipo == 'RM') {

        for (i = 0; i < 1; i++) {
            $('#OS' + i).attr("style", "display:none");
            $('#RM' + i).attr("style", "display:inherit");
            $('#ST' + i).attr("style", "display:none");
            $('#VACIO' + i).attr("style", "display:none");
        }
        $('#tipo_bien_servicio_factura_os').attr("class", "inputdefault form-control");
        $('#tipo_bien_servicio_factura_rm').attr("class", "obligatorio inputdefault form-control");
        $('#tipo_bien_servicio_factura_st').attr("class", "inputdefault form-control");
    } else if (fuente_tipo == 'ST') {

        for (i = 0; i < 1; i++) {
            $('#OS' + i).attr("style", "display:none");
            $('#RM' + i).attr("style", "display:none");
            $('#ST' + i).attr("style", "display:inherit");
            $('#VACIO' + i).attr("style", "display:none");
        }
        $('#tipo_bien_servicio_factura_os').attr("class", "inputdefault form-control");
        $('#tipo_bien_servicio_factura_rm').attr("class", "inputdefault form-control");
        $('#tipo_bien_servicio_factura_st').attr("class", "obligatorio inputdefault form-control ");

    }

}

function onclickCancellation(formulario) {

    if ($("#divAnulacion").is(":visible")) {

        var causal_anulacion_id = $("#causal_anulacion_id").val();
        var desc_anul_factura = $("#desc_anul_factura").val();
        var anul_factura = $("#anul_factura").val();
        var oficina_id = $("#oficina_id").val();

        if (causal_anulacion_id != '' && desc_anul_factura != '') {
            if (ValidaRequeridos(formulario)) {

                var QueryString = "ACTIONCONTROLER=onclickCancellation&" + FormSerialize(formulario) + "&factura_id=" + $("#factura_id").val();

                $.ajax({
                    url: "NotaCreditoClass.php",
                    data: QueryString,
                    beforeSend: function() {
                        showDivLoading();
                    },
                    success: function(response) {

                        if ($.trim(response) == 'true') {
                            alertJquery('Causacion Anulada', 'Anulado Exitosamente');
                            $("#refresh_QUERYGRID_factura").click();
                            Reset(formulario);
                            FacturaOnReset(formulario);
                            $("#oficina_id").val(oficina_id);
                        } else {
                            alertJquery(response, 'Inconsistencia Anulando');
                        }

                        removeDivLoading();
                        $("#divAnulacion").dialog('close');

                    }

                });

            }
        } else {
            alertJquery('Debe seleccionar una causal y digitar una descripcion de anulacion.');
        }



    } else {

        var factura_id = $("#factura_id").val();
        var estado = $("#estado").val();

        if (parseInt(factura_id) > 0) {

            var QueryString = "ACTIONCONTROLER=getEstadoEncabezadoRegistro&factura_id=" + factura_id;

            $.ajax({
                url: "NotaCreditoClass.php",
                data: QueryString,
                beforeSend: function() {
                    showDivLoading();
                },
                success: function(response) {

                    var estado = response;

                    if ($.trim(estado) == 'A' || $.trim(estado) == 'C') {

                        $("#divAnulacion").dialog({
                            title: 'Anulacion Causacion',
                            width: 450,
                            height: 280,
                            closeOnEscape: true
                        });

                    } else {
                        alertJquery('Solo se permite anular Facturas en estado : <b>ACTIVO/CONTABILIZADO</b>', 'Anulacion');
                    }

                    removeDivLoading();
                }

            });


        } else {
            alertJquery('Debe Seleccionar primero una Factura', 'Anulacion');
        }

    }
}


function OnclickContabilizar() {
    var abono_factura_id = $("#abono_factura_id").val();
    var ingreso_abono_factura = $("#ingreso_abono_factura").val();
    var valor = $("#valor_nota").val();
    var QueryString = "ACTIONCONTROLER=getTotalDebitoCredito&abono_factura_id=" + abono_factura_id;

    if (parseInt(abono_factura_id) > 0) {
        if (!formSubmitted) {
            formSubmitted = true;

            $.ajax({
                url: "NotaCreditoClass.php",
                data: QueryString,
                success: function(response) {

                    try {
                        var totalDebitoCredito = $.parseJSON(response);
                        var totalDebito = parseFloat(totalDebitoCredito[0]['debito']) > 0 ? totalDebitoCredito[0]['debito'] : 0;
                        var totalCredito = parseFloat(totalDebitoCredito[0]['credito']) > 0 ? totalDebitoCredito[0]['credito'] : 0;

                        $("#totalDebito").html(totalDebito);
                        $("#totalCredito").html(totalCredito);

                        if (parseFloat(totalDebito) == parseFloat(totalCredito) && parseFloat(removeFormatCurrency(valor)) > 0) {
                            var QueryString = "ACTIONCONTROLER=getContabilizar&abono_factura_id=" + abono_factura_id + "&ingreso_abono_factura=" + ingreso_abono_factura;

                            $.ajax({
                                url: "NotaCreditoClass.php",
                                data: QueryString,
                                success: function(response) {

                                    try {
                                        if ($.trim(response) == 'true') {
                                            alertJquery('Registro Contabilizado', 'Contabilizacion Exitosa');
                                            $("#refresh_QUERYGRID_pago").click();
                                            setDataFormWithResponse();
                                            formSubmitted = false;
                                        } else {
                                            alertJquery(response, 'Inconsistencia Contabilizando');
                                        }


                                    } catch (e) {

                                    }
                                }
                            });
                        } else if (!parseFloat(removeFormatCurrency(valor)) > 0) {
                            alertJquery('El valor del registro es igual a cero :<b>NO SE CONTABILIZARA</b>', 'Contabilizacion');
                        } else {
                            alertJquery('No existen sumas iguales :<b>NO SE CONTABILIZARA</b>', 'Contabilizacion');
                        }
                    } catch (e) {

                    }
                }

            });
        }
    } else {
        alertJquery('Debe Seleccionar primero un Registro', 'Contabilizacion');
    }
}

function OnclickReContabilizar() {
    var factura_id = $("#factura_id").val();
    var fecha = $("#fecha").val();
    var valor = removeFormatCurrency($("#valor").val());
    var QueryString = "ACTIONCONTROLER=getTotalDebitoCredito&factura_id=" + factura_id;

    if (parseInt(factura_id) > 0) {
        var QueryString = "ACTIONCONTROLER=getreContabilizar&factura_id=" + factura_id + "&fecha=" + fecha;

        $.ajax({
            url: "NotaCreditoClass.php",
            data: QueryString,
            success: function(response) {

                try {
                    if ($.trim(response) == 'true') {
                        alertJquery('Factura ReContabilizada', 'Re asignacion Exitosa');
                        $("#refresh_QUERYGRID_factura").click();
                        setDataFormWithResponse();
                    } else {
                        alertJquery(response, 'Inconsistencia ReContabilizando');
                    }


                } catch (e) {

                }
            }
        });
    } else {
        alertJquery('Debe Seleccionar primero una Factura', 'ReContabilizacion');
    }
}


function ComprobarTercero(tipo_bien_servicio_factura_id) {

    var QueryString = "ACTIONCONTROLER=ComprobarTercero&tipo_bien_servicio_factura_id=" + tipo_bien_servicio_factura_id;

    $.ajax({
        url: "NotaCreditoClass.php?rand=" + Math.random(),
        data: QueryString,
        beforeSend: function() {

        },
        success: function(response) {

            try {
                if (parseInt($.trim(response)) > 0) {
                    alertJquery('El tipo de Servicio esta configurado con cuenta para terceros.\n La fuente de facturacion debe tener liquidado los costos', 'Tipo de Servicio');

                }


            } catch (e) {
                alertJquery(e);
            }

        }

    });

}

function OnclickReportar() {
    var factura_id = $("#factura_id").val();

    if (parseInt(factura_id) > 0) {
        $('#reportar').attr("disabled", "true");
        if (!formSubmitted) {
            formSubmitted = true;

            var QueryString = "ACTIONCONTROLER=OnclickReportar&factura_id=" + factura_id;

            $.ajax({
                url: "NotaCreditoClass.php",
                data: QueryString,
                beforeSend: function() {
                    showDivLoading();
                },

                success: function(response) {
                    try {
                        alertJquery(response, 'Enviando Factura');
                        $('#reportar').attr("disabled", "");
                        formSubmitted = false;

                    } catch (e) {
                        alertJquery(e, 'Enviando Factura');
                        formSubmitted = false;
                    }
                    removeDivLoading();
                }
            });
        }

    } else {
        alertJquery('Debe Seleccionar primero una Factura', 'Reporte Factura Electronica');
    }
}

function OnclickReportarVP() {
    var abono_factura_id = $("#abono_factura_id").val();
    var estado = $("#estado").val();

    if (estado == "C") {


        if (parseInt(abono_factura_id) > 0) {
            $("#reportar").attr("disabled", "true");
            if (!formSubmitted) {
                formSubmitted = true;

                var QueryString =
                    "ACTIONCONTROLER=OnclickReportarVP&abono_factura_id=" +
                    abono_factura_id;

                $.ajax({
                    url: "NotaCreditoClass.php",
                    data: QueryString,
                    beforeSend: function() {
                        showDivLoading();
                    },

                    success: function(response) {
                        try {
                            alertJquery(response, "Enviando Nota Credito");
                            $("#reportar").attr("disabled", "");
                            formSubmitted = false;
                        } catch (e) {
                            alertJquery(e, "Enviando Nota");
                            formSubmitted = false;
                        }
                        removeDivLoading();
                    },
                });
            }
        } else {
            alertJquery("Debe Seleccionar primero una Nota", "Reporte Nota credito");
        }
    } else {
        alertJquery("Debe Contabilizar primero la Nota", "Reporte Nota credito");
    }
}




function onclickEnviarMail() {
    //alertJquery("En construccion");

    var abono_factura_id = $("#abono_factura_id").val();
    if (parseInt(abono_factura_id) > 0) {
        var QueryString = "ACTIONCONTROLER=onclickEnviarMail&abono_factura_id=" + abono_factura_id;

        $.ajax({
            url: "NotaCreditoClass.php?rand=" + Math.random(),
            data: QueryString,
            beforeSend: function() {
                showDivLoading();
            },
            success: function(response) {
                removeDivLoading();
                alertJquery(response, "Validacion Envio");

            }

        });
    } else {
        alertJquery("Por favor seleccione una factura", "Validacion");

    }

}

function validaSeleccionFactura() {

    var factura_id = $("#factura_id").val();

    if (parseInt(factura_id) > 0) {
        return true;
    } else {
        alertJquery('Debe cargar primero una Factura!!', 'Validacion');
        return false;
    }

}

function onSendFile(response) {

    if ($.trim(response) == 'false') {
        alertJquery('No se ha podido adjuntar el archivo !!');
    } else {

        alertJquery("Se ha Cargado el adjunto", "Validacion Adjunto");
        setDataFormWithResponse();
    }



}