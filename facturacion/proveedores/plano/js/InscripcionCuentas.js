$(document).ready(function(){
	$("#generar_excel").click(function(){
	
	 var formulario = this.form;
	
	 if(ValidaRequeridos(formulario)){
	 
	   var desde = $("#desde").val();
	   var hasta = $("#hasta").val();
	   var tipo = $("#tipo").val();
	   var oficina_id = $("#oficina_id").val();
	   var all_ofice = $("#all_ofice").val();
	   var si_proveedor = $("#si_proveedor").val();	 
	   var proveedor_id = $("#proveedor_id").val();	 	
	   var saldos = $("#saldos").val();	 	
	   
	   var QueryString = "ArchivoPlanoClass.php?ACTIONCONTROLER=generateFileexcel&desde="+desde+"&hasta="+hasta+"&tipo="+tipo+"&oficina_id="+oficina_id+"&proveedor_id="+proveedor_id+"&all_ofice="+all_ofice+"&si_proveedor="+si_proveedor+"&saldos="+saldos+"&rand="+Math.random();
						 
	   document.location.href = QueryString;						 
	
	 }								
	});	
						   
});

function descargarexcel(){
	
	
			
			var QueryString = "InscripcionCuentasClass.php?ACTIONCONTROLER=generateFile&rand="+Math.random();
			document.location.href = QueryString;
			
}


function beforePrint(formulario){
 
   if(ValidaRequeridos(formulario)){
     var QueryString = "DetallesClass.php?"+FormSerialize(formulario);
  popPup(QueryString,'Impresion Reporte',800,600);
    
   }
}

