// JavaScript Document
$(document).ready(function(){
	checkedAll();
	checkRow();
	autocompleteUsuario();
	linkDetallesCorreo();
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
function autocompleteUsuario(){
	$("input[name=usuario]").autocomplete("/roa/framework/clases/ListaInteligente.php?consulta=usuario_reporte_novedad", {
		width: 260,
		selectFirst: false
	});
	
	$("input[name=usuario]").result(function(event, data, formatted){
		if(data){
			var row = this.parentNode.parentNode;
			details=data[1].split("="); 										   
			$(this).next().val(details[0]);
			$(row).find("input[name=correo]").val(details[1]);

		}
	});
}


/***************************************************************
	  Funciones para el objeto de guardado en los edtalles de ruta
***************************************************************/
function linkDetallesCorreo(){

	$("a[name=saveDetalleCorreo]").attr("href","javascript:void(0)");
	
	$("a[name=saveDetalleCorreo]").focus(function(){
		var celda = this.parentNode;
		$(celda).addClass("focusSaveRow");
	});
	
	$("a[name=saveDetalleCorreo]").blur(function(){
		var celda = this.parentNode;
		$(celda).removeClass("focusSaveRow");
	});
	
	$("a[name=saveDetalleCorreo]").click(function(){
		saveDetalleCorreo(this);
	});
}



function saveDetalleCorreo(obj){
	
	var row = obj.parentNode.parentNode;
	
	if(validaRequeridosDetalle(obj,row)){
	
		var Celda              = obj.parentNode;
		var Fila               = obj.parentNode.parentNode;
		var reporte_novedad_id = $(Fila).find("input[name=reporte_novedad_id]").val();
		var novedad_id         = $("#novedad_id").val();
		var usuario_id     	   = $(Fila).find("input[name=usuario_id]").val();
		var correo       		= $(Fila).find("input[name=correo]").val();
		var checkProcesar      = $(Fila).find("input[name=procesar]");
	
		if(!reporte_novedad_id.length > 0){
			if( $('#guardar',parent.document).length > 0 ){/*se valida el permiso de guardar*/
				detalle_ruta_id    = 'NULL';
				
				var QueryString = "ACTIONCONTROLER=onclickSave&novedad_id="+novedad_id+"&usuario_id="+usuario_id+
				"&correo="+correo;
				
				$.ajax({
					
					url        : "DetalleCorreosClass.php",
					data       : QueryString,
					beforeSend : function(){},
					success    : function(response){
					
						if(!isNaN(response)){
							
							$(Fila).find("input[name=reporte_novedad_id]").val(response);
							
							var Table   = document.getElementById('tableDetalleCorreo');
							var numRows = (Table.rows.length);
							var newRow  = Table.insertRow(numRows);
							
							$(newRow).html($("#clon").html());
							//$(newRow).find("input[name=orden_det_ruta]").focus();
							
							autocompleteUsuario();
							linkDetallesCorreo();
							checkRow();
							updateGrid();
							
							checkProcesar.attr("checked","");
							$(Celda).removeClass("focusSaveRow");
							indexarOrden();
							iniDragTable();
							
						}else{
							alertJquery(response);
						}
					}/*fin del success*/
				});
			}
		}else{
			if( $('#actualizar',parent.document).length > 0 ){/*se valida el persmiso de actualizar*/
				var QueryString = "ACTIONCONTROLER=onclickUpdate&novedad_id="+novedad_id+"&reporte_novedad_id="+reporte_novedad_id+
				"&usuario_id="+usuario_id+"&correo="+correo;
			
				$.ajax({
					
					url        : "DetalleCorreosClass.php",
					data       : QueryString,
					beforeSend : function(){},
					success    : function(response){
						
						if( $.trim(response) == 'true'){
							checkProcesar.attr("checked","");
							$(Fila).find("a[name=saveDetalleCorreo]").parent().addClass("focusSaveRow");
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


function deleteDetalleCorreo(obj){

	var Celda           = obj.parentNode;
	var Fila            = obj.parentNode.parentNode;
	var reporte_novedad_id	= $(Fila).find("input[name=reporte_novedad_id]").val();
	var QueryString     = "ACTIONCONTROLER=onclickDelete&reporte_novedad_id="+reporte_novedad_id;
	
	if(reporte_novedad_id.length > 0){
		if( $('#borrar',parent.document).length > 0 ){/*se valida el permiso de borrar*/
			$.ajax({
				url        : "DetalleCorreosClass.php",
				data       : QueryString,
				beforeSend : function(){},
				success    : function(response){
					
					if( $.trim(response) == 'true' ){
				
						var numRow = (Fila.rowIndex - 1);
						Fila.parentNode.deleteRow(numRow);
			   
						indexarOrden();
						iniDragTable();
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


function saveDetalleCorreos(){
	$("input[name=procesar]:checked").each(function(){
		saveDetalleCorreo(this);
	});
}

function deleteDetalleCorreos(){
	$("input[name=procesar]:checked").each(function(){
		deleteDetalleCorreo(this);
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


