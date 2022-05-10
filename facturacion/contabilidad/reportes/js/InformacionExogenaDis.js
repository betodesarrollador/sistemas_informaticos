$(document).ready(function(){
						   
   $("#generar").click(function(){
								
     var formato_exogena_id      = document.getElementById('formato_exogena_id').value;
	 var periodo_contable_id = document.getElementById('periodo_contable_id').value;
	 
	 if(formato_exogena_id == 'NULL' || periodo_contable_id == 'NULL'){
		alertJquery("Debe seleccionar algun periodo o formato!!!","Validacion Generacion Exogena");
	 }else{
		 
			 
		     var QueryString = "InformacionExogenaDisClass.php?ACTIONCONTROLER=generateFile&download=1&formato_exogena_id="+formato_exogena_id+"&periodo_contable_id="+periodo_contable_id+"&rand="+Math.random();			 
			 
			 document.location.href = QueryString;
		 
	   }	 
								
   });						   
						   
});