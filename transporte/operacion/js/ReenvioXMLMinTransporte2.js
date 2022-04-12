// JavaScript Document

$(document).ready(function(){

  $("#message").dialog();					   
						   
});

function deshabilitaBoton(formulario){
	
	var btnEnviar      = formulario.enviar;		
	var reconstruir    = formulario.reconstruir;		
	var reconstruirXML = $(btnEnviar.parentNode.parentNode.parentNode).find("input[name=reconstruirXML]").attr("checked");	
	
	$("input[name=enviar]").attr("disabled","true");

	reconstruir.value  = reconstruirXML;
		
	return true;
	
}