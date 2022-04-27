// JavaScript Document
function setDataFormWithResponse(){
    var parametrosId = $('#parametros_equivalente_id').val();
    RequiredRemove();

    var parametros  = new Array({campos:"parametros_equivalente_id",valores:$('#parametros_equivalente_id').val()});
	var forma       = document.forms[0];
	var controlador = 'ResolucionClass.php';

	FindRow(parametros,forma,controlador,null,function(resp){
      if($('#guardar'))    $('#guardar').attr("disabled","true");
      if($('#actualizar')) $('#actualizar').attr("disabled","");
      if($('#borrar'))     $('#borrar').attr("disabled","");
      if($('#limpiar'))    $('#limpiar').attr("disabled","");	  
    });


}

function ResolucionOnSaveOnUpdateonDelete(formulario,resp){
   Reset(formulario);
   clearFind();
   $("#refresh_QUERYGRID_parametros").click();
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
   alertJquery(resp,"Tarifas");
}
function ResolucionOnReset(formulario){
	
    clearFind();	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
}

$(document).ready(function(){
						   
  $("#guardar,#actualizar").click(function(){
	  
	  var formulario = document.getElementById('ResolucionForm');
	  
	  if(ValidaRequeridos(formulario)){ 
	    if(this.id == 'guardar'){
			if(parseInt($('#rango_inicial').val()) < parseInt($('#rango_final').val())){	
         		Send(formulario,'onclickSave',null,ResolucionOnSaveOnUpdateonDelete)
			}else{
				alertJquery("El rango Inicial no puede ser mayor que el Final","Resolucion");
			}
		}else{
			if(parseInt($('#rango_inicial').val()) < parseInt($('#rango_final').val())){	
	            Send(formulario,'onclickUpdate',null,ResolucionOnSaveOnUpdateonDelete)
			}else{
				alertJquery("El rango Inicial no puede ser mayor que el Final","Resolucion");
			}
				
		  }
	  }
	  	  
  });

});
	
