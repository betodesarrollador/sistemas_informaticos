// JavaScript Document
function setDataFormWithResponse(){
    var FaqId = $('#errores_id').val();
    RequiredRemove();

    var Faq  = new Array({campos:"errores_id",valores:$('#errores_id').val()});
	var forma       = document.forms[0];
	var controlador = 'FaqClass.php';

	FindRow(Faq,forma,controlador,null,function(resp){
      if($('#guardar'))    $('#guardar').attr("disabled","true");
      if($('#actualizar')) $('#actualizar').attr("disabled","");
      if($('#borrar'))     $('#borrar').attr("disabled","");
      if($('#limpiar'))    $('#limpiar').attr("disabled","");	  
    });

	$("#asunto_id,#anticipos,#cliente,#modulos_codigo,#usuario_ id,#usuario_modifica,#usuario,#descripcion").attr("disabled","true");
	$("#solucion,#fecha_solucion").attr("required","true");	

}


function FaqOnSaveOnUpdateonDelete(formulario,resp){
   Reset(formulario);
   clearFind();
   $("#refresh_QUERYGRID_Faq").click();
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
   alertJquery(resp,"Error");
}
function FaqOnReset(formulario){
	
    clearFind();	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
	$("#asunto_id,#anticipos,#cliente,#modulos_codigo,#usuario_ id,#usuario_modifica,#usuario,#descripcion").attr("disabled","");
	$("#solucion,#fecha_solucion").attr("required","true");	
}

$(document).ready(function(){
						   
	$("#asunto_id,#anticipos,#cliente,#modulos_codigo,#usuario_ id,#usuario_modifica,#usuario,#descripcion").attr("disabled","");
	$("#solucion,#fecha_solucion").attr("required","true");	
						   
  $("#guardar,#actualizar").click(function(){
	  
	  var formulario = document.getElementById('FaqForm');
	  
	  if(ValidaRequeridos(formulario)){ 
	    if(this.id == 'guardar'){
         		Send(formulario,'onclickSave',null,FaqOnSaveOnUpdateonDelete)
		}else{
			    Send(formulario,'onclickUpdate',null,FaqOnSaveOnUpdateonDelete)
			
			}
	  }
	  	  
  });

	///INICIO VALIDACION FECHAS DE REPORTE
 
   $('#fecha_solucion').change(function(){

	var fechas = $('#fecha_solucion').val();
    var fechai = $('#fecha_ingreso_error').val();
    var today = new Date();

    if ((Date.parse(fechas) < Date.parse(fechai)) || (Date.parse(fechas)>today)) {
     alertJquery('Esta fecha no puede ser menor a la fecha de ingreso o mayor a hoy.');
     return this.value = $('#fecha_ingreso_error').val();
    };
 });

});
	
