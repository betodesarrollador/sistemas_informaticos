$(document).ready(function(){
	checkedAll();
	

});

function beforePrint(formulario){
	
   if(ValidaRequeridos(formulario)){
	 var QueryString = "RelacionFacturaClass.php?ACTIONCONTROLER=generateReporte&printers=si";  
	   popPup(QueryString,'Impresion Pendientes',800,600);
   }else{
	 alertJquery("Por favor ingrese los datos requeridos","Validacion");
   }
}

function renovar(solicitud_id){
	
	parent.renovarcontrato(solicitud_id);
}

function finalizar(solicitud_id){
	
	 
	parent.finalizarcontrato(solicitud_id); 
	
}

function setDataFormWithResponse(){

}

function checkedAll(){
	
   $("#checkedAll").click(function(){
								   
							   								   
      if($(this).is(":checked")){
		$("input[name=procesar]").attr("checked","true");
      }else{
  		  $("input[name=procesar]").attr("checked","");
		}
								   
   });

}

function ResetForm(formulario){

	Reset(formulario);
	$("#busqueda").val('');
	$("#frameDepreciados").attr("src",'');
	
}