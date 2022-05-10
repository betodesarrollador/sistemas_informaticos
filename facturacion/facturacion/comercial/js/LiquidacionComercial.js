function cliente_si(){
	if($('#si_cliente').val()==1){
		
		  if($('#cliente'))    $('#cliente').attr("disabled","");
	
	}else if($('#si_cliente').val()=='ALL'){
		
		  if($('#cliente'))    $('#cliente').attr("disabled","true");
		  $('#cliente').val('');
		  $('#cliente_id').val('');
	}
}

function comercial_si(){
	if($('#si_comercial').val()==1){
		
		  if($('#comercial'))    $('#comercial').attr("disabled","");
	
	}else if($('#si_comercial').val()=='ALL'){
		
		  if($('#comercial'))    $('#comercial').attr("disabled","true");
		  $('#comercial').val('');
		  $('#comercial_id').val('');
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



function OnclickLiquidar(){
	window.frames[0].saveDetallesLiquidacion();
	
}

function descargarexcel(formulario){
	
	if(ValidaRequeridos(formulario)){
		 var QueryString = "DetallesLiquidacionClass.php?download=true&"+FormSerialize(formulario);
		 $("#frameReporte").attr("src",QueryString);
		
	}
}


function OnclickGenerar(formulario){
	
	
	if(ValidaRequeridos(formulario)){
		 var QueryString = "DetallesLiquidacionClass.php?"+FormSerialize(formulario);
		 $("#frameReporte").attr("src",QueryString);
		 showDivLoading();	 	   
		 $("#frameReporte").load(function(response){removeDivLoading();});		
	}
	

}

$(document).ready(function(){

 $("#generar_excel").click(function(){

     var formulario = this.form;

    if(ValidaRequeridos(formulario)){
		 var QueryString = "DetallesLiquidacionClass.php?"+FormSerialize(formulario)+"&download=true";
		 $("#frameReporte").attr("src",QueryString);
		 showDivLoading();	 	   
		 $("#frameReporte").load(function(response){removeDivLoading();});		
	}
	
			
   });	
  });

function beforePrint(formulario){
 
   if(ValidaRequeridos(formulario)){
     var QueryString = "DetallesLiquidacionClass.php?"+FormSerialize(formulario);
  popPup(QueryString,'Impresion Reporte',800,600);
    
   }
}