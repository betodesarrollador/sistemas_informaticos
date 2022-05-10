// JavaScript Document
function setDataFormWithResponse(){
	
    var TarifasRutaCubicajeId = $('#tarifa_ruta_cubicaje_id').val();
    RequiredRemove();

    var parametros  = new Array({campos:"tarifa_ruta_cubicaje_id",valores:$('#tarifa_ruta_cubicaje_id').val()});
	var forma       = document.forms[0];
	var controlador = 'TarifasRutaCubicajeClass.php';

	FindRow(parametros,forma,controlador,null,function(resp){
													   													   
      if($('#guardar'))    $('#guardar').attr("disabled","true");
      if($('#actualizar')) $('#actualizar').attr("disabled","");
      if($('#borrar'))     $('#borrar').attr("disabled","");
      if($('#limpiar'))    $('#limpiar').attr("disabled","");	  
	  
    });


}

function TarifasRutaCubicajeOnSaveOnUpdateonDelete(formulario,resp){

   clearFind();
   $("#refresh_QUERYGRID_TarifasRutaCubicaje").click();
   Reset(formulario);
   
   if($('#guardar'))    $('#guardar').attr("disabled","true");
   if($('#actualizar')) $('#actualizar').attr("disabled","");
   if($('#borrar'))     $('#borrar').attr("disabled","");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
	
   alertJquery(resp,"TarifasRutaCubicaje");
   
}
function TarifasRutaCubicajeOnReset(formulario){
	
    clearFind();	
	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
}
