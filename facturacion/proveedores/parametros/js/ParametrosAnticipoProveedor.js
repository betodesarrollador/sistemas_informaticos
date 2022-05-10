// JavaScript Document

function LlenarFormparametrosAnticipo(){
	
RequiredRemove();

var params     = new Array({campos:"parametros_anticipo_proveedor_id",valores:$('#parametros_anticipo_proveedor_id').val()});
var formulario = document.forms[0];
var url        = 'ParametrosAnticipoProveedorClass.php';

FindRow(params,formulario,url,null,function(resp){

 if($('#guardar'))    $('#guardar').attr("disabled","true");
 if($('#actualizar')) $('#actualizar').attr("disabled","");
 if($('#borrar'))     $('#borrar').attr("disabled","");
 if($('#limpiar'))    $('#limpiar').attr("disabled","");
 
});

}

function setNombreCuenta(id,text){
 
 var nombre = text.split("-");
     nombre = $.trim(nombre[1]);
	 
	 $("#nombre").val(nombre);

}

function parametrosAnticipoOnSaveOnUpdateonDelete(formulario,resp){

   Reset(formulario);
   clearFind();
   setFocusFirstFieldForm(formulario);   
   $("#refresh_QUERYGRID_parametros_anticipo_proveedor").click();
   
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
	
   alertJquery(resp,"parametrosAnticipos");
   
}
function parametrosAnticipoOnReset(formulario){
	
	Reset(formulario);
    clearFind();	
    setFocusFirstFieldForm(formulario);	
	
	$("#naturaleza").val("D");
	
	$("#oficina_id option").each(function(){
      if(this.value != 'NULL'){
		  $(this).remove();
      }
    });	
		
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
}