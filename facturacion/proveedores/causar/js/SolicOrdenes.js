// JavaScript Document
var detalle_ss_id='';
var detalle_concepto='';
$(document).ready(function(){
	
	$("#adicionar").click(function(){
		setSolicitud();
		
	});
	
});
function checkRowAnt(obj){
	if(obj){
		if(obj.checked == true ){
			$(obj).attr("checked","false");
		}else{
			$(obj).attr("checked","true");
		}
	}
}

function setSolicitud(){
	
	detalle_ss_id = '';
	detalle_concepto='';
	detalle_valores='';
	detalle_ordenes_cons='';
	pago_saldo=0;
	
	detalle_ant_id = '';	
	detalle_valores_ant=0;
	pago_anticipos=0;	
	
	$(document).find("input[type=checkbox]:checked").each(function(){
		
			detalle_ant_id += $(this).val()+",";	
			detalle_valores_ant+= ($($(this).parent().parent()).find("input[name=pagar]").val())*1;	
			detalle_ordenes_cons+= $($(this).parent().parent()).find("input[name=consecutivo]").val()+",";	
			
	});
	
			
		parent.document.forms[0]['orden_compra_hidden'].value = detalle_ant_id.substring(0, (detalle_ant_id.length-1) ); 	
		parent.document.forms[0]['valor'].value = setFormatCurrency(detalle_valores_ant);
		parent.document.forms[0]['orden_compra'].value = detalle_ordenes_cons.substring(0, (detalle_ordenes_cons.length-1) ); 	
		/*parent.document.forms[0]['valor_neto_factura'].value = setFormatCurrency(total_neto);	*/
		//parent.cargardatos();
		parent.closeDialogOrden();
		
	
}

