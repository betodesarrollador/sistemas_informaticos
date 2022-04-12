// JavaScript Document
function setDataFormWithResponse(){
    var parametrosId = $('#cuenta_tipo_pago_id').val();
    RequiredRemove();
    var parametros  = new Array({campos:"cuenta_tipo_pago_id",valores:$('#cuenta_tipo_pago_id').val()});
	var forma       = document.forms[0];
	var controlador = 'ParametrosClass.php';
	FindRow(parametros,forma,controlador,null,function(resp){
      if($('#guardar'))    $('#guardar').attr("disabled","true");
      if($('#actualizar')) $('#actualizar').attr("disabled","");
      if($('#borrar'))     $('#borrar').attr("disabled","");
      if($('#limpiar'))    $('#limpiar').attr("disabled","");	  
    });

}

function ParametrosOnSaveOnUpdateonDelete(formulario,resp){
   Reset(formulario);
   clearFind();
   $("#refresh_QUERYGRID_parametros").click();
   
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
	
   alertJquery(resp,"Parametros");
   
}
function ParametrosOnReset(formulario){
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
    clearFind();	
	
}
$(document).ready(function(){
						   
  $("#guardar,#actualizar").click(function(){
	  
	  var formulario = document.getElementById('ParametrosForm');
	  
	  if(ValidaRequeridos(formulario)){ 
	    if(this.id == 'guardar'){
         Send(formulario,'onclickSave',null,ParametrosOnSaveOnUpdateonDelete)
		}else{
            Send(formulario,'onclickUpdate',null,ParametrosOnSaveOnUpdateonDelete)
		  }
	  }
	  	  
  });
});
	
