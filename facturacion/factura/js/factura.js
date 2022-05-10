// JavaScript Document
var formSubmitted = false;
$(document).ready(function() {

    $('#fecha').change(function(){

        var fechah = $('#vencimiento').val();
        var fechad = $('#fecha').val();
        var today = new Date();

       if ((Date.parse(fechah) < Date.parse(fechad))) {
            alertJquery('Esta fecha no puede ser mayor a la fecha de vencimiento.');
            return this.value = $('#vencimiento').val();
        };
  });

  $('#vencimiento').change(function(){

    var fechah = $('#vencimiento').val();
    var fechad = $('#fecha').val();
    var today = new Date();

    if ((Date.parse(fechah) < Date.parse(fechad))) {
        alertJquery('Esta fecha no puede ser menor a la fecha de factura.');
        return this.value = $('#fecha').val();
    };
});
    $("#divIca").css("display", "none");
    var factura_id = $("#factura_id").val();
    if (factura_id > 0 && factura_id != '') {
        setDataFormWithResponse();
    }
    $("#saveDetallepuc").click(function() {
        window.frames[0].saveDetalles();
    });
    $("#Buscar").click(function() {
        cargardiv();
    });
    leerCodigobar();
    $("#guardar,#actualizar").click(function() {
        var formulario = document.getElementById('FacturaForm');
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
    $("#tipo_factura_id").change(function() {
        if ($(this).val() == 1) {
            $("#consecutivo_factura").removeAttr('disabled');
        }
        if ($(this).val() == 2) {
            $("#consecutivo_factura").removeAttr('disabled');
        }
        if ($(this).val() == 3) {
            $("#consecutivo_factura").attr('disabled', 'disabled');
        }
    })
});
function showTable() {
    var frame_grid = document.getElementById('frame_grid');
    //Se valida que el iFrame no exista
    if (frame_grid == null) {
        var QueryString = 'ACTIONCONTROLER=showGrid';
        $.ajax({
            url: "FacturaClass.php?rand=" + Math.random(),
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
function cargaConsecutivos() {
    var cliente_id = $('#cliente_hidden').val();
    var fuente_facturacion_cod = $('#fuente_facturacion_cod').val();
    var consecutivo_factura = $('#consecutivo_factura').val();
    var tipo_bien_servicio_factura_os = $('#tipo_bien_servicio_factura_os').val();
    var tipo_bien_servicio_factura_rm = $('#tipo_bien_servicio_factura_rm').val();
    var tipo_bien_servicio_factura_st = $('#tipo_bien_servicio_factura_st').val();
    if (parseInt(cliente_id) > 0 && fuente_facturacion_cod != '' && fuente_facturacion_cod != 'NULL' && (parseInt(tipo_bien_servicio_factura_os) > 0 || parseInt(tipo_bien_servicio_factura_rm) > 0 || parseInt(tipo_bien_servicio_factura_st) > 0)) {
        return true;
    } else {
        if (fuente_facturacion_cod == '' || fuente_facturacion_cod == 'NULL') {
            alertJquery("Por Favor Seleccione una Fuente", "Factura");
            return false;
        } else if ((fuente_facturacion_cod == 'OS' && !parseInt(tipo_bien_servicio_factura_os) > 0) || (fuente_facturacion_cod == 'RM' && !parseInt(tipo_bien_servicio_factura_rm) > 0) || (fuente_facturacion_cod == 'ST' && !parseInt(tipo_bien_servicio_factura_st) > 0)) {
            alertJquery("Por Favor Seleccione un Tipo de Servicio", "Factura");
            return false;
        } else if (!parseInt(cliente_id) > 0) {
            alertJquery("Por Favor Seleccione un Cliente", "Factura");
            return false;
        }
    }
}
function beforePdf() {
    var factura_id = parseInt($("#factura_id").val());
    var fuente_facturacion_cod = parseInt($("#fuente_facturacion_cod").val());
    if (isNaN(factura_id)) {
        alertJquery("Debe seleccionar una Factura  !!!", "PDF Factura");
        return false;
    } else {
        var QueryString =
            "FacturaClass.php?ACTIONCONTROLER=onclickPrint&tipo=PDF&factura_id=" +
            factura_id + "&fuente_facturacion_cod=" + fuente_facturacion_cod;
        popPup(QueryString, "Impresion factura", 800, 600);
    }
}

function buscarVencimiento(){
	
	
	var fecha_inicio =  $('#fecha').val();
	var cliente_id	 =	$('#cliente_hidden').val();
	
	var QueryString = "ACTIONCONTROLER=buscarFecha&fecha_inicio="+fecha_inicio+"&cliente_id="+cliente_id;
			$.ajax({
				url     : "FacturaClass.php",
				data    : QueryString,
				success : function(response){
					
					try{
					//alert(response);
					if(response == "false"){
						alertJquery("No se ha parametrizado la cantidad de dias de vigencia de la factura en el modulo clientes!!!");
					}
					else{
					var vencimiento         = response.replace('"','');
					var vencimiento         = vencimiento.replace('"','');
					
					$("#vencimiento").val(vencimiento);
					}
					$('#vencimiento').attr("disabled","");
					document.getElementById('vencimiento').disabled = true;
					$("#vencimiento").blur();
					
					}catch(e){
	  alertJquery(e);
       }
				}
			});						
							
						
}
function setDataFormWithResponse() {
    var factura_id = $('#factura_id').val();
    var parametros = new Array({ campos: "factura_id", valores: $('#factura_id').val() });
    var forma = document.forms[0];
    var controlador = 'FacturaClass.php';
    FindRow(parametros, forma, controlador, null, function(resp) {
        var data = $.parseJSON(resp);
        var estado = data[0]['estado'];
        var cliente_id = data[0]['cliente_id'];
        var sede_id = data[0]['sede_id'];
        var tipo_factura_id = data[0]['tipo_factura_id'];
        var fact_electronica = data[0]['fact_electronica'];
        var reportada = data[0]['reportada'];
        var adjunto = data[0]['adjunto'];
        if (adjunto != '' && adjunto != 'NULL' && adjunto != 'null' && adjunto != null) {
            $("#adjuntover").html('<a href="' + adjunto + '" target="_blank">Ver Adjunto</a>');
        } else {
            $("#adjuntover").html('&nbsp;');
        }
        if (estado == 'I') {
            $(forma).find("input,select,textarea").each(function() {
                this.disabled = true;
            });
        } else {
            $(forma).find("input,select,textarea").each(function() {
                this.disabled = false;
            });
        }
        var QueryString = "ACTIONCONTROLER=setDataFactura&factura_id=" + factura_id;
        $.ajax({
            url: "FacturaClass.php?rand=" + Math.random(),
            data: QueryString,
            beforeSend: function() {},
            success: function(response) {
                try {
                    var responseArray = $.parseJSON(response);
                    var tipo_bien_servicio_factura_id = responseArray[0]['tipo_bien_servicio_factura_id'];
                    if ($('#fuente_facturacion_cod').val() == 'OS') {
                        Facturatipo();
                        $("#tipo_bien_servicio_factura_os").val(tipo_bien_servicio_factura_id);
                    } else if ($('#fuente_facturacion_cod').val() == 'RM') {
                        Facturatipo();
                        $("#tipo_bien_servicio_factura_rm").val(tipo_bien_servicio_factura_id);
                    } else if ($('#fuente_facturacion_cod').val() == 'ST') {
                        Facturatipo();
                        $("#tipo_bien_servicio_factura_st").val(tipo_bien_servicio_factura_id);
                    }
                } catch (e) {
                    console.log(e);
                }
            }
        });
        RequiredRemove();
        var url = "DetallesClass.php?factura_id=" + factura_id + "&fuente_facturacion_cod=" + $('#fuente_facturacion_cod').val() + "&detalles=" + $('#concepto_item').val() + "&estado=" + estado + "&rand=" + Math.random();
        $("#detalles").attr("src", url);
        var url = "SubtotalClass.php?factura_id=" + factura_id + "&rand=" + Math.random();
        $("#subtotales").attr("src", url);
        if ($('#guardar')) $('#guardar').attr("disabled", "true");
        if ($('#estado').val() == 'A' && tipo_factura_id != 3 && fact_electronica != 1 && reportda != 1) {
            if ($('#actualizar')) $('#actualizar').attr("disabled", "");
            if ($('#contabilizar')) $('#contabilizar').attr("disabled", "");
            if ($('#anular')) $('#anular').attr("disabled", "");
            if ($('#estado')) $('#estado').attr("disabled", "true");
            if ($('#saveDetallepuc')) $('#saveDetallepuc').attr("style", "display:inherit");
        } else if ($('#estado').val() == 'C' && ($('#numero_pagos').val() == 0 || $('#numero_pagos').val() == '') && tipo_factura_id != 3 && fact_electronica != 1) {
            if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
            if ($('#contabilizar')) $('#contabilizar').attr("disabled", "true");
            if ($('#estado')) $('#estado').attr("disabled", "true");
            if ($('#anular')) $('#anular').attr("disabled", "");
            if ($('#saveDetallepuc')) $('#saveDetallepuc').attr("style", "display:none");
        } else if ($('#estado').val() == 'A' && tipo_factura_id == 3 && fact_electronica == 1 && reportada != 1) {
            if ($('#actualizar')) $('#actualizar').attr("disabled", "");
            if ($('#contabilizar')) $('#contabilizar').attr("disabled", "");
            if ($('#anular')) $('#anular').attr("disabled", "true");
            if ($('#estado')) $('#estado').attr("disabled", "true");
            if ($('#saveDetallepuc')) $('#saveDetallepuc').attr("style", "display:inherit");
        } else if ($('#estado').val() == 'C' && tipo_factura_id == 3 && fact_electronica == 1) {
            if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
            if ($('#contabilizar')) $('#contabilizar').attr("disabled", "true");
            if ($('#estado')) $('#estado').attr("disabled", "true");
            if ($('#anular')) $('#anular').attr("disabled", "true");
            if ($('#saveDetallepuc')) $('#saveDetallepuc').attr("style", "display:none");
        } else if ($('#estado').val() == 'A' && tipo_factura_id == 3 && fact_electronica == 1 && reportada == 1) {
            if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
            if ($('#contabilizar')) $('#contabilizar').attr("disabled", "");
            if ($('#anular')) $('#anular').attr("disabled", "true");
            if ($('#estado')) $('#estado').attr("disabled", "true");
            if ($('#saveDetallepuc')) $('#saveDetallepuc').attr("style", "display:inherit");
        } else if ($('#estado').val() == 'A' && tipo_factura_id != 3 && fact_electronica == 1 && reportada != 1) {
            if ($('#actualizar')) $('#actualizar').attr("disabled", "");
            if ($('#contabilizar')) $('#contabilizar').attr("disabled", "");
            if ($('#anular')) $('#anular').attr("disabled", "");
            if ($('#estado')) $('#estado').attr("disabled", "true");
            if ($('#saveDetallepuc')) $('#saveDetallepuc').attr("style", "display:inherit");
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
        setDataCliente(cliente_id, sede_id,false);
        $('#sede_id').val(sede_id);
        cambioSedes();
    });
}
function cambioSedes() {
    var sede_id = $('#sedes').val();
    var cliente_id = $('#cliente_hidden').val();
    var QueryString = "ACTIONCONTROLER=setDataClienteOpe&sede_id=" + sede_id + "&cliente_id=" + cliente_id;
    $.ajax({
        url: "FacturaClass.php?rand=" + Math.random(),
        data: QueryString,
        beforeSend: function() {},
        success: function(response) {
            try {
                var responseArray = $.parseJSON(response);
                var cliente_direccion = responseArray[0]['cliente_direccion'];
                var cliente_tele = responseArray[0]['cliente_tele'];
                var cliente_ciudad = responseArray[0]['cliente_ciudad'];
                var cliente_email = responseArray[0]['cliente_email'];
                $("#cliente_direccion").val(cliente_direccion);
                $("#cliente_tele").val(cliente_tele);
                $("#cliente_ciudad").val(cliente_ciudad);
                $("#cliente_email").val(cliente_email);
            } catch (e) {
                console.log(e);
            }
        }
    });
}
function viewDoc(factura_id) {
    $('#factura_id').val(factura_id);
    setDataFormWithResponse();
}
function cargarRemesaOrden(data) {
    var concepto_item1 = $("#concepto_item").val();
    var concepto_item = concepto_item1.length > 0 ? concepto_item1 : '';
    concepto_item = concepto_item + data;
    $("#concepto_item").val('');
    $("#concepto_item").val(concepto_item);
    detalle_ss_id = document.forms[0]['concepto_item'].value;
    detalle_concepto = '';
    var remesas = detalle_ss_id.split(",");
    document.forms[0]['concepto_item'].value = detalle_ss_id;
    cargardatos();
    $("#mensaje_alerta").html(" ");
    leerCodigobar();
}
function FacturaOnSave(formulario, resp) {
    var responseArray = $.parseJSON(resp);
    var factura_id = responseArray['factura_id'];
    var consecutivo_final = responseArray['consecutivo_final'];
    var error1 = responseArray['error'];
    var concepto_item = $("#concepto_item").val();
    var estado = $("#estado").val();
    if (parseInt(factura_id) > 0) {
        var factura_id = factura_id;
        var fuente_facturacion_cod = $('#fuente_facturacion_cod').val();
        $('#consecutivo_factura').val(consecutivo_final);
        var url = "DetallesClass.php?factura_id=" + factura_id + "&detalles=" + concepto_item + "&estado=" + estado + "&fuente_facturacion_cod=" + fuente_facturacion_cod + "&rand=" + Math.random();
        $("#factura_id").val(factura_id);
        $("#detalles").attr("src", url);
        var url = "SubtotalClass.php?factura_id=" + factura_id + "&rand=" + Math.random();
        $("#subtotales").attr("src", url);
        $("#refresh_QUERYGRID_factura").click();
        if ($('#guardar')) $('#guardar').attr("disabled", "true");
        if ($('#actualizar')) $('#actualizar').attr("disabled", "");
        if ($('#contabilizar')) $('#contabilizar').attr("disabled", "");
        if ($('#anular')) $('#anular').attr("disabled", "");
        if ($('#limpiar')) $('#limpiar').attr("disabled", "");
        if ($('#imprimir')) $('#imprimir').attr("disabled", "");
        if ($('#imprimir1')) $('#imprimir1').attr("disabled", "");
        alertJquery('Guardado Exitosamente', "Factura");
    } else {
        $('#guardar').attr("disabled", ""); //aca
        alertJquery(error1, "Inconsistencia Factura");
    }
}
function FacturaOnUpdate(formulario, resp) {
    var data = $.parseJSON(resp);
    if (data) {
        var factura_id = $("#factura_id").val();
        var estado = $("#estado").val();
        var concepto_item = $("#concepto_item").val();
        var url = "DetallesClass.php?factura_id=" + factura_id + "&detalles=" + concepto_item + "&estado=" + estado + "&rand=" + Math.random();
        $("#detalles").attr("src", url);
        var url = "SubtotalClass.php?factura_id=" + factura_id + "&rand=" + Math.random();
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
    alertJquery(data, "Factura");
}
function FacturaOnReset(formulario) {
    $(formulario).find("input,select,textarea").each(function() {
        this.disabled = false;
    });
    $("#detalles").attr("src", "../../../framework/tpl/blank.html");
    $("#subtotales").attr("src", "../../../framework/tpl/blank.html");
    if ($('#guardar')) $('#guardar').attr("disabled", "");
    if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
    if ($('#contabilizar')) $('#contabilizar').attr("disabled", "true");
    if ($('#anular')) $('#anular').attr("disabled", "true");
    if ($('#imprimir')) $('#imprimir').attr("disabled", "true");
    if ($('#imprimir1')) $('#imprimir1').attr("disabled", "true");
    if ($('#limpiar')) $('#limpiar').attr("disabled", "");
    $("#adjuntover").html('&nbsp;');
    if ($('#saveDetallepuc')) $('#saveDetallepuc').attr("style", "display:inherit");
    clearFind();
    //Causartipo();
    document.getElementById('usuario_id').value = document.getElementById('anul_usuario_id').value;
    document.getElementById('ingreso_factura').value = document.getElementById('anul_factura').value;
    document.getElementById('oficina_id').value = document.getElementById('anul_oficina_id').value;
    if ($('#estado')) $('#estado').attr("disabled", "true");
    document.getElementById('estado').value = 'A';
}
function beforePrint(formulario, url, title, width, height) {
    var factura_id = parseInt($("#factura_id").val());
    if (title == 'Impresion Factura formato') {
        document.getElementById('tipo_impre').value = 'F';
    } else {
        document.getElementById('tipo_impre').value = 'S';
    }
    if (isNaN(factura_id)) {
        alertJquery('Debe seleccionar una Factura a imprimir !!!', 'Impresion Factura');
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
    var estado = $('#estado').val();
    var detalles = concepto_item.split(",");
    var total = 0;
    for (var i in detalles) {
        if (detalles[i] != '') {
            var detalle_frac = detalles[i].split("-");
            var detalle_id = detalle_frac[0];
            var fuente_facturacion_cod = detalle_frac[1];
            var QueryString = "ACTIONCONTROLER=setSolicitud&detalle_id=" + detalle_id + "&fuente_facturacion_cod=" + fuente_facturacion_cod + "&rand=" + Math.random();
            $.ajax({
                url: "FacturaClass.php",
                data: QueryString,
                success: function(resp) {
                    var resp = $.parseJSON(resp);
                    var concepto_detalle = resp[0]['concepto_detalle'];
                    var valor = parseFloat(resp[0]['valor']);
                    detalle_concepto += concepto_detalle + " - ";
                    total = parseFloat(total + valor);
                    $("#concepto").val(detalle_concepto);
                    //$("#concepto").val('Remesas');
                    $("#valor").val(setFormatCurrency(Math.trunc(total)));
                }
            });
        }
    }
    var factura_id = $("#factura_id").val();
    if (factura_id > 0) {
        var url = "DetallesClass.php?detalles=" + concepto_item + "&preview=true" + "&factura_id=" + factura_id + "&estado=" + estado + "&rand=" + Math.random();
        $("#detalles").attr("src", url);
    } else {
        var url = "DetallesClass.php?detalles=" + concepto_item + "&preview=true" + "&estado=" + estado + "&rand=" + Math.random();
        $("#detalles").attr("src", url);
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
        url: "FacturaClass.php",
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
        url: "FacturaClass.php",
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
function setDataCliente(cliente_id, sede_id,bandera=true) {
    var QueryString = "ACTIONCONTROLER=setDataCliente&cliente_id=" + cliente_id;
    $.ajax({
        url: "FacturaClass.php?rand=" + Math.random(),
        data: QueryString,
        beforeSend: function() {},
        success: function(response) {
            try {
                var responseArray = $.parseJSON(response);
                var cliente_nit = responseArray[0]['cliente_nit'];
                var cliente_direccion = responseArray[0]['cliente_direccion'];
                var cliente_tele = responseArray[0]['cliente_tele'];
                var cliente_ciudad = responseArray[0]['cliente_ciudad'];
                var cliente = responseArray[0]['cliente'];
                var cliente_email = responseArray[0]['cliente_email'];
                $("#cliente_nit").val(cliente_nit);
                $("#cliente_direccion").val(cliente_direccion);
                $("#cliente_tele").val(cliente_tele);
                $("#cliente_ciudad").val(cliente_ciudad);
                $("#cliente").val(cliente);
                $("#cliente_email").val(cliente_email);
                var sedes = responseArray[0]['sedes'];
                if (sedes != null && sedes != '') {
                    $("#sedes").empty();
                    $("#sedes").append($("<option>", {
                        value: 'NULL',
                        text: '( Seleccione )'
                    }));
                    for (var i = 0; i < sedes.length; i++) {
                        $("#sedes").append($("<option>", {
                            value: sedes[i].value,
                            text: sedes[i].text
                        }));
                    }
                    if (sede_id > 0) {
                        $("#sedes").val(sede_id);
                    }
                }
                $("#observacion").focus();
            } catch (e) {
                console.log(e);
            }
        }
    });
    if (bandera) buscarVencimiento();
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
                    url: "FacturaClass.php",
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
                url: "FacturaClass.php",
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
function leerCodigobar() {
    $("#codigo_barras").keypress(function(e) {
        console.log("enter");
        if (e.which == 13) {
            e.preventDefault();
            var guia = $("#codigo_barras").val();
            var cliente_id = $('#cliente_hidden').val();
            if (document.getElementById('codigo_barras').value != '' && cargaConsecutivos()) {
                $("#codigo_barras").focus();
                if (guia == "NULL" || guia == "") {
                    guia = 0;
                } else {
                    var QueryString = "ACTIONCONTROLER=setLeerCodigobar&guia=" + guia + "&cliente_id=" + cliente_id;
                    $("#codigo_barras").val('');
                    $.ajax({
                        url: 'FacturaClass.php?random=' + Math.random(),
                        data: QueryString,
                        beforeSend: function() {
                            showDivLoading();
                        },
                        success: function(resp) {
                            try {
                                var data = $.parseJSON(resp);
                                if (data[0]['consecutivo'] != null) {
                                    for (var i = 0; i < data[0]['consecutivo'].length; i++) {
                                        if (data[0]['tipo'][i] == 'remesa') {
                                            $("#select").append('<option  value=' + data[0]['consecutivo'][i] + '-RM,' + '>' + 'N° ' + data[0]['guia'][i] + ' - Oficina : ' + data[0]['oficina'][i] + ' - Tipo : ' + data[0]['tipo'][i] + '  </option>');
                                        } else {
                                            $("#select").append('<option  value=' + data[0]['consecutivo'][i] + '-OS,' + '>' + 'N° ' + data[0]['guia'][i] + ' - Oficina : ' + data[0]['oficina'][i] + ' - Tipo : ' + data[0]['tipo'][i] + '  </option>');
                                        }
                                    }
                                    $("#divRemesasOrdenes").dialog({
                                        width: 600,
                                        height: 240,
                                        left: 700,
                                        title: 'Seleccione la orden de servicio o remesa',
                                        open: function(event, ui) {
                                            $(".ui-dialog-titlebar-close", ui.dialog).click(function() {
                                                $('#select').empty();
                                                $("#mensaje_exito").html(" Se agrego correctamente el documento " + guia);
                                                $("#mensaje_alerta").html('');
                                            });
                                        }
                                    });
                                } else {
                                    cargarRemesaOrden(data);
                                    $("#mensaje_exito").html(" Se agrego correctamente el documento " + guia);
                                    $("#mensaje_alerta").html('');
                                }

                            } catch (e) {
                                console.log(e);
                                $("#mensaje_alerta").html(" " + e + "");
                                $("#mensaje_exito").html('');
                            }
                            $("#codigo_barras").focus();
                            removeDivLoading();
                        }
                    });
                }
            } else {
                $("#codigo_barras").val('');
                $("#codigo_barras").focus();
            }
        }
    });
}
function procesarBloque() {
    var numeros_agregar = $("#numeros_agregar").val();
    var cliente_id = $('#cliente_hidden').val();
    var numeros_arr = '';
    if (numeros_agregar != '' && cargaConsecutivos()) {
        console.log("numero antes" + numeros_agregar);
        separadores = [',', '\n', '\r', '-', '_'],
            numeros_arr = numeros_agregar.split(new RegExp(separadores.join('|'), 'g'));
        console.log("numerosss" + numeros_arr)
        for (var i = 0; i < numeros_arr.length; i++) {
            console.log("numero" + numeros_arr[i])
            var guia = numeros_arr[i];
            console.log("guia" + guia)
            if (guia != '') {
                var QueryString = "ACTIONCONTROLER=setLeerCodigobar&guia=" + guia + "&cliente_id=" + cliente_id;
                $("#codigo_barras").val('');
                $.ajax({
                    url: 'FacturaClass.php?random=' + Math.random(),
                    data: QueryString,
                    beforeSend: function() {
                        showDivLoading();
                    },
                    success: function(resp) {
                        try {
                            var data = $.parseJSON(resp);
                            if (data[0]['consecutivo'] != null) {
                                for (var i = 0; i < data[0]['consecutivo'].length; i++) {
                                    if (data[0]['tipo'][i] == 'remesa') {
                                        $("#select").append('<option  value=' + data[0]['consecutivo'][i] + '-RM,' + '>' + 'N° ' + data[0]['guia'][i] + ' - Oficina : ' + data[0]['oficina'][i] + ' - Tipo : ' + data[0]['tipo'][i] + '  </option>');
                                    } else {
                                        $("#select").append('<option  value=' + data[0]['consecutivo'][i] + '-OS,' + '>' + 'N° ' + data[0]['guia'][i] + ' - Oficina : ' + data[0]['oficina'][i] + ' - Tipo : ' + data[0]['tipo'][i] + '  </option>');
                                    }
                                }
                                $("#divRemesasOrdenes").dialog({
                                    width: 600,
                                    height: 240,
                                    left: 700,
                                    title: 'Seleccione la orden de servicio o remesa',
                                    open: function(event, ui) {
                                        $(".ui-dialog-titlebar-close", ui.dialog).click(function() {
                                            $('#select').empty();
                                            $("#mensaje_exito").html(" Se agrego correctamente el documento " + guia);
                                            $("#mensaje_alerta").html('');
                                            $("#numeros_agregar").val('');
                                        });
                                    }
                                });
                            } else {
                                cargarRemesaOrden(data);
                                $("#mensaje_exito").html(" Se agrego correctamente el documento " + guia);
                                $("#mensaje_alerta").html('');
                                $("#numeros_agregar").val('');
                            }

                        } catch (e) {
                            console.log(e);
                            $("#mensaje_alerta").html(" " + e + "");
                            $("#mensaje_exito").html('');
                        }
                        $("#codigo_barras").focus();
                        removeDivLoading();
                    }
                });
            } else {
                console.log("El numero " + guia + "No es numero");
            }

        }
    } else {
        alertJquery("Debe Escribir datos en el campo para poder procesar!", "Error");
    }
}
function validaCargaExcel() {
    var cliente_id = $('#cliente_hidden').val();
    if (cliente_id != '' && cargaConsecutivos()) {
        return true;
    } else {
        alertJquery('Debe cargar primero una Factura!!', 'Validacion');
        return false;
    }
}
function deleteDetalle(id) {

    var formulario = document.getElementById('FacturaForm');
    var concepto_item = $('#concepto_item').val();
    var concepto_item_nuevo = concepto_item.replace(id, "");
    //console.log(id+concepto_item_nuevo);
    $('#concepto_item').val(concepto_item_nuevo);
    detalle_ss_id = document.forms[0]['concepto_item'].value;
    var remesas = detalle_ss_id.split(",");
    var cantidad = (remesas.length) - 1;
    $('#cantidad_remesas').val(cantidad);
    var factura_id = $('#factura_id').val();
    if (factura_id > 0) {
        var QueryString = "ACTIONCONTROLER=updateDetalleFactura&factura_id=" + factura_id + "&id=" + id;
        $.ajax({
            url: "FacturaClass.php",
            data: QueryString,
            success: function(response) {
                try {
                    if ($.trim(response) == 'true') {
                        if (ValidaRequeridos(formulario)) {
                            Send(formulario, 'onclickUpdate', null, FacturaOnUpdate);
                        }
                        formSubmitted = false;
                    } else {
                        alertJquery(response, '¡Inconsistencia al intentar actualizar el detalle de la factura!');
                    }
                } catch (e) {
                    console.log(e);
                }
            }
        });
    }
    cargardatos();
}
function OnclickContabilizar() {
    var factura_id = $("#factura_id").val();
    var fecha = $("#fecha").val();
    var valor = removeFormatCurrency($("#valor").val());
    var QueryString = "ACTIONCONTROLER=getTotalDebitoCredito&factura_id=" + factura_id;
    if (parseInt(factura_id) > 0) {
        if (!formSubmitted) {
            formSubmitted = true;
            $.ajax({
                url: "FacturaClass.php",
                data: QueryString,
                success: function(response) {
                    try {
                        var totalDebitoCredito = $.parseJSON(response);
                        var totalDebito = parseFloat(totalDebitoCredito[0]['debito']) > 0 ? totalDebitoCredito[0]['debito'] : 0;
                        var totalCredito = parseFloat(totalDebitoCredito[0]['credito']) > 0 ? totalDebitoCredito[0]['credito'] : 0;
                        $("#totalDebito").html(totalDebito);
                        $("#totalCredito").html(totalCredito);
                        if (parseFloat(totalDebito) == parseFloat(totalCredito) && parseFloat(valor) > 0) {
                            var QueryString = "ACTIONCONTROLER=getContabilizar&factura_id=" + factura_id + "&fecha=" + fecha;
                            $.ajax({
                                url: "FacturaClass.php",
                                data: QueryString,
                                success: function(response) {
                                    try {
                                        if ($.trim(response) == 'true') {
                                            alertJquery('Factura Contabilizada', 'Contabilizacion Exitosa');
                                            $("#refresh_QUERYGRID_factura").click();
                                            setDataFormWithResponse();
                                            formSubmitted = false;
                                        } else {
                                            alertJquery(response, 'Inconsistencia Contabilizando');
                                        }
                                    } catch (e) {}
                                }
                            });
                        } else {
                            alertJquery('No existen sumas iguales :<b>NO SE CONTABILIZARA</b>', 'Contabilizacion');
                        }
                    } catch (e) {}
                }
            });
            formSubmitted = false;
        }
    } else {
        alertJquery('Debe Seleccionar primero una Factura', 'Contabilizacion');
        formSubmitted = false;
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
            url: "FacturaClass.php",
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
                } catch (e) {}
            }
        });
    } else {
        alertJquery('Debe Seleccionar primero una Factura', 'ReContabilizacion');
    }
}
function ComprobarTercero(tipo_bien_servicio_factura_id) {
    var QueryString = "ACTIONCONTROLER=ComprobarTercero&tipo_bien_servicio_factura_id=" + tipo_bien_servicio_factura_id;
    $.ajax({
        url: "FacturaClass.php?rand=" + Math.random(),
        data: QueryString,
        beforeSend: function() {},
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
                url: "FacturaClass.php",
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
//validaciion previa
function OnclickReportarVP() {
    var factura_id = $("#factura_id").val();
    if (parseInt(factura_id) > 0) {
        $('#reportar').attr("disabled", "true");
        if (!formSubmitted) {
            formSubmitted = true;
            var QueryString = "ACTIONCONTROLER=OnclickReportarVP&factura_id=" + factura_id;
            $.ajax({
                url: "FacturaClass.php",
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
        alertJquery('Debe Seleccionar primero una Factura', 'Reporte Factura Electronica Validacion Previa');
    }
}
function onclickEnviarMail() {
    //alertJquery("En construccion");
    var factura_id = $("#factura_id").val();
    if (parseInt(factura_id) > 0) {
        var QueryString = "ACTIONCONTROLER=onclickEnviarMail&factura_id=" + factura_id;
        $.ajax({
            url: "FacturaClass.php?rand=" + Math.random(),
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
function cargarExcel(response) {
    console.log(response);
    if ($.trim(response) == 'false') {
        alertJquery('No se ha podido adjuntar el archivo !!');
    } else {
        try {
            var documentos = $.parseJSON(response);
            var cliente_id = $('#cliente_hidden').val();
            for (var i = 0; i < documentos.length; i++) {
                var guia = documentos[i];
                if (guia != '') {
                    var QueryString = "ACTIONCONTROLER=setLeerCodigobar&guia=" + guia + "&cliente_id=" + cliente_id;
                    $.ajax({
                        url: 'FacturaClass.php?random=' + Math.random(),
                        data: QueryString,
                        beforeSend: function() {
                            showDivLoading();
                        },
                        success: function(resp) {
                            try {
                                var data = $.parseJSON(resp);
                                if (data[0]['consecutivo'] != null) {
                                    for (var i = 0; i < data[0]['consecutivo'].length; i++) {
                                        if (data[0]['tipo'][i] == 'remesa') {
                                            $("#select").append('<option  value=' + data[0]['consecutivo'][i] + '-RM,' + '>' + 'N° ' + data[0]['guia'][i] + ' - Oficina : ' + data[0]['oficina'][i] + ' - Tipo : ' + data[0]['tipo'][i] + '  </option>');
                                        } else {
                                            $("#select").append('<option  value=' + data[0]['consecutivo'][i] + '-OS,' + '>' + 'N° ' + data[0]['guia'][i] + ' - Oficina : ' + data[0]['oficina'][i] + ' - Tipo : ' + data[0]['tipo'][i] + '  </option>');
                                        }
                                    }
                                    $("#divRemesasOrdenes").dialog({
                                        width: 600,
                                        height: 240,
                                        left: 700,
                                        title: 'Seleccione la orden de servicio o remesa',
                                        open: function(event, ui) {
                                            $(".ui-dialog-titlebar-close", ui.dialog).click(function() {
                                                $('#select').empty();
                                                $("#mensaje_exito").html(" Se agrego correctamente el documento " + guia);
                                                $("#mensaje_alerta").html('');
                                                $("#numeros_agregar").val('');
                                            });
                                        }
                                    });
                                } else {
                                    cargarRemesaOrden(data);
                                    $("#mensaje_exito").html(" Se agrego correctamente el documento " + guia);
                                    $("#mensaje_alerta").html('');
                                    $("#numeros_agregar").val('');
                                }

                            } catch (e) {
                                console.log(e);
                                $("#mensaje_alerta").html(" " + e + "");
                                $("#mensaje_exito").html('');
                            }
                            $("#codigo_barras").focus();
                            removeDivLoading();
                        }
                    });
                } else {
                    console.log("El numero " + guia + "No es numero");
                }

            }
            alertJquery("Se ha Cargado el adjunto", "Validacion Adjunto");
        } catch (e) {
            alertJquery('Hubo un error al procesar el archivo !!');
            console.log(e);
        }
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