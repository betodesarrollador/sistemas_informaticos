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
		if(obj.checked == true ){
			$(obj).attr("checked","false");
		}else{
			//$(obj).attr("checked","true");
			var Fila        =  obj.parentNode.parentNode;
			var abonos_nc 	= $(Fila).find("input[name=abonos_nc]").val();	
			var saldo 		= $(Fila).find("input[name=saldo]").val();
			var pagar 		= $(Fila).find("input[name=pagar]").val();	
			var pagar1		= removeFormatCurrency(pagar);
			var saldo1		= removeFormatCurrency(saldo);
			
			if(parseFloat(abonos_nc)>0){
				alertJquery("Existen abonos sin Contabilizar para esta Factura/Cuenta por valor de $"+setFormatCurrency(abonos_nc)+"<br> Por favor Contabilice los pagos si desea que se tomen en cuenta en los abonos.<br>De lo contrario por favor anule esos pagos para que no vuelva a aparecer este mensaje","Pago");
				var real = parseFloat(pagar1)-parseFloat(abonos_nc);
		
				if((parseFloat(saldo1)-parseFloat(abonos_nc)) < parseFloat(pagar1)){			
					$(Fila).find("input[name=pagar]").val(setFormatCurrency(real));	
				}
			}
		}
	}
 }

function checkRowAnt(obj){
	if(obj){
		if(obj.checked == true ){
			$(obj).attr("checked","false");
		}else{
		
			//$(obj).attr("checked","true");
			var Fila        =  obj.parentNode.parentNode;
			var abonos_nc 	= $(Fila).find("input[name=abonos_nc]").val();	
			var saldo 		= $(Fila).find("input[name=saldo]").val();
			var pagar 		= $(Fila).find("input[name=pagar]").val();	
			var pagar1		= removeFormatCurrency(pagar);
			var saldo1		= removeFormatCurrency(saldo);
			
			if(parseFloat(abonos_nc)>0){
				alertJquery("Existen abonos sin Contabilizar para esta Factura/Cuenta por valor de $"+setFormatCurrency(abonos_nc)+"<br> Por favor Contabilice los Pagos si desea que se tomen en cuenta en los abonos.<br>De lo contrario por favor anule esos Pagos para que no vuelva a aparecer este mensaje","Pago");
				var real = parseFloat(pagar1)-parseFloat(abonos_nc);
		
				if((parseFloat(saldo1)-parseFloat(abonos_nc)) < parseFloat(pagar1)){			
					$(Fila).find("input[name=pagar]").val(setFormatCurrency(real));	
				}
			}
		}
	}
 }


function setSolicitud(){
	
	detalle_ss_id = '';
	detalle_concepto='';
	detalle_valores='';
	pago_saldo=0;
	
	detalle_ant_id = '';	
	detalle_valores_ant='';
	pago_anticipos=0;	
	
	$(document).find("input[type=checkbox]:checked").each(function(){
		/*if($($(this).parent().parent()).find("input[name=tipo]").val()=='C'){
			detalle_ss_id += $(this).val()+",";	
			detalle_valores+= $($(this).parent().parent()).find("input[name=pagar]").val()+"=";	
			
			valor_ind= removeFormatCurrency($($(this).parent().parent()).find("input[name=pagar]").val());
			pago_saldo = parseFloat(pago_saldo) + parseFloat(valor_ind);
		}else{*/
			valor_ind1= removeFormatCurrency($($(this).parent().parent()).find("input[name=pagar]").val());
			detalle_ant_id += $(this).val()+",";	
			detalle_valores_ant+= valor_ind1+"=";	
			
			
			pago_anticipos = parseFloat(pago_anticipos) + parseFloat(valor_ind1);
			
			
		//}
	});
	pago_saldo = removeFormatCurrency(parent.document.forms[0]['valor'].value);
	if(pago_saldo>=pago_anticipos && pago_saldo>0){
		/*parent.document.forms[0]['causaciones_abono_factura'].value = detalle_ss_id;
		parent.document.forms[0]['valores_abono_factura'].value = detalle_valores;*/
		//parent.document.forms[0]['descuentos_valores'].value = detalle_valores_ant;
		//parent.document.forms[0]['valor_abono_factura'].value = setFormatCurrency(pago_saldo);

		if(pago_anticipos>0)		
			total_neto = parseFloat(pago_saldo) - parseFloat(pago_anticipos);
		else	
			total_neto = parseFloat(pago_saldo);
			
		parent.document.forms[0]['anticipos_cruzar'].value = detalle_ant_id;	
		parent.document.forms[0]['val_anticipos_cruzar'].value = detalle_valores_ant;	
		parent.document.forms[0]['anticipos'].value = setFormatCurrency(pago_anticipos);
		/*parent.document.forms[0]['valor_descu_factura'].value = setFormatCurrency(pago_anticipos);
		parent.document.forms[0]['valor_neto_factura'].value = setFormatCurrency(total_neto);	*/
		//parent.cargardatos();
		parent.closeDialog();
		
	}else if(!pago_saldo>0){
		alertJquery("No se ha asignado un valor a pagar en el documento. <br> Por favor ingrese un valor y luego busque los anticipos.","Pago");
		
	}else if(pago_saldo<pago_anticipos){
		alertJquery("Los Anticipos superan el valor a pagar.<br> Por favor Revise los anticipos.","Pago");

	}
}

