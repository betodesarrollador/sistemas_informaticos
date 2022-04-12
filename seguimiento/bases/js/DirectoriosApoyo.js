// JavaScript Document
//funcion para cargar los datos desde BUSCAR
function setDataFormWithResponse(){
	
	var parametros  = new Array({campos:"apoyo_id",valores:$('#apoyo_id').val()});
	var forma       = document.forms[0];
	var controlador = 'DirectoriosApoyoClass.php';
	
	FindRow(parametros,forma,controlador,null,function(resp){
													  
	  if($('#guardar'))    $('#guardar').attr("disabled","true");
	  if($('#actualizar')) $('#actualizar').attr("disabled","");
	  if($('#borrar'))     $('#borrar').attr("disabled","");
	  if($('#limpiar'))    $('#limpiar').attr("disabled","");
	});
}


function DirectoriosApoyoOnSaveUpdate(formulario,resp){
	
      $("#refresh_QUERYGRID_DirectoriosApoyo").click();
	  
	  clearForm(document.getElementById('DirectoriosApoyoForm'));
	  clearFind();
	  
	  if($('#guardar'))    $('#guardar').attr("disabled","");
	  if($('#actualizar')) $('#actualizar').attr("disabled","true");
	  if($('#borrar'))     $('#borrar').attr("disabled","true");
	  if($('#limpiar'))    $('#limpiar').attr("disabled","");
	  
	  alertJquery(resp);
	  
}


function DirectoriosApoyoOnDelete(formulario,resp){
	
   clearForm(document.getElementById('DirectoriosApoyoForm'));
   clearFind();
	  
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
	  
   $("#refresh_QUERYGRID_DirectoriosApoyo").click();   
   
   	alertJquery(resp);  
}

function directoriosApoyoOnclear(){
   clearFind();
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");	
}