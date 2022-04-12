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
			
	var remesa_id     = obj.value;
	var manifiesto_id = $("#manifiesto_id").val();
	
	var QueryString = "ACTIONCONTROLER=onclickSave&remesa_id="+remesa_id+"&manifiesto_id="+manifiesto_id;
	
	$.ajax({
		url        : "RemesaToMCClass.php?rand="+Math.random(),
		data       : QueryString,
		beforeSend : function(){},
		success    : function(resp){
		
			if(!isNaN(resp)){
				
				$(obj).attr("checked","");
               	$("#refresh_QUERYGRID_RemesaToMC").click();
				
			}else{
				alertJquery(resp);
			}
			
    	parent.loadDetalle();		
			
		}
	});

}