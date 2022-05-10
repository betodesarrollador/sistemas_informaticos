// JavaScript Document
//funcion para cargar los datos desde BUSCAR
function setDataFormWithResponse(){
		
	var parametros  = new Array({campos:"puesto_control_id",valores:$('#puesto_control_id').val()});
	var forma       = document.forms[0];
	var controlador = 'PuestosControlClass.php';
	
	FindRow(parametros,forma,controlador,null,function(resp){
	
	  if($('#actualizar')) $('#actualizar').attr("disabled","");
	  if($('#borrar'))     $('#borrar').attr("disabled","");
	  if($('#limpiar'))    $('#limpiar').attr("disabled","");
	});
}


function PuestosControlOnSaveUpdate(formulario,resp){
      Reset(formulario);
	  clearFind();
	  $("#refresh_QUERYGRID_PuestosControl").click();
	  if($('#guardar'))    $('#guardar').attr("disabled","true");
	  if($('#actualizar')) $('#actualizar').attr("disabled","true");
	  if($('#borrar'))     $('#borrar').attr("disabled","true");
	  if($('#limpiar'))    $('#limpiar').attr("disabled","true");
	  alertJquery($.trim(resp));
}


function PuestosControlOnDelete(formulario,resp){
   Reset(formulario);
   clearFind();
   $("#refresh_QUERYGRID_PuestosControl").click();   
   if($('#guardar'))    $('#guardar').attr("disabled","true");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","true");
   alertJquery($.trim(resp));
}

function PuestosControlOnReset(){
  clearFind();
  $('#guardar').attr("disabled","true");
  $('#actualizar').attr("disabled","true");
  $('#borrar').attr("disabled","true");
  $('#limpiar').attr("disabled","true");  
}

//eventos asignados a los objetos
$(document).ready(function(){
  
  //evento que busca los datos ingresados
  $("#ubicacion").blur(function(){
     var params = new Array({campos:"ubicacion_id",valores:$("#ubicacion_id").val()});
     validaRegistro(this,params,"PuestosControlClass.php",null,function(resp){
     if(parseInt(resp) != 0 ){
	     alertJquery('Ya existe un puesto de control relacionado a esta Ubicacion');
	   }else{
		 $('#guardar').attr("disabled","");
         $('#actualizar').attr("disabled","true");
         $('#borrar').attr("disabled","true");
         $('#limpiar').attr("disabled","true");
	  }
     });
  });

  
  $("#guardar").click(function(){
	  var formulario = document.getElementById('PuestosControlForm');
      Send(formulario,'onclickSave',null,PuestosControlOnSaveUpdate);  	  
  });

});