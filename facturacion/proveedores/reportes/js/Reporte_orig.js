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

function OnclickGenerar(formulario){
	
	if(ValidaRequeridos(formulario)){
		 var QueryString = "DetallesClass.php?"+FormSerialize(formulario);
		 $("#frameReporte").attr("src",QueryString);
		 showDivLoading();	 	   
		 $("#frameReporte").load(function(response){removeDivLoading();});
		
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
	   var si_proveedor = $("#si_proveedor").val();	 
	   var proveedor_id = $("#proveedor_id").val();	 	
	   var saldos = $("#saldos").val();	 	
	   
	   var QueryString = "ReportesClass.php?ACTIONCONTROLER=generateFileexcel&desde="+desde+"&hasta="+hasta+"&tipo="+tipo+"&oficina_id="+oficina_id+
						 "&proveedor_id="+proveedor_id+"&all_ofice="+all_ofice+"&si_proveedor="+si_proveedor+"&saldos="+saldos+"&rand="+Math.random();
						 
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

function beforePrint(formulario){
 
   if(ValidaRequeridos(formulario)){
     var QueryString = "DetallesClass.php?"+FormSerialize(formulario);
  popPup(QueryString,'Impresion Reporte',800,600);
    
   }
}
