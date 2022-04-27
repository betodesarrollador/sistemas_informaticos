// JavaScript Document
//funcion para cargar los datos desde BUSCAR
function setDataFormWithResponse(){
		
	var parametros  = new Array({campos:"novedad_rm_id",valores:$('#novedad_rm_id').val()});
	var forma       = document.forms[0];
	var controlador = 'NovedadRemesaClass.php';
	
	FindRow(parametros,forma,controlador,null,function(resp){
													   
		if($('#guardar')) $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#borrar'))     $('#borrar').attr("disabled","");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");
  
	});
}


function NovedadRemesaOnSaveUpdate(formulario,resp){
	Reset(formulario);  
	clearFind();
    $("#refresh_QUERYGRID_NovedadRemesa").click();
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
	alertJquery($.trim(resp));
}


function NovedadRemesaOnDelete(formulario,resp){
	Reset(formulario);
	clearFind();
	$("#refresh_QUERYGRID_NovedadRemesa").click();
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
	alertJquery($.trim(resp));
}

function NovedadRemesaOnReset(){
	clearFind();
	$('#guardar').attr("disabled","");
	$('#actualizar').attr("disabled","true");
	$('#borrar').attr("disabled","true");
	$('#limpiar').attr("disabled","");
}


//eventos asignados a los objetos
$(document).ready(function(){
	
});