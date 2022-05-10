// JavaScript Document
function setDataFormWithResponse(){
    var parametrosId = $('#parametros_descuento_proveedor_id').val();
    RequiredRemove();

    var parametros  = new Array({campos:"parametros_descuento_proveedor_id",valores:$('#parametros_descuento_proveedor_id').val()});
	var forma       = document.forms[0];
	var controlador = 'DescuentoClass.php';

	FindRow(parametros,forma,controlador,null,function(resp){
      if($('#guardar'))    $('#guardar').attr("disabled","true");
      if($('#actualizar')) $('#actualizar').attr("disabled","");
      if($('#borrar'))     $('#borrar').attr("disabled","");
      if($('#limpiar'))    $('#limpiar').attr("disabled","");	  
    });


}

function DescuentoOnSaveOnUpdateonDelete(formulario,resp){
   Reset(formulario);
   clearFind();
   $("#refresh_QUERYGRID_descuento").click();
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
   alertJquery(resp,"Descuentos");
}
function DescuentoOnReset(formulario){
	
    clearFind();	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
}

$(document).ready(function(){
						   
  $("#guardar,#actualizar").click(function(){
	  
	  var formulario = document.getElementById('DescuentoForm');
	  
	  if(ValidaRequeridos(formulario)){ 
	    if(this.id == 'guardar'){
       		Send(formulario,'onclickSave',null,DescuentoOnSaveOnUpdateonDelete)
		}else{
            Send(formulario,'onclickUpdate',null,DescuentoOnSaveOnUpdateonDelete)
		}
	  }
	  	  
  });

});
	
