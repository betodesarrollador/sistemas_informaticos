// JavaScript Document
//funcion para cargar los datos desde BUSCAR
function setDataFormWithResponse(){
		
	var parametros  = new Array({campos:"habilitacion_id",valores:$('#habilitacion_id').val()});
	var forma       = document.forms[0];
	var controlador = 'ResolucionHabilitacionClass.php';
	
	FindRow(parametros,forma,controlador,null,function(resp){
													   	  													   
	  if($('#guardar')) $('#guardar').attr("disabled","true");													   
	  if($('#actualizar')) $('#actualizar').attr("disabled","");
	  if($('#borrar'))     $('#borrar').attr("disabled","");
	  if($('#limpiar'))    $('#limpiar').attr("disabled","");
	  	  
	});
}


function ResolucionHabilitacionOnSaveUpdate(formulario,resp){
	  Reset(formulario);  
	  clearFind();
      $("#refresh_QUERYGRID_ResolucionHabilitacion").click();
	  if($('#guardar'))    $('#guardar').attr("disabled","");
	  if($('#actualizar')) $('#actualizar').attr("disabled","true");
	  if($('#borrar'))     $('#borrar').attr("disabled","true");
	  if($('#limpiar'))    $('#limpiar').attr("disabled","");
	  alertJquery($.trim(resp));
}


function ResolucionHabilitacionOnDelete(formulario,resp){
   Reset(formulario);  
   clearFind();
   $("#refresh_QUERYGRID_ResolucionHabilitacion").click();   
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
   alertJquery($.trim(resp));
}

function ResolucionHabilitacionOnReset(){
  clearFind();
  
  $("#rango_manif_ini").val("1");
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
     validaRegistro(this,params,"ResolucionHabilitacionClass.php",null,function(resp){
		 		 
     if(parseInt(resp) != 0 ){
	     alertJquery('Ya existe una resolucion para esta empresa');
		 $('#guardar').attr("disabled","true");
		 $('#actualizar').attr("disabled","true");
		 $('#borrar').attr("disabled","true");
		 $('#limpiar').attr("disabled","");  
	   }else{
		   $("#utilizado_rango_manif,#utilizado_rango_manif").val("0");
		   $("#rango_manif_ini").val("1");		   
		 }
		 
     });
  });

  $("#rango_manif_fin").keyup(function(){
	  
	  var rango_manif_fin      = $("#rango_manif_fin").val();
	  var asignado_rango_manif = $("#asignado_rango_manif").val();
	  
      $("#saldo_rango_manif").val(rango_manif_fin - asignado_rango_manif);
	  
  });
  
  $("#rango_despacho_urbano_fin").keyup(function(){
	  
	  var rango_despacho_urbano_fin      = $("#rango_despacho_urbano_fin").val();
	  var asignado_rango_despacho_urbano = $("#asignado_rango_despacho_urbano").val();
	  
      $("#saldo_rango_despacho_urbano").val(rango_despacho_urbano_fin - asignado_rango_despacho_urbano);
	  
  });


    $("#rango_remesa_fin").keyup(function(){
	  
	  var rango_remesa_fin      = $("#rango_remesa_fin").val();
	  var asignado_rango_remesa = $("#asignado_rango_remesa").val();
	  
      $("#saldo_rango_remesa").val(rango_remesa_fin - asignado_rango_remesa);
	  
  });

  			
});