// JavaScript Document

$(document).ready(function(){

	$("#importSolicitud").attr("disabled","true");
	$("#anular").attr("disabled","true");
	$("#divOrdenServicio").css("display","none");
	$("#divDetallesOrden").css("display","none");
	$("#divAnulacion").css("display","none");

	$("#limpiar").click(function(){
		allReset();
	});
	$('#estado').val('L');

	$("#importSolicitud").click(function(){

		if (ValidaRequeridos(this.form)) {
			var cliente_id		=	$("#cliente_id").val();
			var fecha_inicial	=	$("#fecha_inicial").val();
			var fecha_final		=	$("#fecha_final").val();
			$("#iframeOrdenServicio").attr("src","SolicServToGuiaPaqueteoClass.php?cliente_id="+cliente_id+"&fecha_inicial="+fecha_inicial+"&fecha_final="+fecha_final);
			var formulario = document.getElementById('LiquidacionPorOrdenServicioForm');
			$("#divOrdenServicio").dialog({
				title: 'Solicitud de Servicio para Remesar',
				width: 950,
				height: 395,
				closeOnEscape:true,
				show: 'scale',
				hide: 'scale'
			});
		}
	});

	$("#cliente,#fecha_inicial,#fecha_final").change(function(){
		if (!isNaN($("#cliente_id"))) {
			$("#importSolicitud").attr("disabled","true");
		}else{
			$("#importSolicitud").attr("disabled","");
		}
	});
	$("#iframeDetallesOrden").load(function(){
		closeDialog();
	});
});

function closeDialog(){
	$("#divOrdenServicio").dialog('close');
}
function botonGuardar(){
	$("#guardar").attr("disabled","");
}
function cargaDatos(solicitud){

	var url	=	"DetalleLiquidacionSolicitudServiciosClass.php?solicitud_id="+solicitud;
	document.getElementById('iframeDetallesOrden').src = url;
	$("#divDetallesOrden").css("display","");
}
function cargaDatosAnula(solicitud){

	var url	=	"DetalleLiquidacionSolicitudServiciosClass.php?ACTIONCONTROLER=cargaDatosAnular&solicitud_id="+solicitud;
	document.getElementById('iframeDetallesOrden').src = url;
	$("#divDetallesOrden").css("display","");
}

function OnClickSave(formulario){

	if(ValidaRequeridos(formulario)){
		var cliente_id			= document.getElementById("cliente_id").value;
		var estado				= document.getElementById("estado").value;
		var fecha_inicial		= document.getElementById("fecha_inicial").value;
		var fecha_final			= document.getElementById("fecha_final").value;
		var usuario_id			= document.getElementById("usuario_id").value;
		var oficina_id			= document.getElementById("oficina_id").value;
		var fecha_liquidacion	= document.getElementById("fecha_liquidacion").value;
		if (!isNaN(cliente_id)) {
			var QueryString		= "ACTIONCONTROLER=OnClickSave&cliente_id="+cliente_id+"&estado="+estado+"&fecha_inicial="+fecha_inicial+
			"&fecha_final="+fecha_final+"&usuario_id="+usuario_id+"&oficina_id="+oficina_id+"&fecha_liquidacion="+fecha_liquidacion;
			$.ajax({
				url			: "LiquidacionPorOrdenServicioClass.php?rand="+Math.random(),
				data		: QueryString,
				beforeSend	: function(){
					showDivLoading();
				},
				success    : function(resp){
					try{
						window.frames[0].facturaOrdenes(resp);
					}catch(e){
						alertJquery(resp,"Error :"+e);
					}
					removeDivLoading();
				}
			});
		}
	}
}

function OnClickCancel(formulario){

	if($("#divAnulacion").is(":visible")){

		var observacion_anulacion       = $("#observacion_anulacion").val();
		if(ValidaRequeridos(formulario)){
			var cliente_id			= document.getElementById("cliente_id").value;
			var consecutivo			= document.getElementById("consecutivo").value;
			var liquidacion_id		= document.getElementById("liquidacion_id").value;
			if (!isNaN(cliente_id)) {
				var QueryString		= "ACTIONCONTROLER=OnClickCancel&cliente_id="+cliente_id+"&consecutivo="+consecutivo+
				"&liquidacion_id="+liquidacion_id+"&observacion_anulacion="+observacion_anulacion;
				$.ajax({
					url			: "LiquidacionPorOrdenServicioClass.php?rand="+Math.random(),
					data		: QueryString,
					beforeSend	: function(){
						showDivLoading();
					},
					success    : function(resp){
						try{
							if (!isNaN(resp)) {
								allReset();
								alertJquery("Proceso de anulacion terminado correctamente.","Anulacion");
								$("#divAnulacion").dialog('close');
							}else{
								alertJquery(resp,"Error");
								$("#divAnulacion").dialog('close');
							}
						}catch(e){
							alertJquery(resp,"Error :"+e);
							$("#divAnulacion").dialog('close');
						}
						removeDivLoading();
					}
				});
			}
		}
	}else{
		var liquidacion_id = $("#liquidacion_id").val();
		if(parseInt(liquidacion_id) > 0){
			$("#anular").attr("disabled","");
			$("#divAnulacion").dialog({
				title: 'Anulacion Liquidacion',
				width: 450,
				height: 280,
				closeOnEscape:true
			});
		}else{
			alertJquery('Debe Seleccionar primero una Liquidacion','Anulacion');
		}
	}
}

function getSolicitudes(liquidacion_id){

	var QueryString  = "ACTIONCONTROLER=selectSolicitudes&liquidacion_id="+liquidacion_id;
	$.ajax({
		url	: "LiquidacionPorOrdenServicioClass.php?rand="+Math.random(),
		data: QueryString,
		beforeSend	: function(){
			showDivLoading();
		},
		success		: function(resp){
			cargaDatosAnula(resp);
			removeDivLoading();
		}
	});
}

function allReset(){

	var formulario = document.forms[0];
	Reset(formulario);
	$("#busqueda").val('');
	$("#importSolicitud").attr("disabled","true");
	$("#divDetallesOrden").css("display","none");
	var url = "about:blank";
	document.getElementById('iframeDetallesOrden').src = url;
	$("#guardar").attr("disabled","true");
	$("#anular").attr("disabled","true");
	$("#fecha_inicial").attr("disabled","");
	$("#fecha_final").attr("disabled","");
	$('#estado').val('L');
	$('#consecutivo').val();
	// var QueryString	=	"ACTIONCONTROLER=setConsecutivo";
	// $.ajax({
	// 	url	:	'LiquidacionPorOrdenServicioClass.php?random='+Math.random(),
	// 	data: 	QueryString,
	// 	beforeSend: function(){
	// 		showDivLoading();
	// 	},
	// 	success: function(resp){
	// 		$("#consecutivo").val(resp);
	// 		removeDivLoading();
	// 	}
	// });
}

function mensaje(msg,title){
	alertJquery(msg,title);
}

function setDataFormWithResponse(){

	var forma		=	document.forms[0];
	liquidacion_id	=	$("#liquidacion_id").val();
	var QueryString	=	"ACTIONCONTROLER=onclickFind&liquidacion_id="+liquidacion_id;

	$.ajax({
		url        : 'LiquidacionPorOrdenServicioClass.php?random='+Math.random(),
		data       : QueryString,
		beforeSend : function(){
			showDivLoading();
		},
		success    : function(resp){
			try{

				var data	=	$.parseJSON(resp);
				var estado	=	data[0]['estado'];
				setFormWithJSON(forma,data,false,function(){
					$("#fecha_inicial").attr("disabled","true");
					$("#fecha_inicial").css("required","");
					$("#fecha_inicial").removeClass("obligatorio");
					$("#fecha_final").attr("disabled","true");
					$("#fecha_final").css("required","");
					$("#fecha_final").removeClass("obligatorio");
					removeDivLoading();
					var liquidacion_id	= $("#liquidacion_id").val();
					getSolicitudes(liquidacion_id);
					if(estado == 'A' || estado == 'F'){
						if($('#guardar'))	$('#guardar').attr("disabled","true");
						if($('#anular'))	$('#anular').attr("disabled","true");
					}else{
						if($('#guardar'))	$('#guardar').attr("disabled","true");
						if($('#anular'))	$('#anular').attr("disabled","");
					}
				});
			}catch(e){
				removeDivLoading();
			}
		}
	});
}