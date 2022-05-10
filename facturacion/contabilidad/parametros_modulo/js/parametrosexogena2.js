// JavaScript Document
function setDataFormWithResponse(){
   
    //RequiredRemove();
	var formatoExogenaId = $('#formato_exogena_id').val();
    var parametros  = new Array({campos:"formato_exogena_id",valores:$('#formato_exogena_id').val()});
	var forma       = document.forms[0];
	var controlador = 'ParametrosExogenaClass.php';

	FindRow(parametros,forma,controlador,null,function(resp){
      if($('#guardar'))    $('#guardar').attr("disabled","true");
      if($('#actualizar')) $('#actualizar').attr("disabled","");
      if($('#borrar'))     $('#borrar').attr("disabled","");
      if($('#limpiar'))    $('#limpiar').attr("disabled","");	
	  var url = "DetallesParametrosClass.php?formato_exogena_id="+formatoExogenaId+"&rand="+Math.random();
	  $("#detalles").attr("src",url);						  	
    });
}
function ParametrosExogenaOnSave(formulario,resp){
   if(parseInt(resp)>0){
		var formato_exogena_id = resp;
		var url = "DetallesParametrosClass.php?formato_exogena_id="+formato_exogena_id+"&rand="+Math.random();
		$("#formato_exogena_id").val(formato_exogena_id);						
		$("#detalles").attr("src",url);						  	
	   $("#refresh_QUERYGRID_formato_exogena").click();
	   
	   if($('#guardar'))    $('#guardar').attr("disabled","true");
	   if($('#actualizar')) $('#actualizar').attr("disabled","");
	   if($('#borrar'))     $('#borrar').attr("disabled","");
	   if($('#limpiar'))    $('#limpiar').attr("disabled","");
		
	   alertJquery("Guardado Exitosamente","ParametrosExogena");
   }else{
	   alertJquery("Ocurrio una Inconsistencia","ParametrosExogena");
   }
}
function ParametrosExogenaOnUpdate(formulario,resp){
   if(resp){
		var formato_exogena_id = $("#formato_exogena_id").val();
		var url = "DetallesParametrosClass.php?formato_exogena_id="+formato_exogena_id+"&rand="+Math.random();
		$("#detalles").attr("src",url);						  	
   }
   $("#refresh_QUERYGRID_formato_exogena").click();
   
   if($('#guardar'))    $('#guardar').attr("disabled","true");
   if($('#actualizar')) $('#actualizar').attr("disabled","");
   if($('#borrar'))     $('#borrar').attr("disabled","");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
	
   alertJquery(resp,"ParametrosExogena");
}
function ParametrosExogenaOnDelete(formulario,resp){
   if(resp){
		$("#detalles").attr("src","../../../framework/tpl/blank.html");
	   clearFind();
       $("#refresh_QUERYGRID_formato_exogena").click();
	   
	   if($('#guardar'))    $('#guardar').attr("disabled","");
	   if($('#actualizar')) $('#actualizar').attr("disabled","true");
	   if($('#borrar'))     $('#borrar').attr("disabled","true");
	   if($('#limpiar'))    $('#limpiar').attr("disabled","");
   }
   alertJquery(resp,"ParametrosExogena");
}
function ParametrosExogenaOnReset(formulario){
	$("#detalles").attr("src","../../../framework/tpl/blank.html");
    clearFind();		
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
}
$(document).ready(function(){
  $("#saveDetalle").click(function(){										
    window.frames[0].saveDetalles();	
  });  
  $("#deleteDetalle").click(function(){										
    window.frames[0].deleteDetalles();
  });  						   
						   
  $("#guardar,#actualizar").click(function(){
	  
	  var formulario = document.getElementById('ParametrosExogenaForm');
	  
	  if(ValidaRequeridos(formulario)){ 
	    if(this.id == 'guardar'){
         Send(formulario,'onclickSave',null,ParametrosExogenaOnSave)
		}else{
            Send(formulario,'onclickUpdate',null,ParametrosExogenaOnUpdate)
		  }
	  }	  	  
  });
});
	
