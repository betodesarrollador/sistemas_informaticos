// JavaScript Document
var detalle_ss_id='';
var detalle_concepto='';
$(document).ready(function(){
	
	$("#adicionar").click(function(){
		setSolicitud();
		
	});
	compara_cantidad();
});


function compara_cantidad(){
	
	$("input[name=pagar]").keyup(function() {

		var Fila        = $(this).parent().parent();
		var pagar 		= $(Fila).find("input[name=pagar]").val();	
		var saldo 		= $(Fila).find("input[name=saldo]").val();
		var abonos_nc	= $(Fila).find("input[name=abonos_nc]").val();
		
		if(pagar>0){
			
			var pagar1		= removeFormatCurrency(pagar);
			var saldo1		= removeFormatCurrency(saldo);
			
			var abonos_nc1	= parseFloat(abonos_nc)>0 ? parseFloat(abonos_nc):0;
			if(parseFloat(abonos_nc1)>0)
				mensajeabo	= "<br>Por favor tenga en cuenta que los abonos por $"+setFormatCurrency(abonos_nc)+" No contabilizados se toman en cuenta";
			else
				mensajeabo	= "_";
			

			if((parseFloat(saldo1)-parseFloat(abonos_nc1)) < parseFloat(pagar1)){

				$(Fila).find("input[name=pagar]").val(setFormatCurrency(parseFloat(saldo1)-parseFloat(abonos_nc1)));
				alertJquery("Valor ingresado mayor al saldo"+mensajeabo,"Pago");
				
			}
			
			$(Fila).find("input[name=chequear]").attr("checked","");
		}else{

			$(Fila).find("input[name=chequear]").attr('checked', false); 
		}

		
	});	


}

function checkRow(obj){
	if(obj){
		$(obj).attr("checked","true");
		var Fila        =  obj.parentNode.parentNode;
		var abonos_nc 	= $(Fila).find("input[name=abonos_nc]").val();	
		var saldo 		= $(Fila).find("input[name=saldo]").val();
		var pagar 		= $(Fila).find("input[name=pagar]").val();	
		var valor_autorizado	= $(Fila).find("input[name=valor_autorizado]").val();
		
		var pagar1		= removeFormatCurrency(pagar);
		var saldo1		= removeFormatCurrency(saldo);
		
		if(parseFloat(abonos_nc)>0){
			alertJquery("Existen abonos sin Contabilizar para esta Factura/Cuenta por valor de $"+setFormatCurrency(abonos_nc)+"<br> Por favor Contabilice los pagos si desea que se tomen en cuenta en los abonos.<br>De lo contrario por favor anule esos pagos para que no vuelva a aparecer este mensaje","Pago");
			var real = parseFloat(pagar1)-parseFloat(abonos_nc);

			if((parseFloat(saldo1)-parseFloat(abonos_nc)) < parseFloat(pagar1)){			
				$(Fila).find("input[name=pagar]").val(setFormatCurrency(real));	
			}
		}
		
		//alert(pagar1 +"asdasd"+valor_autorizado)
		if(valor_autorizado>0){
			if(parseFloat(pagar1)> parseFloat(valor_autorizado)){

				$(Fila).find("input[name=pagar]").val(setFormatCurrency(parseFloat(valor_autorizado)));
				alertJquery("Solo se autorizo el pago de "+setFormatCurrency(parseFloat(valor_autorizado)),"Pago");
				$(obj).attr("checked","");
			}
		}

	}
}


function setSolicitud(){
	
	detalle_ss_id = '';
	detalle_concepto='';
	detalle_valores='';
	pago_saldo=0;
	
	$(document).find("input[type=checkbox]:checked").each(function(){
		detalle_ss_id += $(this).val()+",";	
		detalle_valores+= $($(this).parent().parent()).find("input[name=pagar]").val()+"=";	
		
		valor_ind= removeFormatCurrency($($(this).parent().parent()).find("input[name=pagar]").val());
		pago_saldo = parseFloat(pago_saldo) + parseFloat(valor_ind);
	});
	parent.document.forms[0]['causaciones_abono_factura'].value = detalle_ss_id;
	parent.document.forms[0]['valores_abono_factura'].value = detalle_valores;
	parent.document.forms[0]['valor_abono_factura'].value = setFormatCurrency(pago_saldo);
	parent.cargardatos();
	parent.closeDialog();
}

