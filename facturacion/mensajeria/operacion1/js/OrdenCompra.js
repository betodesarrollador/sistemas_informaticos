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
		
	var parametros  = new Array({campos:"ordencompra_id",valores:$('#ordencompra_id').val()});
	var forma       = document.forms[0];
	var controlador = 'OrdenCompraClass.php';
	
	FindRow(parametros,forma,controlador,null,function(resp){
													   
		if($('#guardar'))    $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#borrar'))     $('#borrar').attr("disabled","");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");
		
		loadDetalle();
		
	});
}


function OrdenCompraOnSave(formulario,resp){
	
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


function OrdenCompraOnUpdate(formulario,resp){
	updateGrid();
}


function OrdenCompraOnDelete(formulario,resp){
	OrdenCompraOnReset();
	Reset(formulario);
	clearFind();
	updateGrid();
	alertJquery(resp);
}


function OrdenCompraOnReset(){
	
	clearFind();
	
	$("#detalleOrdenCompra").attr("src","/velotax/framework/tpl/blank.html");
	
	$('#guardar').attr("disabled","");
	$('#actualizar').attr("disabled","true");
	$('#borrar').attr("disabled","true");
	$('#limpiar').attr("disabled","");
	
}


function loadDetalle(){
	
	var ordencompra_id = $('#ordencompra_id').val();
	var url            = "DetalleOrdenCompraClass.php?ordencompra_id="+ordencompra_id;
	$("#detalleOrdenCompra").attr("src",url);
	
}


function getProveedor(){
	
	var tercero_id   = $("#tercero_hidden").val();
	var QueryString = "ACTIONCONTROLER=getProveedor&tercero_id=" + $.trim(tercero_id);
	
	$.ajax({
		url     : "OrdenCompraClass.php",
		data    : QueryString,
		success : function(resp){
			resp = $.parseJSON(resp);
			setFormWithJSON(document.forms[0],resp,'true');
		}
	});
}


function updateGrid(){
	$("#refresh_QUERYGRID_OrdenCompra").click();
}