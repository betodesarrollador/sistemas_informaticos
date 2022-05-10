// JavaScript Document
$(document).ready(function() {
    checkedAll();
    $("input[name=serial]").focus();
    autocompleteUbicacionBodega();
    autocompleteEntrada();
    enterdetalle();
    var estado = parent.document.getElementById('estado').value;

    if (estado == 'I') {
        $("a[name=saveDetalleTraslados]").css("display", "none");
        $("a[name=deleteDetalleTraslados]").css("display", "none");
        $(document).find("input,select,textarea").each(function() {
            this.disabled = true;
        });
    } else {
        $("a[name=saveDetalleTraslados]").css("display", "");
        $("a[name=deleteDetalleTraslados]").css("display", "");
        $(document).find("input,select,textarea").each(function() {
            this.disabled = false;
        });
    }
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

function enterdetalle() {

    $("input[name=serial]").keypress(function(e) {
        leerCodigobar(this, e);
    });
}

function leerCodigobar(obj, e) {
    var Fila = obj.parentNode.parentNode;

    if (e.which == 13) {
        e.preventDefault();
        var serial = $(Fila).find("input[name=serial]").val();
        var traslado_id = parent.document.getElementById('traslado_id').value;

        if (document.getElementById('serial').value != '') {

            if (serial == "NULL" || serial == "") {
                serial = 0;
            } else {
                var QueryString = "ACTIONCONTROLER=setLeerCodigobar&serial=" + serial + "&traslado_id=" + traslado_id;

                $.ajax({
                    url: 'DetalleTrasladosClass.php?random=' + Math.random(),
                    data: QueryString,
                    beforeSend: function() {
                        showDivLoading();
                    },
                    success: function(resp) {
                        try {
                            var data = $.parseJSON(resp);

                            if (data[0]['producto_id'] > 0) {
                                console.log("el producto si existe");
                                var serial = data[0]['serial'];
                                var entrada_id = data[0]['entrada_id'];
                                var cantidad = data[0]['cantidad'];
                                var ubicacion_bodega_id = data[0]['ubicacion_bodega_id'];
                                var ubicacion_bodega = data[0]['ubicacion_bodega'];
                                $(Fila).find("input[name=serial]").val(serial);
                                $(Fila).find("input[name=entrada]").val(entrada_id);
                                $(Fila).find("input[name=cantidad]").val(cantidad);
                                $(Fila).find("input[name=ubicacion_bodega_id]").val(ubicacion_bodega_id);
                                $(Fila).find("input[name=ubicacion_bodega]").val(ubicacion_bodega);
                                saveDetalleTraslados(obj);


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

/***************************************************************
	  lista inteligente 
	  **************************************************************/

function autocompleteUbicacionBodega() {

    $("input[name=ubicacion_bodega]").autocomplete("sistemas_informaticos/framework/clases/ListaInteligente.php?consulta=ubicacion_bodega", {
        width: 260,
        selectFirst: true,
        minChars: 3,
        scrollHeight: 220
    });

    $("input[name=ubicacion_bodega]").result(function(event, data, formatted) {
        if (data) {
            var row = this.parentNode.parentNode;
            details = data[1].split("=");
            $(this).next().val(details[0]);

        }
    });

}

function autocompleteEntrada() {

    $("input[name=serial]").autocomplete("sistemas_informaticos/framework/clases/ListaInteligente.php?consulta=wms_serial", {
        width: 260,
        selectFirst: true,
        minChars: 3,
        scrollHeight: 220
    });

    $("input[name=serial]").result(function(event, data, formatted) {
        if (data) {
            var row = this.parentNode.parentNode;
            details = data[1].split("=");
            $(row).find("input[name=serial]").val(details[0]);
            leerCodigobar(this, e);
            $(row).find("input[name=serial]").focus();
        }

    });

}


function deleteDetallesTraslados() {
    $("input[name=procesar]:checked").each(function() {
        deleteDetalleTraslados(this);
    });
}



function deleteDetalleTraslados(obj) {

    var Fila = obj.parentNode.parentNode;

    var traslado_detalle_id = $(Fila).find("#traslado_detalle_id").val();

    if (traslado_detalle_id.length > 0) {

        if ($('#borrar', parent.document).length > 0) { /*se valida el permiso de borrar*/

            var QueryString = "ACTIONCONTROLER=onclickDelete&traslado_detalle_id=" + traslado_detalle_id;

            $.ajax({

                url: "DetalleTrasladosClass.php",
                data: QueryString,
                beforeSend: function() {},
                success: function(response) {

                    if (response == 'true') {

                        var numRow = Fila.rowIndex - 1;
                        Fila.parentNode.deleteRow(numRow);

                        updateGrid();
                        alertJquery("Se elimino correctamente el detalle");

                    } else {
                        alertJquery(response, "Error");
                    }
                } /*fin del success*/
            });
        }

    } else {
        console.log("Detalle no creado");
    }
}


function saveDetalleTraslados(obj) {

    var row = obj.parentNode.parentNode;

    if (validaRequeridosDetalle(obj, row)) {

        var Celda = obj.parentNode;
        var Fila = obj.parentNode.parentNode;

        var traslado_detalle_id = $(Fila).find("#traslado_detalle_id").val();
        var traslado_id = $("#traslado_id").val();
        var cantidad = $(Fila).find("#cantidad").val();
        var serial = $(Fila).find("#serial").val();
        var ubicacion_bodega_id = $(Fila).find("#ubicacion_bodega_id").val();
        var entrada_id = $(Fila).find("#entrada").val();

        if (!traslado_detalle_id.length > 0) {

            if ($('#guardar', parent.document).length > 0) { /*se valida el permiso de guardar*/

                var QueryString = "ACTIONCONTROLER=onclickSave&cantidad=" + cantidad + "&serial=" + serial +
                    "&ubicacion_bodega_id=" + ubicacion_bodega_id + "&traslado_id=" + traslado_id + "&entrada_id=" + entrada_id;

                $.ajax({

                    url: "DetalleTrasladosClass.php",
                    data: QueryString,
                    beforeSend: function() {},
                    success: function(response) {

                        if (response > 0) {

                            var Table = document.getElementById('tableDetalleTraslados');
                            var numRows = (Table.rows.length);
                            var newRow = Table.insertRow(numRows);

                            $(newRow).html($("#clon").html());
                            $(newRow).find("input[name=serial]").focus();

                            updateGrid();

                            // $(Celda).removeClass("focusSaveRow");

                            $(Fila).find("#traslado_detalle_id").val(response);

                            // alertJquery("Se ingreso correctamente el detalle");
                            // $(newRow).find("input[name=serial]").focus();
                            // autocompleteUbicacionBodega();
                            autocompleteEntrada();
                            enterdetalle();

                        } else {
                            alertJquery(response, "Error");
                        }
                    } /*fin del success*/
                });
            }

        } else {
            if ($("#actualizar", parent.document).length > 0) { /*se valida el permiso de guardar*/

                var QueryString = "ACTIONCONTROLER=onclickUpdate&cantidad=" + cantidad + "&serial=" + serial +
                    "&ubicacion_bodega_id=" + ubicacion_bodega_id + "&traslado_id=" +
                    traslado_id + "&traslado_detalle_id=" + traslado_detalle_id + "&entrada_id=" + entrada_id;

                $.ajax({

                    url: "DetalleTrasladosClass.php",
                    data: QueryString,
                    beforeSend: function() {},
                    success: function(response) {

                        if (response == 'true') {

                            updateGrid();

                            alertJquery("Se actualizo correctamente el detalle");

                        } else {
                            alertJquery(response, "Error");
                        }
                    } /*fin del success*/
                });
            }
        }

    } else {
        alertJquery("Faltan campos obligatorios por diligenciar", "validacion");
    }

}



function updateGrid() {
    parent.updateGrid();
}