// JavaScript Document
var value='NULL'
//funcion para cargar los datos desde BUSCAR
function setDataFormWithResponse(){
	
	var parametros  = new Array({campos:"descuento_id",valores:$('#descuento_id').val()});
	var forma       = document.forms[0];
	var controlador = 'TablaDescuentosClass.php';
	FindRow(parametros,forma,controlador,null,function(resp){
		
		if($('#guardar')) $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#borrar'))     $('#borrar').attr("disabled","");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");

		
	});
}


function TablaDescuentosOnSaveUpdate(formulario,resp){	

    alertJquery(resp);
	
	Reset(formulario);
	clearFind();
	$("#refresh_QUERYGRID_TablaDescuentos").click();	

	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
}


function TablaDescuentosOnDelete(formulario,resp){	

    alertJquery(resp);

	Reset(formulario);
	clearFind();
	$("#refresh_QUERYGRID_TablaDescuentos").click();
	
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
}


function TablaDescuentosOnReset(formulario){
	
	clearFind();
	Reset(formulario);
	$("#refresh_QUERYGRID_TablaDescuentos").click();	
	
	$('#guardar').attr("disabled","");
	$('#actualizar').attr("disabled","true");
	$('#borrar').attr("disabled","true");
	$('#limpiar').attr("disabled","");
}

//eventos asignados a los objetos
$(document).ready(function(){		
	
   $("#calculo").change(function(){
								 
      if(this.value == 'NULL' || this.value == 'A'){
		  
		document.getElementById('porcentaje').value    = '';
		document.getElementById('porcentaje').disabled = true;
		  
	  }else{
		  
		  document.getElementById('porcentaje').value    = '';
		  document.getElementById('porcentaje').disabled = false;		  
		  
		}							 
								 
   });
	
});