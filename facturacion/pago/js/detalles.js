// JavaScript Document

$(document).ready(function () {

	checkedAll();
	checkRow();
	autocompleteTercero();
	autocompleteCentroCosto();
	getvalorCalculadoBase();

	$(document).bind('keyup', 'Ctrl+c', function (evt) {

		var txtConcepto = $(document).find(":focus");
		var concepto = parent.document.getElementById("concepto").value;

		if (txtConcepto.attr("name") == "descripcion") {
			var varTmp = txtConcepto.val();
			txtConcepto.val(varTmp + ' ' + concepto);
		}

		return false;

	});

	$(document).bind('keydown', 'Ctrl+t', function (evt) {

		var txtConcepto = $(document).find(":focus");
		var tercero = parent.document.getElementById("tercero").value;

		if (txtConcepto.attr("name") == "descripcion") {
			var varTmp = txtConcepto.val();
			txtConcepto.val(varTmp + ' ' + tercero);
		}

		return false;

	});

});

function checkedAll() {

	$("#checkedAll").click(function () {


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

function autocompleteTercero() {

	$("input[name=tercero]").autocomplete("../../../framework/clases/ListaInteligente.php?consulta=tercero", {
		width: 260,
		selectFirst: true
	});

	$("input[name=tercero]").result(function (event, data, formatted) {
		if (data) {
			var numero_identificacion = data[0].split("-");
			$(this).val($.trim(numero_identificacion[0]));
			$(this).attr("title", data[0]);
			$(this).next().val(data[1]);

			var txtNext = false;

			$(this.parentNode.parentNode).find("input[name!=puc]&&input[name!=tercero]&&input[type=text]").each(function () {
				if (this.readOnly == false && txtNext == false) {
					this.focus();
					txtNext = true;
				}

			});
		}
	});

}

function autocompleteCentroCosto() {

	$("input[name=centro_de_costo]").autocomplete("../../../framework/clases/ListaInteligente.php?consulta=centro_costo", {
		width: 260,
		selectFirst: true
	});

	$("input[name=centro_de_costo]").result(function (event, data, formatted) {
		if (data) {
			var centro_costo = data[0].split("-");
			$(this).val($.trim(centro_costo[0]));
			$(this).attr("title", data[0]);
			$(this).next().val(data[1]);

			var txtNext = false;

			$(this.parentNode.parentNode).find("input[name!=puc]&&input[name!=tercero]&&input[name!=centro_de_costo]&&input[type=text]").each(function () {
				if (this.readOnly == false && txtNext == false) {
					this.focus();
					txtNext = true;
				}

			});
		}
	});

}



/***************************************************************
	  Funciones para el objeto de guardado en las imputaciones
***************************************************************/

function getRequieresCuenta(puc_id, objTxt) {

	var fila = $(objTxt).parent().parent();
	var abono_factura_id = $("#abono_factura_id").val();
	var QueryString = "ACTIONCONTROLER=getRequieresCuenta&puc_id=" + puc_id + '&abono_factura_id=' + abono_factura_id;

	$.ajax({
		url: "DetallesClass.php",
		data: QueryString,
		beforeSend: function () {
			showDivLoading();
		},
		success: function (response) {

			try {

				var requiere = $.parseJSON(response);
				var requiere_tercero = requiere['requiere_tercero'];
				var requiere_centro_costo = requiere['requiere_centro_costo'];
				var require_base = requiere['require_base'];

				fila.find("input[name=tercero]").val("");
				fila.find("input[name=tercero_id]").val("");
				fila.find("input[name=centro_de_costo]").val("");
				fila.find("input[name=centro_de_costo_id]").val("");
				fila.find("input[name=base_abono]").val("");

				if ($.trim(requiere_tercero) == "true") {
					fila.find("input[name=tercero]").removeClass("no_requerido");
					fila.find("input[name=tercero]").attr("readonly", "");
					fila.find("input[name=tercero]").parent().removeClass("no_requerido");
					fila.find("input[name=tercero_id]").addClass("required");
				} else {
					fila.find("input[name=tercero]").addClass("no_requerido");
					fila.find("input[name=tercero]").attr("readonly", "true");
					fila.find("input[name=tercero]").parent().addClass("no_requerido");
					fila.find("input[name=tercero_id]").removeClass("required");
				}


				if ($.trim(requiere_centro_costo) == "true") {
					fila.find("input[name=centro_de_costo]").removeClass("no_requerido");
					fila.find("input[name=centro_de_costo]").attr("readonly", "");
					fila.find("input[name=centro_de_costo]").parent().removeClass("no_requerido");
					fila.find("input[name=centro_de_costo_id]").addClass("required");
				} else {
					fila.find("input[name=centro_de_costo]").addClass("no_requerido");
					fila.find("input[name=centro_de_costo]").attr("readonly", "true");
					fila.find("input[name=centro_de_costo]").parent().addClass("no_requerido");
					fila.find("input[name=centro_de_costo_id]").removeClass("required");
				}

				if ($.trim(require_base) == "true") {
					fila.find("input[name=base_abono]").removeClass("no_requerido");
					fila.find("input[name=base_abono]").attr("readonly", "");
					fila.find("input[name=base_abono]").parent().removeClass("no_requerido");
					fila.find("input[name=base_abono]").addClass("required");
					fila.find("input[name=deb_item_abono]").attr("readonly", "true");
					fila.find("input[name=cre_item_abono]").attr("readonly", "true");
				} else {
					fila.find("input[name=base_abono]").addClass("no_requerido");
					fila.find("input[name=base_abono]").attr("readonly", "true");
					fila.find("input[name=base_abono]").parent().addClass("no_requerido");
					fila.find("input[name=base_abono]").removeClass("required");
					fila.find("input[name=deb_item_abono]").attr("readonly", "");
					fila.find("input[name=cre_item_abono]").attr("readonly", "");
				}

				removeDivLoading();

				var txtNext = false;

				$(fila).find("input[name!=puc]&&input[type=text]").each(function () {
					if (this.readOnly == false && txtNext == false) {
						this.focus();
						txtNext = true;
					}

				});


			} catch (e) {

			}

		}

	});

}

function getvalorCalculadoBase() {

	$("input[name=base_abono]").blur(function () {

		if ($(this).is(".required")) {

			var objBase = this;
			var puc_id = $(this).parent().parent().find("input[name=puc_id]").val();
			var base_abono = $(this).parent().parent().find("input[name=base_abono]").val();
			var abono_factura_proveedor_id = $("#abono_factura_proveedor_id").val();

			var QueryString = "ACTIONCONTROLER=getvalorCalculadoBase&puc_id=" + puc_id + '&abono_factura_proveedor_id=' +
				abono_factura_proveedor_id + "&base_abono=" + base_abono;


			$.ajax({
				url: "DetallesClass.php",
				data: QueryString,
				success: function (response) {

					try {

						var datosCalculo = $.parseJSON(response);

						if ($.trim(datosCalculo['naturaleza']) == 'D') {
							$(objBase).parent().parent().find("input[name=deb_item_abono]").val(datosCalculo['valor']);
							$(objBase).parent().parent().find("input[name=cre_item_abono]").val("");
						} else {
							$(objBase).parent().parent().find("input[name=deb_item_abono]").val("");
							$(objBase).parent().parent().find("input[name=cre_item_abono]").val(datosCalculo['valor']);
						}

					} catch (e) {
					}

				}
			});

		}

	});

}

function saveDetalle(obj) {

	var row = obj.parentNode.parentNode;

	if (validaRequeridosDetalle(obj, row)) {

		var Celda = obj.parentNode;
		var Fila = obj.parentNode.parentNode;
		var item_abono_id = $(Fila).find("input[name=item_abono_id]").val();
		var abono_factura_proveedor_id = $("#abono_factura_proveedor_id").val();
		var puc_id = $(Fila).find("input[name=puc_id]").val();
		var tercero_id = $(Fila).find("input[name=tercero_id]").val();
		var centro_de_costo_id = $(Fila).find("input[name=centro_de_costo_id]").val();
		var desc_abono = $(Fila).find("input[name=desc_abono]").val();
		var base_abono = $(Fila).find("input[name=base_abono_factura]").val();
		var deb_item_abono = removeFormatCurrency($(Fila).find("input[name=deb_item_abono]").val());
		var cre_item_abono = removeFormatCurrency($(Fila).find("input[name=cre_item_abono]").val());
		var valor_total = removeFormatCurrency($(Fila).find("input[name=valor_total]").val());
		var abonos = removeFormatCurrency($(Fila).find("input[name=abonos]").val());
		var checkProcesar = $(Fila).find("input[name=procesar]");
		var saldo = valor_total - abonos;

		tercero_id = tercero_id.length > 0 ? tercero_id : 'NULL';
		centro_de_costo_id = centro_de_costo_id.length > 0 ? centro_de_costo_id : 'NULL';
		base_abono = base_abono.length > 0 ? base_abono : 'NULL';
		deb_item_abono = deb_item_abono.length > 0 ? deb_item_abono : 'NULL';
		cre_item_abono = cre_item_abono.length > 0 ? cre_item_abono : 'NULL';

		console.log(deb_item_abono+' '+cre_item_abono+' '+saldo);

		if ((parseInt(deb_item_abono) > 0 || parseInt(cre_item_abono)) && saldo >= deb_item_abono && saldo >= cre_item_abono) {

			
			var QueryString = "ACTIONCONTROLER=onclickUpdate&abono_factura_proveedor_id=" + abono_factura_proveedor_id + "&item_abono_id=" +
				item_abono_id + "&puc_id=" + puc_id + "&tercero_id=" + tercero_id + "&centro_de_costo_id=" + centro_de_costo_id + "&desc_abono=" + desc_abono +
				"&base_abono=" + base_abono + "&deb_item_abono=" + deb_item_abono + "&cre_item_abono=" + cre_item_abono;

			$.ajax({

				url: "DetallesClass.php",
				data: QueryString,
				beforeSend: function () {
					showDivLoading();
				},
				success: function (response) {

					if ($.trim(response) == 'true') {
						checkProcesar.attr("checked", "");
						if (parent.getTotalDebitoCredito)
							parent.getTotalDebitoCredito(parent.document.getElementById("abono_factura_id").value);
					} else {
						alertJquery(response);
					}

					removeDivLoading();
				}

			});

		} else if (saldo < deb_item_abono || saldo < cre_item_abono) {
			alertJquery("Los valores sobrepasan el saldo de la Factura", "Validacion Debito / Credito");
		} else {
			alertJquery("Debe Ingresar un valor", "Validacion Debito / Credito");
		}

	}

}


function saveDetalles() {

	$("input[name=procesar]:checked").each(function () {

		console.log('test');

		saveDetalle(this);

	});

}


function checkRow() {

	$("input[type=text]").keyup(function (event) {
		var Tecla = event.keyCode;
		var Fila = this.parentNode.parentNode;

		$(Fila).find("input[name=procesar]").attr("checked", "true");

	});

}


