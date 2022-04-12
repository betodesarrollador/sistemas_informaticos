
$(document).ready(function () {

	$('#fecha_inicio').change(function () {

		var fechah = $('#fecha_final').val();
		var fechad = $('#fecha_inicio').val();
		var today = new Date();

		if (Date.parse(fechah) < Date.parse(fechad)) {
			alertJquery('Esta fecha no puede ser mayor a la fecha final o mayor a hoy');
			return this.value = $('#fecha_final').val();
		};
	});

	$('#fecha_final').change(function () {

		var fechah = $('#fecha_final').val();
		var fechad = $('#fecha_inicio').val();
		var today = new Date();

		if (Date.parse(fechah) < Date.parse(fechad)) {
			alertJquery('Esta fecha no puede ser menor a la fecha de inicio o mayor a hoy');
			return this.value = $('#fecha_inicio').val();
		};
	});

	///FIN VALIDACION FECHAS DE REPORTE						   

	$("#frameResult").attr("height", "400");
});


function Listar(formulario) {

	var src = "reporteRendimientoClass.php?ACTIONCONTROLER=generateReport&" + Math.random() + FormSerialize(formulario);

	$("#frameResult").attr("src", src);
	showDivLoading();
	$("#frameResult").load(function (response) {
	  removeDivLoading();
	}); 

}


function Generar(formulario) {

	document.location.href = "reporteRendimientoClass.php?ACTIONCONTROLER=generateFile&" + Math.random() + FormSerialize(formulario);
}

