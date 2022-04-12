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
	
	
	var total_pagar=0;
	var total_mayor=0;
	var total_menor=0;
	var parcial_pagar=0;
	var parcial_mayor=0;
	var parcial_menor=0;
	detalle_ss_id = '';
	detalle_valores='';
	
	$(document).find("input[type=checkbox]:checked").each(function(){/*

		numero_descu=$($(this).parent().parent()).find("input[name=num_descu]").val();	
		tiene_descu=0;
		for(i=1; i<parseInt(numero_descu); i++){
			if(parseInt($($(this).parent().parent()).find("input[name=descuento"+i+"]").val())>0){
				detalle_descuentos+= $($(this).parent().parent()).find("input[name=descuento_id"+i+"]").val()+"_"+$($(this).parent().parent()).find("input[name=descuento"+i+"]").val()+",";		
				parcial_descu= parseFloat(parcial_descu) + parseFloat(removeFormatCurrency($($(this).parent().parent()).find("input[name=descuento"+i+"]").val()));			
				tiene_descu=1;
			}
		}
		if(tiene_descu==1)
			detalle_descuentos+= "-"+$(this).val()+"=";
																   
		detalle_ss_id += $(this).val()+",";	
		detalle_valores+= $($(this).parent().parent()).find("input[name=pagar]").val()+"=";	
		
		valor_ind= removeFormatCurrency($($(this).parent().parent()).find("input[name=pagar]").val());
		pago_saldo = parseFloat(pago_saldo) + parseFloat(valor_ind);
		if(tiene_descu==1)		
			total_descu = parseFloat(total_descu) + parseFloat(parcial_descu);

		parcial_descu=0;
	*/
	
	var mayor_valor =removeFormatCurrency($($(this).parent().parent()).find("input[name=mayor_valor]").val());
	var menor_valor =removeFormatCurrency($($(this).parent().parent()).find("input[name=menor_valor]").val());
	var pagar 		=removeFormatCurrency($($(this).parent().parent()).find("input[name=pagar]").val());
	
	parcial_menor =parseInt(menor_valor)>0 ? parseFloat(parcial_menor)+parseFloat(menor_valor):0;
	parcial_mayor = parseInt(mayor_valor)>0 ? parseFloat(parcial_mayor)+parseFloat(mayor_valor):0;
	parcial_pagar = parseInt(pagar)>0 ? parseFloat(parcial_pagar)+parseFloat(pagar):0;
	
	detalle_ss_id += $(this).val()+",";	
	detalle_valores+= $($(this).parent().parent()).find("input[name=pagar]").val()+"=";	
		
	
	
	});
	//alert("mayor"+parcial_menor+"menor"+parcial_mayor);
	total_pagar=parseFloat(parcial_pagar) ;
	total_mayor = parseFloat(parcial_mayor) ;
	total_menor = parseFloat(parcial_menor) ;
	valor_neto = total_pagar+total_mayor-total_menor;
	
	parent.document.forms[0]['causaciones_abono_factura'].value = detalle_ss_id;
	parent.document.forms[0]['valores_abono_factura'].value = detalle_valores;
	parent.document.forms[0]['valor_abono_factura'].value = setFormatCurrency(total_pagar);
	parent.document.forms[0]['valor_mayor_factura'].value = setFormatCurrency(total_mayor);
	parent.document.forms[0]['valor_descu_factura'].value = setFormatCurrency(total_menor);	
	parent.document.forms[0]['valor_neto_factura'].value = setFormatCurrency(valor_neto);	
	
	parent.cargardatos();
	parent.closeDialog();
}

