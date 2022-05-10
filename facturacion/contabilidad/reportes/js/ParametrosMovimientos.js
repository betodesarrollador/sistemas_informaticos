$(document).ready(function(){
						   
   	///INICIO VALIDACION FECHAS DE REPORTE
	
  	$('#fecha_inicial').change(function(){
	  	var fechah = $('#fecha_final').val();
	  	var fechad = $('#fecha_inicial').val();
	  	var today = new Date();
	 	if ((Date.parse(fechah) < Date.parse(fechad)) || (Date.parse(fechad)>today)) {
	  		alertJquery('Esta fecha no puede ser mayor a la fecha final o mayor a hoy.');
	  		return this.value = $('#fecha_final').val();
	  	};
	});
	$('#fecha_final').change(function(){
	  	var fechah = $('#fecha_final').val();
	  	var fechad = $('#fecha_inicial').val();
	  	var today = new Date();
	  	if ((Date.parse(fechah) < Date.parse(fechad)) || (Date.parse(fechah)>today)) {
	  		alertJquery('Esta fecha no puede ser menor a la fecha de inicio o mayor a hoy.');
	  		return this.value = $('#fecha_inicial').val();
	  	};
	});
	
	///FIN VALIDACION FECHAS DE REPORTE						   						   
	$("#opciones_centros").click(function () {

		if (this.checked) {
			this.value = 'T';
		} else {
			this.value = 'U';
		}

		var objSelect = document.getElementById('centro_de_costo_id');
		var numOp = objSelect.options.length - 1;

		if (this.value == 'T') {

			for (var i = numOp; i > 0; i--) {

				if (objSelect.options[i].value != 'NULL') {
					objSelect.options[i].selected = true;
				} else {
					objSelect.options[i].selected = false;
				}

			}

		} else {

			for (var i = numOp; i > 0; i--) {

				if (objSelect.options[i].value != 'NULL') {
					objSelect.options[i].selected = false;
				} else {
					objSelect.options[i].selected = true;
				}

			}

		}

	});
	
	$("#centro_de_costo_id").change(function () {
		$("#opciones_centros").attr("checked", "");
		$("#opciones_centros").val("U");
	});

});
function generateFile(){
    
  var fecha_inicial = $("#fecha_inicial").val();
  var fecha_final   = $("#fecha_final").val();
  var opciones_centros = $("#opciones_centros").val();
  var centro_de_costo_id = $("#centro_de_costo_id").val(); 
  
	document.location.href = 'ParametrosMovimientosClass.php?ACTIONCONTROLER=generateFile&fecha_inicial='+fecha_inicial+'&fecha_final='+fecha_final+'&opciones_centros='+opciones_centros+'&centro_de_costo_id='+centro_de_costo_id;
    
}