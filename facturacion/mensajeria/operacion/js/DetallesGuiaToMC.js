// JavaScript Document
function saveDetallesDespacho(){
	$("input[type=checkbox]:checked").each(function(){														
		saveDetalleDespacho(this);	
	});	
}

function saveDetalleDespacho(obj){	
	clearFind();	
	var guia_id     = obj.value;
	var manifiesto_id = $("#manifiesto_id").val();	
	var QueryString = "ACTIONCONTROLER=onclickSave&guia_id="+guia_id+"&manifiesto_id="+manifiesto_id;	
	$.ajax({
		url        : "DetallesGuiaToMCClass.php?rand="+Math.random(),
//        url        : "DetallesGuiaToMCClass.php?rand="+Math.random(),
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