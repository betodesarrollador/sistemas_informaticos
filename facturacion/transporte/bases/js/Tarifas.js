// JavaScript Document
$(document).ready(function(){

	$("input[name=porcentaje_seguro]").blur(function(){

		var celda = this.parentNode;
		var porcentaje_seguro = this.value;
		var impuesto_base = $(celda).find("input[name=impuesto_base]").val();

		if (parseFloat(porcentaje_seguro) < parseFloat(impuesto_base)) { 
			$(celda).find("input[name=porcentaje_seguro]").val($(celda).find("input[name=impuesto_base]").val());
			alertJquery("El valor no debe ser menor al valor base establecido.","Validacion");
		}
	});


	$("select[name=periodo]").change(function(){
		setDataFormWithResponse();
	});

	linkDetalles();
});

function saveDetalle(obj){

	var row		=	obj.parentNode.parentNode;
	if(validaRequeridosDetalle(obj,row) && ($("#periodo").val()!='')){
		var Celda							=	obj.parentNode;
		var Fila							=	obj.parentNode.parentNode;
		var cliente_id						=	$("#cliente_id").val();
		var tercero_id						=	$("#tercero_id").val();
		var periodo							=	$("#periodo").val();
		var tarifas_destino_cliente_id		=	$(Fila).find("input[name=tarifas_destino_cliente_id]").val();
		var convencion_id					=	$(Fila).find("input[name=convencion_id]").val();
		var porcentaje						=	$(Fila).find("input[name=porcentaje]").val();
		    porcentaje						=	removeFormatCurrency(porcentaje);
		var tipo							=	$(Fila).find("select[name=tipo]").val();
		var tasa_seguro						=	$(Fila).find("input[name=tasa_seguro]").val();
		    tasa_seguro						=	removeFormatCurrency(tasa_seguro);
		var minimo_despacho					=	$(Fila).find("input[name=minimo_despacho]").val();
		    minimo_despacho					=	removeFormatCurrency(minimo_despacho);
		var minimo_declarado				=	$(Fila).find("input[name=minimo_declarado]").val();
		    minimo_declarado				=	removeFormatCurrency(minimo_declarado);

		var minimo_kilo						=	$(Fila).find("input[name=minimo_kilo]").val();
		    minimo_kilo						=	removeFormatCurrency(minimo_kilo);
			
		var minimo_kilo_unidad				=	$(Fila).find("input[name=minimo_kilo_unidad]").val();
		    minimo_kilo_unidad				=	removeFormatCurrency(minimo_kilo_unidad);
			
		var minimo_unidad					=	$(Fila).find("input[name=minimo_unidad]").val();
		    minimo_unidad					=	removeFormatCurrency(minimo_unidad);
			
		var precio1							=	$(Fila).find("input[name=precio1]").val();
		    precio1							=	removeFormatCurrency(precio1);
		
		var hasta							=	$(Fila).find("input[name=hasta]").val();
		    hasta							=	removeFormatCurrency(hasta);
			
		var precio2							=	$(Fila).find("input[name=precio2]").val();
		    precio2							=	removeFormatCurrency(precio2);
				
			

		if (parseFloat(minimo_despacho)>=0 && parseFloat(minimo_declarado)>=0){
			if (!tarifas_destino_cliente_id.length > 0) {
				var QueryString = "ACTIONCONTROLER=onclickSave&cliente_id="+cliente_id+"&convencion_id="+convencion_id+"&porcentaje="+porcentaje+"&tipo="+tipo+
				"&periodo="+periodo+"&tasa_seguro="+tasa_seguro+"&minimo_despacho="+minimo_despacho+"&minimo_declarado="+minimo_declarado
				+"&minimo_kilo="+minimo_kilo+"&minimo_kilo_unidad="+minimo_kilo_unidad+"&minimo_unidad="+minimo_unidad+"&precio1="+precio1+"&hasta="+hasta+"&precio2="+precio2;
	
				$.ajax({
					url			: "TarifasClass.php",
					data		: QueryString,
					beforeSend	: function(){
						showDivLoading();
					},
					success		: function(response){
						if (!isNaN(response)) {
							$(Fila).find("input[name=tarifas_destino_cliente_id]").val(response);
							removeDivLoading();
							alertJquery("Tarifa cliente Ingresada correctamente.","Detalle");
						}else{
							removeDivLoading();
							alertJquery(response,"Detalle");
						}
					}
				});
			}else{
				var QueryString = "ACTIONCONTROLER=onclickUpdate&cliente_id="+cliente_id+"&tarifas_destino_cliente_id="+tarifas_destino_cliente_id+
				"&convencion_id="+convencion_id+"&porcentaje="+porcentaje+"&tipo="+tipo+"&periodo="+periodo+"&tasa_seguro="+tasa_seguro+"&minimo_despacho="+minimo_despacho+"&minimo_declarado="+minimo_declarado
				+"&minimo_kilo="+minimo_kilo+"&minimo_kilo_unidad="+minimo_kilo_unidad+"&minimo_unidad="+minimo_unidad+"&precio1="+precio1+"&hasta="+hasta+"&precio2="+precio2;

	
				$.ajax({
					url			: "TarifasClass.php",
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
		}else if(porcentaje==0){
			alertJquery("Debe poner un porcentaje mayor a cero","Validacion");
		}else if( parseFloat(porcentaje)>50){
			alertJquery("Debe poner un porcentaje menor a 50","Validacion");
		}else {
			alertJquery("Debe poner un porcentaje","Validacion");
			
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
		var tercero_id						=	$("#tercero_id").val();
		var periodo							=	$("#periodo").val();
	
	  var url = "TarifasClass.php?tercero_id="+tercero_id+"&periodo="+periodo+"&rand="+Math.random();
	  parent.document.getElementById('tarifa').src=url;
	  //$("#tarifa").attr("src",url);						  	
	
}

function TarifasReset(){

	var form 		= document.forms[0];
	Reset(form);
}