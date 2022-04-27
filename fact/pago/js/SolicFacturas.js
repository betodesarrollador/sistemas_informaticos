// JavaScript Document
var detalle_ss_id = '';
var detalle_concepto = '';
$(document).ready(function() {

    $("#adicionar").click(function() {
        setSolicitud();

    });
    compara_cantidad();
});

function compara_cantidad() {

    $("input[name=pagar]").keyup(function() {
        var Fila = $(this).parent().parent();
        var pagar = $(Fila).find("input[name=pagar]").val();
        var saldo = $(Fila).find("input[name=saldo]").val();
        var abonos_nc = $(Fila).find("input[name=abonos_nc]").val();

        var pagar1 = removeFormatCurrency(pagar);
        var saldo1 = removeFormatCurrency(saldo);
        var abonos_nc1 = parseFloat(abonos_nc) > 0 ? parseFloat(abonos_nc) : 0;
        if (parseFloat(abonos_nc1) > 0)
            mensajeabo = "<br>Por favor tenga en cuenta que los abonos por $" + setFormatCurrency(abonos_nc) + " No contabilizados se toman en cuenta";
        else
            mensajeabo = "_";

        if ((parseFloat(saldo1) - parseFloat(abonos_nc1)) < parseFloat(pagar1)) {

            $(Fila).find("input[name=pagar]").val(setFormatCurrency(parseFloat(saldo1) - parseFloat(abonos_nc1)));
            alertJquery("Valor ingresado mayor al saldo" + mensajeabo, "Pago");
        }

    });


}

function checkRow(obj) {

    if (obj) {

        $(obj).attr("checked", "true");
        var Fila = obj.parentNode.parentNode;
        var abonos_nc = $(Fila).find("input[name=abonos_nc]").val();
        var saldo = $(Fila).find("input[name=saldo]").val();
        var pagar = $(Fila).find("input[name=pagar]").val();
        var pagar1 = removeFormatCurrency(pagar);
        var saldo1 = removeFormatCurrency(saldo);

        if (parseFloat(abonos_nc) > 0) {
            alertJquery("Existen abonos sin Contabilizar para esta Factura por valor de $" + setFormatCurrency(abonos_nc) + "<br> Por favor Contabilice los pagos si desea que se tomen en cuenta en los abonos.<br>De lo contrario por favor anule esos pagos para que no vuelva a aparecer este mensaje", "Pago");
            var real = parseFloat(pagar1) - parseFloat(abonos_nc);

            if ((parseFloat(saldo1) - parseFloat(abonos_nc)) < parseFloat(pagar1)) {
                $(Fila).find("input[name=pagar]").val(setFormatCurrency(real));
            }
        }

    }
}

function ValidarDes(obj) {
    if (obj) {
        var Fila = obj.parentNode.parentNode;
        var pagar = $(Fila).find("input[name=pagar]").val();
        var num_descu = $(Fila).find("input[name=num_descu]").val();
        var pagar1 = removeFormatCurrency(pagar);
        var sumando = 0;

        for (i = 1; i < parseInt(num_descu); i++) {
            sumando2 = parseFloat(removeFormatCurrency($(Fila).find("input[name=descuento" + i + "]").val()))
            sumando2 = parseFloat(sumando2) > 0 ? parseFloat(sumando2) : 0;
            if ($(Fila).find("input[name=tipo_descu_id" + i + "]").val() == 'DESC') {
                sumando = parseFloat(sumando) + parseFloat(sumando2);
            }

        }

        if (parseFloat(sumando) > parseFloat(pagar1)) {
            $(Fila).find("input[name=chequear]").attr("checked", "");
            alertJquery("Valor de descuentos mayor al valor a Pagar<br> Por favor verifique", "Pago");
        } else {
            $(Fila).find("input[name=chequear]").attr("checked", "true");

        }
    }
}

function ValidarSaldoNota(obj) {
    if (obj) {
        var Fila = obj.parentNode.parentNode;

        var pagar_valor = $(Fila).find("input[name=pagar_nota]").val();
        var num_descu = $(Fila).find("input[name=num_descu]").val();
        var factura_id = $(Fila).find("input[name=factura_id]").val();
        var fecha = parent.document.forms[0]['fecha'].value;
        var pagar1 = removeFormatCurrency(pagar_valor);

        var query2 = '';

        var puc_id = [num_descu];

        for (i = 1; i <= parseInt(num_descu); i++) {
            puc_id[i] = $(Fila).find("input[name=puc_id" + i + "]").val();
            query2 = query2 + '&puc_id' + i + '=' + puc_id[i];
        }

        //var puc_id = $(Fila).find("input[name=puc_id"+contador+"]").val();


        var QueryString = "ACTIONCONTROLER=buscarImpuesto&num_descu=" + num_descu + "&base=" + pagar1 + "&fecha=" + fecha + query2 + "&factura_id=" + factura_id + "&rand=" + Math.random();

        $.ajax({
            url: "SolicFacturasClass.php",
            data: QueryString,
            success: function(resp) {
                try {
                    var resp = $.parseJSON(resp);
                    for (i = 1; i <= num_descu; i++) {
                        $(Fila).find("input[name=descuento" + i + "]").val(setFormatCurrency(resp[i]));
                    }

                    var sumandos = 0;
                    var restandos = 0;

                    for (j = 1; j <= parseInt(num_descu); j++) {

                        if ($(Fila).find("input[name=tipo_descu_id" + j + "]").val() == 'DESC') {
                            sumandos = parseFloat(sumandos) + parseFloat(removeFormatCurrency($(Fila).find("input[name=descuento" + j + "]").val()));
                        }
                        if ($(Fila).find("input[name=tipo_descu_id" + j + "]").val() == 'MAS') {
                            restandos = parseFloat(restandos) + parseFloat(removeFormatCurrency($(Fila).find("input[name=descuento" + j + "]").val()));
                        }

                    }
                    var valor_final = parseInt((parseFloat(pagar1) - parseFloat(restandos)) + parseFloat(sumandos));
                    $(Fila).find("input[name=pagar]").val(setFormatCurrency(valor_final));

                } catch (e) {
                    console.log(e);
                }
            }
        });


    }
}

function setSolicitud() {

    detalle_ss_id = '';
    detalle_concepto = '';
    detalle_valores = '';
    detalle_descuentos = '';
    detalle_mayor = '';
    numero_descu = 0;
    pago_saldo = 0;
    parcial_descu = 0;
    parcial_mayor = 0;
    total_descu = 0;
    total_mayor = 0;
    total_neto = 0;

    detalle_ss_id_nota_debito = '';
    detalle_concepto_nota = '';
    detalle_valores_nota_debito = '';
    detalle_descuentos_nota_debito = '';
    detalle_mayor_nota_debito = '';
    numero_descu_nota_debito = 0;
    pago_saldo_nota_debito = 0;
    parcial_descu_nota_debito = 0;
    parcial_mayor_nota_debito = 0;
    total_descu_nota_debito = 0;
    total_mayor_nota_debito = 0;
    total_neto_nota_debito = 0;

    $(document).find("input[name=checkfactura]:checked").each(function() {
        numero_descu = $($(this).parent().parent()).find("input[name=num_descu]").val();
        tiene_descu = 0;
        for (i = 1; i <= parseInt(numero_descu); i++) {
            if (parseInt($($(this).parent().parent()).find("input[name=descuento" + i + "]").val()) > 0) {
                detalle_descuentos += $($(this).parent().parent()).find("input[name=descuento_id" + i + "]").val() + "_" + $($(this).parent().parent()).find("input[name=descuento" + i + "]").val() + ",";
                tiene_descu = 1;
                if ($($(this).parent().parent()).find("input[name=tipo_descu_id" + i + "]").val() == 'DESC' && parseInt($($(this).parent().parent()).find("input[name=descuento" + i + "]").val()) > 0) {
                    parcial_descu = parseFloat(parcial_descu) + parseFloat(removeFormatCurrency($($(this).parent().parent()).find("input[name=descuento" + i + "]").val()));
                } else if ($($(this).parent().parent()).find("input[name=tipo_descu_id" + i + "]").val() == 'MAS' && parseInt($($(this).parent().parent()).find("input[name=descuento" + i + "]").val()) > 0) {
                    parcial_mayor = parseFloat(parcial_mayor) + parseFloat(removeFormatCurrency($($(this).parent().parent()).find("input[name=descuento" + i + "]").val()));

                }
            }
        }
        if (tiene_descu == 1)
            detalle_descuentos += "-" + $(this).val() + "=";
            console.log('descuentos: '+detalle_descuentos);

        detalle_ss_id += $(this).val() + ",";
        console.log(detalle_ss_id);
        detalle_valores += $($(this).parent().parent()).find("input[name=pagar]").val() + "=";

        valor_ind = removeFormatCurrency($($(this).parent().parent()).find("input[name=pagar]").val());
        pago_saldo = parseFloat(pago_saldo) + parseFloat(valor_ind);

        if (tiene_descu == 1) {
            total_descu = parseFloat(total_descu) + parseFloat(parcial_descu);
            total_mayor = parseFloat(total_mayor) + parseFloat(parcial_mayor);
        }

        parcial_descu = 0;
        parcial_mayor = 0;

    });

    $(document).find("input[name=checknota]:checked").each(function() {
        numero_descu_nota_debito = $($(this).parent().parent()).find("input[name=num_descu]").val();
        tiene_descu = 0;
        for (i = 1; i <= parseInt(numero_descu_nota_debito); i++) {
            if (parseInt($($(this).parent().parent()).find("input[name=descuento" + i + "]").val()) > 0) {
                detalle_descuentos_nota_debito += $($(this).parent().parent()).find("input[name=descuento_id" + i + "]").val() + "_" + $($(this).parent().parent()).find("input[name=descuento" + i + "]").val() + ",";
                tiene_descu = 1;
                if ($($(this).parent().parent()).find("input[name=tipo_descu_id" + i + "]").val() == 'DESC' && parseInt($($(this).parent().parent()).find("input[name=descuento" + i + "]").val()) > 0) {
                    parcial_descu_nota_debito = parseFloat(parcial_descu_nota_debito) + parseFloat(removeFormatCurrency($($(this).parent().parent()).find("input[name=descuento" + i + "]").val()));
                } else if ($($(this).parent().parent()).find("input[name=tipo_descu_id" + i + "]").val() == 'MAS' && parseInt($($(this).parent().parent()).find("input[name=descuento" + i + "]").val()) > 0) {
                    parcial_mayor_nota_debito = parseFloat(parcial_mayor_nota_debito) + parseFloat(removeFormatCurrency($($(this).parent().parent()).find("input[name=descuento" + i + "]").val()));

                }
            }
        }
        if (tiene_descu == 1)
            detalle_descuentos_nota_debito += "-" + $(this).val() + "=";
            console.log('descuentos nota: '+detalle_descuentos_nota_debito);


        detalle_ss_id_nota_debito += $(this).val() + ",";
        console.log(detalle_ss_id_nota_debito);
        detalle_valores_nota_debito += $($(this).parent().parent()).find("input[name=pagar]").val() + "=";

        valor_ind = removeFormatCurrency($($(this).parent().parent()).find("input[name=pagar]").val());
        pago_saldo_nota_debito = parseFloat(pago_saldo_nota_debito) + parseFloat(valor_ind);

        if (tiene_descu == 1) {
            total_descu_nota_debito = parseFloat(total_descu_nota_debito) + parseFloat(parcial_descu_nota_debito);
            total_mayor_nota_debito = parseFloat(total_mayor_nota_debito) + parseFloat(parcial_mayor_nota_debito);
        }

        parcial_descu_nota_debito = 0;
        parcial_mayor_nota_debito = 0;

    });

    var valor_descuentos = total_descu + total_descu_nota_debito;
    var valor_mayor = total_mayor + total_mayor_nota_debito;
    var total = ((parseFloat(pago_saldo) - parseFloat(total_descu)) + parseFloat(total_mayor)) + ((parseFloat(pago_saldo_nota_debito) - parseFloat(total_descu_nota_debito)) + parseFloat(total_mayor_nota_debito));
    
    total = total.toFixed(0);
    console.log('descuentos '+valor_descuentos+' mayor valor '+valor_mayor+' total '+total);
    if(pago_saldo > 0 && $("#tableDetalles tr").length > 2){

        parent.document.forms[0]['causaciones_abono_factura'].value = detalle_ss_id;
        parent.document.forms[0]['valores_abono_factura'].value = detalle_valores;
        console.log('detalle_descuentos : ', detalle_descuentos);
        parent.document.forms[0]['descuentos_items'].value = detalle_descuentos;

        pago_saldo = pago_saldo.toFixed(0);
        parent.document.forms[0]['valor_abono_factura'].value = setFormatCurrency(pago_saldo);

    }else if ($("#tableDetalles tr").length == 2){

        parent.document.forms[0]['causaciones_abono_factura'].value = '';
        parent.document.forms[0]['valores_abono_factura'].value = '';
        parent.document.forms[0]['descuentos_items'].value = '';
        parent.document.forms[0]['valor_abono_factura'].value = 0;

    }else{

        parent.document.forms[0]['causaciones_abono_factura'].value = '';
        parent.document.forms[0]['valores_abono_factura'].value = '';
        parent.document.forms[0]['descuentos_items'].value = '';
        parent.document.forms[0]['valor_abono_factura'].value = 0;
        
    }

    if(pago_saldo_nota_debito > 0 && $("#tableNotasDebito tr").length > 2){

        parent.document.forms[0]['causaciones_abono_nota'].value = detalle_ss_id_nota_debito;
        parent.document.forms[0]['valores_abono_nota'].value = detalle_valores_nota_debito;
        parent.document.forms[0]['descuentos_items_nota'].value = detalle_descuentos_nota_debito;

        pago_saldo_nota_debito = pago_saldo_nota_debito.toFixed(0);

        parent.document.forms[0]['valor_abono_nota'].value = setFormatCurrency(pago_saldo_nota_debito);

    }else if ($("#tableNotasDebito tr").length == 2){

        parent.document.forms[0]['causaciones_abono_nota'].value = '';
        parent.document.forms[0]['valores_abono_nota'].value = '';
        parent.document.forms[0]['descuentos_items_nota'].value = '';
        parent.document.forms[0]['valor_abono_nota'].value = 0;

    }else{

        parent.document.forms[0]['causaciones_abono_nota'].value = '';
        parent.document.forms[0]['valores_abono_nota'].value = '';
        parent.document.forms[0]['descuentos_items_nota'].value = '';
        parent.document.forms[0]['valor_abono_nota'].value = 0;

    }

    
    parent.document.forms[0]['valor_descu_factura'].value = setFormatCurrency(valor_descuentos);
    parent.document.forms[0]['valor_mayor_factura'].value = setFormatCurrency(valor_mayor);
    parent.document.forms[0]['valor_neto_factura'].value = setFormatCurrency(total);
    
    parent.cargardatos();
    parent.closeDialog();
}