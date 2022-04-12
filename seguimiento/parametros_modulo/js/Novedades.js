// JavaScript Document
//funcion para cargar los datos desde BUSCAR
function setDataFormWithResponse(){
		
	var parametros  = new Array({campos:"novedad_id",valores:$('#novedad_id').val()});
	var forma       = document.forms[0];
	var controlador = 'NovedadesClass.php';
	
	FindRow(parametros,forma,controlador,null,function(resp){

	  var novedad_id = $('#novedad_id').val();	 
	  var url    = "DetalleCorreosClass.php?novedad_id="+novedad_id+"&rand="+Math.random();
		
	  $("#detalleCorreos").attr("src",url);

	
	  if($('#guardar'))    $('#guardar').attr("disabled","true");
	  if($('#actualizar')) $('#actualizar').attr("disabled","");
	  if($('#borrar'))     $('#borrar').attr("disabled","");
	  if($('#limpiar'))    $('#limpiar').attr("disabled","");
	});
}


function NovedadesOnSave(formulario,resp){

  	  var novedad_id = parseInt(resp);
	  	  
      if(isNumber(novedad_id)){

      	$("#refresh_QUERYGRID_Novedades").click();
	 
		var url    = "DetalleCorreosClass.php?novedad_id="+novedad_id+"&rand="+Math.random();
	    $("#detalleCorreos").attr("src",url);
		
	  	if($('#guardar'))    $('#guardar').attr("disabled","true");
	  	if($('#actualizar')) $('#actualizar').attr("disabled","");
	  	if($('#borrar'))     $('#borrar').attr("disabled","");
	  	if($('#limpiar'))    $('#limpiar').attr("disabled","");
		alertJquery("Guardado Exitosamente \n Por favor Ingrese los Usuarios para Reporte Interno","Novedades");  
	  }else{
	  	if($('#guardar'))    $('#guardar').attr("disabled","");
	  	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	  	if($('#borrar'))     $('#borrar').attr("disabled","true");
	  	if($('#limpiar'))    $('#limpiar').attr("disabled","");
		alertJquery("Ocurrio una inconsistencia : "+resp,"Novedades");  
	  }
}

function NovedadesOnUpdate(formulario,resp){

	  var novedad_id = $('#novedad_id').val();	 
	  var url    = "DetalleCorreosClass.php?novedad_id="+novedad_id+"&rand="+Math.random();
	  $("#detalleCorreos").attr("src",url);
	
      $("#refresh_QUERYGRID_Novedades").click();
	  if($('#guardar'))    $('#guardar').attr("disabled","true");
	  if($('#actualizar')) $('#actualizar').attr("disabled","");
	  if($('#borrar'))     $('#borrar').attr("disabled","");
	  if($('#limpiar'))    $('#limpiar').attr("disabled","");
	  alertJquery($.trim(resp),"Novedades");
}


function NovedadesOnDelete(formulario,resp){
   Reset(document.getElementById('NovedadesForm'));
   clearFind();  
   $("#detalleCorreos").attr("src","/roa/framework/tpl/blank.html");
   $("#refresh_QUERYGRID_Novedades").click();
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
   	alertJquery($.trim(resp),"Novedades");  
}

function NovedadesOnReset(){
  clearFind();	
  $("#detalleCorreos").attr("src","/roa/framework/tpl/blank.html");
  $('#guardar').attr("disabled","");
  $('#actualizar').attr("disabled","true");
  $('#borrar').attr("disabled","true");
  $('#limpiar').attr("disabled","");  
}

function updateGrid(){
   $("#refresh_QUERYGRID_Novedades").click();   	
}
//eventos asignados a los objetos
$(document).ready(function(){
  
  //evento que busca los datos ingresados
  $("#novedad").blur(function(){
     var params = new Array({campos:"novedad",valores:$("#novedad").val()});
     validaRegistro(this,params,"NovedadesClass.php",null,function(resp){
     if(parseInt(resp) != 0 ){
	     alertJquery('Novedad ya fue ingresada',"Novedades");
		 $('#guardar').attr("disabled","");
	   }else{
		 $('#guardar').attr("disabled","");
         $('#actualizar').attr("disabled","true");
         $('#borrar').attr("disabled","true");
         $('#limpiar').attr("disabled","true");
	  }
     });
  });

  $("#saveDetallesCorreos").click(function(){
										
    window.frames[0].saveDetalleCorreos();
	
  });
  
  
  $("#deleteDetallesCorreos").click(function(){
										
    window.frames[0].deleteDetalleCorreos();
	
  });
  
  
  $("#alerta_id option").each(function(){
      var datosOpcion = this.text.split("-");									   

      $(this).text($.trim(datosOpcion[0]));
      if(this.value != 'NULL')$(this).css("color","#ffffff");	  
      $(this).css("background",$.trim(datosOpcion[1]));
  });
  
});