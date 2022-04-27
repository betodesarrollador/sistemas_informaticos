// JavaScript Document

$(document).ready(function(){
  resetDetalle('detalleFormaPago');
  $("#saveDetalles").click(function(){
    window.frames[0].saveDetallesSoliServi();
  });
    
  $("#deleteDetalles").click(function(){
    window.frames[0].deleteDetallesSoliServi();
  });   

  $("#saveTerceros").click(function(){
    window.frames[1].saveDetallesSoliServi();
  });
    
  $("#deleteTerceros").click(function(){
    window.frames[1].deleteDetallesSoliServi();
  });   

});

function setDataFormWithResponse(){
	
RequiredRemove();

FindRow([{campos:"forma_pago_id",valores:$('#forma_pago_id').val()}],document.forms[0],'FormaPagoClass.php',null, 
  function(resp){
	  
	try{
		
	var data          = $.parseJSON(resp);  
	var forma_pago_id = data[0]['forma_pago_id']; 
		
	document.getElementById('detalleFormaPago').src = "DetalleFormaPagoClass.php?forma_pago_id="+forma_pago_id+"&rand="+Math.random();
	document.getElementById('terceroFormaPago').src = "TerceroFormaPagoClass.php?forma_pago_id="+forma_pago_id+"&rand="+Math.random();
  
    if($('#guardar'))    $('#guardar').attr("disabled","true");
    if($('#actualizar')) $('#actualizar').attr("disabled","");
    if($('#borrar'))     $('#borrar').attr("disabled","");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");
	
	}catch(e){
		 alertJquery(resp,"Error :"+e);
	  }
	
  });


}

function FormaPagoOnSaveOnUpdateonDelete(formulario,resp){

   Reset(formulario);
   clearFind();
   resetDetalle('detalleFormaPago');   
   $("#refresh_QUERYGRID_forma_pago").click();
   
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
	
   alertJquery(resp,"FormaPago");
   
}
function FormaPagoOnReset(formulario){
	
    Reset(formulario);
    clearFind();	
	resetDetalle('detalleFormaPago');
	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
}