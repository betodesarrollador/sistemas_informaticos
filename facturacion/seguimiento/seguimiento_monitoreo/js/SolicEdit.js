// JavaScript Document
$(document).ready(function(){
	
	$("#actualizar").click(function(){
		setSolicitud();
		
	});

});



function checkRow(obj){
	
//	$(obj).attr("checked","true");
 }

function setSolicitud(){
	
	var detalle_seg_id  = $("#detalle_seg_id").val();
	var n               = $("input[type=checkbox]:checked").length;
	var cont            = 0;
	var enviar          = false;
	
	$(document).find("input[type=checkbox]").each(function(){

	
		//if( $('#actualizar',parent.document).length > 0 ){

			remesa_id          = $($(this).parent().parent()).find("input[name=remesa_id]").val();
			observaciones      = $($(this).parent().parent()).find("input[name=observaciones]").val();
			detalle_seg_rem_id = $($(this).parent().parent()).find("input[name=detalle_seg_rem_id]").val();

			if(this.checked == true && parseInt(detalle_seg_rem_id)>0){
	   
				var QueryString = "ACTIONCONTROLER=onclickUpdate&detalle_seg_id="+detalle_seg_id+"&remesa_id="+remesa_id+"&observaciones="+observaciones+"&detalle_seg_rem_id="+detalle_seg_rem_id;
				
				enviar = true;
		
			}else if(this.checked == true && !parseInt(detalle_seg_rem_id)>0){

				var QueryString = "ACTIONCONTROLER=onclickSave&detalle_seg_id="+detalle_seg_id+"&remesa_id="+remesa_id+"&observaciones="+observaciones;
				
				enviar = true;

			}else if(this.checked == false && parseInt(detalle_seg_rem_id)>0){				

				var QueryString = "ACTIONCONTROLER=onclickDelete&detalle_seg_id="+detalle_seg_id+"&remesa_id="+remesa_id+"&observaciones="+observaciones+"&detalle_seg_rem_id="+detalle_seg_rem_id;
				
				enviar = true;
			
			}else{
				  enviar = false;
			  }

			
			if(enviar){
				
			  $.ajax({
				
				url        : "SolicEditClass.php?rand="+Math.random(),
				data       : QueryString,
				beforeSend : function(){},
				success    : function(response){
										
					if(!isNaN(response)){
						cont++;
						if(parseInt(cont)==parseInt(n)){
						  parent.closeDialogedit();
						}
						
					}else{
						alertJquery(response);
					}
				}
				
			  });
			
			}
			
		//}
	});
	
	
}

