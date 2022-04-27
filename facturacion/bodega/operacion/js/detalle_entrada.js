// JavaScript Document
$(document).ready(function() {

    checkedAll();
    checkRow();
    //autocompleteUbiBodega();

    var estado = parent.document.getElementById("estado").value;

    if (estado == 'P') {
        $("select[name=ubicacion_bodega]").each(function() {
            BuscarUbicacion(this);
        });
    } else if (estado == 'IN') {
        var recepcion_id = parent.document.getElementById("recepcion_id").value;
        var entrada_id = parent.document.getElementById("entrada_id").value;

        if (recepcion_id > 0) {

            var QueryString = "ACTIONCONTROLER=traerUbicacion&recepcion_id=" + recepcion_id;

            $.ajax({

                url: "detalleEntradaClass.php",
                data: QueryString,
                beforeSend: function() {
                    showDivLoading();
                },
                success: function(response) {

                    var data = $.parseJSON(response);

                    if (data != false) {

                        $("select[name=ubicacion_bodega]").each(function() {
                            var Fila = this.parentNode.parentNode;
                            for (var i = 0; i < data.length; i++) {
                                $(Fila).find('#ubicacion_bodega').append('<option value="' + data[i]['value'] + '">' + data[i]['ubicacion_bodega'] + '</option>');
                            }

                        });
                    }
                    removeDivLoading();
                }

            });
        }
    }






    $("select[name=ubicacion_bodega]").blur(function() {

        var Fila = this.parentNode.parentNode;
        var ubicacion_bodega_id = $(Fila).find('select[name = ubicacion_bodega]').val();

        if (ubicacion_bodega_id > 0) {

            var QueryString = "ACTIONCONTROLER=traerPosicion&ubicacion_bodega_id=" + ubicacion_bodega_id;

            $.ajax({

                url: "detalleEntradaClass.php",
                data: QueryString,
                beforeSend: function() {
                    showDivLoading();
                },
                success: function(response) {

                    var data = $.parseJSON(response);

                    $(Fila).find('#posicion').empty();
                    $(Fila).find('#posicion').append('<option value="NULL">Seleccione</option>');
                    if (data != false) {
                        for (var i = 0; i < data.length; i++) {
                            $(Fila).find('#posicion').append('<option value="' + data[i]['value'] + '">' + data[i]['posicion'] + '</option>');
                        }
                    }
                    removeDivLoading();
                }

            });

            var QueryString = "ACTIONCONTROLER=traerEstado&ubicacion_bodega_id=" + ubicacion_bodega_id;

            $.ajax({

                url: "detalleEntradaClass.php",
                data: QueryString,
                beforeSend: function() {
                    showDivLoading();
                },
                success: function(response) {

                    var data = $.parseJSON(response);
                    $(Fila).find('#estado_producto').empty();
                    $(Fila).find('#estado_producto').append('<option value="NULL">Seleccione</option>');
                    if (data != false) {
                        for (var i = 0; i < data.length; i++) {
                            $(Fila).find('#estado_producto').append('<option value="' + data[i]['value'] + '">' + data[i]['estado'] + '</option>');
                        }
                    }
                    removeDivLoading();

                }

            });

        }
    });

});

function BuscarUbicacion(fila) {
    var Fila = fila.parentNode.parentNode;
    var recepcion_id = parent.document.getElementById("recepcion_id").value;
    if (recepcion_id > 0) {

        var QueryString = "ACTIONCONTROLER=traerUbicacion&recepcion_id=" + recepcion_id;

        $.ajax({

            url: "detalleEntradaClass.php",
            data: QueryString,
            beforeSend: function() {
                showDivLoading();
            },
            success: function(response) {

                var data = $.parseJSON(response);

                $(Fila).find('#ubicacion_bodega').empty();
                $(Fila).find('#ubicacion_bodega').append('<option value="NULL">Seleccione</option>');
                if (data != false) {
                    for (var i = 0; i < data.length; i++) {
                        $(Fila).find('#ubicacion_bodega').append('<option value="' + data[i]['value'] + '">' + data[i]['ubicacion_bodega'] + '</option>');
                    }
                }
                removeDivLoading();
            }

        });
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



function saveDetalles(formulario) {


    $("input[name=procesar]:checked").each(function(formulario) {

        saveDetalle(this, formulario);

    });


}

/* function saveDetallesInventario(formulario) {

	$("input[name=procesar]:checked").each(function (formulario) {

		saveDetalleInventario(this, formulario);

	});

} */

function saveDetalle(obj, formulario) {


    var row = obj.parentNode.parentNode;

    if (validaRequeridosDetalle(obj, row)) {

        var Celda = obj.parentNode;
        var Fila = obj.parentNode.parentNode;


        var entrada_id = parent.document.getElementById("entrada_id").value;
        var producto_id = $(Fila).find("input[name=producto_id]").val();
        var recepcion_detalle_id = $(Fila).find("input[name=recepcion_detalle_id]").val();
        var serial = $(Fila).find("input[name=serial]").val();
        var cantidad = $(Fila).find("input[name=cantidad]").val();
        var ubicacion_bodega_id = $(Fila).find('select[name = ubicacion_bodega]').val();
        var posicion_id = $(Fila).find("#posicion").val();
        var estado_producto_id = $(Fila).find("#estado_producto").val();

        var checkProcesar = $(Fila).find("input[name=procesar]");

        if (entrada_id.length > 0) {

            var QueryString = "ACTIONCONTROLER=onclickSave&entrada_id=" + entrada_id + "&recepcion_detalle_id=" + recepcion_detalle_id + "&producto_id=" + producto_id +
                "&serial=" + serial + "&cantidad=" + cantidad + "&ubicacion_bodega_id=" + ubicacion_bodega_id + "&posicion_id=" + posicion_id + "&estado_producto_id=" + estado_producto_id;


            $.ajax({

                url: "detalleEntradaClass.php",
                data: QueryString,
                beforeSend: function() {
                    showDivLoading();
                },
                success: function(response) {

                    if (!isNaN(response)) {

                        $(Fila).find("input[name=entrada_detalle_id]").val(response);

                        var Table = document.getElementById('tableDetalles');
                        var numRows = (Table.rows.length);
                        var newRow = Table.insertRow(numRows);

                        $(newRow).find("input[name=producto]").focus();
                        checkRow();
                        checkProcesar.attr("checked", "");
                        $(Celda).removeClass("focusSaveRow");


                        removeDivLoading();
                        setTimeout(alertJquery("Ingreso a Inventario Existoso", "Atención"), 9000);

                    } else {
                        alertJquery(response);
                        console.log(response);
                    }
                }

            });

        }

    } else {
        /* setTimeout( alert("¡Debe Ingresar La Ubicación de La Bodega!", "Validacion"), 10000); */
        alertJquery("Faltan campos por digitar", "Validacion");
    }


}

/* function saveDetalleInventario(obj, formulario) {

	var row = obj.parentNode.parentNode;

	if (validaRequeridosDetalle(obj, row)) {

		var Celda = obj.parentNode;
		var Fila = obj.parentNode.parentNode;


		var entrada_id = parent.document.getElementById("entrada_id").value;
		var producto_id = $(Fila).find("input[name=producto_id]").val();
		var serial = $(Fila).find("input[name=serial]").val();
		var cantidad = $(Fila).find("input[name=cantidad]").val();
		var entrada_detalle_id = $(Fila).find("input[name=entrada_detalle_id]").val();
		var ubicacion_bodega_id = $(Fila).find('select[name = ubicacion_bodega]').val();
		var posicion_id = $(Fila).find("#posicion").val();
		var estado_producto_id = $(Fila).find("#estado_producto").val();

		var checkProcesar = $(Fila).find("input[name=procesar]");

		if (entrada_id.length > 0) {

			var QueryString = "ACTIONCONTROLER=onclickSaveInventario&entrada_id="+entrada_id+"&entrada_detalle_id=" + entrada_detalle_id + "&producto_id=" + producto_id +
				"&serial=" + serial + "&cantidad=" + cantidad + "&ubicacion_bodega_id=" + ubicacion_bodega_id + "&posicion_id=" + posicion_id + "&estado_producto_id=" + estado_producto_id;

			$.ajax({

				url: "detalleEntradaClass.php",
				data: QueryString,
				beforeSend: function () {
					showDivLoading();
				},
				success: function (response) {

					if (!isNaN(response)) {

						$(Fila).find("input[name=inventario_id]").val(response);

						var Table = document.getElementById('tableDetalles');
						var numRows = (Table.rows.length);
						var newRow = Table.insertRow(numRows);

						$(newRow).find("input[name=producto]").focus();
						checkRow();
						checkProcesar.attr("checked", "");
						$(Celda).removeClass("focusSaveRow");


						removeDivLoading();
						setTimeout(alertJquery("Ingreso a Inventario Existoso", "Atención"), 9000);

					} else {
						alertJquery(response);
						console.log(response);
					}
				}

			});

		}

	} else {
		    setTimeout(alert("¡Debe Ingresar La Ubicación de la Bodega!", "Validacion"), 10000);
		   alertJquery("Faltan campos por digitar","Validacion");
         }


} */



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

        url: "detalleEntradaClass.php",
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

/* function autocompleteUbiBodega() {

	$("input[name=ubicacion_bodega]").autocomplete("sistemas_informaticos/framework/clases/ListaInteligente.php?consulta=ubicacion_bodega_entrada", {
		width: 260,
		selectFirst: true
	});

	$("input[name=ubicacion_bodega]").result(function (event, data, formatted) {
	
		if (data) {

 			$("input[name=codigo_barra]").each(function () {
				traerCodigoBarras(this, data[1]);
			}); 

			

			var ubicacion_bodega_id = data[0].split("-");

			//$(this).val($.trim(ubicacion_bodega_id[0]));
			$(this).attr("title", data[0]);
			$(this).next().val(data[1]);
			var txtNext = false;

		}

	});

} */