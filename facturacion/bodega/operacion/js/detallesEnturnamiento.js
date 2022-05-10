$(document).ready(function() {

    checkedAll();
    checkRow();
    linkImputaciones();
    autocompleteProducto();
    ultimaFila();

    $("#codigo_barra").focus();

});

function ultimaFila() {

    $("input[name=codigo_barra]").keypress(function(e) {
        leerCodigobar(this, e);
    });

    $("input[name=serial]").keypress(function(e) {
        leerCodigoSerial(this, e);
    });
}



function leerCodigobar(obj, e) {
    var Fila = obj.parentNode.parentNode;

    if (e.which == 13) {
        e.preventDefault();
        var codigo_barra = $(Fila).find("input[name=codigo_barra]").val();
        var enturnamiento_id = parent.document.getElementById('enturnamiento_id').value;

        if (document.getElementById('codigo_barra').value != '') {

            if (codigo_barra == "NULL" || codigo_barra == "") {
                codigo_barra = 0;
            } else {
                var QueryString = "ACTIONCONTROLER=setLeerCodigobar&codigo_barra=" + codigo_barra + "&enturnamiento_id=" + enturnamiento_id;

                $.ajax({
                    url: 'detallesEnturnamientoClass.php?random=' + Math.random(),
                    data: QueryString,
                    beforeSend: function() {
                        showDivLoading();
                    },
                    success: function(resp) {
                        try {
                            var data = $.parseJSON(resp);

                            if (data[0]['producto_id'] > 0) {
                                console.log("el producto si existe");
                                var producto_id = data[0]['producto_id'];
                                var nombre = data[0]['nombre'];
                                var codigo = data[0]['codigo_barra'];
                                $(Fila).find("input[name=producto_id]").val(producto_id);
                                $(Fila).find("input[name=producto]").val(nombre);
                                $(Fila).find("input[name=codigo_barra]").val(codigo);
                                $(Fila).find("input[name=cantidad]").val(1);

                            } else {
                                alertJquery("El producto no exite");
                            }
                        } catch (e) {
                            alertJquery(resp, "Atencion: ");
                        }
                        $(Fila).find("input[name=serial]").focus();

                        removeDivLoading();
                    }
                });
            }
        } else {
            console.log("no es enter");
        }
    }

}

function leerCodigoSerial(obj, e) {
    var Celda = obj.parentNode;
    var Fila = obj.parentNode.parentNode;
    var checkProcesar = $(Fila).find("input[name=procesar]");

    if (e.which == 13) {
        e.preventDefault();

        var producto_id = $(Fila).find("input[name=producto_id]").val();
        var enturnamiento_id = $("#enturnamiento_id").val();
        var serial = $(Fila).find("input[name=serial]").val();
        var cantidad = $(Fila).find("input[name=cantidad]").val();

        if (producto_id > 0) {
            if (document.getElementById('serial').value != '') {

                if (serial == "NULL" || serial == "") {
                    serial = 0;
                } else {
                    var QueryString = "ACTIONCONTROLER=setLeerCodigoSerial&serial=" + serial + "&enturnamiento_id=" + enturnamiento_id + "&producto_id=" + producto_id + "&cantidad=" + cantidad;

                    $.ajax({
                        url: 'detallesEnturnamientoClass.php?random=' + Math.random(),
                        data: QueryString,
                        beforeSend: function() {

                        },
                        success: function(resp) {

                            if (!isNaN(resp)) {

                                $(Fila).find("input[name=detalle_enturnamiento_id]").val(resp);

                                var Table = document.getElementById('tableDetalles');
                                var numRows = (Table.rows.length);
                                var newRow = Table.insertRow(numRows);

                                $(newRow).html($("#clon").html());

                                checkRow();
                                linkImputaciones();
                                autocompleteProducto();
                                ultimaFila();
                                checkProcesar.attr("checked", "");
                                $(Celda).removeClass("focusSaveRow");



                                $(newRow).find("input[name=codigo_barra]").focus();
                            } else {
                                alertJquery(resp);
                            }

                        }
                    });
                }
            } else {
                console.log("no es enter");
            }
        } else {
            alertJquery("¡Debe digitar primero un nombre de producto o codigo de barras!")
        }
    }

}

function checkedAll() {

    $("#checkedAll").click(function() {


        if ($(this).is(":checked")) {
            $("input[name=procesar]").attr("checked", "true");
        } else {
            $("input[name=procesar]").attr("checked", "");
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
        var producto_id = $(Fila).find("input[name=producto_id]").val();
        var enturnamiento_detalle_id = $(Fila).find("input[name=enturnamiento_detalle_id]").val();
        var enturnamiento_id = $("#enturnamiento_id").val();
        var serial = $(Fila).find("input[name=serial]").val();
        var cantidad = $(Fila).find("input[name=cantidad]").val();
        var checkProcesar = $(Fila).find("input[name=procesar]");

        if (!enturnamiento_detalle_id.length > 0) {

            var QueryString = "ACTIONCONTROLER=onclickSave&&enturnamiento_id=" + enturnamiento_id + "&producto_id=" + producto_id +
                "&serial=" + serial + "&cantidad=" + cantidad;


            $.ajax({

                url: "detallesEnturnamientoClass.php",
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

                        $(newRow).html($("#clon").html());
                        $(newRow).find("input[name=producto]").focus();

                        checkRow();
                        linkImputaciones();
                        autocompleteProducto();

                        checkProcesar.attr("checked", "");
                        $(Celda).removeClass("focusSaveRow");


                        alertJquery("Guardado Exitosamente");

                    } else {
                        alertJquery(response);

                    }
                    removeDivLoading();
                }

            });

        } else {

            var QueryString = "ACTIONCONTROLER=onclickUpdate&enturnamiento_detalle_id=" + enturnamiento_detalle_id + "&enturnamiento_id=" + enturnamiento_id + "&producto_id=" +
                producto_id + "&serial=" + serial + "&cantidad=" + cantidad;

            $.ajax({

                url: "detallesEnturnamientoClass.php",
                data: QueryString,
                beforeSend: function() {
                    showDivLoading();
                },
                success: function(response) {

                    if ($.trim(response) == 'true') {
                        checkProcesar.attr("checked", "");

                        $(Fila).find("a[name=saveDetalles]").parent().addClass("focusSaveRow");
                        alertJquery("Actualizado Exitosamente");
                    } else {
                        alertJquery(response);
                    }

                    removeDivLoading();
                }

            });


        }

    } else {
        alertJquery("Debe Ingresar un valor", "Validacion");
    }


}

function deleteDetalle(obj) {

    var Celda = obj.parentNode;
    var Fila = obj.parentNode.parentNode;
    var enturnamiento_detalle_id = $(Fila).find("input[name=enturnamiento_detalle_id]").val();
    var QueryString = "ACTIONCONTROLER=onclickDelete&enturnamiento_detalle_id=" + enturnamiento_detalle_id;

    if (enturnamiento_detalle_id.length > 0) {

        $.ajax({

            url: "detallesEnturnamientoClass.php",
            data: QueryString,
            beforeSend: function() {
                showDivLoading();
            },
            success: function(response) {

                if ($.trim(response) == 'true') {

                    var numRow = (Fila.rowIndex - 1);
                    Fila.parentNode.deleteRow(numRow);

                } else {
                    alertJquery(response);
                }

                removeDivLoading();
            }

        });

    } else {
        alertJquery('No puede eliminar elementos que no han sido guardados');
        $(Fila).find("input[name=procesar]").attr("checked", "");
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
            $(Fila).find("input[name=cantidad]").val(1);
            $("input[name=serial]").focus();
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