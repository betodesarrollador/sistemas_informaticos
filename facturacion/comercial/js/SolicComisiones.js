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


function setSolicitud() {

    detalle_ss_id = '';
    $(document).find("input[type=checkbox]:checked").each(function() {
        detalle_ss_id += $(this).val() + ",";
    });

    parent.document.forms[0]['concepto_item'].value = detalle_ss_id;

    parent.cargardatos();
    parent.closeDialog();
}