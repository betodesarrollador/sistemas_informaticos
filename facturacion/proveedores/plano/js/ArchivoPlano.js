



function OnclickGenerar(formulario){
	
	if(ValidaRequeridos(formulario)){
		 var QueryString = "DetallesClass.php?"+FormSerialize(formulario);
		 $("#framePlano").attr("src",QueryString);
		 showDivLoading();	 	   
		 $("#framePlano").load(function(response){removeDivLoading();});
		
	}
	
}

$(document).ready(function(){
	$("#generar_excel").click(function(){
	
	 var formulario = this.form;
	
	 if(ValidaRequeridos(formulario)){
	 
	  /* var desde = $("#desde").val();
	   var hasta = $("#hasta").val();
	   var tipo = $("#tipo").val();
	   var oficina_id = $("#oficina_id").val();
	   var all_ofice = $("#all_ofice").val();
	   var si_proveedor = $("#si_proveedor").val();	 
	   var proveedor_id = $("#proveedor_id").val();	 	
	   var saldos = $("#saldos").val();	 	
	   */
	   var QueryString = "ArchivoPlanoClass.php?ACTIONCONTROLER=generateFileexcel&rand="+Math.random();
						 
	   document.location.href = QueryString;						 
	
	 }								
	});	
						   
});

function descargarexcel(formulario){
	
	 var QueryString = "ArchivoPlanoClass.php?ACTIONCONTROLER=generateFileexcel&rand="+Math.random();
		 document.location.href = QueryString;
}

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

