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

	});	


}

function checkRow(obj){
	
	if(obj){
		
		$(obj).attr("checked","true");
		var Fila        =  obj.parentNode.parentNode;
		var abonos_nc 	= $(Fila).find("input[name=abonos_nc]").val();	
		var saldo 		= $(Fila).find("input[name=saldo]").val();
		var pagar 		= $(Fila).find("input[name=pagar]").val();	
		var pagar1		= removeFormatCurrency(pagar);
		var saldo1		= removeFormatCurrency(saldo);
		
		if(parseFloat(abonos_nc)>0){
			alertJquery("Existen abonos sin Contabilizar para esta Factura por valor de $"+setFormatCurrency(abonos_nc)+"<br> Por favor Contabilice los pagos si desea que se tomen en cuenta en los abonos.<br>De lo contrario por favor anule esos pagos para que no vuelva a aparecer este mensaje","Pago");
			var real = parseFloat(pagar1)-parseFloat(abonos_nc);
	
			if((parseFloat(saldo1)-parseFloat(abonos_nc)) < parseFloat(pagar1)){			
				$(Fila).find("input[name=pagar]").val(setFormatCurrency(real));	
			}
		}
	  
	}
 }
function ValidarDes(obj){
	if(obj){

		var Fila        =  obj.parentNode.parentNode;
		var pagar 		= $(Fila).find("input[name=pagar]").val();	
		var num_descu 	= $(Fila).find("input[name=num_descu]").val();	
		var pagar1		= removeFormatCurrency(pagar);
		var sumando		= 0;
		
		for(i=1;i<parseInt(num_descu);i++){
			sumando2= parseFloat(removeFormatCurrency($(Fila).find("input[name=descuento"+i+"]").val()))
			sumando2=parseFloat(sumando2)>0 ? parseFloat(sumando2):0;
			sumando = parseFloat(sumando)+parseFloat(sumando2);	
			
		}
		if(parseFloat(sumando)>parseFloat(pagar1)){
			$(Fila).find("input[name=chequear]").attr("checked","");
			alertJquery("Valor de descuentos mayor al valor a Pagar<br> Por favor verifique","Pago");

		}else{
			$(Fila).find("input[name=chequear]").attr("checked","true");
		
		}
	}

}
function setSolicitud(){
	
	detalle_ss_id = '';
	detalle_concepto='';
	detalle_valores='';
	detalle_descuentos='';
	numero_descu=0;
	pago_saldo=0;
	parcial_descu=0;
	total_descu=0;
	total_neto=0;
	
	$(document).find("input[type=checkbox]:checked").each(function(){

		
															   
		detalle_ss_id += $(this).val()+",";	
		detalle_valores+= $($(this).parent().parent()).find("input[name=pagar]").val()+"=";	
		
		detalle_concepto += "Factura "+$($(this).parent().parent()).find("input[name=concepto_hidden]").val()+",";
		
		valor_ind= removeFormatCurrency($($(this).parent().parent()).find("input[name=pagar]").val());
		pago_saldo = parseFloat(pago_saldo) + parseFloat(valor_ind);
		
	});
	
	total_neto=parseFloat(pago_saldo);
	parent.document.forms[0]['concepto_abono_factura'].value = detalle_concepto;
	parent.document.forms[0]['causaciones_abono_factura'].value = detalle_ss_id;
	parent.document.forms[0]['valores_abono_factura'].value = detalle_valores;
	//parent.document.forms[0]['descuentos_items'].value = detalle_descuentos;	
	//parent.document.forms[0]['valor_abono_factura'].value = setFormatCurrency(pago_saldo);
	parent.document.forms[0]['valor_descu_factura'].value = setFormatCurrency(total_neto);
	//parent.document.forms[0]['valor_neto_factura'].value = setFormatCurrency(total_neto);	
	parent.cargardatos();
	parent.closeDialog();
}

