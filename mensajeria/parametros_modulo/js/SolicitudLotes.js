// JavaScript Document
$(document).ready(function(){
	
	
	$("#saveDetalles").click(function(){
		window.frames[0].saveDetalles();
	});
	
	
	$("#deleteDetalles").click(function(){
		window.frames[0].deleteDetalles();
	});

});


function setDataFormWithResponse(){
		
	var parametros  = new Array({campos:"campo_archivo_solicitud_id",valores:$('#campo_archivo_solicitud_id').val()});
	var forma       = document.forms[0];
	var controlador = 'SolicitudLotesClass.php';
	
	FindRow(parametros,forma,controlador,null,function(resp){
													   
		if($('#guardar'))    $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#borrar'))     $('#borrar').attr("disabled","");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");
		
		loadDetalle();
		
	});
}


function SolicitudLotesOnSave(formulario,resp){
	
	updateGrid();
	
	if($('#guardar'))    $('#guardar').attr("disabled","true");
	if($('#actualizar')) $('#actualizar').attr("disabled","");
	if($('#borrar'))     $('#borrar').attr("disabled","");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
	
	resp = $.parseJSON(resp);
	
	if($.isArray(resp)){
		
		setFormWithJSON(formulario,resp,'true');
		loadDetalle();
		
	}else{
		alertJquery("Ocurrio una inconsistencia : "+resp);
	}
}


function SolicitudLotesOnUpdate(formulario,resp){
	updateGrid();
	loadDetalle();
}


function SolicitudLotesOnDelete(formulario,resp){
	SolicitudLotesOnReset();
	Reset(formulario);
	clearFind();
	updateGrid();
	alertJquery(resp);
}


function SolicitudLotesOnReset(){
	
	clearFind();
	
	$("#detalleSolicitudLotes").attr("src","/velotax/framework/tpl/blank.html");
	
	$('#guardar').attr("disabled","");
	$('#actualizar').attr("disabled","true");
	$('#borrar').attr("disabled","true");
	$('#limpiar').attr("disabled","");
	
}


function loadDetalle(){
	
	var campo_archivo_solicitud_id = $('#campo_archivo_solicitud_id').val();
	var url            = "DetalleSolicitudLotesClass.php?campo_archivo_solicitud_id="+campo_archivo_solicitud_id;
	$("#detalleSolicitudLotes").attr("src",url);
	
}


function updateGrid(){
	$("#refresh_QUERYGRID_SolicitudLotes").click();
}