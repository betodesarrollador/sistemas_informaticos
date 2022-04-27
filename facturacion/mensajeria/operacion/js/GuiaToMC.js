// JavaScript Document
$(document).ready(function(){
	var manifiesto_id = $("#manifiesto_id").val();						   
	var QueryString = "DetallesGuiaToMCClass.php?manifiesto_id="+manifiesto_id;
	$("#frameReporte").attr("src",QueryString);		   
						   
	$("#despachar").click(function(){
		window.frames[0].saveDetallesDespacho();		
	}); 
});

function OnclickGenerar(formulario){	
	if(ValidaRequeridos(formulario)){
		 var QueryString = "DetallesGuiaToMCClass.php?"+FormSerialize(formulario);
		 $("#frameReporte").attr("src",QueryString);
		 showDivLoading();	 	   
		 $("#frameReporte").load(function(response){removeDivLoading();});		
	}	
}