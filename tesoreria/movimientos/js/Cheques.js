// JavaScript Document
var detalle_ss_id='';
var detalle_concepto='';
$(document).ready(function(){
	
	$("#adicionar").click(function(){
		setSolicitud();
		
	});
});

function checkRow(obj){
	if(obj){
		$(obj).attr("checked","true");
		var Fila        =  obj.parentNode.parentNode;
		var num_cheque 	= $(Fila).find("input[name=num_cheque]").val();	
		
		if(num_cheque==0){
			alertJquery("Al parecer este numero de cheque "+num_cheque+", no es valido <br> Por favor Revise","Plantilla");
			$(obj).attr("checked","");
		}
		if(num_cheque==''){
			alertJquery("Al parecer este numero de cheque "+num_cheque+", no es valido <br> Por favor Revise","Plantilla");
			$(obj).attr("checked","");
		}
		
	}
 }


function setSolicitud(){
	
	detalle_ss_id = '';
	detalle_valores='';
	
	$(document).find("input[type=checkbox]:checked").each(function(){
		detalle_ss_id += $(this).val()+",";	
		detalle_valores+= $($(this).parent().parent()).find("input[name=num_cheque]").val()+",";
	});
	detalle_valores= detalle_valores.substring(0, detalle_valores.length-1);
	detalle_ss_id= detalle_ss_id.substring(0, detalle_ss_id.length-1);	
	parent.document.forms[0]['cheques_ids'].value = detalle_ss_id;
	parent.document.forms[0]['cheques'].value = detalle_valores;
	parent.closeDialog();
}

