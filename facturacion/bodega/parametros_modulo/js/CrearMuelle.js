// JavaScript Document

$(document).ready(function(){
  resetDetalle('detalleCrearMuelle');
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

FindRow([{campos:"muelle_id",valores:$('#muelle_id').val()}],document.forms[0],'CrearMuelleClass.php',null, 
  function(resp){
    
  try{
  var data          = $.parseJSON(resp);  
  var muelle_id = data[0]['muelle_id']; 
  
    if($('#guardar'))    $('#guardar').attr("disabled","true");
    if($('#actualizar')) $('#actualizar').attr("disabled","");
    if($('#borrar'))     $('#borrar').attr("disabled","");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");
  
  }catch(e){
     alertJquery(resp,"Error :"+e);
    }
  
  });


}

function CrearMuelleOnSaveOnUpdateonDelete(formulario,resp){

   Reset(formulario);
   clearFind();
   resetDetalle('detalleCrearMuelle');   
  var usuario_id = $('#usuario_static').val();
  $('#usuario_id').val(usuario_id);
   $("#refresh_QUERYGRID_muelle_id").click();
   
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
  
   alertJquery(resp,"CrearMuelle");
   
}
function CrearMuelleOnReset(formulario){
  
    Reset(formulario);
    clearFind();  
  resetDetalle('detalleCrearMuelle');
  var usuario_id = $('#usuario_static').val();
  $('#usuario_id').val(usuario_id);
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled",""); 
}