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
   
   $("#opciones_placa").change(function(){

	   $("#placa,#placa_id_hidden").val("");
	   
       if(this.value == 'U'){
         document.getElementById("placa").disabled = false; 
	   }else{
           document.getElementById("placa").disabled = true;
		 }
										
   });
   
   $("#opciones_conductor").change(function(){

	   $("#conductor,#conductor_id_hidden").val("");
	   
       if(this.value == 'U'){
         document.getElementById("conductor").disabled = false; 
	   }else{
           document.getElementById("conductor").disabled = true;
		 }
										
   });   
   
  $("#opciones_oficina").click(function(){

     if(this.checked){
	   this.value = 'T';	 
	 }else{
		  this.value = 'U';
	   }
	   
     var objSelect = document.getElementById('oficina_id'); 
	 var numOp     = objSelect.options.length -1;
	   
     if(this.value == 'T'){
	   
	   for(var i = numOp; i > 0; i-- ){
		   
		  if(objSelect.options[i].value != 'NULL'){
			 objSelect.options[i].selected = true;
		  }else{
			   objSelect.options[i].selected = false;
			} 
		   
	   }
		 		 
	 }else{
		 
	     for(var i = numOp; i > 0; i-- ){
		   
		   if(objSelect.options[i].value != 'NULL'){
			 objSelect.options[i].selected = false;
		   }else{
			   objSelect.options[i].selected = true;
			 } 
		   
	     } 		 
		 
	  }

  });   
   
   
  $("#opciones_estado").click(function(){

     if(this.checked){
	   this.value = 'T';	 
	 }else{
		  this.value = 'U';
	   }
	   
     var objSelect = document.getElementById('estado'); 
	 var numOp     = objSelect.options.length -1;
	   
     if(this.value == 'T'){
	   
	   for(var i = numOp; i > 0; i-- ){
		   
		  if(objSelect.options[i].value != 'NULL'){
			 objSelect.options[i].selected = true;
		  }else{
			   objSelect.options[i].selected = false;
			} 
		   
	   }
		 		 
	 }else{
		 
	     for(var i = numOp; i > 0; i-- ){
		   
		   if(objSelect.options[i].value != 'NULL'){
			 objSelect.options[i].selected = false;
		   }else{
			   objSelect.options[i].selected = true;
			 } 
		   
	     } 		 
		 
	  }

  });      
						   
   $("#listar").click(function(){			
	  document.getElementById('frameResult').src = "reporteAprobacionDespachosClass.php?ACTIONCONTROLER=generateReport&"+Math.random()+FormSerialize(this.form);								
   });
   
   $("#generar").click(function(){			
	  document.location.href = "reporteAprobacionDespachosClass.php?ACTIONCONTROLER=generateFile&"+Math.random()+FormSerialize(this.form);								
   });   
						   
});