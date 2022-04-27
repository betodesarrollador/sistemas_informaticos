// JavaScript Document
var formSubmitted = false;

function setDataFormWithResponse() {
    var factura_proveedor_id = $('#factura_proveedor_id').val();
    var QueryString = "ACTIONCONTROLER=setDataFactura&factura_proveedor_id=" + factura_proveedor_id;

    RequiredRemove();

    var parametros = new Array({ campos: "factura_proveedor_id", valores: $('#factura_proveedor_id').val() });
    var forma = document.forms[0];
    var controlador = 'CausarClass.php';

    var url = "DetallesClass.php?factura_proveedor_id=" + factura_proveedor_id + "&rand=" + Math.random();
    $("#detalles").attr("src", url);

    if ($('#estado_factura_proveedor').val() == 'A') {
        document.getElementById('codfactura_proveedor').disabled = false;
        document.getElementById('fecha_factura_proveedor').disabled = false;
        document.getElementById('vence_factura_proveedor').disabled = false;
        document.getElementById('concepto_factura_proveedor').disabled = false;
        document.getElementById('fuente_servicio_cod').disabled = true;
        document.getElementById('tipo_bien_servicio_nn').disabled = true;
        document.getElementById('valor').disabled = true;
        document.getElementById('proveedornn').disabled = true;
        document.getElementById('proveedor_nit').disabled = true;

    } else if ($('#estado_factura_proveedor').val() == 'C') {
        document.getElementById('codfactura_proveedor').disabled = true;
        document.getElementById('fecha_factura_proveedor').disabled = true;
        document.getElementById('vence_factura_proveedor').disabled = true;
        document.getElementById('concepto_factura_proveedor').disabled = true;
        document.getElementById('fuente_servicio_cod').disabled = true;
        document.getElementById('tipo_bien_servicio_nn').disabled = true;
        document.getElementById('valor').disabled = true;
        document.getElementById('proveedornn').disabled = true;
        document.getElementById('proveedor_nit').disabled = true;

    } else {
        document.getElementById('codfactura_proveedor').disabled = false;
        document.getElementById('fecha_factura_proveedor').disabled = false;
        document.getElementById('vence_factura_proveedor').disabled = false;
        document.getElementById('concepto_factura_proveedor').disabled = false;
        document.getElementById('fuente_servicio_cod').disabled = false;
        document.getElementById('tipo_bien_servicio_nn').disabled = false;
        document.getElementById('valor').disabled = false;
        document.getElementById('proveedornn').disabled = false;
        document.getElementById('proveedor_nit').disabled = false;

    }

    FindRow(parametros, forma, controlador, null, function(resp) {
        if ($('#guardar')) $('#guardar').attr("disabled", "true");
        if ($('#estado_factura_proveedor').val() == 'A') {
            if ($('#actualizar')) $('#actualizar').attr("disabled", "");
            if ($('#contabilizar')) $('#contabilizar').attr("disabled", "");
            if ($('#anular')) $('#anular').attr("disabled", "");
            if ($('#saveDetallepuc')) $('#saveDetallepuc').attr("style", "display:inherit");
            if ($('#deleteDetallepuc')) $('#deleteDetallepuc').attr("style", "display:inherit");
        } else if ($('#estado_factura_proveedor').val() == 'C' && ($('#numero_pagos').val() == 0 || $('#numero_pagos').val() == '')) {
            if ($('#actualizar')) $('#actualizar').attr("disabled", "");
            if ($('#contabilizar')) $('#contabilizar').attr("disabled", "true");
            if ($('#anular')) $('#anular').attr("disabled", "");
            if ($('#saveDetallepuc')) $('#saveDetallepuc').attr("style", "display:inherit");
            if ($('#deleteDetallepuc')) $('#deleteDetallepuc').attr("style", "display:inherit");

        } else {
            if ($('#actualizar')) $('#actualizar').attr("disabled", "");
            if ($('#contabilizar')) $('#contabilizar').attr("disabled", "true");
            if ($('#anular')) $('#anular').attr("disabled", "true");
            if ($('#saveDetallepuc')) $('#saveDetallepuc').attr("style", "display:none");
            if ($('#deleteDetallepuc')) $('#deleteDetallepuc').attr("style", "display:none");

        }
        if ($('#limpiar')) $('#limpiar').attr("disabled", "");
        if ($('#imprimir')) $('#imprimir').attr("disabled", "");
        getTotalDebitoCredito(factura_proveedor_id);

        $.ajax({
            url: "CausarClass.php?rand=" + Math.random(),
            data: QueryString,
            beforeSend: function() {

            },
            success: function(response) {

                try {

                    var responseArray = $.parseJSON(response);
                    var proveedor_id = responseArray[0]['proveedor_id'];
                    var proveedor_nit = responseArray[0]['proveedor_nit'];
                    var codfactura_proveedor = responseArray[0]['codfactura_proveedor'];
                    var proveedor_nombre = responseArray[0]['proveedor_nombre'];
                    var orden_compra_id = responseArray[0]['orden_compra_id'];
                    var liquidacion_despacho_id = responseArray[0]['liquidacion_despacho_id'];
                    var tipo_bien_servicio_id = responseArray[0]['tipo_bien_servicio_id'];
                    var valor_man = responseArray[0]['valor'];
                    var valor_ord = responseArray[0]['valor'];
                    var num_referencia = responseArray[0]['num_referencia'];
                    var dias_vencimiento = responseArray[0]['dias_vencimiento'];
                    var tercero_id = responseArray[0]['tercero_id'];

                    $("#dias_vencimiento").val(dias_vencimiento);
                    $("#tercero_id").val(tercero_id);


                    if ($('#fuente_servicio_cod').val() == 'OC') {
                        Causartipo();
                        $("#proveedor").val(proveedor_nombre);
                        $("#orden_compra_hidden").val(orden_compra_id);
                        $("#tipo_bien_servicio_ord").val(tipo_bien_servicio_id);
                        $("#proveedor_nit").val(proveedor_nit);
                        $("#valor").val(valor_ord);

                    } else if ($('#fuente_servicio_cod').val() == 'MC') {
                        Causartipo();
                        $("#proveedormc").val(proveedor_nombre);
                        $("#liquidacion_despacho_id").val(liquidacion_despacho_id);
                        $("#proveedor_nit").val(proveedor_nit);
                        $("#valor").val(valor_man);
                        $("#manifiesto_id").val(num_referencia);

                    } else if ($('#fuente_servicio_cod').val() == 'DU') {
                        Causartipo();
                        $("#proveedordu").val(proveedor_nombre);
                        $("#liquidacion_despacho_id").val(liquidacion_despacho_id);
                        $("#proveedor_nit").val(proveedor_nit);
                        $("#valor").val(valor_man);
                        $("#despacho_id").val(num_referencia);
                    } else if ($('#fuente_servicio_cod').val() == 'NN') {
                        Causartipo();
                        $("#proveedornn").val(proveedor_nombre);
                        $("#proveedor_id").val(proveedor_id);
                        $("#codfactura_proveedornn").val(codfactura_proveedor);
                        $("#tipo_bien_servicio_nn").val(tipo_bien_servicio_id);
                        $("#proveedor_nit").val(proveedor_nit);
                        $("#valor").val(valor_ord);

                    }

                } catch (e) {
                    alertJquery(e);
                }

            }

        });

    });

}

function viewDoc(factura_proveedor_id) {
    $('#factura_proveedor_id').val(factura_proveedor_id);
    setDataFormWithResponse();
}

function CausarOnSave(formulario, resp) {

    if (isInteger(resp)) {

        var factura_proveedor_id = resp;
        var url = "DetallesClass.php?factura_proveedor_id=" + factura_proveedor_id + "&rand=" + Math.random();
        $("#factura_proveedor_id").val(factura_proveedor_id);
        $("#detalles").attr("src", url);
        $("#refresh_QUERYGRID_causar").click();

        if ($('#guardar')) $('#guardar').attr("disabled", "true");
        if ($('#actualizar')) $('#actualizar').attr("disabled", "");
        if ($('#contabilizar')) $('#contabilizar').attr("disabled", "");
        if ($('#anular')) $('#anular').attr("disabled", "");
        if ($('#limpiar')) $('#limpiar').attr("disabled", "");
        if ($('#imprimir')) $('#imprimir').attr("disabled", "");

        getTotalDebitoCredito(factura_proveedor_id);
    } else {

        alertJquery(resp, "Causar");

    }


}

function CausarOnUpdate(formulario, resp) {
    if (resp) {
        var factura_proveedor_id = $("#factura_proveedor_id").val();
        var url = "DetallesClass.php?factura_proveedor_id=" + factura_proveedor_id + "&rand=" + Math.random();
        $("#detalles").attr("src", url);
    }
    $("#refresh_QUERYGRID_causar").click();

    if ($('#guardar')) $('#guardar').attr("disabled", "true");
    if ($("#estado_factura_proveedor").val() == 'A') {
        if ($('#actualizar')) $('#actualizar').attr("disabled", "");
        if ($('#contabilizar')) $('#contabilizar').attr("disabled", "");
        if ($('#anular')) $('#anular').attr("disabled", "");
        if ($('#saveDetallepuc')) $('#saveDetallepuc').attr("style", "display:inherit");
        if ($('#deleteDetallepuc')) $('#deleteDetallepuc').attr("style", "display:inherit");

    } else if ($('#estado_factura_proveedor').val() == 'C' && ($('#numero_pagos').val() == 0 || $('#numero_pagos').val() == '')) {
        if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
        if ($('#contabilizar')) $('#contabilizar').attr("disabled", "true");
        if ($('#anular')) $('#anular').attr("disabled", "");
        if ($('#saveDetallepuc')) $('#saveDetallepuc').attr("style", "display:none");
        if ($('#deleteDetallepuc')) $('#deleteDetallepuc').attr("style", "display:none");

    } else {
        if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
        if ($('#contabilizar')) $('#contabilizar').attr("disabled", "true");
        if ($('#anular')) $('#anular').attr("disabled", "true");
        if ($('#saveDetallepuc')) $('#saveDetallepuc').attr("style", "display:none");
        if ($('#deleteDetallepuc')) $('#deleteDetallepuc').attr("style", "display:none");


    }
    if ($('#limpiar')) $('#limpiar').attr("disabled", "");
    if ($('#imprimir')) $('#imprimir').attr("disabled", "");
    getTotalDebitoCredito(factura_proveedor_id);

    alertJquery(resp, "Causar");

}

function CausarOnReset(formulario) {
    $("#detalles").attr("src", "/rotterdan/framework/tpl/blank.html");
    if ($('#guardar')) $('#guardar').attr("disabled", "");
    if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
    if ($('#contabilizar')) $('#contabilizar').attr("disabled", "true");
    if ($('#anular')) $('#anular').attr("disabled", "true");
    if ($('#limpiar')) $('#limpiar').attr("disabled", "");
    if ($('#imprimir')) $('#imprimir').attr("disabled", "true");
    if ($('#saveDetallepuc')) $('#saveDetallepuc').attr("style", "display:inherit");
    if ($('#deleteDetallepuc')) $('#deleteDetallepuc').attr("style", "display:inherit");
    $("#totalDebito").html("0.00");
    $("#totalCredito").html("0.00");
    clearFind();
    $("#fuente_servicio_cod").val('NN');
    Causartipo();
    document.getElementById('usuario_id').value = document.getElementById('anul_usuario_id').value;
    document.getElementById('ingreso_factura_proveedor').value = document.getElementById('anul_factura_proveedor').value;
    document.getElementById('oficina_id').value = document.getElementById('anul_oficina_id').value;
    document.getElementById('estado_factura_proveedor').value = 'A';
    document.getElementById('estado').value = 'A';

    /*   if($('#estado_factura_proveedor').val()=='A'){
    		document.getElementById('codfactura_proveedor').disabled = false;
    		document.getElementById('fecha_factura_proveedor').disabled = false;
    		document.getElementById('vence_factura_proveedor').disabled=false;
    		document.getElementById('concepto_factura_proveedor').disabled=false;	
    		document.getElementById('fuente_servicio_cod').disabled=true;			
    		document.getElementById('tipo_bien_servicio_nn').disabled=true;							
    		document.getElementById('valor').disabled=true;							
    		document.getElementById('proveedornn').disabled=true;							
    		document.getElementById('proveedor_nit').disabled=true;							
    				
       }else if($('#estado_factura_proveedor').val()=='C'){
    		document.getElementById('codfactura_proveedor').disabled = true;
    		document.getElementById('fecha_factura_proveedor').disabled = true;
    		document.getElementById('vence_factura_proveedor').disabled=true;
    		document.getElementById('concepto_factura_proveedor').disabled=true;	
    		document.getElementById('fuente_servicio_cod').disabled=true;			
    		document.getElementById('tipo_bien_servicio_nn').disabled=true;							
    		document.getElementById('valor').disabled=true;							
    		document.getElementById('proveedornn').disabled=true;							
    		document.getElementById('proveedor_nit').disabled=true;							
    				
       }else {
    		document.getElementById('codfactura_proveedor').disabled = false;
    		document.getElementById('fecha_factura_proveedor').disabled = false;
    		document.getElementById('vence_factura_proveedor').disabled=false;
    		document.getElementById('concepto_factura_proveedor').disabled=false;	
    		document.getElementById('fuente_servicio_cod').disabled=false;			
    		document.getElementById('tipo_bien_servicio_nn').disabled=false;							
    		document.getElementById('valor').disabled=false;							
    		document.getElementById('proveedornn').disabled=false;							
    		document.getElementById('proveedor_nit').disabled=false;							
    		
       }*/
    document.getElementById('fuente_servicio_cod').disabled = false;
    document.getElementById('codfactura_proveedor').disabled = false;
    document.getElementById('fecha_factura_proveedor').disabled = false;
    document.getElementById('vence_factura_proveedor').disabled = false;
    document.getElementById('concepto_factura_proveedor').disabled = false;
    document.getElementById('fuente_servicio_cod').disabled = false;
    document.getElementById('tipo_bien_servicio_nn').disabled = false;
    document.getElementById('valor').disabled = false;
    document.getElementById('proveedornn').disabled = false;
    document.getElementById('proveedor_nit').disabled = false;
}


$(document).ready(function() {

    var factura_proveedor_id = $("#factura_proveedor_id").val();

    if (factura_proveedor_id > 0 && factura_proveedor_id != '') {

        setDataFormWithResponse();
    }

    $("#saveDetallepuc").click(function() {
        window.frames[0].saveDetalles();
    });
    $("#deleteDetallepuc").click(function() {
        window.frames[0].deleteDetalles();
    });

    $("#Buscar").click(function() {
        cargardiv();

    });

    $("#BuscarOrdenes").click(function() {
        cargardivordenes();

    });

    $("#dias_vencimiento").blur(function() {

        var fecha = $("#fecha_factura_proveedor").val();
        var dias = $("#dias_vencimiento").val();

        if ((isNaN(dias) || dias == '') && (fecha != '')) {

            alertJquery("Debe ingresar los dias de vencimiento de la factura");
            document.getElementById('vencimiento').value = '';
            //("#vencimiento").val(resp);
        } else {
            var QueryString = "ACTIONCONTROLER=setVencimiento&fecha=" + fecha + "&dias=" + dias;
            $.ajax({
                url: "CausarClass.php",
                data: QueryString,
                success: function(resp) {
                    $("#vence_factura_proveedor").val(resp);
                }
            });
        }

    });

    $("#guardar,#actualizar").click(function() {

        var formulario = document.getElementById('CausarForm');

        if (ValidaRequeridos(formulario)) {
            if (this.id == 'guardar') {
                //cargardiv();
                Send(formulario, 'onclickSave', null, CausarOnSave)
            } else {
                Send(formulario, 'onclickUpdate', null, CausarOnUpdate)
            }
        }

    });

});

function closeDialog() {
    $("#divSolicitudFacturas").dialog('close');
}

function closeDialogOrden() {
    $("#divSolicitudOrdenes").dialog('close');
}

function cargardiv() {
    var proveedor_id = $('#proveedor_id').val();

    if (parseInt(proveedor_id) > 0) {
        $("#iframeSolicitud").attr("src", "SolicFacturasClass.php?proveedor_id=" + proveedor_id + "&rand=" + Math.random());
        $("#divSolicitudFacturas").dialog({
            title: 'Facturas Causadas',
            width: 880,
            height: 395,
            closeOnEscape: true,
            show: 'scale',
            hide: 'scale'
        });
    } else {
        alertJquery("Por Favor Seleccione un Proveedor", "Facturas");
    }
}

function cargardivordenes() {
    var proveedor_id = $('#proveedor_id').val();

    if (parseInt(proveedor_id) > 0) {
        $("#iframeOrden").attr("src", "SolicOrdenesClass.php?proveedor_id=" + proveedor_id + "&rand=" + Math.random());
        $("#divSolicitudOrdenes").dialog({
            title: 'Ordenes Liquidadas',
            width: 880,
            height: 395,
            closeOnEscape: true,
            show: 'scale',
            hide: 'scale'
        });
    } else {
        alertJquery("Por Favor Seleccione un Proveedor", "Facturas");
    }
}

function setDataProveedorOrden(proveedor_id) {

    var QueryString = "ACTIONCONTROLER=setDataProveedorOrden&proveedor_id=" + proveedor_id;

    $.ajax({
        url: "CausarClass.php?rand=" + Math.random(),
        data: QueryString,
        beforeSend: function() {

        },
        success: function(response) {

            try {

                var responseArray = $.parseJSON(response);
                var proveedor_nit = responseArray[0]['proveedor_nit'];
                var tercero_id = responseArray[0]['tercero_id'];
                var proveedor_id = responseArray[0]['proveedor_id'];
                var nombre_prov = $('#proveedor').val();
                var nombre_split = nombre_prov.split('-');

                $("#proveedor_id").val(proveedor_id);
                $("#proveedor_nit").val(proveedor_nit);
                $("#tercero_id").val(tercero_id);
                var nombre_final = nombre_split[1].replace(/^\s+|\s+$/g, "");
                $("#proveedor").val(nombre_final);

            } catch (e) {
                alertJquery(e);
            }

        }

    });

}

function setDataProveedor(proveedor_id) {

    var QueryString = "ACTIONCONTROLER=setDataProveedor&orden_compra_id=" + orden_compra_id;

    $.ajax({
        url: "CausarClass.php?rand=" + Math.random(),
        data: QueryString,
        beforeSend: function() {

        },
        success: function(response) {

            try {

                var responseArray = $.parseJSON(response);
                var proveedor_nit = responseArray[0]['proveedor_nit'];
                var orden_compra_id = responseArray[0]['orden_compra_id'];
                var tipo_bien_servicio_ord = responseArray[0]['tipo_bien_servicio_ord'];
                var valor = responseArray[0]['valor'];
                var tercero_id = responseArray[0]['tercero_id'];
                var proveedor_id = responseArray[0]['proveedor_id'];
                var nombre_prov = $('#proveedor').val();
                var nombre_split = nombre_prov.split('-');

                $("#proveedor_id").val(proveedor_id);
                $("#proveedor_nit").val(proveedor_nit);
                $("#tercero_id").val(tercero_id);
                $("#orden_compra_id").val(orden_compra_id);
                $("#tipo_bien_servicio_ord").val(tipo_bien_servicio_ord);
                $("#valor").val(valor);
                var nombre_final = nombre_split[3].replace(/^\s+|\s+$/g, "");
                $("#proveedor").val(nombre_final);

            } catch (e) {
                alertJquery(e);
            }

        }

    });

}

function setDataTerceManifiesto(liquidacion_despacho_id) {

    var QueryString = "ACTIONCONTROLER=setDataTerceManifiesto&liquidacion_despacho_id=" + liquidacion_despacho_id;

    $.ajax({
        url: "CausarClass.php?rand=" + Math.random(),
        data: QueryString,
        beforeSend: function() {

        },
        success: function(response) {

            try {

                var responseArray = $.parseJSON(response);
                var proveedor_nit = responseArray[0]['proveedor_nit'];
                var manifiesto_id = responseArray[0]['manifiesto_id'];
                var valor = responseArray[0]['valor'];
                var proveedor_id = responseArray[0]['proveedor_id'];
                var nombre_prov = $('#proveedormc').val();
                var nombre_split = nombre_prov.split('-');

                $("#proveedor_nit").val(proveedor_nit);
                $("#manifiesto_id").val(manifiesto_id);
                $("#valor").val(valor);
                var nombre_final = nombre_split[2].replace(/^\s+|\s+$/g, "");
                $("#proveedormc").val(nombre_final);

                if (!proveedor_id > 0) {
                    alertJquery('El Tercero no esta Creado como Proveedor<br>Creelo en el Formato de Proveedor', 'Proveedor');
                }

            } catch (e) {
                alertJquery(e);
            }

        }

    });

}

function setDataTerceDespacho(liquidacion_despacho_id) {

    var QueryString = "ACTIONCONTROLER=setDataTerceDespacho&liquidacion_despacho_id=" + liquidacion_despacho_id;

    $.ajax({
        url: "CausarClass.php?rand=" + Math.random(),
        data: QueryString,
        beforeSend: function() {

        },
        success: function(response) {

            try {

                var responseArray = $.parseJSON(response);
                var proveedor_nit = responseArray[0]['proveedor_nit'];
                var despacho_id = responseArray[0]['despacho_id'];
                var valor = responseArray[0]['valor'];
                var proveedor_id = responseArray[0]['proveedor_id'];
                var nombre_prov = $('#proveedordu').val();
                var nombre_split = nombre_prov.split('-');

                $("#proveedor_nit").val(proveedor_nit);
                $("#despacho_id").val(despacho_id);
                $("#valor").val(valor);
                var nombre_final = nombre_split[2].replace(/^\s+|\s+$/g, "");
                $("#proveedordu").val(nombre_final);

                if (!proveedor_id > 0) {
                    alertJquery('El Tercero no esta Creado como Proveedor<br>Creelo en el Formato de Proveedor', 'Proveedor');
                }


            } catch (e) {
                alertJquery(e);
            }

        }

    });

}

function setDataProveedornn(proveedor_id) {

    var QueryString = "ACTIONCONTROLER=setDataProveedornn&proveedor_id=" + proveedor_id;

    $.ajax({
        url: "CausarClass.php?rand=" + Math.random(),
        data: QueryString,
        beforeSend: function() {

        },
        success: function(response) {

            try {

                var responseArray = $.parseJSON(response);
                var proveedor_nit = responseArray[0]['proveedor_nit'];

                $("#proveedor_nit").val(proveedor_nit);

            } catch (e) {
                alertJquery(e);
            }

        }

    });

}

function Causartipo() {
    var fuente_tipo = $("#fuente_servicio_cod").val();

    if (fuente_tipo == 'NULL') {
        for (i = 0; i < 5; i++) {
            $('#OC' + i).attr("style", "display:none");
            $('#MC' + i).attr("style", "display:none");
            $('#DU' + i).attr("style", "display:none");
            $('#NN' + i).attr("style", "display:none");
            $('#VACIO' + i).attr("style", "display:inherit");
        }
        $('#proveedor').val('');
        $('#proveedormc').val('');
        $('#proveedordu').val('');
        $('#proveedornn').val('');
        $('#proveedor_nit').val('');
        $('#codfactura_proveedornn').attr("class", "inputdefault ");
        $('#orden_compra_hidden').attr("class", "inputdefault ");
        $('#manifiesto_id').attr("class", "inputdefault ");
        $('#despacho_id').attr("class", "inputdefault ");
        $('#tipo_bien_servicio_nn').attr("class", "inputdefault ");
        $('#valor').attr("readonly", "yes");
        $('#valor').val('');


    } else if (fuente_tipo == 'OC') {

        for (i = 0; i < 5; i++) {
            $('#OC' + i).attr("style", "display:inherit");
            $('#MC' + i).attr("style", "display:none");
            $('#DU' + i).attr("style", "display:none");
            $('#NN' + i).attr("style", "display:none");
            $('#VACIO' + i).attr("style", "display:none");
        }
        $('#proveedor').attr("class", "obligatorio inputdefault");
        $('#proveedor').val('');
        $('#proveedormc').attr("class", "inputdefault ");
        $('#proveedordu').attr("class", "inputdefault ");
        $('#proveedornn').attr("class", "inputdefault ");
        $('#proveedor_nit').val('');
        $('#codfactura_proveedornn').attr("class", "inputdefault ");
        $('#codfactura_proveedor').attr("class", "obligatorio inputdefault ");
        $('#orden_compra_hidden').val('');
        $('#orden_compra_hidden').attr("class", "obligatorio inputdefault");
        $('#manifiesto_id').attr("class", "inputdefault ");
        $('#despacho_id').attr("class", "inputdefault ");
        $('#tipo_bien_servicio_nn').attr("class", "inputdefault ");
        $('#valor').attr("readonly", "yes");
        $('#valor').val('');

    } else if (fuente_tipo == 'MC') {

        for (i = 0; i < 5; i++) {
            $('#OC' + i).attr("style", "display:none");
            $('#MC' + i).attr("style", "display:inherit");
            $('#DU' + i).attr("style", "display:none");
            $('#NN' + i).attr("style", "display:none");
            $('#VACIO' + i).attr("style", "display:none");
        }
        $('#proveedor').attr("class", "inputdefault ");
        $('#proveedormc').attr("class", "obligatorio inputdefault ");
        $('#proveedormc').val('');
        $('#proveedordu').attr("class", "inputdefault ");
        $('#proveedornn').attr("class", "inputdefault ");
        $('#proveedor_nit').val('');
        $('#codfactura_proveedornn').attr("class", "inputdefault ");
        $('#orden_compra_hidden').attr("class", "inputdefault ");
        $('#manifiesto_id').attr("class", "obligatorio inputdefault ");
        $('#manifiesto_id').val('');
        $('#despacho_id').attr("class", "inputdefault ");
        $('#tipo_bien_servicio_nn').attr("class", "inputdefault ");
        $('#valor').attr("readonly", "yes");
        $('#valor').val('');


    } else if (fuente_tipo == 'DU') {

        for (i = 0; i < 5; i++) {
            $('#OC' + i).attr("style", "display:none");
            $('#MC' + i).attr("style", "display:none");
            $('#DU' + i).attr("style", "display:inherit");
            $('#NN' + i).attr("style", "display:none");
            $('#VACIO' + i).attr("style", "display:none");
        }
        $('#proveedor').attr("class", "inputdefault ");
        $('#proveedormc').attr("class", "inputdefault ");
        $('#proveedordu').attr("class", "obligatorio inputdefault ");
        $('#proveedordu').val('');
        $('#proveedornn').attr("class", "inputdefault ");
        $('#proveedor_nit').val('');
        $('#codfactura_proveedornn').attr("class", "inputdefault ");
        $('#orden_compra_hidden').attr("class", "inputdefault ");
        $('#manifiesto_id').attr("class", "inputdefault ");
        $('#despacho_id').attr("class", "obligatorio inputdefault ");
        $('#despacho_id').val('');
        $('#tipo_bien_servicio_nn').attr("class", "inputdefault ");
        $('#valor').attr("readonly", "yes");
        $('#valor').val('');

    } else if (fuente_tipo == 'NN') {

        for (i = 0; i < 5; i++) {
            $('#OC' + i).attr("style", "display:none");
            $('#MC' + i).attr("style", "display:none");
            $('#DU' + i).attr("style", "display:none");
            $('#NN' + i).attr("style", "display:inherit");
            $('#VACIO' + i).attr("style", "display:none");
        }
        $('#proveedor').attr("class", "inputdefault ");
        $('#proveedormc').attr("class", "inputdefault ");
        $('#proveedordu').attr("class", "inputdefault ");
        $('#proveedornn').val('');
        $('#proveedor_id').val('');
        $('#proveedornn').attr("class", "obligatorio inputdefault ");
        $('#proveedor_nit').val('');
        $('#codfactura_proveedornn').attr("class", "obligatorio inputdefault ");
        $('#codfactura_proveedornn').val('');
        $('#orden_compra_hidden').attr("class", "inputdefault ");
        $('#manifiesto_id').attr("class", "inputdefault ");
        $('#despacho_id').attr("class", "inputdefault ");
        $('#tipo_bien_servicio_nn').attr("class", "obligatorio inputdefault ");
        $('#valor').attr("readonly", "");
        $('#valor').val('');

    }

}

function onclickCancellation(formulario) {

    if ($("#divAnulacion").is(":visible")) {

        var causal_anulacion_id = $("#causal_anulacion_id").val();
        var desc_anul_factura_proveedor = $("#desc_anul_factura_proveedor").val();
        var anul_factura_proveedor = $("#anul_factura_proveedor").val();

        if (ValidaRequeridos(formulario)) {

            var QueryString = "ACTIONCONTROLER=onclickCancellation&" + FormSerialize(formulario) + "&factura_proveedor_id=" + $("#factura_proveedor_id").val();

            $.ajax({
                url: "CausarClass.php",
                data: QueryString,
                beforeSend: function() {
                    showDivLoading();
                },
                success: function(response) {

                    if ($.trim(response) == 'true') {
                        alertJquery('Causacion Anulada', 'Anulado Exitosamente');
                        $("#refresh_QUERYGRID_causar").click();
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

        var factura_proveedor_id = $("#factura_proveedor_id").val();
        var estado_factura_proveedor = $("#estado_factura_proveedor").val();

        if (parseInt(factura_proveedor_id) > 0) {

            var QueryString = "ACTIONCONTROLER=getEstadoEncabezadoRegistro&factura_proveedor_id=" + factura_proveedor_id;

            $.ajax({
                url: "CausarClass.php",
                data: QueryString,
                beforeSend: function() {
                    showDivLoading();
                },
                success: function(response) {

                    var estado = response;

                    if ($.trim(estado) == 'A' || $.trim(estado) == 'C') {

                        $("#divAnulacion").dialog({
                            title: 'Anulacion Causacion',
                            width: 650,
                            height: 280,
                            closeOnEscape: true
                        });

                    } else {
                        alertJquery('Solo se permite anular Causaciones en estado : <b>ACTIVO/CONTABILIZADO</b>', 'Anulacion');
                    }

                    removeDivLoading();
                }

            });


        } else {
            alertJquery('Debe Seleccionar primero un Registro Liquidado', 'Anulacion');
        }

    }
}

function getTotalDebitoCredito(factura_proveedor_id) {

    var QueryString = "ACTIONCONTROLER=getTotalDebitoCredito&factura_proveedor_id=" + factura_proveedor_id;

    $.ajax({
        url: "CausarClass.php",
        data: QueryString,
        success: function(response) {

            try {
                var totalDebitoCredito = $.parseJSON(response);
                var totalDebito = parseFloat(totalDebitoCredito[0]['debito']) > 0 ? totalDebitoCredito[0]['debito'] : 0;
                var totalCredito = parseFloat(totalDebitoCredito[0]['credito']) > 0 ? totalDebitoCredito[0]['credito'] : 0;
                var totalDiferencia = Math.abs(totalDebito - totalCredito);

                $("#totalDebito").html(setFormatCurrency(totalDebito));
                $("#totalCredito").html(setFormatCurrency(totalCredito));
                $("#totalDiferencia").html(setFormatCurrency(totalDiferencia));
            } catch (e) {

            }
        }

    });


}

function OnclickContabilizar() {

    window.frames[0].checkearTodo();

    window.frames[0].saveDetalles();

    var factura_proveedor_id = $("#factura_proveedor_id").val();
    var fecha_factura_proved = $("#fecha_factura_proveedor").val();
    var valor = $("#valor").val();
    var QueryString = "ACTIONCONTROLER=getTotalDebitoCredito&factura_proveedor_id=" + factura_proveedor_id;

    if (parseInt(factura_proveedor_id) > 0) {
        if (!formSubmitted) {
            formSubmitted = true;
            $.ajax({
                url: "CausarClass.php",
                data: QueryString,
                success: function(response) {

                    try {
                        var totalDebitoCredito = $.parseJSON(response);
                        var totalDebito = parseFloat(totalDebitoCredito[0]['debito']) > 0 ? totalDebitoCredito[0]['debito'] : 0;
                        var totalCredito = parseFloat(totalDebitoCredito[0]['credito']) > 0 ? totalDebitoCredito[0]['credito'] : 0;

                        $("#totalDebito").html(setFormatCurrency(totalDebito));
                        $("#totalCredito").html(setFormatCurrency(totalCredito));

                        if (parseFloat(totalDebito) == parseFloat(totalCredito) && parseFloat(totalCredito) > 0) {
                            var QueryString = "ACTIONCONTROLER=getContabilizar&factura_proveedor_id=" + factura_proveedor_id + "&fecha_factura_proveedor=" + fecha_factura_proved;

                            $.ajax({
                                url: "CausarClass.php",
                                data: QueryString,
                                success: function(response) {

                                    try {
                                        if ($.trim(response) == 'true') {
                                            alertJquery('Registro Contabilizado', 'Contabilizacion Exitosa');
                                            $("#refresh_QUERYGRID_causar").click();
                                            setDataFormWithResponse();
                                            formSubmitted = false;
                                        } else {
                                            alertJquery(response, 'Inconsistencia Contabilizando');
                                            formSubmitted = false;
                                        }


                                    } catch (e) {

                                    }
                                }
                            });
                        } else if (parseFloat(totalDebito) == parseFloat(totalCredito) && parseFloat(totalCredito) == 0) {
                            alertJquery('Los valores no Pueden estar En Ceros :<b>NO SE CONTABILIZARA</b>', 'Contabilizacion');
                        } else {
                            alertJquery('No existen sumas iguales :<b>NO SE CONTABILIZARA</b>', 'Contabilizacion');
                        }
                    } catch (e) {

                    }
                }

            });
        }
    } else {
        alertJquery('Debe Seleccionar primero un Registro Causado', 'Contabilizacion');
    }
}

function beforePrint(formulario, url, title, width, height) {

    var encabezado_registro_id = parseInt($("#encabezado_registro_id").val());
    var equivalente = $("#equivalente").val();

    if (isNaN(encabezado_registro_id)) {

        alertJquery('Debe seleccionar una Causacion Contabilizada!!!', 'Impresion Causacion');
        return false;

    } else {
        if (equivalente == 1) {
            if (confirm("Imprimir primero Documento soporte Equivalente?") == true) {

                $("#imp_doc_contable").val('SI');
                return true;

            } else {
                $("#imp_doc_contable").val('NO');
                return true;
            }
        } else {
            $("#imp_doc_contable").val('NO');
            return true;
        }
    }
}