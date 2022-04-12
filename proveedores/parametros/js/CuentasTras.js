// JavaScript Document


function setDataFormWithResponse(){
	
RequiredRemove();

FindRow([{campos:"cuenta_traslado_id",valores:$('#cuenta_traslado_id').val()}],document.forms[0],'CuentasTrasClass.php',null, 
  function(resp){
	  
	try{
		
	var data          = $.parseJSON(resp);  
	var cuenta_traslado_id = data[0]['cuenta_traslado_id']; 
		
  
    if($('#guardar'))    $('#guardar').attr("disabled","true");
    if($('#actualizar')) $('#actualizar').attr("disabled","");
    if($('#borrar'))     $('#borrar').attr("disabled","");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");
	
	}catch(e){
		 alertJquery(resp,"Error :"+e);
	  }
	
  });


}

function CuentasTrasOnSaveOnUpdateonDelete(formulario,resp){

   Reset(formulario);
   clearFind();

   $("#refresh_QUERYGRID_cuentras_traslados").click();
   
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
	
   alertJquery(resp,"CuentaTras");
   
}
function CuentasTrasOnReset(formulario){
	
    Reset(formulario);
    clearFind();	

	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
}