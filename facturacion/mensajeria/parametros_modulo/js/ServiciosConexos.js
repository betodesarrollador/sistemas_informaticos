// JavaScript Document
//funcion para cargar los datos desde BUSCAR
function setDataFormWithResponse(){
		
	var parametros  = new Array({campos:"servi_conex_id",valores:$('#servi_conex_id').val()});
	var forma       = document.forms[0];
	var controlador = 'ServiciosConexosClass.php';
	
	FindRow(parametros,forma,controlador,null,function(resp){
													   
		if($('#guardar')) $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#borrar'))     $('#borrar').attr("disabled","");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");
  
	});
}


function ServiciosConexosOnSaveUpdate(formulario,resp){
	Reset(formulario);  
	clearFind();
    $("#refresh_QUERYGRID_ServiciosConexos").click();
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
	alertJquery($.trim(resp));
}


function ServiciosConexosOnDelete(formulario,resp){
	Reset(formulario);
	clearFind();
	$("#refresh_QUERYGRID_ServiciosConexos").click();
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
	alertJquery($.trim(resp));
}

function ServiciosConexosOnReset(){
	clearFind();
	$('#guardar').attr("disabled","");
	$('#actualizar').attr("disabled","true");
	$('#borrar').attr("disabled","true");
	$('#limpiar').attr("disabled","");
}


//eventos asignados a los objetos
$(document).ready(function(){
	
});