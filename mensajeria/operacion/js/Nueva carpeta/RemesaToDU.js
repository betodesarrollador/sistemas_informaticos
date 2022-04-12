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
	
	var remesa_id          = obj.value;
	var despachos_urbanos_id = $("#despachos_urbanos_id").val();
	
	var QueryString = "ACTIONCONTROLER=onclickSave&remesa_id="+remesa_id+"&despachos_urbanos_id="+despachos_urbanos_id;
	
	$.ajax({
		url        : "RemesaToDUClass.php",
		data       : QueryString,
		beforeSend : function(){},
		success    : function(resp){
		
			if(!isNaN(resp)){
				
				$(obj).attr("checked","");
				$("#refresh_QUERYGRID_RemesaToDU").click();
				
			}else{
				alertJquery(resp);
			}
			parent.loadDetalle();	
		}
	});

}