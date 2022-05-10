// JavaScript Document
$(document).ready(function(){
	checkedAll();
});


function deleteDetalleDespacho(obj,detalle_despacho_id){
	
	
	var Fila          = obj.parentNode.parentNode;	
	var QueryString   = "ACTIONCONTROLER=deleteDetalleDespacho&detalle_despacho_id="+detalle_despacho_id;
	
	$.ajax({
		   
		url        : "DetalleDespachosUrbanosClass.php",
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


function checkedAll(){
	$("#checkedAll").click(function(){
		if($(this).is(":checked")){
			$("#tableDespacho input[name=procesar]").attr("checked","true");
		}else{
			$("#tableDespacho input[name=procesar]").attr("checked","");
		}
	});
}