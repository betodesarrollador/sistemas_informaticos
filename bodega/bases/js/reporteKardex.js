$(document).ready(function(){
						   
   	///INICIO VALIDACION FECHAS DE REPORTE
	
  	$('#fecha_inicio').change(function(){

	  	var fechah = $('#fecha_final').val();
	  	var fechad = $('#fecha_inicio').val();
	  	var today = new Date();

	 	if ((Date.parse(fechah) < Date.parse(fechad)) || (Date.parse(fechad)>today)) {
	  		alertJquery('Esta fecha no puede ser mayor a la fecha final o mayor a hoy.');
	  		return this.value = $('#fecha_final').val();
	  	};
	});

	$('#fecha_final').change(function(){

	  	var fechah = $('#fecha_final').val();
	  	var fechad = $('#fecha_inicio').val();
	  	var today = new Date();

	  	if ((Date.parse(fechah) < Date.parse(fechad)) || (Date.parse(fechah)>today)) {
	  		alertJquery('Esta fecha no puede ser menor a la fecha de inicio o mayor a hoy.');
	  		return this.value = $('#fecha_inicio').val();
	  	};
	});
	
	///FIN VALIDACION FECHAS DE REPORTE						   						   						   
						   
   $("#frameResult").attr("height","400");						   
   
   $("#opciones_producto").change(function(){

	   $("#producto,#producto_id_hidden").val("");
	   
       if(this.value == 'U'){
         document.getElementById("producto").disabled = false; 
	   }else{
           document.getElementById("producto").disabled = true;
		 }
										
   });
   
   
						   
   $("#listar").click(function(){			
	  document.getElementById('frameResult').src = "reporteKardexClass.php?ACTIONCONTROLER=generateReport&"+Math.random()+FormSerialize(this.form);								
   });
   
   $("#generar").click(function(){			
	  document.location.href = "reporteKardexClass.php?ACTIONCONTROLER=generateReport&download=true&"+Math.random()+FormSerialize(this.form);								
   });   
						   
});

function viewDocument(tipo,movimiento_id){

	if(tipo=='E'){
		var QueryString = "../../operacion/clases/EntradaClass.php?ACTIONCONTROLER=onclickPrint&entrada_producto_id="+movimiento_id;
  	}else{
  		var QueryString = "../../operacion/clases/SalidaClass.php?ACTIONCONTROLER=onclickPrint&salida_producto_id="+movimiento_id;
  	}
  var title       = "Impresion movimiento";
  var width       = 900;
  var height      = 600;

 
    
  popPup(QueryString,title,width,height);  
	
}