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
		if (obj.checked == true  )
		{ 
			$(obj).attr("checked","false");
		}
		else{
		//$(obj).attr("checked","true");
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
			if($(Fila).find("input[name=tipo_descu_id"+i+"]").val()=='DESC'){
				sumando = parseFloat(sumando)+parseFloat(sumando2);	
			}
			
		}
		if(parseFloat(sumando)>parseFloat(pagar1)){
			$(Fila).find("input[name=chequear]").attr("checked","");
			alertJquery("Valor de descuentos mayor al valor a Pagar<br> Por favor verifique","Pago");
		}else{
			$(Fila).find("input[name=chequear]").attr("checked","true");
		
		}
	}
}

function ValidarSaldoNota(obj){
	if(obj){
		var Fila        =  obj.parentNode.parentNode;
	    
		var pagar_valor = $(Fila).find("input[name=pagar_nota]").val();	
		var num_descu 	= $(Fila).find("input[name=num_descu]").val();
		var fecha		= parent.document.forms[0]['fecha'].value;
		var pagar1		= removeFormatCurrency(pagar_valor);
		
		var query2 = '';
		
		var puc_id = [num_descu];
		
		for(i=1;i<=parseInt(num_descu);i++){
			puc_id[i] = $(Fila).find("input[name=puc_id"+i+"]").val();
			query2 = query2+'&puc_id'+i+'='+puc_id[i];
		}
		
			//var puc_id = $(Fila).find("input[name=puc_id"+contador+"]").val();
						
					
			var QueryString = "ACTIONCONTROLER=buscarImpuesto&num_descu="+num_descu+"&base="+pagar1+"&fecha="+fecha+query2+"&rand="+Math.random();
			
			$.ajax({
				url     : "SolicFacturasClass.php",
				data    : QueryString,
				success : function(resp){
					try{
						var resp 				= $.parseJSON(resp);
						for(i=1;i<=num_descu;i++){
							$(Fila).find("input[name=descuento"+i+"]").val(setFormatCurrency(resp[i]));
						}
						
						var sumandos	= 0;
						var restandos	= 0;
						
						for(j=1;j<=parseInt(num_descu);j++){
							
							if($(Fila).find("input[name=tipo_descu_id"+j+"]").val()=='DESC'){
								sumandos = parseFloat(sumandos)+parseFloat(removeFormatCurrency($(Fila).find("input[name=descuento"+j+"]").val()));	
							}
							if($(Fila).find("input[name=tipo_descu_id"+j+"]").val()=='MAS'){
								restandos = parseFloat(restandos)+parseFloat(removeFormatCurrency($(Fila).find("input[name=descuento"+j+"]").val()));	
							}
							
						}
						var valor_final = parseInt((parseFloat(pagar1) - parseFloat(restandos)) + parseFloat(sumandos));
						$(Fila).find("input[name=pagar]").val(setFormatCurrency(valor_final));
							
					}catch(e){
						console.log(e);
					}
				}
			});
			
		
	}
}

function setSolicitud(){
	
	detalle_ss_id = '';
	detalle_concepto='';
	detalle_valores='';
	detalle_descuentos='';
	detalle_mayor='';
	numero_descu=0;
	pago_saldo=0;
	parcial_descu=0;
	parcial_mayor=0;
	total_descu=0;
	total_mayor=0;
	total_neto=0;
	
	$(document).find("input[type=checkbox]:checked").each(function(){
		numero_descu=$($(this).parent().parent()).find("input[name=num_descu]").val();	
		tiene_descu=0;
		for(i=1; i<=parseInt(numero_descu); i++){
			if(parseInt($($(this).parent().parent()).find("input[name=descuento"+i+"]").val())>0 ){
				detalle_descuentos+= $($(this).parent().parent()).find("input[name=descuento_id"+i+"]").val()+"_"+$($(this).parent().parent()).find("input[name=descuento"+i+"]").val()+",";		
				tiene_descu=1;
				if($($(this).parent().parent()).find("input[name=tipo_descu_id"+i+"]").val()=='DESC' && parseInt($($(this).parent().parent()).find("input[name=descuento"+i+"]").val())>0){
					parcial_descu= parseFloat(parcial_descu) + parseFloat(removeFormatCurrency($($(this).parent().parent()).find("input[name=descuento"+i+"]").val()));			
				}else if($($(this).parent().parent()).find("input[name=tipo_descu_id"+i+"]").val()=='MAS' && parseInt($($(this).parent().parent()).find("input[name=descuento"+i+"]").val())>0){
					parcial_mayor= parseFloat(parcial_mayor) + parseFloat(removeFormatCurrency($($(this).parent().parent()).find("input[name=descuento"+i+"]").val()));			
					
				}
			}
		}
		if(tiene_descu==1)
			detalle_descuentos+= "-"+$(this).val()+"=";
																   
		detalle_ss_id += $(this).val()+",";	
		detalle_valores+= $($(this).parent().parent()).find("input[name=pagar]").val()+"=";	
		
		valor_ind= removeFormatCurrency($($(this).parent().parent()).find("input[name=pagar]").val());
		pago_saldo = parseFloat(pago_saldo) + parseFloat(valor_ind);
		
		if(tiene_descu==1){		
			total_descu = parseFloat(total_descu) + parseFloat(parcial_descu);
			total_mayor = parseFloat(total_mayor) + parseFloat(parcial_mayor);			
		}
		
		parcial_descu=0;
		parcial_mayor=0;
		
	});
	total_neto=(parseFloat(pago_saldo) - parseFloat(total_descu))+parseFloat(total_mayor);
	parent.document.forms[0]['causaciones_abono_factura'].value = detalle_ss_id;
	parent.document.forms[0]['valores_abono_factura'].value = detalle_valores;
	parent.document.forms[0]['descuentos_items'].value = detalle_descuentos;	
	parent.document.forms[0]['valor_abono_factura'].value = setFormatCurrency(pago_saldo);
	parent.document.forms[0]['valor_descu_factura'].value = setFormatCurrency(total_descu);
	parent.document.forms[0]['valor_mayor_factura'].value = setFormatCurrency(total_mayor);
	
	parent.document.forms[0]['valor_neto_factura'].value = setFormatCurrency(total_neto);	
	parent.cargardatos();
	parent.closeDialog();
}
