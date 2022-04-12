$(document).ready(function(){
						   
	$("#generar_excel").click(function(){
	
	 var formulario = this.form;
	
	 if(ValidaRequeridos(formulario)){
	 
	   var desde 			= $("#desde").val();
	   var hasta 			= $("#hasta").val();
	   var tipo 			= $("#tipo").val();
	   var oficina_id		= $("#oficina_id").val();
	   var all_ofice 		= $("#all_ofice").val();
	   var puc_id 			= $("#puc_id").val();
	   var all_cta 			= $("#all_cta").val();
	   var tipo_documento_id= $("#tipo_documento_id").val();
	   var all_docs 		= $("#all_docs").val();

	   var si_proveedor 	= $("#si_proveedor").val();	 
	   var proveedor_id 	= $("#proveedor_id").val();	
	   var proveedor 	= $("#proveedor").val();	 	
	   var saldos 			= $("#saldos").val();	 	
	   
	   var QueryString = "ReportesClass.php?ACTIONCONTROLER=generateFileexcel&desde="+desde+"&hasta="+hasta+"&tipo="+tipo+"&oficina_id="+oficina_id+
						 "&proveedor_id="+proveedor_id+"&proveedor="+proveedor+"&all_ofice="+all_ofice+"&puc_id="+puc_id+"&all_cta="+all_cta+"&all_docs="+all_docs+
						 "&tipo_documento_id="+tipo_documento_id+"&si_proveedor="+si_proveedor+"&saldos="+saldos+"&rand="+Math.random();
						 
	   document.location.href = QueryString;						 
	
	 }								
	});	
	
	relacausa();
	
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

function ReporteOnReset(formulario){

	$("#frameReporte").attr("src","/rotterdan/framework/tpl/blank.html");	

}

function Proveedor_si(){
	if($('#si_proveedor').val()==1){
		
		  if($('#proveedor'))    $('#proveedor').attr("disabled","");
	
	}else if($('#si_proveedor').val()=='ALL'){
		
		  if($('#proveedor'))    $('#proveedor').attr("disabled","true");
		  $('#proveedor').val('');
		  $('#proveedor_id').val('');
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

function all_cta(){
	if(document.getElementById('all_ctas').checked==true){
		$('#all_ctas').val('SI');

		var objSelect = document.getElementById('puc_id'); 
		var numOp     = objSelect.options.length -1;
	   
	   
	   for(var i = numOp; i > 0; i-- ){
		   
		  if(objSelect.options[i].value != 'NULL'){
			 objSelect.options[i].selected = true;
		  }else{
			   objSelect.options[i].selected = false;
			} 
		   
	   }
		 		 


	}else{
		$('#all_ctas').val('NO');
		var objSelect = document.getElementById('puc_id'); 
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

function all_doc(){
	if(document.getElementById('all_docs').checked==true){
		$('#all_docs').val('SI');

		var objSelect = document.getElementById('tipo_documento_id'); 
		var numOp     = objSelect.options.length -1;
	   
	   
	   for(var i = numOp; i > 0; i-- ){
		   
		  if(objSelect.options[i].value != 'NULL'){
			 objSelect.options[i].selected = true;
		  }else{
			   objSelect.options[i].selected = false;
			} 
		   
	   }
		 		 


	}else{
		$('#all_docs').val('NO');
		var objSelect = document.getElementById('tipo_documento_id'); 
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

function relacausa(){

  	$('#tipo').change(function(){
		if ($('#tipo').val()=='RC'){
			
			$('#all_docs').attr('disabled','');
			$("#all_ctas").attr('disabled','');
			$("#tipo_documento_id").attr('disabled','');
			$("#puc_id").attr('disabled','');
			$("#si_proveedor").attr('disabled','');
			$('#desde,#hasta,#si_proveedor,#oficina_id').removeClass('obligatorio');
			
		}else{
			
			$('#all_docs').attr('disabled','');
			$("#all_ctas").attr('disabled','');
			$("#tipo_documento_id").attr('disabled','');
			$("#puc_id").attr('disabled','');
			$("#si_proveedor").attr('disabled','');
			$('#desde,#hasta,#si_proveedor,#oficina_id,#all_docs,#all_ctas,#tipo_documento_id,#puc_id').removeClass('obligatorio');

		}
	});

}



function OnclickGenerar(formulario){
	
	if(ValidaRequeridos(formulario)){
		 var QueryString = "DetallesClass.php?"+FormSerialize(formulario);
		 $("#frameReporte").attr("src",QueryString);
		 showDivLoading();	 	   
		 $("#frameReporte").load(function(response){removeDivLoading();});
		
	}
	
}

function descargarexcel(formulario){
	
	if(ValidaRequeridos(formulario)){
		 var QueryString = "DetallesClass.php?download=true&"+FormSerialize(formulario);
		 $("#frameReporte").attr("src",QueryString);
		
	}
}

function beforePrint(formulario){
 
   if(ValidaRequeridos(formulario)){
     var QueryString = "DetallesClass.php?"+FormSerialize(formulario);
  popPup(QueryString,'Impresion Reporte',800,600);
    
   }
}
