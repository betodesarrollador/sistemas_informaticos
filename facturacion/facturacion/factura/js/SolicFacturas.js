// JavaScript Document
var detalle_ss_id = '';
var detalle_concepto = '';
$(document).ready(function() {

    $("#adicionar").click(function() {
        setSolicitud();

    });

});

function checkAll(obj) {

    $("input[name=check]").each(function() {

        var Fila = this;

        if ($(obj).is(':checked')) {

            $(Fila).attr("checked", "true");

            checkRow(Fila);

            console.log('si');

        } else {

            $(Fila).removeAttr("checked");

            checkRow(Fila);

            console.log('no');

        }
    });

}

function checkRow(obj) {

    var tipo_servicio = $("#tipo_servicio").val();
    var Fila = obj.parentNode.parentNode;
    var valor_fac = $(Fila).find("input[name=valor_facturar]").val();
    var valor_cos = $(Fila).find("input[name=valor_costo]").val();
    var fuente = $(Fila).find("input[name=fuente_fac]").val();

    if ((parseInt(tipo_servicio) > 0 && fuente == 'RM' && parseInt(valor_fac) > 0 && parseInt(valor_cos) > 0 && parseInt(valor_fac) < parseInt(valor_cos))) {

        jConfirm('<p align="center">El Valor a facturar es menor al Valor del Costo : <br><br><b>Valor Costo : ' + Math.round(valor_cos) + ' Valor Facturar :' + valor_fac + '</b><br><br>Es posible que usted este intentando cobrar al cliente menos valor del que le pago al conductor!!!</p> Desea continuar facturando a perdidas?', "Validacion Costo",
            function(r) {

                if (r) {
                    $(obj).attr("checked", "true");
                } else {
                    $(obj).attr("checked", "");
                }
            });

        /*  alertJquery('<p align="center">El Valor a facturar es menor al Valor del Costo : <br><br><b>Valor Costo : ' + Math.round(valor_cos) + ' Valor Facturar :' + valor_fac + '</b><br><br>Es posible que usted este intentando cobrar al cliente menos valor del que le pago al conductor!!!</p>'); */

    } else if ((parseInt(tipo_servicio) > 0 && fuente == 'RM' && parseInt(valor_fac) > 0 && !parseInt(valor_cos) > 0)) {
        alertJquery('El costo no ha sido Ingresado');
        $(obj).attr("checked", "");
    } else if ((parseInt(tipo_servicio) > 0 && fuente == 'RM' && !parseInt(valor_fac) > 0 && parseInt(valor_cos) > 0)) {
        alertJquery('El Valor a facturar no ha sido Ingresado');
        $(obj).attr("checked", "");
    } else if ((parseInt(tipo_servicio) > 0 && fuente == 'RM' && !parseInt(valor_fac) > 0 && !parseInt(valor_cos) > 0)) {
        alertJquery('El Valor a facturar y el Costo no ha sido Ingresado');
        $(obj).attr("checked", "");
    } else if ((parseInt(tipo_servicio) > 0 && fuente == 'RM' && parseInt(valor_fac) > 0 && parseInt(valor_cos) > 0) || !tipo_servicio > 0) {
        $(obj).attr("checked", "true");

    }
}

function setSolicitud() {

    detalle_ss_id = '';
    detalle_concepto = '';

    $(document).find("input[type=checkbox]:checked").each(function() {

        var Fila = this.parentNode.parentNode;
        var fuente = $(Fila).find("input[name=fuente_fac]").val();

        detalle_ss_id += $(this).val() + "-" + fuente + ",";

    });

    var concepto_item = parent.$("#concepto_item").val();

    if (concepto_item != '') {
        parent.document.forms[0]['concepto_item'].value = detalle_ss_id + "," + concepto_item;
    } else {
        parent.document.forms[0]['concepto_item'].value = detalle_ss_id;
    }

    parent.cargardatos();
    parent.ValidaIca();
    parent.ValidaOrigenDist();
    parent.closeDialog();
}