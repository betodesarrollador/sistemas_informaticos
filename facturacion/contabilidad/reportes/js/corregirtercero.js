// JavaScript Document
var formSubmitted = false;
function setDataFormWithResponse(){
    var corregirterceroId = $('#corregirtercero_id').val();
    RequiredRemove();
    var corregirtercero  = new Array({campos:"corregirtercero_id",valores:$('#corregirtercero_id').val()});
	var forma       = document.forms[0];
	var controlador = 'CorregirTerceroClass.php';
	FindRow(corregirtercero,forma,controlador,null,function(resp){
      if($('#actualizar')) $('#actualizar').attr("disabled","");
      if($('#limpiar'))    $('#limpiar').attr("disabled","");	  
    });
}
function CorregirTerceroOnSaveOnUpdateonDelete(formulario,resp){
   Reset(formulario);
   clearFind();
   $("#refresh_QUERYGRID_corregirtercero").click();
   if($('#actualizar')) $('#actualizar').attr("disabled","");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
   alertJquery(resp,"CorregirTerceros");
}
function CorregirTerceroOnReset(formulario){
	
    clearFind();	
    if($('#actualizar')) $('#actualizar').attr("disabled","");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
}
$(document).ready(function(){
						   
  var formulario = document.getElementById('CorregirTerceroForm');
						   
  $("#guardar,#actualizar").click(function(){
	if(this.id == 'guardar'){
			if(!formSubmitted){	
				 formSubmitted = true;	
				 Send(formulario,'onclickSave',null,CorregirTerceroOnSaveOnUpdateonDelete);
			}
		}else{
			Send(formulario,'onclickUpdate',null,CorregirTerceroOnSaveOnUpdateonDelete);
		}	
	
	formSubmitted = false;
  
  });
});
	
