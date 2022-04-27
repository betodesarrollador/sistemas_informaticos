// JavaScript Document
$(document).ready(function(){	
	indexarOrden();
	checkedAll();
});

function deleteDetalleManifiesto(obj,detalle_despacho_id){	
	
	var Fila          = obj.parentNode.parentNode;	
	var QueryString   = "ACTIONCONTROLER=deleteDetalleManifiesto&detalle_despacho_id="+detalle_despacho_id;
	
	$.ajax({
		   
		url        : "DetalleManifiestosClass.php",
		data       : QueryString,
		beforeSend : function(){},
		success    : function(response){
			if( $.trim(response) == 'true'){				
				var numRow = (Fila.rowIndex - 1);
				Fila.parentNode.deleteRow(numRow);				
			}else{
				alertJquery(response);
			}
		}
	});
}

function deleteDetallesManifiesto(){
	$("input[name=procesar]:checked").each(function(){
		deleteDetalleManifiesto(this);
	});
}	

function indexarOrden(){
	$("#tableDespacho tbody > tr").each(function(index){
		if ( $(this).find("input[name=detalle]").val() != (index+1) ){
			$(this).find("input[name=detalle]").val((index+1));
		}
	});
}

function checkedAll(){
	$("#checkedAll").click(function(){
		if($(this).is(":checked")){
			$("#tableDespacho input[name=procesar]").attr("checked","true");
		}else{
			$("#tableDespacho input[name=procesar]").attr("checked","");
		}	
	});
}

function updateGrid(){
	parent.updateGrid();
}