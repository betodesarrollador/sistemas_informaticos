// JavaScript Document
function LlenarFormPeriodo(){
	
RequiredRemove();

var params     = new Array({campos:"tipo_dinero_id",valores:$('#tipo_dinero_id').val()});
var formulario = document.forms[0];
var url        = 'TipoDineroClass.php';

FindRow(params,formulario,url,null,null);

if($('#guardar'))    $('#guardar').attr("disabled","true");
if($('#actualizar')) $('#actualizar').attr("disabled","");
if($('#borrar'))     $('#borrar').attr("disabled","");
if($('#limpiar'))    $('#limpiar').attr("disabled","");
}

function setDataFormWithResponse(){
    var parametrosId = $('#tipo_dinero_id').val();
    RequiredRemove();

    var parametros  = new Array({campos:"tipo_dinero_id",valores:$('#tipo_dinero_id').val()});
	var forma       = document.forms[0];
	var controlador = 'TipoDineroClass.php';

	FindRow(parametros,forma,controlador,null,function(resp){
      if($('#guardar'))    $('#guardar').attr("disabled","true");
      if($('#actualizar')) $('#actualizar').attr("disabled","");
      if($('#borrar'))     $('#borrar').attr("disabled","");
      if($('#limpiar'))    $('#limpiar').attr("disabled","");	  
    });
}

function TipoDineroOnSaveOnUpdateonDelete(formulario,resp){
	
   Reset(formulario);
   clearFind();
   $("#refresh_QUERYGRID_tipodinero").click();
   
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
	
   alertJquery(resp,"Tipo Dinero");
}

function TipoDineroOnReset(formulario){
	
	Reset(formulario);
    clearFind();
    setFocusFirstFieldForm(formulario);	
	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
}
