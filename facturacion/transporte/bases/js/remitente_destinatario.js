// JavaScript Document

function setDataFormWithResponse() {

	RequiredRemove();

	FindRow([{ campos: "remitente_destinatario_id", valores: $('#remitente_destinatario_id').val() }], document.forms[0], 'RemitenteDestinatarioClass.php', null, function () {

		$("#tipo").val("D");


		var tipo_identificacion_id = document.getElementById('tipo_identificacion_id').value;

		calculaDigitoTercero();
		ocultaFilaNombresRazon(tipo_identificacion_id);

		$("#tipo_identificacion_id").trigger("change");

		if ($('#guardar')) $('#guardar').attr("disabled", "true");
		if ($('#actualizar')) $('#actualizar').attr("disabled", "");
		if ($('#borrar')) $('#borrar').attr("disabled", "");
		if ($('#limpiar')) $('#limpiar').attr("disabled", "");

	});


}

var formSubmitted = false;

function RemitenteDestinatarioOnSaveOnUpdateonDelete(formulario, resp) {

	if ((parseInt(resp) > 0) || (resp == 'true')) {
		if (parseInt(resp) > 0) {
			$("#remitente_destinatario_id").val(resp);
		}
		if (!formSubmitted) {

			var QueryString = FormSerialize(formulario) + "&ACTIONCONTROLER=sendRemitenteDestinatarioMintransporte";

			$.ajax({
				url: "RemitenteClass.php?rand=" + Math.random(),
				data: QueryString,
				beforeSend: function () {
					window.scrollTo(0, 0);
					showDivMessage("Reportando al Ministerio de Transporte<br>Por Favor Espere..", "../../../framework/media/images/general/cable_data_transfer_md_wht.gif");
					formSubmitted = true;
				},
				success: function (resp) {

					removeDivMessage();

					showDivMessage(resp, "../../../framework/media/images/general/cable_data_transfer_md_wht.gif");
					formSubmitted = false;

					Reset(formulario);
					clearFind();
					$("#tipo").val("D");
					$("#estado").val("D");
					$("#refresh_QUERYGRID_remitente_destinatario").click();

					if ($('#guardar')) $('#guardar').attr("disabled", "");
					if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
					if ($('#borrar')) $('#borrar').attr("disabled", "true");
					if ($('#limpiar')) $('#limpiar').attr("disabled", "");

				}

			});

		}

	} else {
		alertJquery(resp);
	}

}
function RemitenteDestinatarioOnReset(formulario) {

	Reset(formulario);
	clearFind();

	$("#tipo").val("D");
	$("#estado").val("D");
	$("#primer_apellido,#segundo_apellido").removeClass("obligatorio");

	if ($('#guardar')) $('#guardar').attr("disabled", "");
	if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
	if ($('#borrar')) $('#borrar').attr("disabled", "true");
	if ($('#limpiar')) $('#limpiar').attr("disabled", "");
}

$(document).ready(function () {

	$("#tipo_identificacion_id").change(function () {

		if (this.value != '2' && this.value != 'NULL') {
			$("#primer_apellido,#segundo_apellido").addClass("obligatorio");
			$("#telefono").removeClass("obligatorio");
			$("#telefono").removeClass("requerido");
		} else {
			$("#telefono").addClass("obligatorio");
			$("#primer_apellido,#segundo_apellido").removeClass("obligatorio");
			$("#primer_apellido,#segundo_apellido").removeClass("requerido");
		}

	});

	$("#tipo_identificacion_id").trigger("change");

	$("#filaApellidos").css("display", "none");

	$("#tipo_identificacion_id").change(function () {
		calculaDigitoTercero();
		ocultaFilaNombresRazon(this.value);
	});

	$("#numero_identificacion").blur(function () {



		var remitente_destinatario_id = $("#remitente_destinatario_id").val();
		var numero_identificacion = this.value;
		var params = new Array({ campos: "numero_identificacion", valores: numero_identificacion });

		if (numero_identificacion.length > 11) {
			alertJquery("El numero de identificacion no puede exceder los 11 caracteres", "Validacion");
			$("#numero_identificacion").val("");
		}
		if (numero_identificacion.length < 5) {
			alertJquery("El numero de identificacion no puede contener menos de 5 caracteres", "Validacion");
			$("#numero_identificacion").val("");
		}

		if (!remitente_destinatario_id.length > 0) {

			validaRegistro(this, params, "RemitenteDestinatarioClass.php", null, function (resp) {

				if (parseInt(resp) != 0) {

					var params = new Array({ campos: "numero_identificacion", valores: numero_identificacion });
					var formulario = document.forms[0];
					var url = 'RemitenteDestinatarioClass.php';

					FindRow(params, formulario, url, null, function (resp) {

						var data = $.parseJSON(resp);

						ocultaFilaNombresRazon(data[0]['tipo_identificacion_id']);

						clearFind();

						$("#tipo_identificacion_id").attr("disabled", "true");

						$('#guardar').attr("disabled", "");
						$('#actualizar').attr("disabled", "true");
						$('#borrar').attr("disabled", "true");
						$('#limpiar').attr("disabled", "");

					}, true);

				} else {
					calculaDigitoTercero();

					$("#tipo_identificacion_id").attr("disabled", "");


					$('#guardar').attr("disabled", "");
					$('#actualizar').attr("disabled", "true");
					$('#borrar').attr("disabled", "true");
					$('#limpiar').attr("disabled", "");
				}
			});

		}

	});


});

