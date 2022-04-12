function setDataFormWithResponse(tabla_impuestos_id){
		
	var parametros  = new Array({campos:"tabla_impuestos_id",valores:""+tabla_impuestos_id+""});
	var forma       = document.forms[0];
	var controlador = 'TablaImpuestosClass.php';
	
	FindRow(parametros,forma,controlador,null,function(resp){
		
		if($('#guardar')) $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#borrar'))     $('#borrar').attr("disabled","");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");
		
		
	});
}


function TablaImpuestosOnSaveUpdate(formulario,resp){
	
			Reset(formulario);
			clearFind();
			$("#refresh_QUERYGRID_TablaImpuestos").click();
			if($('#guardar'))    $('#guardar').attr("disabled","");
			if($('#actualizar')) $('#actualizar').attr("disabled","true");
			if($('#borrar'))     $('#borrar').attr("disabled","true");
			if($('#limpiar'))    $('#limpiar').attr("disabled","");
			
			alertJquery(resp);					
}


function TablaImpuestosOnDelete(formulario,resp){
	
			Reset(formulario);
			clearFind();
			$("#refresh_QUERYGRID_TablaImpuestos").click();
			if($('#guardar'))    $('#guardar').attr("disabled","");
			if($('#actualizar')) $('#actualizar').attr("disabled","true");
			if($('#borrar'))     $('#borrar').attr("disabled","true");
			if($('#limpiar'))    $('#limpiar').attr("disabled","");
			
			alertJquery(resp);				
	
}


function TablaImpuestosOnReset(){
	clearFind();
	$('#guardar').attr("disabled","");
	$('#actualizar').attr("disabled","true");
	$('#borrar').attr("disabled","true");
	$('#limpiar').attr("disabled","");
}

function setNombreImpuesto(){
	
  $("#impuesto_id").change(function(){
								   
    var lista = document.getElementById('impuesto_id');
	
	for(var i = 0; i < lista.options.length; i++){
		
		
		if(lista[i].value == this.value){
			
			document.getElementById('nombre').value = lista[i].text;
			
		}
		
		
	}
								   
  });	
	
}

function habilitaImpuestoBase(){
	
	$("#base").change(function(){
							   
		if(this.value == 'NULL' || this.value == 'F'){
          document.getElementById('base_impuesto_id').value    = 'NULL';			
		  document.getElementById('base_impuesto_id').disabled = true;
		}else{
			document.getElementById('base_impuesto_id').disabled = false;
		  }
							   
    });
	
}

function habilitaRteIca(){
	
	$("#rte").change(function(){
							   
		if(this.value == '1' || this.value == 'SI'){
          document.getElementById('ica').value  = '0';			
		  document.getElementById('ica').disabled = true;
		}else{
			document.getElementById('ica').disabled = false;
		  }
							   
    });

    	$("#ica").change(function(){
							   
		if(this.value == '1' || this.value == 'SI'){
          document.getElementById('rte').value    = '0';			
		  document.getElementById('rte').disabled = true;
		}else{
			document.getElementById('rte').disabled = false;
		  }
							   
    });
	
}

//eventos asignados a los objetos
$(document).ready(function(){
	
    setNombreImpuesto();
	habilitaImpuestoBase();
	habilitaRteIca();

	
});