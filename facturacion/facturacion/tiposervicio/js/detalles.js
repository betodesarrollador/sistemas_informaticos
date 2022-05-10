// JavaScript Document

$(document).ready(function() {

    checkedAll();
    checkRow();
    autocompleteCodigoContable();
    linkImputaciones();

    $("a[name=activar]").click(function() {

        ActivarDetalle(this);

    });



});



function checkedAll() {

    $("#checkedAll").click(function() {


        if ($(this).is(":checked")) {
            $("input[name=procesar]").attr("checked", "true");
        } else {
            $("input[name=procesar]").attr("checked", "");
        }

    });

}

/***************************************************************
	  lista inteligente para la ubicacion con jquery
**************************************************************/

function autocompleteCodigoContable() {

    var tipo_bien_servicio_factura_id = $("#tipo_bien_servicio_factura_id").val();

    $("input[name=puc]").autocomplete("../../../framework/clases/ListaInteligente.php?consulta=cuentas_movimiento_servicio", {
        width: 260,
        selectFirst: true,
        minChars: 4,
        scrollHeight: 220
    });

    $("input[name=puc]").result(function(event, data, formatted) {

        if (data) {

            var codigo_puc = data[0].split("-");

            $(this).val($.trim(codigo_puc[0]));
            $(this).attr("title", data[0]);
            $(this).next().val(data[1]);

            $(this.parentNode.parentNode).find("input[name=descripcion]").val($.trim(codigo_puc[1]));
            $(this.parentNode.parentNode).find("input[name=despuc_bien_servicio_factura]").val($.trim(codigo_puc[2]));

        }

    });

}

function linkImputaciones() {

    $("a[name=saveDetalles]").attr("href", "javascript:void(0)");

    $("a[name=saveDetalles]").focus(function() {
        var celda = this.parentNode;
        $(celda).addClass("focusSaveRow");
    });

    $("a[name=saveDetalles]").blur(function() {
        var celda = this.parentNode;
        $(celda).removeClass("focusSaveRow");
    });

    $("a[name=saveDetalles]").click(function() {

        saveDetalle(this);

    });

}



function saveDetalle(obj) {

    var row = obj.parentNode.parentNode;

    if (validaRequeridosDetalle(obj, row)) {

        var Celda = obj.parentNode;
        var Fila = obj.parentNode.parentNode;
        var codpuc_bien_servicio_factura_id = $(Fila).find("input[name=codpuc_bien_servicio_factura_id]").val();
        var tipo_bien_servicio_factura_id = $("#tipo_bien_servicio_factura_id").val();
        var puc_id = $(Fila).find("input[name=puc_id]").val();
        var despuc_bien_servicio_factura = $(Fila).find("input[name=despuc_bien_servicio_factura]").val();
        var natu_bien_servicio_factura = $(Fila).find("select[name=natu_bien_servicio_factura]").val();
        var contra_bien_servicio_factura = $(Fila).find("input[name=contra_bien_servicio_factura]").is(":checked") ? 1 : 0;
        var tercero_bien_servicio_factura = $(Fila).find("input[name=tercero_bien_servicio_factura]").is(":checked") ? 1 : 0;
        var ret_tercero_bien_servicio_factura = $(Fila).find("input[name=ret_tercero_bien_servicio_factura]").is(":checked") ? 1 : 0;
        var reteica_bien_servicio_factura = $(Fila).find("input[name=reteica_bien_servicio_factura]").is(":checked") ? 1 : 0;
        var aplica_ingreso = $(Fila).find("input[name=aplica_ingreso]").is(":checked") ? 1 : 0;
        var aplica_tenedor = $(Fila).find("input[name=aplica_tenedor]").is(":checked") ? 1 : 0;
        var checkProcesar = $(Fila).find("input[name=procesar]");



        if (!codpuc_bien_servicio_factura_id.length > 0) {

            codpuc_bien_servicio_factura_id = 'NULL';

            var QueryString = "ACTIONCONTROLER=onclickSave&tipo_bien_servicio_factura_id=" + tipo_bien_servicio_factura_id + "&codpuc_bien_servicio_factura_id=" +
                codpuc_bien_servicio_factura_id + "&puc_id=" + puc_id + "&natu_bien_servicio_factura=" + natu_bien_servicio_factura + "&contra_bien_servicio_factura=" + contra_bien_servicio_factura + "&despuc_bien_servicio_factura=" + despuc_bien_servicio_factura + "&tercero_bien_servicio_factura=" + tercero_bien_servicio_factura +
                "&ret_tercero_bien_servicio_factura=" + ret_tercero_bien_servicio_factura + "&reteica_bien_servicio_factura=" + reteica_bien_servicio_factura + "&aplica_ingreso=" + aplica_ingreso + "&aplica_tenedor=" + aplica_tenedor;


            $.ajax({

                url: "DetallesClass.php",
                data: QueryString,
                beforeSend: function() {
                    showDivLoading();
                },
                success: function(response) {

                    if (!isNaN(response)) {

                        $(Fila).find("input[name=codpuc_bien_servicio_factura_id]").val(response);

                        var Table = document.getElementById('tableDetalles');
                        var numRows = (Table.rows.length);
                        var newRow = Table.insertRow(numRows);

                        $(newRow).html($("#clon").html());
                        $(newRow).find("input[name=puc]").focus();


                        checkRow();
                        autocompleteCodigoContable();
                        linkImputaciones();


                        checkProcesar.attr("checked", "");
                        $(Celda).removeClass("focusSaveRow");
                        removeDivLoading();
                        parent.document.getElementById("refresh_QUERYGRID_tiposervicio").click();

                    } else {
                        alertJquery(response);
                    }

                }

            });

        } else {

            var QueryString = "ACTIONCONTROLER=onclickUpdate&tipo_bien_servicio_factura_id=" + tipo_bien_servicio_factura_id + "&codpuc_bien_servicio_factura_id=" +
                codpuc_bien_servicio_factura_id + "&puc_id=" + puc_id + "&natu_bien_servicio_factura=" + natu_bien_servicio_factura + "&contra_bien_servicio_factura=" + contra_bien_servicio_factura + "&despuc_bien_servicio_factura=" + despuc_bien_servicio_factura + "&tercero_bien_servicio_factura=" + tercero_bien_servicio_factura +
                "&ret_tercero_bien_servicio_factura=" + ret_tercero_bien_servicio_factura + "&reteica_bien_servicio_factura=" + reteica_bien_servicio_factura + "&aplica_ingreso=" + aplica_ingreso + "&aplica_tenedor=" + aplica_tenedor;

            $.ajax({

                url: "DetallesClass.php",
                data: QueryString,
                beforeSend: function() {
                    showDivLoading();
                },
                success: function(response) {

                    if ($.trim(response) == 'true') {
                        checkProcesar.attr("checked", "");
                        $(Fila).find("a[name=saveDetalles]").parent().addClass("focusSaveRow");
                        parent.document.getElementById("refresh_QUERYGRID_tiposervicio").click();
                    } else {
                        alertJquery(response);
                    }

                    removeDivLoading();
                }

            });


        }

    } else {
        alertJquery("Debe Ingresar un valor", "Tipo Servicio");
    }


}

function deleteDetalle(obj) {

    var Celda = obj.parentNode;
    var Fila = obj.parentNode.parentNode;
    var codpuc_bien_servicio_factura_id = $(Fila).find("input[name=codpuc_bien_servicio_factura_id]").val();
    var QueryString = "ACTIONCONTROLER=onclickDelete&codpuc_bien_servicio_factura_id=" + codpuc_bien_servicio_factura_id;

    if (codpuc_bien_servicio_factura_id.length > 0) {

        $.ajax({

            url: "DetallesClass.php",
            data: QueryString,
            beforeSend: function() {
                showDivLoading();
            },
            success: function(response) {

                if ($.trim(response) == 'true') {

                    alertJquery('Cuenta Desactivada Exitosamente', 'Tipo de Servicio');
                } else {
                    alertJquery(response);
                }

                removeDivLoading();
            }

        });

    } else {
        alertJquery('No puede eliminar Desactivar que no han sido guardados');
        $(Fila).find("input[name=procesar]").attr("checked", "");
    }

}

function ActivarDetalle(obj) {

    var row = obj.parentNode.parentNode;
    var Celda = obj.parentNode;
    var Fila = obj.parentNode.parentNode;
    var codpuc_bien_servicio_factura_id = $(Fila).find("input[name=codpuc_bien_servicio_factura_id]").val();
    var QueryString = "ACTIONCONTROLER=onclickActivar&&codpuc_bien_servicio_factura_id=" + codpuc_bien_servicio_factura_id;


    if (codpuc_bien_servicio_factura_id.length > 0) {

        $.ajax({

            url: "DetallesClass.php",
            data: QueryString,
            beforeSend: function() {
                showDivLoading();
            },
            success: function(response) {

                if ($.trim(response) == 'true') {
                    alertJquery('Cuenta Activada Exitosamente', 'Tipo de Servicio');

                } else {
                    alertJquery(response);
                }

                removeDivLoading();
            }

        });

    } else {
        alertJquery('No puede eliminar Activar que no han sido guardados');
    }
}

function saveDetalles() {

    $("input[name=procesar]:checked").each(function() {

        saveDetalle(this);

    });

}

function deleteDetalles() {

    $("input[name=procesar]:checked").each(function() {

        deleteDetalle(this);

    });

}


function checkRow() {

    $("input[type=text]").keyup(function(event) {

        var Tecla = event.keyCode;
        var Fila = this.parentNode.parentNode;

        $(Fila).find("input[name=procesar]").attr("checked", "true");

    });
    $("input[type=radio]").click(function() {

        var Fila = this.parentNode.parentNode;

        $(Fila).find("input[name=procesar]").attr("checked", "true");

    });

}