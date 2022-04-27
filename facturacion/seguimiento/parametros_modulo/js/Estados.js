// JavaScript Document
//funcion para cargar los datos desde BUSCAR
function setDataFormWithResponse(){
		
	var parametros  = new Array({campos:"estado_segui_id",valores:$('#estado_segui_id').val()});
	var forma       = document.forms[0];
	var controlador = 'EstadosClass.php';
	
	FindRow(parametros,forma,controlador,null,function(resp){
	
	  if($('#guardar'))    $('#guardar').attr("disabled","true");
	  if($('#actualizar')) $('#actualizar').attr("disabled","");
	  if($('#borrar'))     $('#borrar').attr("disabled","");
	  if($('#limpiar'))    $('#limpiar').attr("disabled","");
	});
}


function EstadosOnSaveUpdate(formulario,resp){
	  Reset(formulario);
      clearFind();
      $("#refresh_QUERYGRID_Estados").click();
	  if($('#guardar'))    $('#guardar').attr("disabled","");
	  if($('#actualizar')) $('#actualizar').attr("disabled","true");
	  if($('#borrar'))     $('#borrar').attr("disabled","true");
	  if($('#limpiar'))    $('#limpiar').attr("disabled","");
	  jAlert($.trim(resp),"Estados Seguimiento");
}


function EstadosOnDelete(formulario,resp){
   Reset(formulario);
   clearFind();   
   $("#refresh_QUERYGRID_Estados").click();
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
   	jAlert($.trim(resp),"Estados Seguimiento");  
}

function EstadosOnReset(){
  clearFind();	
  $('#guardar').attr("disabled","");
  $('#actualizar').attr("disabled","true");
  $('#borrar').attr("disabled","true");
  $('#limpiar').attr("disabled","");  
}

//eventos asignados a los objetos
$(document).ready(function(){
  
  //evento que busca los datos ingresados
/*  $("#estado_segui").blur(function(){
     var params = new Array({campos:"estado_segui",valores:$("#estado_segui").val()});
     validaRegistro(this,params,"EstadosClass.php",null,function(resp){
     if(parseInt(resp) != 0 ){
	     alert('Estado ingresado anteriormente');
	   }else{
		 $('#guardar').attr("disabled","");
         $('#actualizar').attr("disabled","true");
         $('#borrar').attr("disabled","true");
         $('#limpiar').attr("disabled","true");
	  }
     });
  });*/

  
  
  
});