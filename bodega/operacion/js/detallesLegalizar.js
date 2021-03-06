$(document).ready(function() {

    checkedAll();
    checkRow();
    autocompleteProducto();

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



function saveDetalles(formulario) {

    $("input[name=procesar]:checked").each(function(formulario) {

        saveDetalle(this, formulario);

    });

}

function saveDetalle(obj, formulario) {


    var row = obj.parentNode.parentNode;

    if (validaRequeridosDetalle(obj, row)) {

        var Celda = obj.parentNode;
        var Fila = obj.parentNode.parentNode;
        var producto_id = $(Fila).find("input[name=producto_id]").val();
        var enturnamiento_detalle_id = $(Fila).find("input[name=enturnamiento_detalle_id]").val();
        var recepcion_id = $("#recepcion_id").val();
        var serial = $(Fila).find("input[name=serial]").val();
        var cantidad = $(Fila).find("input[name=cantidad]").val();
        var checkProcesar = $(Fila).find("input[name=procesar]");

        if (enturnamiento_detalle_id.length > 0) {

            var QueryString = "ACTIONCONTROLER=onclickSave&recepcion_id=" + recepcion_id + "&enturnamiento_detalle_id=" + enturnamiento_detalle_id + "&producto_id=" + producto_id +
                "&serial=" + serial + "&cantidad=" + cantidad;


            $.ajax({

                url: "detallesLegalizarClass.php",
                data: QueryString,
                beforeSend: function() {
                    showDivLoading();
                },
                success: function(response) {

                    if (!isNaN(response)) {

                        $(Fila).find("input[name=detalle_enturnamiento_id]").val(response);

                        var Table = document.getElementById('tableDetalles');
                        var numRows = (Table.rows.length);
                        var newRow = Table.insertRow(numRows);

                        $(newRow).find("input[name=producto]").focus();
                        checkRow();
                        checkProcesar.attr("checked", "");
                        $(Celda).removeClass("focusSaveRow");


                        removeDivLoading();
                        alertJquery("Recepci??n Legalizada Exitosamente");


                    } else {
                        alertJquery(response);
                    }
                }

            });

        }

    } else {
        alertJquery("Debe Ingresar un valor", "Validacion");
    }


}



function checkRow() {

    $("input[type=text]").keyup(function(event) {

        var Tecla = event.keyCode;
        var Fila = this.parentNode.parentNode;

        $(Fila).find("input[name=procesar]").attr("checked", "true");

    });

}

function traerCodigoBarras(obj, producto_id) {
    var Fila = obj.parentNode.parentNode;
    var QueryString = "ACTIONCONTROLER=traerCodigo&producto_id=" + producto_id;

    $.ajax({

        url: "detallesEnturnamientoClass.php",
        data: QueryString,
        beforeSend: function() {
            showDivLoading();
        },
        success: function(response) {

            var data = $.parseJSON(response);
            var codigo_barra = data[0]['codigo_barra'];
            $(Fila).find("input[name=codigo_barra]").val(codigo_barra);
            removeDivLoading();
        }

    });
}

function autocompleteProducto() {

    $("input[name=producto]").autocomplete("sistemas_informaticos/framework/clases/ListaInteligente.php?consulta=wms_producto", {
        width: 260,
        selectFirst: true
    });

    $("input[name=producto]").result(function(event, data, formatted) {
        if (data) {

            $("input[name=codigo_barra]").each(function() {
                traerCodigoBarras(this, data[1]);
            });

            var producto_id = data[0].split("-");
            $(this).val($.trim(producto_id[0]));
            $(this).attr("title", data[0]);
            $(this).next().val(data[1]);
            var txtNext = false;

        }
    });

}