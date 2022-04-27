// JavaScript Document
$(document).ready(function(){

	$("input[name=valor_min]").blur(function(){

		var celda = this.parentNode;
		var valor_min = this.value;
		var base_ini = $(celda).find("input[name=base_ini]").val();
		base_ini = removeFormatCurrency(base_ini);
		valor_min = removeFormatCurrency(valor_min);

		/*if (parseFloat(valor_min) < parseFloat(base_ini)) {
			$(celda).find("input[name=valor_min]").val($(celda).find("input[name=base_ini]").val());
			alertJquery("El valor no debe ser menor al valor base establecido.","Validacion");
		}*/
	});

	$("input[name=valor_max]").blur(function(){

		var celda = this.parentNode;
		var valor_max = this.value;
		var base_max = $(celda).find("input[name=base_max]").val();
		base_max = removeFormatCurrency(base_max);
		valor_max = removeFormatCurrency(valor_max);

		if (parseFloat(valor_max) < parseFloat(base_max)) {
			$(celda).find("input[name=valor_max]").val($(celda).find("input[name=base_max]").val());
			alertJquery("El valor no debe ser menor al valor base establecido.","Validacion");
		}
	});

	$("input[name=porcentaje_seguro]").blur(function(){

		var celda = this.parentNode;
		var porcentaje_seguro = this.value;
		var impuesto_base = $(celda).find("input[name=impuesto_base]").val();

		if (parseFloat(porcentaje_seguro) < parseFloat(impuesto_base)) {
			$(celda).find("input[name=porcentaje_seguro]").val($(celda).find("input[name=impuesto_base]").val());
			alertJquery("El valor no debe ser menor al valor base establecido.","Validacion");
		}
	});

	$("input[name=vr_min_declarado]").blur(function(){

		var celda = this.parentNode;
		var vr_min_declarado = this.value;
		var vr_min_dec_base = $(celda).find("input[name=vr_min_dec_base]").val();

		if (parseFloat(vr_min_declarado) < parseFloat(vr_min_dec_base)) {
			$(celda).find("input[name=vr_min_declarado]").val($(celda).find("input[name=vr_min_dec_base]").val());
			alertJquery("El valor no debe ser menor al valor base establecido.","Validacion");
		}
	});

	$("select[name=periodo_contable_id]").change(function(){
		setDataFormWithResponse();
	});
	
	linkDetalles();
});

function saveDetalle(obj){

	var row		=	obj.parentNode.parentNode;
	if(validaRequeridosDetalle(obj,row) && ($("#periodo_contable_id").val()!='')){
		var Celda						=	obj.parentNode;
		var Fila						=	obj.parentNode.parentNode;
		var cliente_id					=	$("#cliente_id").val();
		var tipo_servicio_mensajeria_id	=	$("#tipo_servicio_mensajeria_id").val();
		var periodo_contable_id			=	$("#periodo_contable_id").val();
		var tarifas_masivo_cliente_id	=	$(Fila).find("input[name=tarifas_masivo_cliente_id]").val();
		var tipo_envio_id				=	$(Fila).find("input[name=tipo_envio_id]").val();
		
		var rango_inicial				=	$(Fila).find("input[name=rango_inicial]").val();
		var rango_final					=	$(Fila).find("input[name=rango_final]").val();
		var valor_min					=	$(Fila).find("input[name=valor_min]").val();
		var valor_max					=	$(Fila).find("input[name=valor_max]").val();
		var porcentaje_seguro			=	$(Fila).find("input[name=porcentaje_seguro]").val();
		var vr_min_declarado			=	$(Fila).find("input[name=vr_min_declarado]").val();
		var valor_min					=	removeFormatCurrency(valor_min);
		var valor_max					=	removeFormatCurrency(valor_max);
		var porcentaje_seguro			=	removeFormatCurrency(porcentaje_seguro);
		var vr_min_declarado			=	removeFormatCurrency(vr_min_declarado);
		if ((valor_min>0) && (valor_max>0) && (porcentaje_seguro>0) ){
			if (!tarifas_masivo_cliente_id.length > 0) {
				var QueryString = "ACTIONCONTROLER=onclickSave&cliente_id="+cliente_id+"&tipo_servicio_mensajeria_id="+tipo_servicio_mensajeria_id+"&rango_inicial="+rango_inicial+
				"&rango_final="+rango_final+"&valor_min="+valor_min+"&valor_max="+valor_max+"&porcentaje_seguro="+porcentaje_seguro+"&periodo_contable_id="+periodo_contable_id+
				"&vr_min_declarado="+vr_min_declarado+"&tipo_envio_id="+tipo_envio_id;
	
				$.ajax({
					url			: "CorreoMasivoClientesClass.php",
					data		: QueryString,
					beforeSend	: function(){
						showDivLoading();
					},
					success		: function(response){
						if (!isNaN(response)) {
							$(Fila).find("input[name=tarifas_masivo_cliente_id]").val(response);
							removeDivLoading();
							alertJquery("Tarifa actualizada correctamente.","Detalle");
						}else{
							removeDivLoading();
							alertJquery(response,"Detalle");
						}
					}
				});
			}else{
				var QueryString = "ACTIONCONTROLER=onclickUpdate&cliente_id="+cliente_id+"&tipo_servicio_mensajeria_id="+tipo_servicio_mensajeria_id+"&rango_inicial="+rango_inicial+"&rango_final="+rango_final+
				"&valor_min="+valor_min+"&valor_max="+valor_max+"&porcentaje_seguro="+porcentaje_seguro+"&periodo_contable_id="+periodo_contable_id+
				"&tarifas_masivo_cliente_id="+tarifas_masivo_cliente_id+"&vr_min_declarado="+vr_min_declarado+"&tipo_envio_id="+tipo_envio_id;
	
				$.ajax({
					url			: "CorreoMasivoClientesClass.php",
					data		: QueryString,
					beforeSend	: function(){
						showDivLoading();
					},
					success		: function(response){
						removeDivLoading();
						alertJquery(response,"Detalle");
					}
				});
			}
		}else{
			alertJquery("Debe crear una tarifa base para este tipo de envio o verifique que no hayan valores en 0","Validacion");
		}
	}else{
		alertJquery("Debe ingresar los campos Requeridos.","Validacion")
	}
}

function linkDetalles(){

	$("a[name=saveDetalleTarifaCliente]").click(function(){
		saveDetalle(this);
	});
}

function setDataFormWithResponse(){
	var periodo_contable_id1	=	document.getElementById("periodo_contable_id").value;
	if (periodo_contable_id1>0) {
		$("#tableTarifasCliente").find("input[name=tipo_envio_id]").each(function(){
			var Row  = this.parentNode.parentNode;
			var tipo_envio_id = this.value;
			var periodo_contable_id	=	document.getElementById("periodo_contable_id").value;
			var cliente_id			=	document.getElementById("cliente_id").value;
			// alert(tipo_envio_id);
			// 	alert(this.name);
			var QueryString			=	"ACTIONCONTROLER=OnClickFind&periodo_contable_id="+periodo_contable_id+"&cliente_id="+cliente_id+"&tipo_envio_id="+tipo_envio_id;
			$.ajax({
				url			:	"CorreoMasivoClientesClass.php?rand="+Math.random(),
				data		:	QueryString,
				beforeSend	:	function(){
					showDivLoading();
				},
				success		: function(resp){
					try{
						var data = $.parseJSON(resp);
						$(Row).find("input").each(function(){
							if(data[0]['tarifas_masivo_cliente_id']==null){
								if(this.name=='tarifas_masivo_cliente_id') this.value='';
							}else{
								if(this.name=='tarifas_masivo_cliente_id') this.value=data[0]['tarifas_masivo_cliente_id'];
							}
							if(data[0]['base_ini']==null){
								if(this.name=='base_ini') $(this).val(0);
								if(this.name=='valor_min') $(this).val(0);
							}else{
								var base_ini	=	data[0]['base_ini'];
								var valor_min	=	data[0]['base_ini'];
								if(this.name=='base_ini') $(this).val(setFormatCurrency(base_ini));
								if(this.name=='valor_min') $(this).val(setFormatCurrency(valor_min));
							}
							if(data[0]['base_max']==null){
								if(this.name=='base_max') $(this).val(0);
								if(this.name=='valor_max') $(this).val(0);
							}else{
								var base_max	=	data[0]['base_max'];
								var valor_max	=	data[0]['base_max'];
								if(this.name=='base_max') $(this).val(setFormatCurrency(base_max));
								if(this.name=='valor_max') $(this).val(setFormatCurrency(valor_max));
							}
							if(data[0]['vr_min_declarado']==null){
								if(this.name=='vr_min_dec_base') $(this).val(0);
								if(this.name=='vr_min_declarado') $(this).val(0);
							}else{
								var vr_min_dec_base		=	data[0]['vr_min_declarado'];
								var vr_min_declarado	=	data[0]['vr_min_declarado'];
								if(this.name=='vr_min_dec_base') $(this).val(setFormatCurrency(vr_min_dec_base));
								if(this.name=='vr_min_declarado') $(this).val(setFormatCurrency(vr_min_declarado));
							}
							if(data[0]['porcentaje_seguro']==null){
								if(this.name=='impuesto_base') $(this).val(0);
								if(this.name=='porcentaje_seguro') $(this).val(0);
							}else{
								var impuesto_base		=	data[0]['porcentaje_seguro'];
								var porcentaje_seguro	=	data[0]['porcentaje_seguro'];
								if(this.name=='impuesto_base') $(this).val(setFormatCurrency(impuesto_base));
								if(this.name=='porcentaje_seguro') $(this).val(setFormatCurrency(porcentaje_seguro));
							}
							// if (this.name=='saveDetalleTarifaCliente') {
							// 	if (Error>0) {
							// 		$(this).css("display","none");
							// 		// delete Error;
							// 		// alert(Error);
							// 	}else{
							// 		$(this).css("display","");
							// 		// alert(Error);
							// 		// delete Error;
							// 	}
							// }
							// alert(this.value);
							if (removeFormatCurrency(this.value)>0) {
								$(this).attr("disabled","");
								$(this).addClass("obligatorio");
							}else if(removeFormatCurrency(this.value)==0){
								$(this).attr("disabled","true");
								$(this).removeClass("obligatorio");
							}
						});
					}catch(e){
						alertJquery(resp,"Error :"+e);
					}
					removeDivLoading();
				}
			});
		});
	}else{
		alertJquery("Por favor seleccione un periodo contable.","Validacion");
	}
}

function CorreoMasivoClientesReset(){

	var form 		= document.forms[0];
	Reset(form);
}