// JavaScript Document
$(document).ready(function(){
	checkedAll();
	checkRow();
	autocompleteUbicacion();
	linkDetallesRuta();
	indexarOrden();
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


/***************************************************************
	  lista inteligente para la ubicacion con jquery
**************************************************************/
function autocompleteUbicacion(){
	$("input[name=ubicacion]").autocomplete("/roa/framework/clases/ListaInteligente.php?consulta=ubicacion_punto", {
		width: 450,
		selectFirst: true
	});
	
	$("input[name=ubicacion]").result(function(event, data, formatted){
		if(data){
			var row = this.parentNode.parentNode;
			details=data[1].split("-");
			details_nom=data[0].split("-");
			$(row).find("input[name=ubicacion]").val(details_nom[0]);
			$(this).next().val(details[0]);
			$(this).next().next().val(details[1]);			
			/*$(row).find("input[name=tiporef]").val(details[2]);
			$(row).find("input[name=refe]").val(details[3]);*/
						
			$(row).find("input[name=refe]").val(details[2]);
			
			

		}
	});
}


/***************************************************************
	  Funciones para el objeto de guardado en los edtalles de ruta
***************************************************************/
function linkDetallesRuta(){

	$("a[name=saveDetalleRuta]").attr("href","javascript:void(0)");
	
	$("a[name=saveDetalleRuta]").focus(function(){
		var celda = this.parentNode;
		$(celda).addClass("focusSaveRow");
	});
	
	$("a[name=saveDetalleRuta]").blur(function(){
		var celda = this.parentNode;
		$(celda).removeClass("focusSaveRow");
	});
	
	$("a[name=saveDetalleRuta]").click(function(){
		saveDetalleRuta(this);
	});
	

	$("a[name=saveNewDetalle]").attr("href","javascript:void(0)");
	
	$("a[name=saveNewDetalle]").focus(function(){
		var celda = this.parentNode;
		$(celda).addClass("focusSaveRow");
	});
	
	$("a[name=saveNewDetalle]").blur(function(){
		var celda = this.parentNode;
		$(celda).removeClass("focusSaveRow");
	});
	
	/*$("a[name=saveNewDetalle]").click(function(){
		agregar(this);
	});*/

}

function agregar(obj){
	
		var Table   = document.getElementById('tableDetalleRuta');
		var Fila    = obj.parentNode.parentNode; 
		var numRows = (parseInt(Fila.rowIndex) + 1);
		
		var newRow  = Table.insertRow(numRows);
				
		$(newRow).html($("#clon").html());
		autocompleteUbicacion();
		linkDetallesRuta();
		checkRow();
		indexarOrden();	

}



function saveDetalleRuta(obj){
	
	var row = obj.parentNode.parentNode;
	
	if(validaRequeridosDetalle(obj,row)){
	
		var Celda              = obj.parentNode;
		var Fila               = obj.parentNode.parentNode;
		var detalle_ruta_id	   = $(Fila).find("input[name=detalle_ruta_id]").val();
		var ruta_id            = $("#ruta_id").val();
		var orden_det_ruta     = $(Fila).find("input[name=orden_det_ruta]").val();
		var ubicacion_id       = $(Fila).find("input[name=ubicacion_id]").val();
		//var distancia_det_ruta = $(Fila).find("input[name=distancia_det_ruta]").val();
		//var tiempo_det_ruta    = $(Fila).find("input[name=tiempo_det_ruta]").val();
		var punto_referencia_id= $(Fila).find("input[name=punto_referencia_id]").val();
		var checkProcesar      = $(Fila).find("input[name=procesar]");
	
		if(!detalle_ruta_id.length > 0){
			//if( $('#guardar',parent.document).length > 0 ){/*se valida el permiso de guardar*/
				detalle_ruta_id    = 'NULL';
				
				var QueryString = "ACTIONCONTROLER=onclickSave&ruta_id="+ruta_id+"&detalle_ruta_id="+detalle_ruta_id+
				"&orden_det_ruta="+orden_det_ruta+"&ubicacion_id="+ubicacion_id+/*"&distancia_det_ruta="+distancia_det_ruta+
				"&tiempo_det_ruta="+tiempo_det_ruta+*/"&punto_referencia_id="+punto_referencia_id;
								
				$.ajax({
					
					url        : "DetalleRutaClass.php",
					data       : QueryString,
					beforeSend : function(){
						showDivLoading();
						setMessageWaiting();
					},
					success    : function(response){
						
						removeDivLoading();
					
						if(!isNaN(response)){
							
							/*$(Fila).find("input[name=detalle_ruta_id]").val(response);
							
							var Table   = document.getElementById('tableDetalleRuta');
							var numRows = (Table.rows.length);
							var newRow  = Table.insertRow(numRows);
							
							$(newRow).html($("#clon").html());
							//$(newRow).find("input[name=orden_det_ruta]").focus();
							
							autocompleteUbicacion();
							linkDetallesRuta();
							checkRow();
							updateGrid();
							parent.setCoordinatesMapRoute(ruta_id);*/
							setMessage('Se guardo exitosamente.');
							//checkProcesar.attr("checked","");
							obj.checked = false;
							$(Celda).removeClass("focusSaveRow");
							indexarOrden();
							
						}else{
							alertJquery(response);
						}
					}/*fin del success*/
				});
			//}
		}else{
//			if( $('#actualizar',parent.document).length > 0 ){/*se valida el persmiso de actualizar*/
				var QueryString = "ACTIONCONTROLER=onclickUpdate&ruta_id="+ruta_id+"&detalle_ruta_id="+detalle_ruta_id+
				"&orden_det_ruta="+orden_det_ruta+"&ubicacion_id="+ubicacion_id+/*"&distancia_det_ruta="+distancia_det_ruta+
				"&tiempo_det_ruta="+tiempo_det_ruta+*/"&punto_referencia_id="+punto_referencia_id;
			
				$.ajax({
					
					url        : "DetalleRutaClass.php",
					data       : QueryString,
					beforeSend : function(){
					 setMessageWaiting();
					},
					success    : function(response){
						
						if( $.trim(response) == 'true'){
							setMessage('Se actualizo exitosamente.');
							//checkProcesar.attr("checked","");
							obj.checked = false;
							$(Fila).find("a[name=saveDetalleRuta]").parent().addClass("focusSaveRow");
							updateGrid();
							//parent.setCoordinatesMapRoute(ruta_id);
						}else{
							alertJquery(response);
						}
					}/*fin del success*/
				});
			//}
		}
	}
}


function deleteDetalleRuta(obj){

	var Celda           = obj.parentNode;
	var Fila            = obj.parentNode.parentNode;
	var ruta_id            = $("#ruta_id").val();	
	var detalle_ruta_id	= $(Fila).find("input[name=detalle_ruta_id]").val();
	var QueryString     = "ACTIONCONTROLER=onclickDelete&detalle_ruta_id="+detalle_ruta_id;
	
	if(detalle_ruta_id.length > 0){
		//if( $('#borrar',parent.document).length > 0 ){/*se valida el permiso de borrar*/
			$.ajax({
				url        : "DetalleRutaClass.php",
				data       : QueryString,
				beforeSend : function(){
				   setMessageWaiting();
				},
				success    : function(response){
					
					if( $.trim(response) == 'true' ){
				
						setMessage('Se borro exitosamente.');
						
						var numRow = (Fila.rowIndex - 1);
						Fila.parentNode.deleteRow(numRow);
			   
						indexarOrden();
						updateGrid();
						//parent.setCoordinatesMapRoute(ruta_id);
						
				
					}else{
						alertJquery(response);
					}
				}/*fin del success*/
			});
		//}
	}else{
		$(Fila).remove();
	}
}


function saveDetallesRuta(){
	$("input[name=procesar]").each(function(){
		saveDetalleRuta(this);
	});
}

function deleteDetallesRuta(){
	$("input[name=procesar]:checked").each(function(){
		deleteDetalleRuta(this);
	});
}

function updateGrid(){
	parent.updateGrid();
}

function checkRow(){
	$("input[type=text]").keyup(function(event){
		
		var Tecla = event.keyCode;
		var Fila  = this.parentNode.parentNode;
		
		$(Fila).find("input[name=procesar]").attr("checked","true");
	});
}


/**
* funcion para poner el numero de 
* orden de forma automatica en el 
* detalle de la tabla
*/
function indexarOrden(){
	$("#tableDetalleRuta tbody > tr").each(function(index){
		
		if ( $(this).find("input[name=orden_det_ruta]").val() != (index+1) ){
		
			$(this).find("input[name=orden_det_ruta]").val((index+1));
			
			//if ( ( $(this).find("input[name=detalle_ruta_id]").val() != "") )
				//$(this).find("input[name=procesar]").attr("checked","true");				
		}
	});
}

