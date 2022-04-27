$(document).ready(function(){
						   
   	///INICIO VALIDACION FECHAS DE REPORTE
	
  	$('#desde').change(function(){

	  	var fechah = $('#hasta').val();
	  	var fechad = $('#desde').val();
	  	var today = new Date();

	  	if ((Date.parse(fechah) < Date.parse(fechad)) || (Date.parse(fechad)>today)) {
	  		alertJquery('Esta fecha no puede ser mayor a la fecha final o mayor a hoy.');
	  		return this.value = $('#hasta').val();
	  	};
	});

	$('#hasta').change(function(){

	  	var fechah = $('#hasta').val();
	  	var fechad = $('#desde').val();
	  	var today = new Date();

	  	if ((Date.parse(fechah) < Date.parse(fechad)) || (Date.parse(fechah)>today)) {
	  		alertJquery('Esta fecha no puede ser menor a la fecha de inicio o mayor a hoy.');
	  		return this.value = $('#desde').val();
	  	};
	});
	
	///FIN VALIDACION FECHAS DE REPORTE

});	

function Cliente_si(){
	if($('#si_cliente').val()==1){
		
		  if($('#cliente'))    $('#cliente').attr("disabled","");
	
	}else if($('#si_cliente').val()=='ALL'){
		
		  if($('#cliente'))    $('#cliente').attr("disabled","true");
		  $('#cliente').val('');
		  $('#cliente_id').val('');
	}

}

function all_oficce(){
	if(document.getElementById('all_oficina').checked==true){
		$('#all_oficina').val('SI');

		var objSelect = document.getElementById('oficina_id'); 
		var numOp     = objSelect.options.length -1;
	   
	   
	   for(var i = numOp; i > 0; i-- ){
		   
		  if(objSelect.options[i].value != 'NULL'){
			 objSelect.options[i].selected = true;
		  }else{
			   objSelect.options[i].selected = false;
			} 		   
	   }

	}else{
		$('#all_oficina').val('NO');
		var objSelect = document.getElementById('oficina_id'); 
		var numOp     = objSelect.options.length -1;
		 
	     for(var i = numOp; i > 0; i-- ){
		   
		   if(objSelect.options[i].value != 'NULL'){
			 objSelect.options[i].selected = false;
		   }else{
			   objSelect.options[i].selected = true;
			 } 		   
	     } 	
	}	
}

function all_estados(){
	if(document.getElementById('all_estado').checked==true){
		$('#all_estado').val('SI');
		
		var objSelect = document.getElementById('estado_id'); 
		var numOp     = objSelect.options.length -1;	   

	   for(var i = numOp; i > 0; i-- ){
		   
		  if(objSelect.options[i].value != 'NULL'){
			 objSelect.options[i].selected = true;
		  }else{
			   objSelect.options[i].selected = false;
			} 		   
	   }

	}else{
		$('#all_estado').val('NO');
		var objSelect = document.getElementById('estado_id'); 
		var numOp     = objSelect.options.length -1;
		 
	     for(var i = numOp; i > 0; i-- ){
		   
		   if(objSelect.options[i].value != 'NULL'){
			 objSelect.options[i].selected = false;
		   }else{
			   objSelect.options[i].selected = true;
			 } 		   
	     } 	
	}	
}

function all_clases(){
	if(document.getElementById('all_clase').checked==true){
		$('#all_clase').val('SI');
		
		var objSelect = document.getElementById('clase_id'); 
		var numOp     = objSelect.options.length -1;	   

	   for(var i = numOp; i > 0; i-- ){
		   
		  if(objSelect.options[i].value != 'NULL'){
			 objSelect.options[i].selected = true;
		  }else{
			   objSelect.options[i].selected = false;
			} 		   
	   }

	}else{
		$('#all_clase').val('NO');
		var objSelect = document.getElementById('clase_id'); 
		var numOp     = objSelect.options.length -1;
		 
	     for(var i = numOp; i > 0; i-- ){
		   
		   if(objSelect.options[i].value != 'NULL'){
			 objSelect.options[i].selected = false;
		   }else{
			   objSelect.options[i].selected = true;
			 } 		   
	     } 	
	}	
}

function OnclickGenerar(formulario){
	
	if(ValidaRequeridos(formulario)){
		 var QueryString = "DetallesRemesasClass.php?"+FormSerialize(formulario);
		 $("#frameReporte").attr("src",QueryString);
		 showDivLoading();	 	   
		 $("#frameReporte").load(function(response){removeDivLoading();});
	}
	
}

function OnclickGenerarExcel(formulario){
     if(ValidaRequeridos(formulario)){
	 
       var desde = $("#desde").val();
	   var hasta = $("#hasta").val();
	   var oficina_id = $("#oficina_id").val();
	   var estado_id = $("#estado_id").val();	
	   var clase_id = $("#clase_id").val();		   
	   var si_cliente = $("#si_cliente").val();	 
	   var all_oficina = $("#all_oficina").val();	 
	   var all_estado = $("#all_estado").val();
	   var all_clase = $("#all_clase").val();	   
       var cliente_id = $("#cliente_id").val();	
		
       var QueryString = "reporteRemesasClass.php?ACTIONCONTROLER=generateFile&desde="+desde+"&hasta="+hasta+"&oficina_id="+oficina_id+"&download=SI"
	   +"&estado_id="+estado_id+"&si_cliente="+si_cliente+"&all_oficina="+all_oficina+"&all_estado="+all_estado+"&cliente_id="+cliente_id
	   +"&clase_id="+clase_id+"&all_clase="+all_clase+"&rand="+Math.random();
			 
	   document.location.href = QueryString;

	 }
}
function beforePrint(formulario){
		if(ValidaRequeridos(formulario)){
			var QueryString = "reporteRemesasClass.php?ACTIONCONTROLER=onclickGenerar&"+FormSerialize(formulario);
			popPup(QueryString,'Impresion Reporte',800,600);
		}
	}
	
