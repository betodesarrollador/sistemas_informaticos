$(document).ready(function(){
						   
   $("#generar").click(function(){
								
     var valor      = document.getElementById('periodo_uiaf_id').value;
//	 var cliente_id = document.getElementById('cliente_id').value;
	 
	 if(valor == 'NULL'){
		alertJquery("Debe seleccionar algun periodo!!!","Validacion Generacion archivo UIAF");
	 }else{
		 
//		     var QueryString = "archivoUIAFClass.php?ACTIONCONTROLER=generateFile&download=1&periodo_uiaf_id="+valor+"&cliente_id="+cliente_id+"&rand="+Math.random();
			 
		     var QueryString = "archivoUIAFClass.php?ACTIONCONTROLER=generateFile&download=1&periodo_uiaf_id="+valor+"&rand="+Math.random();			 
			 
			 document.location.href = QueryString;
		 
	   }	 
								
   });						   
						   
});