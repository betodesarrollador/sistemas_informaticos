$(document).ready(function(){
						   
	///INICIO VALIDACION FECHAS DE REPORTE
						   
  	$('#desde').change(function(){

	  	var fechah = $('#hasta').val();
	  	var fechad = $('#desde').val();
	  	var today = new Date();

	  	if ((Date.parse(fechah) < Date.parse(fechad)) || (Date.parse(fechad)>today)) {
	  		alertJquery('Esta fecha no puede ser mayor a la fecha final o mayor a hoy');
	  		return this.value = $('#hasta').val();
	  	};
	});

	$('#hasta').change(function(){

	  	var fechah = $('#hasta').val();
	  	var fechad = $('#desde').val();
	  	var today = new Date();

	  	if ((Date.parse(fechah) < Date.parse(fechad)) || (Date.parse(fechah)>today)) {
	  		alertJquery('Esta fecha no puede ser menor a la fecha de inicio o mayor a hoy');
	  		return this.value = $('#desde').val();
	  	};
	});
	
	///FIN VALIDACION FECHAS DE REPORTE
	
	if (document.getElementById('transito_display')) {
		document.getElementById('transito_display').style.display="none";
	};
	if (document.getElementById('entregado_display')) {
		document.getElementById('entregado_display').style.display="none";
	};
	if (document.getElementById('devuelto_display')) {
		document.getElementById('devuelto_display').style.display="none";
	};
	
	$('#abrir_transito').click(function(){
		document.getElementById('abrir_transito').style.display="none";
		document.getElementById('cerrar_transito').style.display="block";

		document.getElementById('transito_display').style.display="block";				
						
	});	
	$('#cerrar_transito').click(function(){
		document.getElementById('abrir_transito').style.display="block";
		document.getElementById('cerrar_transito').style.display="none";

		document.getElementById('transito_display').style.display="none";				
						
	});	
	$('#abrir_entregado').click(function(){
		document.getElementById('abrir_entregado').style.display="none";
		document.getElementById('cerrar_entregado').style.display="block";

		document.getElementById('entregado_display').style.display="block";				
						
	});	
	$('#cerrar_entregado').click(function(){
		document.getElementById('abrir_entregado').style.display="block";
		document.getElementById('cerrar_entregado').style.display="none";

		document.getElementById('entregado_display').style.display="none";				
						
	});	
	$('#abrir_devuelto').click(function(){
		document.getElementById('abrir_devuelto').style.display="none";
		document.getElementById('cerrar_devuelto').style.display="block";

		document.getElementById('devuelto_display').style.display="block";				
						
	});	
	$('#cerrar_devuelto').click(function(){
		document.getElementById('abrir_devuelto').style.display="block";
		document.getElementById('cerrar_devuelto').style.display="none";

		document.getElementById('devuelto_display').style.display="none";				
						
	});	

});

$(document).keypress(function(e){
	if(e.which == 13){
		var form = document.forms[0];
		OnclickGenerar(form);
	}
});

function sologuia(){

	if ($('#allguia').val()=='S'){

		$('#guia_id').attr('disabled','');
		$("#desde,#hasta,#origen_id,#destino_id,#oficina_id,#estado_id,#reexpedido").val('');
		$("#allreexpedido").val('N');
		$('#desde,#hasta,#estado_id,#all_estado,#all_oficina,#all_servicio,#tipo_servicio_mensajeria_id,#si_mensajero,#si_usuario,#oficina_id,#mensajero,#origen,#destino,#allreexpedido,#reexpedido,#consolidado').attr('disabled','true');
		$('#desde,#hasta,#estado_id,#si_usuario,#si_mensajero,#oficina_id,#allreexpedido,#reexpedido,#consolidado,#all_servicio,#tipo_servicio_mensajeria_id').removeClass('obligatorio');
		$('#guia_id').addClass('obligatorio');

	};
	if ($('#allguia').val()=='N'){

		$('#guia_id').attr('disabled','true');
		$("#allreexpedido").val('S');
		$('#allreexpedido,#reexpedido,#consolidado,#all_servicio,#tipo_servicio_mensajeria_id').attr('disabled','');
		$('#reexpedido').addClass('obligatorio');
		$('#guia_id').removeClass('obligatorio');
		$('#guia_id').css('border-color','none');

		$("#guia_id").val('');
	};

}
function soloreexpedido(){

	if ($('#allreexpedido').val()=='S'){

		$('#reexpedido,#consolidado').attr('disabled','');
		$("#desde,#hasta,#origen_id,#destino_id,#oficina_id,#estado_id,#guia_id").val('');
		$('#desde,#hasta,#estado_id,#all_estado,#all_oficina,#si_mensajero,#oficina_id,#mensajero,#origen,#destino,#guia_id,#all_servicio,#tipo_servicio_mensajeria_id').attr('disabled','true');
		$('#desde,#hasta,#estado_id,#si_mensajero,#oficina_id,#allguia,#guia_id,#all_servicio,#tipo_servicio_mensajeria_id').removeClass('obligatorio');
		$('#reexpedido,#consolidado').addClass('obligatorio');

	};
	if ($('#allreexpedido').val()=='N'){

		$('#reexpedido,#guia_id,#consolidado').attr('disabled','true');
		$('#desde,#hasta,#estado_id,#all_estado,#all_oficina,#si_mensajero,#oficina_id,#origen,#destino,#all_servicio,#tipo_servicio_mensajeria_id').attr('disabled','');
		$('#desde,#hasta,#estado_id,#oficina_id,#si_mensajero').addClass('obligatorio');
		$('#reexpedido').removeClass('obligatorio');

		$("#reexpedido").val('');
	};

}


function Mensajero_si(){
	if($('#si_mensajero').val()==1){
		
		  if($('#mensajero'))    $('#mensajero').attr("disabled","");
	
	}else if($('#si_mensajero').val()=='ALL'){
		
		  if($('#mensajero'))    $('#mensajero').attr("disabled","true");
		  $('#mensajero').val('');
		  $('#mensajero_id').val('');
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
		 var QueryString = "ReporteGuiasMensajeroClass.php?ACTIONCONTROLER=generateReport&"+FormSerialize(formulario);
		 $("#frameReporte").attr("src",QueryString);
		 showDivLoading();
		 $("#frameReporte").load(function(response){removeDivLoading();});
	}
	
}

function OnclickGenerarExcel(formulario){
     if(ValidaRequeridos(formulario)){
       var QueryString = "ReporteGuiasMensajeroClass.php?ACTIONCONTROLER=generateReport&download=true&"+FormSerialize(formulario);
	   document.location.href = QueryString;
	}
}

function OnclickGenerarExcelFiltrado(formulario){
     if(ValidaRequeridos(formulario)){
	 
		
       var QueryString = "ReporteGuiasMensajeroClass.php?ACTIONCONTROLER=generateReport&download=true&formato=SI&filtrado=SI&"+FormSerialize(formulario);
			 
	   document.location.href = QueryString;

	 }
}

function beforePrint(formulario){
	
   if(ValidaRequeridos(formulario)){
	 var QueryString = "ReporteGuiasMensajeroClass.php?ACTIONCONTROLER=generateReport&"+FormSerialize(formulario);
	 popPup(QueryString,'Impresion Reporte',800,600);
	   
   }
}