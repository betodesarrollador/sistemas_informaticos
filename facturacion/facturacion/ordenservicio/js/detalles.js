// JavaScript Document

$(document).ready(function () {

	checkedAll();
	checkRow();
	linkImputaciones();
	suma_cantidad();
	autocompleteRemesa();

});
function autocompleteRemesa() {

	var cliente_id = parent.document.getElementById('cliente_hidden').value;

	if (cliente_id > 0) {

		$("input[name=remesa]").autocomplete("../../../framework/clases/ListaInteligente.php?consulta=remesa_cliente_servicio&cliente_id=" + cliente_id, {
			width: 260,
			selectFirst: true
		});

		$("input[name=remesa]").result(function (event, data, formatted) {

			if (data) {

				var remesa_id = data[1];
				var remesa = data[0].split(':');
				var remesa = remesa[1].split(' - ');

				$(this).val(remesa[0]);
				$(this).attr("title", data[0]);
				$(this).next().val(remesa_id);

			}

		});

	} else {

		parent.alertJquery('Debe seleccionar primero un cliente!', 'Atencion')

	}

}

function suma_cantidad() {

	$("input[name=cant_item_orden_servicio]").keyup(function () {
		var Fila = $(this).parent().parent();
		var cant = $(Fila).find("input[name=cant_item_orden_servicio]").val();
		var valoruni = $(Fila).find("input[name=valoruni_item_orden_servicio]").val();

		if (cant != '' && cant != 0 && valoruni != '' && valoruni != 0) {
			var total = removeFormatCurrency(cant) * removeFormatCurrency(valoruni);
			$(Fila).find("input[name=valor_total]").val(setFormatCurrency(total));
		}

	});

	$("input[name=valoruni_item_orden_servicio]").keyup(function () {
		var Fila = $(this).parent().parent();
		var cant = $(Fila).find("input[name=cant_item_orden_servicio]").val();
		var valoruni = $(Fila).find("input[name=valoruni_item_orden_servicio]").val();
		if (cant != '' && cant != 0 && valoruni != '' && valoruni != 0) {
			var total = removeFormatCurrency(cant) * removeFormatCurrency(valoruni);
			$(Fila).find("input[name=valor_total]").val(setFormatCurrency(total));
		}

	});


}
function checkedAll() {

	$("#checkedAll").click(function () {


		if ($(this).is(":checked")) {
			$("input[name=procesar]").attr("checked", "true");
		} else {
			$("input[name=procesar]").attr("checked", "");
		}

	});

}


function linkImputaciones() {

	$("a[name=saveDetalles]").attr("href", "javascript:void(0)");

	$("a[name=saveDetalles]").focus(function () {
		var celda = this.parentNode;
		$(celda).addClass("focusSaveRow");
	});

	$("a[name=saveDetalles]").blur(function () {
		var celda = this.parentNode;
		$(celda).removeClass("focusSaveRow");
	});

	$("a[name=saveDetalles]").click(function () {

		saveDetalle(this);

	});

}



function saveDetalle(obj) {
	var row = obj.parentNode.parentNode;

	if (validaRequeridosDetalle(obj, row)) {

		var Celda = obj.parentNode;
		var Fila = obj.parentNode.parentNode;
		var item_orden_servicio_id = $(Fila).find("input[name=item_orden_servicio_id]").val();
		var orden_servicio_id = $("#orden_servicio_id").val();
		var cant_item_orden_servicio = $(Fila).find("input[name=cant_item_orden_servicio]").val();
		var desc_item_orden_servicio = $(Fila).find("input[name=desc_item_orden_servicio]").val();
		var valoruni_item_orden_servicio = $(Fila).find("input[name=valoruni_item_orden_servicio]").val();
		var remesa_id = $(Fila).find("input[name=remesa_id]").val();
		var checkProcesar = $(Fila).find("input[name=procesar]");



		if (!item_orden_servicio_id.length > 0) {

			item_orden_servicio_id = 'NULL';

			var QueryString = "ACTIONCONTROLER=onclickSave&orden_servicio_id=" + orden_servicio_id + "&item_orden_servicio_id=" +
				item_orden_servicio_id + "&cant_item_orden_servicio=" + cant_item_orden_servicio + "&desc_item_orden_servicio=" + desc_item_orden_servicio
				+ "&valoruni_item_orden_servicio=" + valoruni_item_orden_servicio + "&remesa_id=" + remesa_id;


			$.ajax({

				url: "DetallesClass.php",
				data: QueryString,
				beforeSend: function () {
					showDivLoading();
				},
				success: function (response) {

					if (!isNaN(response)) {

						$(Fila).find("input[name=item_orden_servicio_id]").val(response);

						var Table = document.getElementById('tableDetalles');
						var numRows = (Table.rows.length);
						var newRow = Table.insertRow(numRows);

						$(newRow).html($("#clon").html());
						$(newRow).find("input[name=cant_item_orden_servicio]").focus();


						checkRow();
						linkImputaciones();
						suma_cantidad();


						checkProcesar.attr("checked", "");
						$(Celda).removeClass("focusSaveRow");
						if (parent.getTotal)
							parent.getTotal(parent.document.getElementById("orden_servicio_id").value);

						removeDivLoading();


					} else {
						removeDivLoading();
						parent.alertJquery(response);
					}
				}

			});

		} else {

			var QueryString = "ACTIONCONTROLER=onclickUpdate&orden_servicio_id=" + orden_servicio_id + "&item_orden_servicio_id=" +
				item_orden_servicio_id + "&cant_item_orden_servicio=" + cant_item_orden_servicio + "&desc_item_orden_servicio=" + desc_item_orden_servicio
				+ "&valoruni_item_orden_servicio=" + valoruni_item_orden_servicio + "&remesa_id=" + remesa_id;

			$.ajax({

				url: "DetallesClass.php",
				data: QueryString,
				beforeSend: function () {
					showDivLoading();
				},
				success: function (response) {

					if ($.trim(response) == 'true') {
						checkProcesar.attr("checked", "");
						if (parent.getTotal)
							parent.getTotal(parent.document.getElementById("orden_servicio_id").value);
						$(Fila).find("a[name=saveDetalles]").parent().addClass("focusSaveRow");
					} else {
						parent.alertJquery(response);
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
	var item_orden_servicio_id = $(Fila).find("input[name=item_orden_servicio_id]").val();
	var QueryString = "ACTIONCONTROLER=onclickDelete&item_orden_servicio_id=" + item_orden_servicio_id;

	if (item_orden_servicio_id.length > 0) {

		$.ajax({

			url: "DetallesClass.php",
			data: QueryString,
			beforeSend: function () {
				showDivLoading();
			},
			success: function (response) {

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

	$("input[name=procesar]:checked").each(function () {

		saveDetalle(this);

	});

}

function deleteDetalles() {

	$("input[name=procesar]:checked").each(function () {

		deleteDetalle(this);

	});

}


function checkRow() {

	$("input[type=text]").keyup(function (event) {

		var Tecla = event.keyCode;
		var Fila = this.parentNode.parentNode;

		$(Fila).find("input[name=procesar]").attr("checked", "true");

	});

}


