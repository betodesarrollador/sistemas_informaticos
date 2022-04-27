// JavaScript Document
$(document).ready(function(){
	var reexpedido_id = $("#reexpedido_id").val();						   
	var QueryString = "DetallesGuiaToREClass.php?reexpedido_id="+reexpedido_id;
	$("#frameReporte").attr("src",QueryString);		   
						   
	$("#despachar").click(function(){
		window.frames[0].saveDetallesReexpedido();		
	}); 
});

function OnclickGenerar(formulario){	
	if(ValidaRequeridos(formulario)){
		 var QueryString = "DetallesGuiaToREClass.php?"+FormSerialize(formulario);
		 $("#frameReporte").attr("src",QueryString);
		 showDivLoading();	 	   
		 $("#frameReporte").load(function(response){
		   removeDivLoading();
		   });		
	}	
}