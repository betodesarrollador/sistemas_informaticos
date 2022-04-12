// JavaScript Document
function setDataFormWithResponse(){
	var tercero_id = $('#tercero_id').val();
	RequiredRemove();
	var parametros  = new Array({campos:"tercero_id",valores:$('#tercero_id').val()});
	var forma       = document.forms[0];
	var controlador = 'ClientesClass.php';
	FindRow(parametros,forma,controlador,null,function(resp){

		var data = $.parseJSON(resp);
		cliente_id = data[0]['cliente_id'];
		ocultaFilaNombresRazon(data[0]['tipo_persona_id']);
		if($('#guardar'))    $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#imprimir')) $('#imprimir').attr("disabled","");
		if($('#borrar'))     $('#borrar').attr("disabled","");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");

		var url = "SocioClass.php?tercero_id="+tercero_id+"&rand="+Math.random();
		$("#socios").attr("src",url);

		var url = "ComercialClass.php?tercero_id="+tercero_id+"&rand="+Math.random();
		$("#comerciales").attr("src",url);	

		var url = "OperativaClass.php?tercero_id="+tercero_id+"&rand="+Math.random();
		$("#operativa").attr("src",url);

		var url = "Correo24horasClientesClass.php?cliente_id="+cliente_id+"&rand="+Math.random();
		$("#24h").attr("src",url);
		$("#tarifas24h").css("display","");

		var url = "CorreoNormalClientesClass.php?cliente_id="+cliente_id+"&rand="+Math.random();
		$("#normal").attr("src",url);
		$("#tarifasnormal").css("display","");

		var url = "CorreoMasivoClientesClass.php?cliente_id="+cliente_id+"&rand="+Math.random();
		$("#masivo").attr("src",url);	
		$("#tarifasmasivo").css("display","");
		
		$("#legal,#tributaria,#operativas,#financiera,#comercial").css("display","");
		$("#banco_id,#numcuenta_cliente_factura,#tipo_cta_id,#regimen_id,#recursos_cliente_factura").addClass("obligatorio");
	});
}

function LlenarFormNumId(){
	RequiredRemove();
	FindRow([{campos:"tercero_id",valores:$('#tercero_id').val()}],document.forms[0],'ClientesClass.php');
	if($('#guardar'))    $('#guardar').attr("disabled","true");
	if($('#actualizar')) $('#actualizar').attr("disabled","");
	if($('#imprimir')) $('#imprimir').attr("disabled","");
	if($('#borrar'))     $('#borrar').attr("disabled","");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
}

function onclickDuplicar(formulario){
	
	if($("#divDuplicar").is(":visible")){
	 
	   var tipo_servicio_mensajeria_id 	= $("#tipo_servicio_mensajeria_id").val();
	   var cliente_id 					= $("#cliente_id").val();
	   var periodo   					= $("#periodo").val();
	   var periodo_final   				= $("#periodo_final").val();
	   	
	var QueryString = "ACTIONCONTROLER=onclickDuplicar&"+FormSerialize(formulario)+"&cliente_id="+cliente_id;
	
	$.ajax({
       url        : "ClientesClass.php",
	   data       : QueryString,
	   beforeSend : function(){
		 showDivLoading();
	   },
	   success : function(response){
		   
		   try{
				var data	= $.parseJSON(response);
				if(response=='true'){
					alertJquery('Tarifas Duplicadas Exitosamente',"Duplicar Tarifas");
				}else{
					alertJquery('Error al Duplicar Tarifas.',"Duplicar Tarifas");					
				}
			}catch(e){
				alertJquery(response,"Error");
			}	
						 
	     removeDivLoading();			 
	     }
		 
	 });
	
    }else{
		
		    $("#divDuplicar").dialog({
			  title: 'Duplicar Tarifas',
			  width: 450,
			  height: 280,
			  closeOnEscape:true
             });		
		
	}  
	  
}

function ClienteOnSave(formulario,resp){

	$("#refresh_QUERYGRID_terceros").click();

	try{
		var dataJSON = $.parseJSON(resp)
	}catch(e){
		alertJquery(e);
	}

	if($.isArray(dataJSON)){

		var tercero_id = dataJSON[0]['tercero_id'];
		var cliente_id = dataJSON[0]['cliente_id'];
		var remitente_destinatario_id = dataJSON[0]['remitente_destinatario_id'];
		$("#tercero_id").val(tercero_id);
		$("#cliente_id").val(cliente_id);
		$("#remitente_destinatario_id").val(remitente_destinatario_id);
		$("#legal,#tributaria,#operativas,#financiera,#comercial").css("display","");
		$("#banco_id,#numcuenta_cliente_factura,#tipo_cta_id,#regimen_id,#recursos_cliente_factura").addClass("obligatorio");

		var url = "SocioClass.php?tercero_id="+tercero_id+"&rand="+Math.random();
		$("#socios").attr("src",url);

		var url = "OperativaClass.php?tercero_id="+tercero_id+"&rand="+Math.random();
		$("#operativa").attr("src",url);

		var url = "ComercialClass.php?tercero_id="+tercero_id+"&rand="+Math.random();
		$("#comerciales").attr("src",url);	

		var url = "Correo24horasClass.php?cliente_id="+cliente_id+"&rand="+Math.random();
		$("#24h").attr("src",url);

		var url = "CorreoNormalClass.php?cliente_id="+cliente_id+"&rand="+Math.random();
		$("#normal").attr("src",url);

		var url = "CorreoMavisoClass.php?cliente_id="+cliente_id+"&rand="+Math.random();
		$("#masivo").attr("src",url);	

		sendRemitenteDestinatarioMintransporte(resp,formulario);
		if($('#guardar'))    $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#imprimir'))   $('#imprimir').attr("disabled","");
		if($('#borrar'))     $('#borrar').attr("disabled","");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");

	}else{
		alertJquery("Ocurrio una inconsistencia : "+resp);
		if($('#guardar'))    $('#guardar').attr("disabled","");
		if($('#actualizar')) $('#actualizar').attr("disabled","true");
		if($('#borrar'))     $('#borrar').attr("disabled","true");
		if($('#imprimir'))   $('#imprimir').attr("disabled","true");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");
	}
}

function sendRemitenteDestinatarioMintransporte(resp,formulario){

	if($.trim(resp) == 'true'){

		var QueryString = FormSerialize(formulario)+"&ACTIONCONTROLER=sendRemitenteDestinatarioMintransporte";

		$.ajax({
			url        : "RemitenteClass.php?rand="+Math.random(),
			data       : QueryString,
			beforeSend : function(){
				window.scrollTo(0,0);
				showDivMessage("Reportando al Ministerio de Transporte<br>Por Favor Espere..","/velotax/framework/media/images/general/cable_data_transfer_md_wht.gif");
			},
			success    : function(resp){
				removeDivMessage();
				showDivMessage(resp,"/velotax/framework/media/images/general/cable_data_transfer_md_wht.gif");
				Reset(formulario);
				clearFind();
				$("#tipo").val("R");
				$("#estado").val("D");
				$("#refresh_QUERYGRID_remitente").click();
				if($('#guardar'))    $('#guardar').attr("disabled","");
				if($('#actualizar')) $('#actualizar').attr("disabled","true");
				if($('#borrar'))     $('#borrar').attr("disabled","true");
				if($('#limpiar'))    $('#limpiar').attr("disabled","");
			}
		});
	}else{
		alertJquery(resp);
	}
}

function ClienteOnUpdate(formulario,resp){

	$("#refresh_QUERYGRID_terceros").click();

	if(resp == 'true' || resp == true || !isNaN(resp)){
		var clienteId = isNaN(resp) ? $('#cliente_id').val() : resp;
		$('#cliente_id').val(clienteId);

		$("#legal,#tributaria,#operativas,#financiera,#comercial").css("display","");
		$("#banco_id,#numcuenta_cliente_factura,#tipo_cta_id,#regimen_id,#recursos_cliente_factura").addClass("obligatorio");

		var tercero_id = $('#tercero_id').val();
		var url = "SocioClass.php?tercero_id="+tercero_id+"&rand="+Math.random();
		$("#socios").attr("src",url);

		var url = "ComercialClass.php?tercero_id="+tercero_id+"&rand="+Math.random();
		$("#comerciales").attr("src",url);	

		var url = "OperativaClass.php?tercero_id="+tercero_id+"&rand="+Math.random();
		$("#operativa").attr("src",url);	

		sendRemitenteDestinatarioMintransporte(resp,formulario)

		if($('#guardar'))    $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#imprimir'))   $('#imprimir').attr("disabled","");
		if($('#borrar'))     $('#borrar').attr("disabled","");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");
	}else {
		alertJquery("Ocurrio una inconsistencia : "+resp);
		if($('#guardar'))    $('#guardar').attr("disabled","");
		if($('#actualizar')) $('#actualizar').attr("disabled","true");
		if($('#borrar'))     $('#borrar').attr("disabled","true");
		if($('#imprimir'))   $('#imprimir').attr("disabled","true");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");
	}
}

function ClienteonDelete(formulario,resp){

	$("#socios").attr("src","/velotax/framework/tpl/blank.html");
	$("#operativa").attr("src","/velotax/framework/tpl/blank.html");
	$("#24h").attr("src","/velotax/framework/tpl/blank.html");
	$("#normal").attr("src","/velotax/framework/tpl/blank.html");
	$("#masivo").attr("src","/velotax/framework/tpl/blank.html");
	$("#legal,#tributaria,#operativas,#financiera,#comercial").css("display","none");
	$("#banco_id,#numcuenta_cliente_factura,#tipo_cta_id,#regimen_id,#recursos_cliente_factura").removeClass("obligatorio");

	$("#refresh_QUERYGRID_terceros").click();
	clearFind();
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#imprimir'))   $('#imprimir').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
	$('#estado').val('B');
	alertJquery(resp,"Clientes");
}

function ClienteOnReset(formulario){

	$("#socios").attr("src","/velotax/framework/tpl/blank.html");
	$("#operativa").attr("src","/velotax/framework/tpl/blank.html");
	$("#24h").attr("src","/velotax/framework/tpl/blank.html");
	$("#normal").attr("src","/velotax/framework/tpl/blank.html");
	$("#masivo").attr("src","/velotax/framework/tpl/blank.html");
	$("#legal,#tributaria,#operativas,#financiera,#comercial").css("display","none");
	$("#banco_id,#numcuenta_cliente_factura,#tipo_cta_id,#regimen_id,#recursos_cliente_factura").removeClass("obligatorio");
	clearFind();
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#imprimir'))   $('#imprimir').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
	$('#estado').val('B');
}

function beforePrint(formulario,url,title,width,height){

	var cliente_id = parseInt($("#cliente_id").val());
	if(isNaN(cliente_id)){
		alertJquery('Debe seleccionar un Cliente a imprimir !!!','Impresion Cliente');
		return false;
	}else{
		return true;
	}
}

$(document).ready(function(){

	$("#legal,#tributaria,#operativas,#financiera,#comercial").css("display","none");

	$("#saveDetallesoc").click(function(){
		window.frames[0].saveDetalles();
	});


	$("#deleteDetallesoc").click(function(){
		window.frames[0].deleteDetalles();
	});

	$("#saveDetalleope").click(function(){
		window.frames[1].saveDetalles();
	});


	$("#deleteDetalleope").click(function(){
		window.frames[1].deleteDetalles();
	});

	$("#saveDetalleope").click(function(){
		window.frames[5].saveDetalles();
	});


	$("#deleteDetalleope").click(function(){
		window.frames[5].deleteDetalles();
	});

	$("#tipo_identificacion_id").change(function(){
		calculaDigitoTercero();
	});

	$("#numero_identificacion").blur(function(){

		var tercero_id            = $("#tercero_id").val();
		var cliente_id            = $("#cliente_id").val();
		var numero_identificacion = this.value;
		var params                = new Array({campos:"numero_identificacion",valores:numero_identificacion});

		if(!tercero_id.length > 0){

			validaRegistro(this,params,"ClientesClass.php",null,function(resp){

				if(parseInt(resp) != 0 ){
					var params     = new Array({campos:"numero_identificacion",valores:numero_identificacion});
					var formulario = document.forms[0];
					var url        = 'ClientesClass.php';

					FindRow(params,formulario,url,null,function(resp){

						var data = $.parseJSON(resp);
						ocultaFilaNombresRazon(data[0]['tipo_persona_id']);

						clearFind();

						$('#guardar').attr("disabled","true");
						$('#actualizar').attr("disabled","");
						$('#borrar').attr("disabled","");
						$('#limpiar').attr("disabled","");
						var tercero_id            = $("#tercero_id").val();
						var cliente_id            = $("#cliente_id").val();

						if(cliente_id>0 && tercero_id>0){
							var url = "SocioClass.php?tercero_id="+tercero_id+"&rand="+Math.random();
							$("#socios").attr("src",url);

							var url = "OperativaClass.php?tercero_id="+tercero_id+"&rand="+Math.random();
							$("#operativa").attr("src",url);	
							$("#legal,#tributaria,#operativas,#financiera,#comercial").css("display","");
							$("#banco_id,#numcuenta_cliente_factura,#tipo_cta_id,#regimen_id,#recursos_cliente_factura").addClass("obligatorio");
						}else if(tercero_id>0){
							$('#guardar').attr("disabled","");
							$('#actualizar').attr("disabled","true");
							$('#borrar').attr("disabled","true");
							$('#limpiar').attr("disabled","");
						}
					});
				}else{
					calculaDigitoTercero();
					$('#guardar').attr("disabled","");
					$('#actualizar').attr("disabled","true");
					$('#borrar').attr("disabled","true");
					$('#limpiar').attr("disabled","");
				}
			});
		}
	});

	$("#guardar,#actualizar").click(function(){

		var formulario = document.getElementById('ClientesForm');
		if(ValidaRequeridos(formulario) && ValidaOtrosTercero(formulario)){
			if(this.id == 'guardar'){
				Send(formulario,'onclickSave',null,ClienteOnSave)
			}else{
				Send(formulario,'onclickUpdate',null,ClienteOnUpdate)
			}
		}
	});
	$("#tipo_persona_id").change(function(){
		ocultaFilaNombresRazon(this.value);
	});
});