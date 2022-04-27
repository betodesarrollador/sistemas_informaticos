// JavaScript Document
$(document).ready(function(){
	$("#guiar").click(function(){
		saveDetallesDespacho();				 
	 });
});							 
function saveDetallesDespacho(){
	$("input[type=checkbox]:checked").each(function(){														
		saveDetalleDespacho(this);	
	});	
}

function saveDetalleDespacho(obj){	
	clearFind();	
	var guia_id     = obj.value;
	var cierre_crm_id = $("#cierre_crm_id").val();	
	var QueryString = "ACTIONCONTROLER=onclickSave&guia_id="+guia_id+"&cierre_crm_id="+cierre_crm_id;	
	$.ajax({
		url        : "SolicCierreToGuiaClass.php?rand="+Math.random(),
		data       : QueryString,
		beforeSend : function(){},
		success    : function(resp){		
			if(!isNaN(resp)){		
				$(obj).attr("checked","");
               	$("#refresh_QUERYGRID_DetallesGuiaToMC").click();				
			}else{
				alertJquery(resp);
			}			
    	parent.parent.loadDetalle();				
		}
	});	
}