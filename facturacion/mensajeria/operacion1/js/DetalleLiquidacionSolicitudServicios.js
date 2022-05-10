// JavaScript Document
function facturaOrdenes(liquidacion_id){
	if (!isNaN(liquidacion_id)) {
		var liquidacion		=	liquidacion_id;
		var k = 0;
		var i = 0;
		$("input[name=solicitud_id]").each(function(){
			k++;
		});

		var solicitud	=	new Array(k);
		$("input[name=solicitud_id]").each(function(){
			var solicitud_id = this.value;
			solicitud[i] = solicitud_id;
			i++;
		});

		var QueryString	= "ACTIONCONTROLER=OnClickSave&liquidacion_id="+liquidacion_id+"&solicitud_id="+solicitud;
		$.ajax({
			url			: "DetalleLiquidacionSolicitudServiciosClass.php?rand="+Math.random(),
			data		: QueryString,
			beforeSend	: function(){
				showDivLoading();
			},
			success    : function(resp){
				// alert(resp);
				if(resp=='true'){
					parent.mensaje('Proceso de liquidacion terminado exitosamente.','Terminado');
				}else if(resp=='false'){
					parent.mensaje('No se puede terminar la liquidacion','Error en la liquidacion');
				}else{
					parent.mensaje(resp,'Error en la liquidacion');
				}
				removeDivLoading();
				parent.allReset();
			}
		});
	}else{
		parent.mensaje(liquidacion_id,"Error");
	}
}

function AnularfacturaOrdenes(liquidacion_id){
	var liquidacion		=	liquidacion_id;
	var k = 0;
	var i = 0;
	$("input[name=solicitud_id]").each(function(){
		k++;
	});

	var solicitud	=	new Array(k);
	$("input[name=solicitud_id]").each(function(){
		var solicitud_id = this.value;
		solicitud[i] = solicitud_id;
		i++;
	});

	var QueryString	= "ACTIONCONTROLER=OnClickCancel&liquidacion_id="+liquidacion_id+"&solicitud_id="+solicitud;
	$.ajax({
		url			: "DetalleLiquidacionSolicitudServiciosClass.php?rand="+Math.random(),
		data		: QueryString,
		beforeSend	: function(){
			showDivLoading();
		},
		success    : function(resp){
			// alert(resp);
			if(resp=='true'){
				parent.mensaje('Proceso anulacion de liquidacion terminado exitosamente.','Terminado');
			}else if(resp=='false'){
				parent.mensaje('No se puede terminar la liquidacion','Error en la liquidacion');
			}
			removeDivLoading();
			parent.allReset();
		}
	});
}