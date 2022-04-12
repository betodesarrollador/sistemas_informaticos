// JavaScript Document
//funcion para cargar los datos desde BUSCAR
function setDataFormWithResponse(){
		
	var parametros  = new Array({campos:"poliza_empresa_id",valores:$('#poliza_empresa_id').val()});
	var forma       = document.forms[0];
	var controlador = 'PolizaSeguroClass.php';
	
	FindRow(parametros,forma,controlador,null,function(resp){
													   
	  if($('#guardar')) $('#guardar').attr("disabled","true");													   
	  if($('#actualizar')) $('#actualizar').attr("disabled","");
	  if($('#borrar'))     $('#borrar').attr("disabled","");
	  if($('#limpiar'))    $('#limpiar').attr("disabled","");
	  	  
	});
}


function PolizaSeguroOnSaveUpdate(formulario,resp){
	  Reset(formulario);  
	  clearFind();
      $("#refresh_QUERYGRID_PolizaSeguro").click();
	  if($('#guardar'))    $('#guardar').attr("disabled","");
	  if($('#actualizar')) $('#actualizar').attr("disabled","true");
	  if($('#borrar'))     $('#borrar').attr("disabled","true");
	  if($('#limpiar'))    $('#limpiar').attr("disabled","");
	  alertJquery($.trim(resp));
}


function PolizaSeguroOnDelete(formulario,resp){
   Reset(formulario);  
   clearFind();
   $("#refresh_QUERYGRID_PolizaSeguro").click();   
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
   alertJquery($.trim(resp));
}

function PolizaSeguroOnReset(){
  clearFind();
  $('#guardar').attr("disabled","");
  $('#actualizar').attr("disabled","true");
  $('#borrar').attr("disabled","true");
  $('#limpiar').attr("disabled","");  
}

//eventos asignados a los objetos
$(document).ready(function(){
  
  //evento que busca los datos ingresados
  $("#empresa_id").change(function(){
     var params = new Array({campos:"empresa_id",valores:$("#empresa_id").val()});
     validaRegistro(this,params,"PolizaSeguroClass.php",null,function(resp){
     if(parseInt(resp) != 0 ){
	     alertJquery('Ya existe una poliza para esta empresa');
		 $('#guardar').attr("disabled","true");
		 $('#actualizar').attr("disabled","true");
		 $('#borrar').attr("disabled","true");
		 $('#limpiar').attr("disabled","");  
	   }
     });
  });
	
	var url = "DetallePolizaSeguroClass.php";
	$("#detallePoliza").attr("src",url);
});