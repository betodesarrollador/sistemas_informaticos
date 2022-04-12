// JavaScript Document

function setDataFormWithResponse(){
	
RequiredRemove();

FindRow([{campos:"aseguradora_id",valores:$('#aseguradora_id').val()}],document.forms[0],'AseguradorasClass.php',null, 
  function(){
  
    if($('#guardar'))    $('#guardar').attr("disabled","true");
    if($('#actualizar')) $('#actualizar').attr("disabled","");
    if($('#borrar'))     $('#borrar').attr("disabled","");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");
	
  });


}

function AseguradorasOnSaveOnUpdateonDelete(formulario,resp){

   Reset(formulario);
   clearFind();
   $("#refresh_QUERYGRID_aseguradora").click();
   
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
	
   alertJquery(resp,"Aseguradoras");
   
}
function AseguradorasOnReset(formulario){
	
    Reset(formulario);
    clearFind();	
	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
}