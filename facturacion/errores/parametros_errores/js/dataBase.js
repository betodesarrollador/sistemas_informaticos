// JavaScript Document

$(document).ready(function(){

  $("input[type=text],textarea").not("#contrasena").keyup(function(){												

    this.value = this.value.toLowerCase();								   
    
    });

    $("#contrasena").removeClass("text_uppercase");
 
});

function setDataFormWithResponse(){
  
RequiredRemove();

FindRow([{campos:"cliente_id",valores:$('#cliente_id').val()}],document.forms[0],'dataBaseClass.php',null, 
  function(resp){
    
  try{
  
    if($('#guardar'))    $('#guardar').attr("disabled","true");
    if($('#actualizar')) $('#actualizar').attr("disabled","");
    if($('#borrar'))     $('#borrar').attr("disabled","");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");
  
  }catch(e){
     alertJquery(resp,"Error :"+e);
    }
  
  });


}

function success(formulario){

   Reset(formulario);
   clearFind();
   $("#contrasena").val("");
     
   $("#refresh_QUERYGRID_clientes_db").click();
   
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");

}

function dataBaseOnSaveOnUpdateonDelete(formulario,resp){

    alertJquery(resp);
   
}
function dataBaseOnReset(formulario){
  
    Reset(formulario);
    clearFind();  
  
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled",""); 
}