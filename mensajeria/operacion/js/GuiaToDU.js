// JavaScript Document
$(document).ready(function(){
	
	$("#despachar").click(function(){
		saveDetallesDespacho();
	});  
});

function saveDetallesDespacho(){	
	$("input[type=checkbox]:checked").each(function(){	
		saveDetalleDespacho(this);	
	});	
}

function saveDetalleDespacho(obj){	
	var guia_id          = obj.value;
	var despachos_urbanos_id = $("#despachos_urbanos_id").val();	
	var QueryString = "ACTIONCONTROLER=onclickSave&guia_id="+guia_id+"&despachos_urbanos_id="+despachos_urbanos_id;
	
	$.ajax({
		url        : "GuiaToDUClass.php",
		data       : QueryString,
		beforeSend : function(){},
		success    : function(resp){
		
			if(!isNaN(resp)){
				
				$(obj).attr("checked","");
				$("#refresh_QUERYGRID_GuiaToDU").click();
				
			}else{
				alertJquery(resp);
			}
			parent.loadDetalle();	
		}
	});
}