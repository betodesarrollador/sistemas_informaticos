// JavaScript Document
$(document).ready(function(){
	
	checkRow();
	
	autocompleteUbicacion();
	autocompleteNovedad();
	
	linkDetallesMonitoreo();
	
	indexarOrden();
	
	addCambiaArribo();
	addchangeTimeStop();
	
	calculaPasoEstimado();
	
	
	$("input[name=puesto_control]").click(function(event){
		
		var Fila  = this.parentNode.parentNode;
		
		if ( $(Fila).find("pre").css("display") == "none" ){
			$(Fila).find("pre").show('slow');
			verObserDeta(Fila);
		}
		else{
			$(Fila).find("pre").hide('fast');
			ocultaObserDeta(Fila);
		}
	});
	
	
	$("textarea[name=obser_deta]").focus(function(){
		var Fila  = this.parentNode.parentNode;
		verObserDeta(Fila);
	});
	
	
	$("textarea[name=obser_deta]").blur(function(){
		var Fila  = this.parentNode.parentNode;
		ocultaObserDeta(Fila);
	});
	
	
	$("textarea[name=obser_deta]").keyup(function(event){
		var Fila  = this.parentNode.parentNode;
		resizeObserDeta(Fila)
	});
});


function checkedAll(){
	$("#checkedAll").click(function(){
	
		if($(this).is(":checked")){
			$("input[name=procesar]").attr("checked","true");
		}else{
			$("input[name=procesar]").attr("checked","");
		}
	});
}


function checkRow(){
	$("input[type=text]").keyup(function(event){
		
		var Tecla = event.keyCode;
		var Fila  = this.parentNode.parentNode;
		
		$(Fila).find("input[name=procesar]").attr("checked","true");
	});
}


/***************************************************************
	  lista inteligente para la ubicacion con jquery
**************************************************************/
function autocompleteUbicacion(){
	$("input[name=ubicacion]").autocomplete("/roa/framework/clases/ListaInteligente.php?consulta=ubicacion",{
		width: 260,
		selectFirst: false
	});
	
	$("input[name=ubicacion]").result(function(event, data, formatted){
		if (data) $(this).next().val(data[1]);
	});
}


/***************************************************************
	  lista inteligente para la Novedad con jquery
**************************************************************/
function autocompleteNovedad(){
	
	$("input[name=novedad]").autocomplete("/roa/framework/clases/ListaInteligente.php?consulta=novedad",{
		width: 260,
		selectFirst: false
	});
	
	$("input[name=novedad]").result(function(event, data, formatted){
		if (data) $(this).next().val(data[1]);
	});
}


/***************************************************************
  Funciones para el objeto de guardado en los edtalles de ruta
***************************************************************/
function linkDetallesMonitoreo(){
	
	$("a[name=saveDetalleMonitoreo]").attr("href","javascript:void(0)");
	
	$("a[name=saveDetalleMonitoreo]").focus(function(){
		calculaRetraso(this);
		var celda = this.parentNode;
		$(celda).addClass("focusSaveRow");
	});
	
	$("a[name=saveDetalleMonitoreo]").blur(function(){
		var celda = this.parentNode;
		$(celda).removeClass("focusSaveRow");
	});
	
	$("a[name=saveDetalleMonitoreo]").click(function(){
		//saveDetalleMonitoreo(this);
		saveDetallesMonitoreo();
	});
}


/**
* funcion para arrastrar las filas
* de la tabla a cualquier orden
*/
function iniDragTable(){
	$('#tableDetalleMonitoreo').tableDnD({
		onDrop: function(table, row){
			indexarOrden();
			//calculaPasoEstimado();
			//calculaRecorridoAcumulado();
		},
		dragHandle: "dragHandle"
	});
	
	$("#tableDetalleMonitoreo tr").hover(function(){
			$(this).find("input[name=orden_det_seg]").addClass('showDragHandle');
	}, function(){
			$(this).find("input[name=orden_det_seg]").removeClass('showDragHandle');
	});
}


/**
* funcion para poner el numero de 
* orden de forma automatica en el 
* detalle de la tabla
*/
function indexarOrden(){
	$("#tableDetalleMonitoreo tbody > tr").each(function(index){
		
		if ( $(this).find("input[name=orden_det_seg]").val() != (index+1) ){
		
			$(this).find("input[name=orden_det_seg]").val((index+1));
			
			if ( ( $(this).find("input[name=detalle_seg_id]").val() != "") )
				$(this).find("input[name=procesar]").attr("checked","true");
		}
	});
}


/**
* funciona para asociar el evento blur de
* los campos de texto de tiempo arribo
*/
function addCambiaArribo(){
	
	var Fila = $('#tableDetalleMonitoreo tr:last');
	$(Fila).find("input[name=fecha_reporte], input[name=hora_reporte]").blur(function(){
		FindPosition(this);
	});
	
	$(Fila).find("a[name=saveDetalleMonitoreo]").unbind('focus');
	
	$(Fila).find("a[name=saveDetalleMonitoreo]").focus(function(){
		var celda = this.parentNode;
		$(celda).addClass("focusSaveRow");
	});
}


function addchangeTimeStop(){
	
	var Fila = $('#tableDetalleMonitoreo tr:last');
	$(Fila).find("input[name=tiempo_novedad]").blur(function(){
		
		$(Fila).find("input[name=paso_estimado]").val( sumaMinutos( $(Fila).find("input[name=paso_estimado]").val(), -parseInt($(Fila).find("input[name=tiempo_novedad]").val()) ) );
		$(Fila).find("input[name=retraso]").val( $(Fila).find("input[name=tiempo_novedad]").val() );
		
	});
}


function saveDetalleMonitoreo(obj){
	
	var row = obj.parentNode.parentNode;
	
	if(validaRequeridosDetalle(obj,row)){
		
		var Celda          = obj.parentNode;
		var Fila           = obj.parentNode.parentNode;
		var seguimiento_id = $("#seguimiento_id").val();
		var detalle_seg_id = $(Fila).find("input[name=detalle_seg_id]").val();
		var orden_det_seg  = $(Fila).find("input[name=orden_det_seg]").val();
		var ubicacion_id   = $(Fila).find("input[name=ubicacion_id]").val();
		var paso_estimado  = $(Fila).find("input[name=paso_estimado]").val();
		var fecha_reporte  = $(Fila).find("input[name=fecha_reporte]").val();
		var hora_reporte   = $(Fila).find("input[name=hora_reporte]").val();
		var novedad_id     = $(Fila).find("input[name=novedad_id]").val();
		var tiempo_novedad = $(Fila).find("input[name=tiempo_novedad]").val();
		var retraso        = $(Fila).find("input[name=retraso]").val();
		var obser_deta     = $(Fila).find("textarea[name=obser_deta]").val();
		var checkProcesar  = $(Fila).find("input[name=procesar]");
		
		if(!novedad_id.length > 0){ novedad_id = 'NULL' }
		if(!obser_deta.length > 0){ obser_deta = 'NULL' }
		
		if(!detalle_seg_id.length > 0){
			if( $('#guardar',parent.document).length > 0 ){/*se valida el permiso de guardar*/
				detalle_seg_id  = 'NULL';
				
				var QueryString = "ACTIONCONTROLER=onclickSave&seguimiento_id="+seguimiento_id+"&detalle_seg_id="+detalle_seg_id+
				"&orden_det_seg="+orden_det_seg+"&ubicacion_id="+ubicacion_id+"&paso_estimado="+paso_estimado+"&fecha_reporte="+fecha_reporte+
				"&hora_reporte="+hora_reporte+"&novedad_id="+novedad_id+"&tiempo_novedad="+tiempo_novedad+
				"&retraso="+retraso+"&obser_deta="+obser_deta;
				
				
				$.ajax({
					
					url        : "DetalleMonitoreoClass.php",
					data       : QueryString,
					beforeSend : function(){
						checkProcesar.attr("checked","");
					},
					success    : function(response){
						
						//alert("save");
						checkProcesar.attr("checked","");
						if(!isNaN(response)){
							
							$(Fila).find("input[name=detalle_seg_id]").val(response);
							$(Celda).removeClass("focusSaveRow");
							
							var Table   = document.getElementById('tableDetalleMonitoreo');
							var numRows = (Table.rows.length);
							var newRow  = Table.insertRow(numRows);
							
							$(newRow).html($("#clon").html());
							//$(newRow).find("input[name=orden_det_ruta]").focus();
							
							autocompleteUbicacion();
							autocompleteNovedad();
							linkDetallesMonitoreo();
							//addCambiaArribo();
							checkRow();
							
							indexarOrden();
							//iniDragTable();
							
							//addCambiaTiempo();
							//addCambiaDistancia();
							
						}else{
							alert(response);
						}
					}
				});
			}
		}else{
			if( $('#actualizar',parent.document).length > 0 ){/*se valida el persmiso de actualizar*/
				var QueryString = "ACTIONCONTROLER=onclickUpdate&seguimiento_id="+seguimiento_id+"&detalle_seg_id="+detalle_seg_id+
				"&orden_det_seg="+orden_det_seg+"&ubicacion_id="+ubicacion_id+"&fecha_reporte="+fecha_reporte+
				"&hora_reporte="+hora_reporte+"&novedad_id="+novedad_id+"&tiempo_novedad="+tiempo_novedad+
				"&retraso="+retraso+"&obser_deta="+obser_deta;
				
				
				$.ajax({
					
					url        : "DetalleMonitoreoClass.php",
					data       : QueryString,
					beforeSend : function(){
						checkProcesar.attr("checked","");
					},
					success    : function(response){
						//alert("update");
						if( $.trim(response) == 'true'){
							//$(Fila).find("a[name=saveDetalleMonitoreo]").parent().addClass("focusSaveRow");
						}else{
							alert(response);
						}
					}
				});
			}
		}
	}
}


function deleteDetalleMonitoreo(obj){
	
	var Celda           = obj.parentNode;
	var Fila            = obj.parentNode.parentNode;
	var detalle_seg_id	= $(Fila).find("input[name=detalle_seg_id]").val();
	var QueryString     = "ACTIONCONTROLER=onclickDelete&detalle_seg_id="+detalle_seg_id;
	
	if(detalle_seg_id.length > 0){
		if( $('#borrar',parent.document).length > 0 ){/*se valida el permiso de borrar*/
			$.ajax({
				
				url        : "DetalleMonitoreoClass.php",
				data       : QueryString,
				beforeSend : function(){},
				success    : function(response){
					
					if( $.trim(response) == 'true'){
						
						var numRow = (Fila.rowIndex - 1);
						Fila.parentNode.deleteRow(numRow);
						
						indexarOrden();
						iniDragTable();
						
						//calculaPasoEstimado();
						//calculaRecorridoAcumulado();
						
					}else{
						alert(response);
					}
				}
			});
		}
	}else{
		alert('No puede eliminar elementos que no han sido guardados');
		$(Fila).find("input[name=procesar]").attr("checked","");
	}
}


function saveDetallesMonitoreo(){
	$("input[name=procesar]:checked").each(function(){
		saveDetalleMonitoreo(this);
	});
}


function deleteDetallesMonitoreo(){
	$("input[name=procesar]:checked").each(function(){
		deleteDetalleMonitoreo(this);
	});
}


function calculaRetraso(obj){

	var Retraso     = 0;
	var RetrasoTemp = 0;
	var FechaArribo = "";
    var Celda       = obj.parentNode;
    var Fila        = obj.parentNode.parentNode;
	
	Retraso = diferenciaFechas( $(Fila).find("input[name=fecha_reporte]").val()+" "+$(Fila).find("input[name=hora_reporte]").val() ,$(Fila).find("input[name=paso_estimado]").val() );
	Retraso = parseInt(Retraso) + parseInt( $(Fila).find("input[name=tiempo_novedad]").val() );
	
	$(Fila).find("input[name=retraso]").val(  parseInt(Retraso)  );
	
	$("#tableDetalleMonitoreo tbody > tr").each(function(index){
		if( index >= (Fila.rowIndex) && (  $(this).find("input[name=fecha_reporte]").val().length > 0 && $(this).find("input[name=hora_reporte]").val().length > 0 ) ){
			
			$(this).find("input[name=paso_estimado]").val( sumaMinutos( $(this).find("input[name=paso_estimado]").val() , Retraso) );
			
			FechaArribo = sumaMinutos( $(this).find("input[name=fecha_reporte]").val()+" "+$(this).find("input[name=hora_reporte]").val() , Retraso).split(" ");
			
			$(this).find("input[name=fecha_reporte]").val( FechaArribo[0] );
			$(this).find("input[name=hora_reporte]").val( FechaArribo[1] );
			
			$(this).find("input[name=procesar]").attr("checked","true");
			
		}
	});
}


function FindPosition(obj){
	
	var Table         = document.getElementById('tableDetalleMonitoreo');
	var numRows       = (Table.rows.length);
	var newPosition   = numRows;
    var Celda         = obj.parentNode;
    var Fila          = obj.parentNode.parentNode;
	var fecha_reporte = $(Fila).find("input[name=fecha_reporte]").val();
	var hora_reporte  = $(Fila).find("input[name=hora_reporte]").val();
	
	if(fecha_reporte.length > 0 && hora_reporte.length > 0){
		
		$("#tableDetalleMonitoreo tbody > tr").each(function(index){
			if( ( diferenciaFechas( $(Fila).find("input[name=fecha_reporte]").val()+" "+$(Fila).find("input[name=hora_reporte]").val(), $(this).find("input[name=fecha_reporte]").val()+" "+$(this).find("input[name=hora_reporte]").val() ) ) > 0 ){
				newPosition = index+1;
			}
		});
		
		$("#tableDetalleMonitoreo tbody > tr").each(function(index){
			if( parseInt( $(this).find("input[name=orden_det_seg]").val() ) > newPosition ){
				$(this).find("input[name=orden_det_seg]").val( parseInt( $(this).find("input[name=orden_det_seg]").val() ) + 1 );
				$(this).find("input[name=procesar]").attr("checked","true");
			}
		});
		
		$(Fila).find("input[name=orden_det_seg]").val( newPosition+1 );
		$(Fila).find("input[name=paso_estimado]").val( fecha_reporte+" "+hora_reporte );
	}
}


function calculaPasoEstimado(){
	var Retraso         = 0;
	var pasoEstimado    = "";
	var fechaArriboTemp = "";
	var horaArriboTemp  = "";
	var fechaPasoTemp   = "";
	
	$("#tableDetalleMonitoreo tbody > tr").each(function(index){
		
		if(! $(this).find("input[name=paso_estimado]").val().length > 0 ){
			
			$(this).find("input[name=paso_estimado]").val( pasoEstimado );
			$(this).find("input[name=fecha_reporte]").val(fechaArriboTemp);
			$(this).find("input[name=hora_reporte]").val(horaArriboTemp);
		}
		
		pasoEstimado = sumaMinutos(  $(this).find("input[name=paso_estimado]").val() , Retraso  );
		
		$(this).find("input[name=paso_estimado]").val( pasoEstimado );
		
		Retraso = parseInt( $(this).find("input[name=retraso]").val() ) + parseInt(Retraso);
		fechaPasoTemp   = $(this).find("input[name=paso_estimado]").val();
		fechaArriboTemp = $(this).find("input[name=fecha_reporte]").val();
		horaArriboTemp  = $(this).find("input[name=hora_reporte]").val();
		
			/*alert(fechaPasoTemp);
			$(this).find("input[name=paso_estimado]").val( $(this.rowIndex-1 ).find("input[name=hora_reporte]").val() );
			$(this).find("input[name=fecha_reporte]").val(fechaArriboTemp);
			$(this).find("input[name=hora_reporte]").val(horaArriboTemp);*/
		
	});
}


/**
* las dos fechas deben ser cadenas de texto con 
* el siguiente formato 1999-12-31 24:59:59
*/
function fechasIguales(fecha1, fecha2){
	
	fecha1  = fecha1.split(" ");
	fecha2  = fecha2.split(" ");
	var fecha1D = fecha1[0].split("-");
	var fecha1T = fecha1[1].split(":");
	var fecha2D = fecha2[0].split("-");
	var fecha2T = fecha2[1].split(":");
	
	fecha1 = new Date(fecha1D[0],(fecha1D[1]-1),fecha1D[2],
							fecha1T[0],fecha1T[1],fecha1T[2]);
	
	fecha2 = new Date(fecha2D[0],(fecha2D[1]-1),fecha2D[2],
							fecha2T[0],fecha2T[1],fecha2T[2]);
	
	if(fecha1.getTime() == fecha2.getTime())
		return true;
	else 
		return false;
}


/**
* la fecha debe ser cadena de texto con
* el siguiente formato 1999-12-31 24:59:59
* los minutos debe ser un valor entero
*/
function sumaMinutos(fecha, minutos){
	
	fecha  = fecha.split(" ");
	var fechaD = fecha[0].split("-");
	var fechaT = fecha[1].split(":");
	
	fecha = new Date(fechaD[0],(fechaD[1]-1),fechaD[2],
							fechaT[0],fechaT[1],fechaT[2]);
	
	
	fecha.setMinutes( fecha.getMinutes() + parseInt(minutos));
	
	var fechaFinal = fecha.getFullYear()+"-"+(fecha.getMonth()+1)+"-"+fecha.getDate()+
							" "+fecha.getHours()+":"+fecha.getMinutes()+":"+fecha.getSeconds();
	
	
	return fechaFinal;
}


/**
* las dos fechas deben ser cadenas de texto con 
* el siguiente formato 1999-12-31 24:59:59
* el valor retornado se expresa en minutos
*/
function diferenciaFechas(fecha1, fecha2){
	
	fecha1  = fecha1.split(" ");
	fecha2  = fecha2.split(" ");
	var fecha1D = fecha1[0].split("-");
	var fecha1T = fecha1[1].split(":");
	var fecha2D = fecha2[0].split("-");
	var fecha2T = fecha2[1].split(":");
	
	fecha1 = new Date(fecha1D[0],(fecha1D[1]-1),fecha1D[2],
							fecha1T[0],fecha1T[1],fecha1T[2]);
	
	fecha2 = new Date(fecha2D[0],(fecha2D[1]-1),fecha2D[2],
							fecha2T[0],fecha2T[1],fecha2T[2]);
	
	return Math.ceil( (fecha1.getTime() - fecha2.getTime()) / (60000) );
	
}


function verObserDeta(Fila){
	resizeObserDeta(Fila);
	$(Fila).find("textarea[name=obser_deta]").css("display","none")
	$(Fila).find("textarea[name=obser_deta]").show("slow");
}


function ocultaObserDeta(Fila){
	$(Fila).find("textarea[name=obser_deta]").hide("slow",function () {
		$(this).css({'height' : '14px', 'display' : 'inherit'});
	});
}


function resizeObserDeta(Fila){
	var heightTextArea =  Math.ceil( (($(Fila).find("textarea[name=obser_deta]").attr("value").length / 15) * 12) + 12 ) + "px";
	$(Fila).find("textarea[name=obser_deta]").css("height", heightTextArea);
}