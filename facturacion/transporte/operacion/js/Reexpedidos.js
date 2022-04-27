// JavaScript Document
//eventos asignados a los objetos
$(document).ready(function(){
	
});

//funcion para cargar los datos desde BUSCAR
function setDataFormWithResponse(){	
	
	var parametros 	= new Array ({campos:"reexpedido_id", valores:$('#reexpedido_id').val()});
	var forma 		= document.forms[0];
	var controlador = 'ReexpedidosClass.php';
	
	FindRow(parametros,forma,controlador,null,function(resp){
		
		if($('#guardar'))    $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#borrar'))     $('#borrar').attr("disabled","");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");
		
	});
}


function ReexpedidosOnSave(formulario,resp){
	
	updateGrid();
	
	if($('#guardar'))    $('#guardar').attr("disabled","true");
	if($('#actualizar')) $('#actualizar').attr("disabled","");
	if($('#borrar'))     $('#borrar').attr("disabled","");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
	
	resp = $.parseJSON(resp);
	
	if($.isArray(resp)){
		
		$("#reexpedido_id").val(resp[0]['reexpedido_id']);
		$("#reexpedido").val(resp[0]['reexpedido']);
		
	}else{
		alertJquery("Ocurrio una inconsistencia : "+resp);
	}
}

function ReexpedidosOnUpdate(formulario,resp){
	
	updateGrid()
	
	if($.trim(resp) == 'true'){
		
		alertJquery("Se Actualizo de Forma Exitosa");
		Reset(formulario);
		ReexpedidosOnReset();
	
	}else{
		alertJquery(resp);
	}

}


function ReexpedidosOnDelete(formulario,resp){
   Reset(document.getElementById('ReexpedidosForm'));
   $("#refresh_QUERYGRID_Reexpedidos").click();   
   	alert(resp);  
}

function ReexpedidosOnReset(){
	
	clearFind();
	
	$('#guardar').attr("disabled","");
	$('#actualizar').attr("disabled","true");
	$('#borrar').attr("disabled","true");
	$('#limpiar').attr("disabled","true");
	
}

function updateGrid(){
	$("#refresh_QUERYGRID_Reexpedidos").click();
}
