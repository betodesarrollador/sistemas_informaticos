// JavaScript Document
$(document).ready(function(){
	//$("input[name=ubicacion]:first").focus();
	checkedAll();
	
	checkRow();
	autocompleteUbicacion();
	autocompletePunto();
	linkDetallesSeguimiento();
	indexarOrden();
	comp_date();
	editar_remesas();
	//addCambiaTiempo();
	//addCambiaDistancia();
	
	//calculaPasoEstimado();
	//calculaRecorridoAcumulado();
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
		//var Tecla = event.keyCode;
		var Fila  = this.parentNode.parentNode;
		
		$(Fila).find("input[name=procesar]").attr("checked","true");
	});
	
	$("select").change(function(event){
		//var Tecla = event.keyCode;
		var Fila  = this.parentNode.parentNode;
		
		$(Fila).find("input[name=procesar]").attr("checked","true");
	});	
}


/***************************************************************
	  lista inteligente para la ubicacion con jquery
**************************************************************/
function autocompleteUbicacion(){
	
	$("input[name=ubicacion]").autocomplete("/roa/framework/clases/ListaInteligente.php?consulta=ubicacion",{
		width: 450,
		selectFirst: false
	});
	
	$("input[name=ubicacion]").result(function(event, data, formatted){
		if (data) $(this).next().val(data[1]);
	});
}

function autocompletePunto(){
	
	$("input[name=punto_referencia]").autocomplete("/roa/framework/clases/ListaInteligente.php?consulta=ubicacion_punto_referencia",{
		width: 450,
		selectFirst: false
	});
	
	$("input[name=punto_referencia]").result(function(event, data, formatted){
	    if (data){
			var row = this.parentNode.parentNode;
			details=data[1].split("-");
			details_nom=data[0].split("-");
			$(row).find("input[name=ubicacion]").val(details_nom[1]);
			$(row).find("input[name=ubicacion_id]").val(details[1]);
			$(row).find("input[name=punto_referencia]").val(details_nom[0]);
			$(row).find("input[name=punto_referencia_id]").val(details[0]);			
			$(row).find("input[name=tipo_punto]").val(details[2]);				
			
		}
	});
}

/***comprobar fechas ****/
function comp_date(){
	
	$("input[name=fecha_reporte]").blur(function(){
									
		var fecha_escrita=$(this).val();
		var fecha_actual= $("#FechaActual").val();
		var fecha_salida= $("#FechaSalida").val();		

		fecha_escrita=fecha_escrita.split("-");
		fecha_actual= fecha_actual.split("-");
		fecha_salida= fecha_salida.split("-");	
		
		fecha_escrita_new= new Date(fecha_escrita[0],fecha_escrita[1]-1,fecha_escrita[2]);
		fecha_actual_new= new Date(fecha_actual[0],fecha_actual[1]-1,fecha_actual[2]);
		fecha_salida_new= new Date(fecha_salida[0],fecha_salida[1]-1,fecha_salida[2]);

		if(parseInt(fecha_escrita_new.getTime()) > parseInt(fecha_actual_new.getTime()) || parseInt(fecha_escrita_new.getTime()) < parseInt(fecha_salida_new.getTime())){
			
			$(this).val($("#FechaActual").val());
			if(parseInt(fecha_escrita_new.getTime()) > parseInt(fecha_actual_new.getTime()))
				alertJquery("Fecha Ingresada Superior a la Actual");					
			else if( parseInt(fecha_escrita_new.getTime()) < parseInt(fecha_salida_new.getTime()))	
				alertJquery("Fecha Ingresada Inferior a la Fecha de Salida");
		
		}
	});
	
	
}

/** Editar asignacion de remesas**/

function editar_remesas(){
	$("a[name=AsignRemesas]").click(function(){

		var Fila                = this.parentNode.parentNode;
		var detalle_seg_id	    = $(Fila).find("input[name=detalle_seg_id]").val();
		if(parseInt(detalle_seg_id)>0){
			parent.cargardivedit(detalle_seg_id);
		}else{
			alertJquery("No se puede Asignar Remesas, Detalle No ingresado");	
		}

	});
	
}


function comprobar_novedad(obj){
		
	var Celda               = obj.parentNode;
	var Fila                = obj.parentNode.parentNode;
	var trafico_id      	= $("#trafico_id").val();
	var novedad_id	    	= $(Fila).find("select[name=novedad_id]").val();
	
	//$(Fila).find("input[name=fecha_reporte]").attr("readonly","readonly");
//	$(Fila).find("input[name=hora_reporte]").attr("readonly","readonly");
//	
	if(novedad_id.length > 0){
		
		if(novedad_id == 11){
			
			var QueryString = "ACTIONCONTROLER=comprobar_finalizacion&trafico_id="+trafico_id;
			
		$.ajax({
			
			url        : "DetalleSeguimientoClass.php?rand="+Math.random(),
			data       : QueryString,
			beforeSend : function(){
			  //setMessageWaiting();
			},
			success    : function(response){
				
              try{
				  	if(response == "false"){
						
						alertJquery("ADVERTENCIA: no se han finalizado todas las remesas verifique porfavor","ADVERTENCIA");
					}
				  }catch(e){
				  alertJquery(response);
				}
				    
			}/*fin del success*/
			});
		}
		
		

			
		var QueryString = "ACTIONCONTROLER=comprobar_novedad&novedad_id="+novedad_id;

		$.ajax({
			
			url        : "DetalleSeguimientoClass.php?rand="+Math.random(),
			data       : QueryString,
			beforeSend : function(){
			  //setMessageWaiting();
			},
			success    : function(response){
				
              try{
				   var data           = $.parseJSON(response);  
					
				   var QueryString    = "ACTIONCONTROLER=getTipoCausal&finaliza="+data[0]['finaliza_remesa']+"&devolucion="+data[0]['devolucion'];
				   
				   $.ajax({
					 url        : "DetalleSeguimientoClass.php?rand="+Math.random(),
					 data       : QueryString,
					 beforeSend : function(){
					 },
					 success    : function(resp){			 
						 $(Fila).find("select[name=causal_devolucion_id]").parent().html(resp);
						if(data[0]['requiere_remesa']==1){
							$(Fila).find("select[name=remesa_id]").attr("disabled","");
							$(Fila).find("select[name=causal_devolucion_id]").attr("disabled","");
						}else{
							$(Fila).find("select[name=remesa_id]").attr("disabled","true");
							$(Fila).find("select[name=causal_devolucion_id]").attr("disabled","true");	
							
							$(Fila).find("select[name=remesa_id]").val("NULL");
							$(Fila).find("select[name=causal_devolucion_id]").val("NULL");					
							
						}
						if (novedad_id == 6){
					
					
					$(Fila).find("input[name=fecha_reporte]").removeAttr("readonly");
					$(Fila).find("input[name=hora_reporte]").removeAttr("readonly");
					
					}
					else{
					
					//alert("asdasdasd");
					$(Fila).find("input[name=fecha_reporte]").attr("readonly","readonly");
					$(Fila).find("input[name=hora_reporte]").attr("readonly","readonly");
					
					var det_seg_id =parseInt($(Fila).find("input[name=detalle_seg_id]").val());
						
					var QueryString1 = "ACTIONCONTROLER=comprobacion_fecha_hora&det_seg_id="+det_seg_id;
					
					$.ajax({
					   
						url        : "DetalleSeguimientoClass.php?rand="+Math.random(),
						data       : QueryString1,
						 beforeSend : function(){
							 
						 },
						 success    : function(response){
							
							  try{
								  
								  var lista           = $.parseJSON(response); 
								  
								  $(Fila).find("input[name=fecha_reporte]").val(lista[0]['fecha_reporte']);
								  $(Fila).find("input[name=hora_reporte]").val(lista[0]['hora_reporte']);
								  
								 }catch(e){
								  alertJquery(response);
								}
							}
					   
					});
					
		}
						
					 }
				   });
					

			  }catch(e){
				  alertJquery(response);
				}
          
				
			}/*fin del success*/
		});
		
	}
}

/***************************************************************
  Funciones para el objeto de guardado en los edtalles de ruta
***************************************************************/
function linkDetallesSeguimiento(){
	
	$("a[name=saveDetalleSeguimiento]").attr("href","javascript:void(0)");
	
	$("a[name=saveDetalleSeguimiento]").focus(function(){
		var celda = this.parentNode;
		$(celda).addClass("focusSaveRow");
	});
	
	$("a[name=saveDetalleSeguimiento]").blur(function(){
		var celda = this.parentNode;
		$(celda).removeClass("focusSaveRow");
	});
	
	/*$("a[name=saveDetalleSeguimiento]").click(function(){
		agregar(this);
	});*/
}

function agregar(obj){
	
	if(parent.document.getElementById('estado').value=='A' || parent.document.getElementById('estado').value=='F'){
		alertJquery('No se puede Adicionar Novedades en estado Anulado o Finalizado','Trafico');	
	}else{
		var Table   = document.getElementById('tableDetalleSeguimiento');
		var Fila    = obj.parentNode.parentNode; 
		var numRows = (parseInt(Fila.rowIndex) + 1);
		
		var newRow  = Table.insertRow(numRows);
		
		$(newRow).html($("#clon").html());
		autocompleteUbicacion();
		autocompletePunto();
		linkDetallesSeguimiento();
		checkRow();
		indexarOrden();	
		saveagregar(obj);
		comp_date();
		editar_remesas();

		
	}

}


/**
* funcion para poner el numero de 
* orden de forma automatica en el 
* detalle de la tabla
*/
function indexarOrden(){
	$("#tableDetalleSeguimiento tbody > tr").each(function(index){
		if ( $(this).find("input[name=orden_det_ruta]").val() != (index+1) ){
			
			$(this).find("input[name=orden_det_ruta]").val((index+1));
			

				var orden_det_ruta	    = $(this).find("input[name=orden_det_ruta]").val();
				var detalle_seg_id	    = $(this).find("input[name=detalle_seg_id]").val();

				var QueryString = "ACTIONCONTROLER=onclickUpdateNew&detalle_seg_id="+detalle_seg_id+"&orden_det_ruta="+orden_det_ruta;
				$.ajax({
					
					url        : "DetalleSeguimientoClass.php",
					data       : QueryString,
					beforeSend : function(){
					  setMessageWaiting();	
					},
					success    : function(response){
						
						if( $.trim(response) == 'true'){
							//checkProcesar.attr("checked","");
						  setMessage('&nbsp;');

						}else{
							alertJquery(response);
						}
					}/*fin del success*/
				});

		}
	});
}


/**
* funciona para asociar el evento blur de
* los campos de texto de tiempo
*/
/*
function addCambiaTiempo(){
	$("input[name=tiempo_tramo]").blur(function(){
		if(isNaN(parseInt( $(this).val())) > 0 ) $(this).val("0");
		calculaPasoEstimado();
	});
}
*/

/**
* funcion para asociar el evento blur de
* losc ampos de texto recorrido
*/
/*
function addCambiaDistancia(){
	$("input[name=distancia_tramo]").blur(function(){
		if(isNaN(parseInt( $(this).val())) > 0 ) $(this).val("0");
		calculaRecorridoAcumulado();
	});
}
*/
function saveagregar(obj){
		
	var Celda               = obj.parentNode;
	var Fila                = obj.parentNode.parentNode;
	var trafico_id      	= $("#trafico_id").val();
	var orden_det_ruta	    = parseInt(parseInt($(Fila).find("input[name=orden_det_ruta]").val())+1);

	var Table        = Fila.parentNode;
	var IndexRowNext = (parseInt(Fila.rowIndex));
	
	if(trafico_id.length > 0){
		var QueryString = "ACTIONCONTROLER=onclickSaveNew&trafico_id="+trafico_id+"&orden_det_ruta="+orden_det_ruta;

		$.ajax({
			
			url        : "DetalleSeguimientoClass.php",
			data       : QueryString,
			beforeSend : function(){
			  setMessageWaiting();
			},
			success    : function(response){
				
              try{
				  
				var data           = $.parseJSON(response);
				var detalle_seg_id = data[0]['detalle_seg_id'];
				var fecha_reporte  = data[0]['fecha_reporte'];
				var hora_reporte   = data[0]['hora_reporte'];

                setMessage('Se adiciono exitosamente.');
				$(Table.rows[IndexRowNext]).find("input[name=detalle_seg_id]").val(detalle_seg_id);
				$(Table.rows[IndexRowNext]).find("input[name=fecha_reporte]").val(fecha_reporte);
				$(Table.rows[IndexRowNext]).find("input[name=hora_reporte]").val(hora_reporte);					
				  
			  }catch(e){
				  alertJquery(response);
				}
          
				
			}/*fin del success*/
		});

	}
}
function saveDetalleSeguimiento(obj){
	var formSubmitted = false;  //este
	
	var row = obj.parentNode.parentNode;
    
	if(!formSubmitted){  //este
		if(validaRequeridosDetalle(obj,row)){
			
			var Celda               = obj.parentNode;
			var Fila                = obj.parentNode.parentNode;
			var trafico_id      	= $("#trafico_id").val();
			var detalle_seg_id	    = $(Fila).find("input[name=detalle_seg_id]").val();
			var ubicacion_id        = $(Fila).find("input[name=ubicacion_id]").val();
			var punto_referencia    = $(Fila).find("input[name=punto_referencia]").val();
			var tipo_punto          = $(Fila).find("input[name=tipo_punto]").val();		
			var punto_referencia_id = $(Fila).find("input[name=punto_referencia_id]").val();
			var orden_det_ruta      = $(Fila).find("input[name=orden_det_ruta]").val();
			var novedad_id       	= $(Fila).find("select[name=novedad_id]").val();
			
			var remesa_id       	= $(Fila).find("select[name=remesa_id]").val();
			var causal_devolucion_id       	= $(Fila).find("select[name=causal_devolucion_id]").val();
			
			var fecha_reporte       = $(Fila).find("input[name=fecha_reporte]").val();
			var hora_reporte    	= $(Fila).find("input[name=hora_reporte]").val();
			var obser_deta    		= $(Fila).find("input[name=obser_deta]").val();
			var checkProcesar       = $(Fila).find("input[name=procesar]");
							
			if(!detalle_seg_id.length > 0){
	
					detalle_seg_id  = 'NULL';
					
					var QueryString = "ACTIONCONTROLER=onclickSave&trafico_id="+trafico_id+"&detalle_seg_id="+detalle_seg_id+
					"&ubicacion_id="+ubicacion_id+"&novedad_id="+novedad_id+"&orden_det_ruta="+orden_det_ruta+"&remesa_id="+remesa_id+"&causal_devolucion_id="+causal_devolucion_id+
					"&fecha_reporte="+fecha_reporte+"&hora_reporte="+hora_reporte+"&obser_deta="+obser_deta+"&punto_referencia="+punto_referencia+"&punto_referencia_id="+punto_referencia_id+'&tipo_punto='+tipo_punto;
					
					
					$.ajax({
						
						url        : "DetalleSeguimientoClass.php",
						data       : QueryString,
						beforeSend : function(){
						  setMessageWaiting();
						  formSubmitted = true;
						},
						success    : function(response){
							
						   try{
							   
							  var data            = $.parseJSON(response); 
							  var detalle_seg_id  = data['detalle_seg_id'];
							  var fecha_reporte   = data['fecha_reporte'];
							  var hora_reporte    = data['hora_reporte'];
							  
								setMessage('Se guardo exitosamente.');
								checkProcesar.attr("checked","");
								$(Fila).find("input[name=detalle_seg_id]").val(detalle_seg_id);	
								$(Fila).find("input[name=fecha_reporte]").val(fecha_reporte);	
								$(Fila).find("input[name=hora_reporte]").val(hora_reporte);	
								
								checkeds = parseInt(checkeds) + 1;
								
								if(checkeds == totalCheckeds){
									parent.getestado();
									parent.reloadGrid();
								}
							   
						   }catch(e){
						        
								alertJquery(response);
						   }											
						   formSubmitted = false;						
													
								/*	if(!isNaN(response)){
										setMessage('Se guardo exitosamente.');
										checkProcesar.attr("checked","");
										$(Fila).find("input[name=detalle_seg_id]").val(response);
										//parent.setCoordinatesMapRoute(trafico_id);
															
									}else{
										alertJquery(response);
									}*/
						}/*fin del success*/
						
					});
	
			}else{
	
				var QueryString = "ACTIONCONTROLER=onclickUpdate&trafico_id="+trafico_id+"&detalle_seg_id="+detalle_seg_id+
				"&ubicacion_id="+ubicacion_id+"&novedad_id="+novedad_id+"&orden_det_ruta="+orden_det_ruta+"&remesa_id="+remesa_id+"&causal_devolucion_id="+causal_devolucion_id+
				"&fecha_reporte="+fecha_reporte+"&hora_reporte="+hora_reporte+"&obser_deta="+obser_deta+"&punto_referencia="
				+punto_referencia+"&punto_referencia_id="+punto_referencia_id+'&tipo_punto='+tipo_punto;
				
				$.ajax({
					
					url        : "DetalleSeguimientoClass.php",
					data       : QueryString,
					beforeSend : function(){
					  setMessageWaiting();
					  formSubmitted = true;
					},
					success    : function(response){
							
						   try{
							   
							  var data            = $.parseJSON(response); 
							  var fecha_reporte   = data['fecha_reporte'];
							  var hora_reporte    = data['hora_reporte'];
							  
							  setMessage('Se actualizo exitosamente.');
							  checkProcesar.attr("checked","");							
							  $(Fila).find("a[name=saveDetalleSeguimiento]").parent().addClass("focusSaveRow");	
							  $(Fila).find("input[name=fecha_reporte]").val(fecha_reporte);	
							  $(Fila).find("input[name=hora_reporte]").val(hora_reporte);	
								
							  checkeds = parseInt(checkeds) + 1;
								
							  if(checkeds == totalCheckeds){
								parent.getestado();
								parent.reloadGrid();
							  }							
							   
						   }catch(e){
								alertJquery(response);
						   }							
							
						   formSubmitted = false;
						//setMessage('&nbsp;');						
							
						/*if( $.trim(response) == 'true'){
							setMessage('Se actualizo exitosamente.');
							checkProcesar.attr("checked","");
							$(Fila).find("a[name=saveDetalleSeguimiento]").parent().addClass("focusSaveRow");
							//parent.setCoordinatesMapRoute(trafico_id);											
						}else{
							alertJquery(response);
						}*/
					}/*fin del success*/
				});
			}
		}
	}//aca
}


function deleteDetalleSeguimiento(obj){
	
	var Celda           = obj.parentNode;
	var Fila            = obj.parentNode.parentNode;
	var trafico_id      = $("#trafico_id").val();
	var detalle_seg_id	= $(Fila).find("input[name=detalle_seg_id]").val();
	var detalle_ruta_id	= $(Fila).find("input[name=detalle_ruta_id]").val();
	var QueryString     = "ACTIONCONTROLER=onclickDelete&detalle_seg_id="+detalle_seg_id;
	
	if(detalle_seg_id.length > 0 ){

			$.ajax({
				
				url        : "DetalleSeguimientoClass.php",
				data       : QueryString,
				beforeSend : function(){
				  setMessageWaiting();
				},
				success    : function(response){
					
					if( $.trim(response) == 'true'){
						
						setMessage('Se borro exitosamente.');
						
						//var numRow = (Fila.rowIndex - 1);
						$(Fila).remove();
						
						indexarOrden();
						//parent.setCoordinatesMapRoute(trafico_id);
						
						//calculaPasoEstimado();
						//calculaRecorridoAcumulado();
						
						  if(checkeds == totalCheckeds){
							//parent.reloadGrid();
						  }							
						
					}else{
						alertJquery(response);
					}
				}/*fin del success*/
			});

	}else{
		$(Fila).remove();
	}
}

var checkeds      = 0;
var totalCheckeds = 0;

function saveDetallesSeguimiento(){
	
	$("input[name=procesar]:checked").each(function(){	
	   totalCheckeds = parseInt(totalCheckeds) + 1;
    });
	
	$("input[name=procesar]:checked").each(function(){
		saveDetalleSeguimiento(this);
	});
	
	
}


function deleteDetallesSeguimiento(){
	$("input[name=procesar]:checked").each(function(){
		deleteDetalleSeguimiento(this);
	});
}	




/*
function calculaPasoEstimado(){
	var fechaHoraTemp  = $("#FechaHoraSalida").val();
	var nuevaFechaHora = '';
	$("#tableDetalleSeguimiento tbody > tr").each(function(index){
		//alertJquery(nuevaFechaHora);
		if ( $(this).find("input[name=paso_estimado]").val() == '' )
			$(this).find("input[name=paso_estimado]").val( fechaHoraTemp );
		
		var nuevaFechaHora = sumaMinutos(  fechaHoraTemp , $(this).find("input[name=tiempo_tramo]").val()  );
		
		if(!fechasIguales( nuevaFechaHora, $(this).find("input[name=paso_estimado]").val() ) ){
			$(this).find("input[name=paso_estimado]").val( nuevaFechaHora );
			$(this).find("input[name=procesar]").attr("checked","true");
		}
		fechaHoraTemp = nuevaFechaHora;
	});
}


function calculaRecorridoAcumulado(){
	var recorridoAcumulado = 0;
	$("#tableDetalleSeguimiento tbody > tr").each(function(index){
		
		var nuevorecorridoAcumulado = parseInt(recorridoAcumulado) + parseInt($(this).find("input[name=distancia_tramo]").val());
		
		if( nuevorecorridoAcumulado != $(this).find("input[name=recorrido_acumulado]").val() ){
			$(this).find("input[name=recorrido_acumulado]").val( nuevorecorridoAcumulado );
			$(this).find("input[name=procesar]").attr("checked","true");
		}
		recorridoAcumulado = nuevorecorridoAcumulado;
	});
}
*/

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