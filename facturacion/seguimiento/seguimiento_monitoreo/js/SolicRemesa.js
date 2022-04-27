// JavaScript Document
$(document).ready(function(){
	
	$("#adicionar").click(function(){
		setSolicitud();
		
	});

});



function checkRow(obj){
	
	$(obj).attr("checked","true");
 }

function setSolicitud(){
	
	var detalle_seg_id  = $("#detalle_seg_id").val();
	var n = $("input:checked").length;
	var cont =0;
	$(document).find("input[type=checkbox]:checked").each(function(){

		remesa_id= $($(this).parent().parent()).find("input[name=remesa_id]").val();
		observaciones= $($(this).parent().parent()).find("input[name=observaciones]").val();


		if( $('#actualizar',parent.document).length > 0 ){
			
			var QueryString = "ACTIONCONTROLER=onclickSave&detalle_seg_id="+detalle_seg_id+"&remesa_id="+remesa_id+"&observaciones="+observaciones;
			
			$.ajax({
				
				url        : "SolicRemesaClass.php",
				data       : QueryString,
				beforeSend : function(){},
				success    : function(response){
					
					if(!isNaN(response)){
						cont++;
						if(parseInt(cont)==parseInt(n))
						parent.closeDialog();
						
					}else{
						alertJquery(response);
					}
				}
			});
			
		}
	});
	
	
}

