// JavaScript Document
$(document).ready(function(){

	/*$("input[name=vr_kg_inicial_min]").blur(function(){

		var celda = this.parentNode;
		var vr_kg_inicial_min = this.value;
		var min_base_ini = $(celda).find("input[name=min_base_ini]").val();
		min_base_ini = removeFormatCurrency(min_base_ini);
		vr_kg_inicial_min = removeFormatCurrency(vr_kg_inicial_min);

		if (parseFloat(vr_kg_inicial_min) < parseFloat(min_base_ini)) { 
			$(celda).find("input[name=vr_kg_inicial_min]").val($(celda).find("input[name=min_base_ini]").val());
			alertJquery("El valor no debe ser menor al valor base establecido.","Validacion");
		}
	});

	$("input[name=vr_kg_inicial_max]").blur(function(){

		var celda = this.parentNode;
		var vr_kg_inicial_max = this.value;
		var min_base_kg_ini = $(celda).find("input[name=min_base_kg_ini]").val();
		min_base_kg_ini = removeFormatCurrency(min_base_kg_ini);
		vr_kg_inicial_max = removeFormatCurrency(vr_kg_inicial_max);

		if (parseFloat(vr_kg_inicial_max) < parseFloat(min_base_kg_ini)) {
			$(celda).find("input[name=vr_kg_inicial_max]").val($(celda).find("input[name=min_base_kg_ini]").val());
			alertJquery("El valor no debe ser menor al valor base establecido.","Validacion");
		}
	});

	$("input[name=vr_kg_adicional_min]").blur(function(){

		var celda = this.parentNode;
		var vr_kg_adicional_min = this.value;
		var min_base_adi = $(celda).find("input[name=min_base_adi]").val();
		min_base_adi = removeFormatCurrency(min_base_adi);
		vr_kg_adicional_min = removeFormatCurrency(vr_kg_adicional_min);

		if (parseFloat(vr_kg_adicional_min) < parseFloat(min_base_adi)) {
			$(celda).find("input[name=vr_kg_adicional_min]").val($(celda).find("input[name=min_base_adi]").val());
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
		var vr_min_declarado_base = $(celda).find("input[name=vr_min_declarado_base]").val();

		if (parseFloat(vr_min_declarado) < parseFloat(vr_min_declarado_base)) {
			$(celda).find("input[name=vr_min_declarado]").val($(celda).find("input[name=vr_min_declarado_base]").val());
			alertJquery("El valor no debe ser menor al valor base establecido.","Validacion");
		}
	});*/

	$("select[name=periodo_contable_id]").change(function(){
		setDataFormWithResponse();
	});

	linkDetalles();
});

function saveDetalle(obj){

	var row		=	obj.parentNode.parentNode;
	if(validaRequeridosDetalle(obj,row) && ($("#periodo_contable_id").val()!='')){
		var Celda							=	obj.parentNode;
		var Fila							=	obj.parentNode.parentNode;
		var cliente_id						=	$("#cliente_id").val();
		var tipo_servicio_mensajeria_id		=	$("#tipo_servicio_mensajeria_id").val();
		var periodo_contable_id				=	$("#periodo_contable_id").val();
		var tarifas_mensajeria_cliente_id	=	$(Fila).find("input[name=tarifas_mensajeria_cliente_id]").val();
		var tipo_envio_id					=	$(Fila).find("input[name=tipo_envio_id]").val();
		var vr_kg_inicial_min				=	$(Fila).find("input[name=vr_kg_inicial_min]").val();
		var vr_kg_inicial_min				=	removeFormatCurrency(vr_kg_inicial_min);

		var vr_kg_inicial_max				=	$(Fila).find("input[name=vr_kg_inicial_max]").val();
		var vr_kg_inicial_max				=	removeFormatCurrency(vr_kg_inicial_max);

		var vr_kg_adicional_min				=	$(Fila).find("input[name=vr_kg_adicional_min]").val();
		var vr_kg_adicional_min				=	removeFormatCurrency(vr_kg_adicional_min);
		var porcentaje_seguro				=	$(Fila).find("input[name=porcentaje_seguro]").val();
		var porcentaje_seguro				=	removeFormatCurrency(porcentaje_seguro);
		var vr_min_declarado				=	$(Fila).find("input[name=vr_min_declarado]").val();
		var vr_min_declarado				=	removeFormatCurrency(vr_min_declarado);

		if ((vr_kg_inicial_min>0) && (vr_kg_adicional_min>0) && (porcentaje_seguro>0) ){
			if (!tarifas_mensajeria_cliente_id.length > 0) {
				var QueryString = "ACTIONCONTROLER=onclickSave&cliente_id="+cliente_id+"&tipo_servicio_mensajeria_id="+tipo_servicio_mensajeria_id+"&tipo_envio_id="+tipo_envio_id+
				"&vr_kg_inicial_min="+vr_kg_inicial_min+"&vr_kg_adicional_min="+vr_kg_adicional_min+"&porcentaje_seguro="+porcentaje_seguro+"&periodo_contable_id="+periodo_contable_id+
				"&vr_min_declarado="+vr_min_declarado+"&vr_kg_inicial_max="+vr_kg_inicial_max;
	
				$.ajax({
					url			: "Correo24horasClientesClass.php",
					data		: QueryString,
					beforeSend	: function(){
						showDivLoading();
					},
					success		: function(response){
						if (!isNaN(response)) {
							$(Fila).find("input[name=tarifas_mensajeria_cliente_id]").val(response);
							removeDivLoading();
							alertJquery("Tarifa actualizada correctamente.","Detalle");
						}else{
							removeDivLoading();
							alertJquery(response,"Detalle");
						}
					}
				});
			}else{
				var QueryString = "ACTIONCONTROLER=onclickUpdate&cliente_id="+cliente_id+"&tipo_servicio_mensajeria_id="+tipo_servicio_mensajeria_id+"&tipo_envio_id="+tipo_envio_id+
				"&vr_kg_inicial_min="+vr_kg_inicial_min+"&vr_kg_adicional_min="+vr_kg_adicional_min+"&porcentaje_seguro="+porcentaje_seguro+"&periodo_contable_id="+periodo_contable_id+
				"&tarifas_mensajeria_cliente_id="+tarifas_mensajeria_cliente_id+"&vr_min_declarado="+vr_min_declarado+"&vr_kg_inicial_max="+vr_kg_inicial_max;
	
				$.ajax({
					url			: "Correo24horasClientesClass.php",
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
	var periodo_contable_id_1	=	document.getElementById("periodo_contable_id").value;
	if (periodo_contable_id_1>0) {
		$("#tableTarifasCliente").find("input[name=tipo_envio_id]").each(function(){
			var Row  = this.parentNode.parentNode;
			var tipo_envio_id = this.value;
			var periodo_contable_id	=	document.getElementById("periodo_contable_id").value;
			var cliente_id			=	document.getElementById("cliente_id").value;
			// alert(tipo_envio_id);
				// alert(this.name);
			var QueryString			=	"ACTIONCONTROLER=OnClickFind&periodo_contable_id="+periodo_contable_id+"&cliente_id="+cliente_id+"&tipo_envio_id="+tipo_envio_id;
			$.ajax({
				url			:	"CorreoNormalClientesClass.php?rand="+Math.random(),
				data		:	QueryString,
				beforeSend	:	function(){
					showDivLoading();
				},
				success		: function(resp){
					try{
						var data = $.parseJSON(resp);
						// alert($(Row).find("input").length);
						$(Row).find("input").each(function(){
							// var Error = 0;
							// alert(this.name);
							if(data[0]['tarifas_mensajeria_cliente_id']==null){
								if(this.name=='tarifas_mensajeria_cliente_id') this.value='';
							}else{
								if(this.name=='tarifas_mensajeria_cliente_id') this.value=data[0]['tarifas_mensajeria_cliente_id'];
							}
							if(data[0]['min_base_ini']==null){
								if(this.name=='min_base_ini') $(this).val(0);
								if(this.name=='vr_kg_inicial_min') this.value=0;
								// if(this.name=='vr_kg_inicial_min') Error = 1;
							}else{
								if(this.name=='min_base_ini') $(this).val(data[0]['min_base_ini']);
								// if(this.name=='vr_kg_inicial_min') $(this).val(0);
								if(this.name=='vr_kg_inicial_min') $(this).val(data[0]['min_base_ini']);
							}
							if(data[0]['min_base_kg_ini']==null){
								if(this.name=='min_base_kg_ini') $(this).val(0);
								if(this.name=='vr_kg_inicial_max') $(this).val(0);
							}else{
								var min_base_kg_ini			=	data[0]['min_base_kg_ini'];
								var vr_kg_inicial_max		=	data[0]['min_base_kg_ini'];
								if(this.name=='min_base_kg_ini') $(this).val(setFormatCurrency(min_base_kg_ini));
								if(this.name=='vr_kg_inicial_max') $(this).val(setFormatCurrency(vr_kg_inicial_max));
							}
							
							if(data[0]['min_kg_adicional']==null){
								if(this.name=='min_base_adi') $(this).val(0);
								if(this.name=='vr_kg_adicional_min') $(this).val(0);
								// if(this.name=='vr_kg_adicional_min')Error = 1;
							}else{
								if(this.name=='min_base_adi') $(this).val(data[0]['min_kg_adicional']);
								if(this.name=='vr_kg_adicional_min') $(this).val(data[0]['min_kg_adicional']);
							}
							if(data[0]['vr_min_declarado']==null){
								if(this.name=='vr_min_dec_base') $(this).val(0);
								if(this.name=='vr_min_declarado') $(this).val(0);
								// if(this.name=='vr_min_declarado')Error = 1;
							}else{
								if(this.name=='vr_min_dec_base') $(this).val(data[0]['vr_min_declarado']);
								if(this.name=='vr_min_declarado') $(this).val(data[0]['vr_min_declarado']);
							}
							if(data[0]['porcentaje_seguro']==null){
								if(this.name=='impuesto_base') $(this).val(0);
								if(this.name=='porcentaje_seguro') $(this).val(0);
								// if(this.name=='porcentaje_seguro') Error = 1;
							}else{
								if(this.name=='impuesto_base') $(this).val(data[0]['porcentaje_seguro']);
								if(this.name=='porcentaje_seguro') $(this).val(data[0]['porcentaje_seguro']);
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

function CorreoNormalClientesReset(){

	var form 		= document.forms[0];
	Reset(form);
}