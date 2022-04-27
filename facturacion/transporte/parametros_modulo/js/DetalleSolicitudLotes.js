// JavaScript Document
$(document).ready(function(){
	checkedAll();
	checkRow();
	autocompleteAll();
	linkDetalles();
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
function autocompleteAll(){
	
	$("input[name=valor_foranea]").autocomplete("../../../framework/clases/ListaInteligente.php?consulta="+$("#autoSugerente").val(), {
		width: 260,
		selectFirst: false
	});
	
	$("input[name=valor_foranea]").result(function(event, data, formatted) {
		if (data) $(this).next().val(data[1]);
	});	
}


/***************************************************************
	Funciones para el objeto de guardado en los edtalles de ruta
***************************************************************/
function linkDetalles(){

	$("a[name=saveDetalle]").attr("href","javascript:void(0)");
	
	$("a[name=saveDetalle]").focus(function(){
		var celda = this.parentNode;
		$(celda).addClass("focusSaveRow");
	});
	
	$("a[name=saveDetalle]").blur(function(){
		var celda = this.parentNode;
		$(celda).removeClass("focusSaveRow");
	});
	
	$("a[name=saveDetalle]").click(function(){
		saveDetalle(this);
	});
}


function saveDetalle(obj){
	
	var row = obj.parentNode.parentNode;
	
	if(validaRequeridosDetalle(obj,row)){
	
		var Celda         = obj.parentNode;
		var Fila          = obj.parentNode.parentNode;
		var checkProcesar = $(Fila).find("input[name=procesar]");
		
		var QueryString   = {
								'ACTIONCONTROLER'                   : '',
								'campo_archivo_solicitud_id'        : $("#campo_archivo_solicitud_id").val(),
								'relacion_archivo_det_solicitud_id' : $(Fila).find("input[name=relacion_archivo_det_solicitud_id]").val(),
								'valor_foranea_id'                  : $(Fila).find("input[name=valor_foranea_id]").val(),
								'valor_foranea'                     : $(Fila).find("input[name=valor_foranea]").val(),
								'valor_archivo'                     : $(Fila).find("input[name=valor_archivo]").val()
							};
	
		if(!QueryString.relacion_archivo_det_solicitud_id.length > 0){
			
			if( $('#guardar',parent.document).length > 0 ){/*se valida el permiso de guardar*/
			
				QueryString.ACTIONCONTROLER        = 'onclickSave';
				QueryString.detalle_ordenconexo_id = 'NULL';
				
				$.ajax({
					
					url        : "DetalleSolicitudLotesClass.php",
					data       : QueryString,
					beforeSend : function(){},
					success    : function(response){
					
						if(!isNaN(response)){
							
							$(Fila).find("input[name=relacion_archivo_det_solicitud_id]").val(response);
							
							var Table   = document.getElementById('tableDetalle');
							var numRows = (Table.rows.length);
							var newRow  = Table.insertRow(numRows);
							
							$(newRow).html($("#clon").html());
							//$(newRow).find("input[name=orden_det_ruta]").focus();
							
							autocompleteAll();
							linkDetalles();
							checkRow();
							updateGrid();
							
							checkProcesar.attr("checked","");
							$(Celda).removeClass("focusSaveRow");
							
						}else{
							alertJquery(response);
						}
					}/*fin del success*/
				});
			}
		}else{
			
			if( $('#actualizar',parent.document).length > 0 ){/*se valida el persmiso de actualizar*/
			
				QueryString.ACTIONCONTROLER = 'onclickUpdate';
				
				$.ajax({
					
					url        : "DetalleSolicitudLotesClass.php",
					data       : QueryString,
					beforeSend : function(){},
					success    : function(response){
						
						if( $.trim(response) == 'true'){
							
							checkProcesar.attr("checked","");
							$(Fila).find("a[name=saveDetalle").parent().addClass("focusSaveRow");
							updateGrid();
							
						}else{
							alertJquery(response);
						}
					}/*fin del success*/
				});
			}
		}
	}
}


function deleteDetalle(obj){

	var Celda           = obj.parentNode;
	var Fila            = obj.parentNode.parentNode;
	var QueryString     = {
							'ACTIONCONTROLER'                   : 'onclickDelete',
							'relacion_archivo_det_solicitud_id' : $(Fila).find("input[name=relacion_archivo_det_solicitud_id]").val()
							};
	
	if(QueryString.relacion_archivo_det_solicitud_id.length > 0){
		
		if( $('#borrar',parent.document).length > 0 ){/*se valida el permiso de borrar*/
		
			$.ajax({
				url        : "DetalleSolicitudLotesClass.php",
				data       : QueryString,
				beforeSend : function(){},
				success    : function(response){
					
					if( $.trim(response) == 'true' ){
						
						var numRow = (Fila.rowIndex - 1);
						Fila.parentNode.deleteRow(numRow);
			   			
						updateGrid();
						
					}else{
						alertJquery(response);
					}
				}/*fin del success*/
			});
		}
	}else{
		
		alertJquery('No puede eliminar elementos que no han sido guardados');
		$(Fila).find("input[name=procesar]").attr("checked","");
		
	}
}


function saveDetalles(){
	$("input[name=procesar]:checked").each(function(){
		saveDetalle(this);
	});
}


function deleteDetalles(){
	$("input[name=procesar]:checked").each(function(){
		deleteDetalle(this);
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