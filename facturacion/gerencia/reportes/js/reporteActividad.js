function Cliente_si(){
	if($('#si_cliente').val()==1){
		
		  if($('#cliente'))    $('#cliente').attr("disabled","");
	
	}else if($('#si_cliente').val()=='ALL'){
		
		  if($('#cliente'))    $('#cliente').attr("disabled","true");
		  $('#cliente').val('');
		  $('#cliente_id').val('');
	}

}

$(document).ready(function(){

	$("#generar_excel").click(function(){
	
	 var formulario = this.form;
	
	 if(ValidaRequeridos(formulario)){
	 
	   var desde = $("#desde").val();
	   var hasta = $("#hasta").val();
	   var tipo = $("#tipo").val();
	   var oficina_id = $("#oficina_id").val();
	   var all_ofice = $("#all_ofice").val();
	   var si_cliente = $("#si_cliente").val();	 
	   var cliente_id = $("#cliente_id").val();	 	
	   var saldos = $("#saldos").val();	 	
	   
	   var QueryString = "reporteCuentasFPClass.php?ACTIONCONTROLER=generateFileexcel&desde="+desde+"&hasta="+hasta+"&tipo="+tipo+"&oficina_id="+oficina_id+
						 "&cliente_id="+cliente_id+"&all_ofice="+all_ofice+"&si_cliente="+si_cliente+"&saldos="+saldos+"&rand="+Math.random();
						 
	   document.location.href = QueryString;						 
	
	 }								
	});	
});

function descargarexcel(formulario){
	
	if(ValidaRequeridos(formulario)){
		 var QueryString = "DetallesClass.php?download=true&"+FormSerialize(formulario);
		 $("#frameReporte").attr("src",QueryString);
		
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

function OnclickGenerar(formulario){
	
	if(ValidaRequeridos(formulario)){
		 var QueryString = "DetallesActividadClass.php?"+FormSerialize(formulario);
		 $("#frameReporte").attr("src",QueryString);
		 showDivLoading();	 	   
		 $("#frameReporte").load(function(response){removeDivLoading();});
		
	}
	
}