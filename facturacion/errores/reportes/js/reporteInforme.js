
$(document).ready(function () {

	$('#fecha_inicio').change(function () {

		var fechah = $('#fecha_final').val();
		var fechad = $('#fecha_inicio').val();
		var today = new Date();

		if ((Date.parse(fechah) < Date.parse(fechad)) || (Date.parse(fechad) > today)) {
			alertJquery('Esta fecha no puede ser mayor a la fecha final o mayor a hoy');
			return this.value = $('#fecha_final').val();
		};
	});

	$('#fecha_final').change(function () {

		var fechah = $('#fecha_final').val();
		var fechad = $('#fecha_inicio').val();
		var today = new Date();

		if ((Date.parse(fechah) < Date.parse(fechad)) || (Date.parse(fechah) > today)) {
			alertJquery('Esta fecha no puede ser menor a la fecha de inicio o mayor a hoy');
			return this.value = $('#fecha_inicio').val();
		};
	});

	///FIN VALIDACION FECHAS DE REPORTE						   

	$("#frameResult").attr("height", "400");
});


function Listar(formulario) {

	if (ValidaRequeridos(formulario)) {

		document.getElementById('frameResult').src = "reporteInformeClass.php?ACTIONCONTROLER=generateReport&" + Math.random() + FormSerialize(formulario);
		
	}
	
	

}


function Generar(formulario) {

	document.location.href = "reporteInformeClass.php?ACTIONCONTROLER=generateFile&" + Math.random() + FormSerialize(formulario);
}

