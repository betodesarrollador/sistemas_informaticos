// JavaScript Document
//funcion para cargar los datos desde BUSCAR
function setDataFormWithResponse(){
		
	var parametros  = new Array({campos:"alerta_id",valores:$('#alerta_id').val()});
	var forma       = document.forms[0];
	var controlador = 'AlertasPanicoClass.php';
	
	FindRow(parametros,forma,controlador,null,function(resp){
													   
	  if($('#guardar')) $('#guardar').attr("disabled","true");													   
	  if($('#actualizar')) $('#actualizar').attr("disabled","");
	  if($('#borrar'))     $('#borrar').attr("disabled","");
	  if($('#limpiar'))    $('#limpiar').attr("disabled","");
	  
      //$.getScript("/roa/framework/js/iColorPicker.js");	  
	  
	  $("#color_alerta_panico").css("background",$("#color_alerta_panico").val());
	  
	});
}


function AlertasPanicoOnSaveUpdate(formulario,resp){
	  Reset(document.getElementById('AlertasPanicoForm'));
	  $("#color_alerta_panico").css("background","");	  
	  clearFind();
      $("#refresh_QUERYGRID_AlertasPanico").click();
	  if($('#guardar'))    $('#guardar').attr("disabled","");
	  if($('#actualizar')) $('#actualizar').attr("disabled","true");
	  if($('#borrar'))     $('#borrar').attr("disabled","true");
	  if($('#limpiar'))    $('#limpiar').attr("disabled","");
	  alertJquery($.trim(resp));
}


function AlertasPanicoOnDelete(formulario,resp){
   Reset(document.getElementById('AlertasPanicoForm'));
   $("#color_alerta_panico").css("background","");	  
   clearFind();
   $("#refresh_QUERYGRID_AlertasPanico").click();   
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
   alertJquery($.trim(resp));
}

function AlertasPanicoOnReset(){
  $("#color_alerta_panico").css("background","");	
  clearFind();
  $('#guardar').attr("disabled","");
  $('#actualizar').attr("disabled","true");
  $('#borrar').attr("disabled","true");
  $('#limpiar').attr("disabled","");  
}

//eventos asignados a los objetos
$(document).ready(function(){
  
  //evento que busca los datos ingresados
  $("#alerta_panico").blur(function(){
     var params = new Array({campos:"alerta_panico",valores:$("#alerta_panico").val()});
     validaRegistro(this,params,"AlertasPanicoClass.php",null,function(resp){
     if(parseInt(resp) != 0 ){
	     alertJquery('Color ya fue ingresado');
	   }else{
		 $('#guardar').attr("disabled","");
         $('#actualizar').attr("disabled","true");
         $('#borrar').attr("disabled","true");
         $('#limpiar').attr("disabled","true");
	  }
     });
  });


  			
});