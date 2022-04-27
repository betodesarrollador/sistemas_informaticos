$(document).ready(function(){
    var remitente_id=$("#remitente_id").val();
	var destinatario_id=$("#destinatario_id").val();
	if(parseInt(remitente_id)>0){
		$('#si_remitente').attr("disabled","true");
		$('#si_remitente').val('1');
	}
	if(parseInt(destinatario_id)>0){
		$('#si_destinatario').attr("disabled","true");
		$('#si_destinatario').val('1');
	}
  	$("#desde").change(function(){

	  	var fechah = $("#hasta").val();
	  	var fechad = $("#desde").val();
	  	var today = new Date();

	  	if ((Date.parse(fechah) < Date.parse(fechad)) || (Date.parse(fechad)>today)) {
	  		alertJquery('Esta fecha no puede ser mayor a la fecha final o mayor a hoy');
	  		return this.value = $("#hasta").val();
	  	};

	});

	$("#hasta").change(function(){

	  	var fechah = $("#hasta").val();
	  	var fechad = $("#desde").val();
	  	var today = new Date();

	  	if ((Date.parse(fechah) < Date.parse(fechad)) || (Date.parse(fechah)>today)) {
	  		alertJquery('Esta fecha no puede ser menor a la fecha de inicio o mayor a hoy');
	  		return this.value = $("#desde").val();
	  	};
	});

});

$(document).keypress(function(e){
	if(e.which == 13){
		var form = document.forms[0];
		OnclickGenerar(form);
	}
});



function Remitente_si(){
	if($('#si_remitente').val()==1){
		
		  if($('#remitente'))    $('#remitente').attr("disabled","");
	
	}else if($('#si_remitente').val()=='ALL'){
		
		  if($('#remitente'))    $('#remitente').attr("disabled","true");
		  $('#remitente').val('');
		  $('#remitente_id').val('');
	}

}

function Destinatario_si(){
	if($('#si_destinatario').val()==1){
		
		  if($('#destinatario'))    $('#destinatario').attr("disabled","");
	
	}else if($('#si_destinatario').val()=='ALL'){
		
		  if($('#destinatario'))    $('#destinatario').attr("disabled","true");
		  $('#destinatario').val('');
		  $('#destinatario_id').val('');
	}

}

function Usuario_si(){
	if($('#si_usuario').val()==1){
		
		  if($('#usuario'))    $('#usuario').attr("disabled","");
	
	}else if($('#si_usuario').val()=='ALL'){
		
		  if($('#usuario'))    $('#usuario').attr("disabled","true");
		  $('#usuario').val('');
		  $('#usuario_id').val('');
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

function all_servicios(){
	if(document.getElementById('all_servicio').checked==true){
		$('#all_servicio').val('SI');
		
		var objSelect = document.getElementById('tipo_servicio_mensajeria_id'); 
		var numOp     = objSelect.options.length -1;	   

	   for(var i = numOp; i > 0; i-- ){
		   
		  if(objSelect.options[i].value != 'NULL'){
			 objSelect.options[i].selected = true;
		  }else{
			   objSelect.options[i].selected = false;
			} 		   
	   }

	}else{
		$('#all_servicio').val('NO');
		var objSelect = document.getElementById('tipo_servicio_mensajeria_id'); 
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
		 var QueryString = "DetallesReporteGuiasClass.php?"+FormSerialize(formulario);
		 $("#frameReporte").attr("src",QueryString);
		 showDivLoading();
		 $("#frameReporte").load(function(response){removeDivLoading();});
	}
	
}

function OnclickGenerarExcel(formulario){
     if(ValidaRequeridos(formulario)){
	 
		
       var QueryString = "DetallesReporteGuiasClass.php?ACTIONCONTROLER=generateFile&"+FormSerialize(formulario)+"&download=SI&rand="+Math.random();
			 
	   document.location.href = QueryString;

	 }
}

function OnclickGenerarExcelFormato(formulario){
     if(ValidaRequeridos(formulario)){
	 
		
       var QueryString = "DetallesReporteGuiasClass.php?ACTIONCONTROLER=generateFileFormato&"+FormSerialize(formulario)+"&download=SI&rand="+Math.random();
			 
	   document.location.href = QueryString;

	 }
}

function OnclickGenerarExcelFiltrado(formulario){
     if(ValidaRequeridos(formulario)){
	 
		
       var QueryString = "DetallesReporteGuiasClass.php?ACTIONCONTROLER=generateFileFormato1&"+FormSerialize(formulario)+"&download=SI&rand="+Math.random();
			 
	   document.location.href = QueryString;

	 }
}


function OnclickGenerarFotos(formulario){
     if(ValidaRequeridos(formulario)){
	   if($('#si_remitente').val()=='1'){
			
		   var QueryString = "DetallesReporteGuiasClass.php?ACTIONCONTROLER=generateFotos&"+FormSerialize(formulario)+"&download=SI&rand="+Math.random();
				 
		   document.location.href = QueryString;
	   }else{
			alertJquery("Solo se puede Generar un archivo Zip para un solo remitente","Validacion");   
	   }
	 }
}
function beforePrint(formulario){
	
   if(ValidaRequeridos(formulario)){
	 var QueryString = "DetallesReporteGuiasClass.php?"+FormSerialize(formulario);
	 popPup(QueryString,'Impresion Reporte',800,600);
	   
   }
}