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

function all_traza(){
	if(document.getElementById('all_trazabilidad').checked==true){
		$('#all_trazabilidad').val('SI');

		var objSelect = document.getElementById('trazabilidad_id'); 
		var numOp     = objSelect.options.length -1;	   
	   
	   for(var i = numOp; i > 0; i-- ){
		   
		  if(objSelect.options[i].value != 'NULL'){
			 objSelect.options[i].selected = true;
		  }else{
			   objSelect.options[i].selected = false;
			} 		   
	   }

	}else{
		$('#all_trazabilidad').val('NO');
		var objSelect = document.getElementById('trazabilidad_id'); 
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
		 var QueryString = "DetallesTrazabilidadClass.php?"+FormSerialize(formulario);
		 $("#frameReporte").attr("src",QueryString);
		 showDivLoading();	 	   
		 $("#frameReporte").load(function(response){removeDivLoading();});		
	}	
	
 $("#generar_excel").click(function(){

     var formulario = this.form;

     if(ValidaRequeridos(formulario)){
	 
       var desde			 = $("#desde").val();
	   var hasta			 = $("#hasta").val();
	   var all_oficina		 = $("#all_oficina").val();
       var oficina_id		 = $("#oficina_id").val();
	   var si_cliente 		 = $("#si_cliente").val();	 
	   var cliente_id 		 = $("#cliente_id").val();
	   var all_estado 		 = $("#all_estado").val();	 
	   var estado_id 		 = $("#estado_id").val();	
	   var all_trazabilidad  = $("#all_trazabilidad").val();	 
	   var trazabilidad_id   = $("#trazabilidad_id").val();	   
	   
       var QueryString = "reporteTrazabilidadClass.php?ACTIONCONTROLER=generateFileexcel&desde="+desde+"&hasta="+hasta+"&oficina_id="+oficina_id+
	                     "&cliente_id="+cliente_id+"&all_oficina="+all_oficina+"&si_cliente="+si_cliente+"&trazabilidad_id="+trazabilidad_id+
						 "&all_trazabilidad="+all_trazabilidad+"&estado_id="+estado_id+"&all_estado="+all_estado+"&rand="+Math.random();
						 
	   document.location.href = QueryString;	
	 }								
   });		
	
}

$(document).keypress(function(e){
	if(e.which == 13){
		var form = document.forms[0];
		OnclickGenerar(form);
	}
});