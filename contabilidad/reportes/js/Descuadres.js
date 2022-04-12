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
});
function generateFile(){
    
  var fecha_inicial = $("#fecha_inicial").val();
  var fecha_final   = $("#fecha_final").val(); 
      
  document.location.href = 'DescuadresClass.php?ACTIONCONTROLER=generateFile&fecha_inicial='+fecha_inicial+'&fecha_final='+fecha_final;
    
}