// JavaScript Document
function setDataFormWithResponse(){
    var asuntoId = $('#asunto_id').val();
    RequiredRemove();

    var asunto  = new Array({campos:"asunto_id",valores:$('#asunto_id').val()});
	var forma       = document.forms[0];
	var controlador = 'AsuntoClass.php';

	FindRow(asunto,forma,controlador,null,function(resp){
      if($('#guardar'))    $('#guardar').attr("disabled","true");
      if($('#actualizar')) $('#actualizar').attr("disabled","");
      if($('#borrar'))     $('#borrar').attr("disabled","");
      if($('#limpiar'))    $('#limpiar').attr("disabled","");	  
    });


}

function AsuntoOnSaveOnUpdateonDelete(formulario,resp){
   Reset(formulario);
   clearFind();
   $("#refresh_QUERYGRID_asunto").click();
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
   alertJquery(resp,"Asunto");
}
function AsuntoOnReset(formulario){
	
    clearFind();	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
}

$(document).ready(function(){
						   
  $("#guardar,#actualizar").click(function(){
	  
	  var formulario = document.getElementById('AsuntoForm');
	  
	   if(ValidaRequeridos(formulario)){ 
	    if(this.id == 'guardar'){
         		Send(formulario,'onclickSave',null,AsuntoOnSaveOnUpdateonDelete)	
				
		}else{
			    Send(formulario,'onclickUpdate',null,AsuntoOnSaveOnUpdateonDelete)
		  }
	  }
	  	  
  });

});
	
