// JavaScript Document
function LlenarFormPeriodo(){
	
RequiredRemove();

var params     = new Array({campos:"chequeras_id",valores:$('#chequeras_id').val()});
var formulario = document.forms[0];
var url        = 'ChequerasClass.php';

FindRow(params,formulario,url,null,null);

if($('#guardar'))    $('#guardar').attr("disabled","true");
if($('#actualizar')) $('#actualizar').attr("disabled","");
if($('#borrar'))     $('#borrar').attr("disabled","");
if($('#limpiar'))    $('#limpiar').attr("disabled","");
}

function setDataFormWithResponse(){
    var parametrosId = $('#chequeras_id').val();
    RequiredRemove();

    var parametros  = new Array({campos:"chequeras_id",valores:$('#chequeras_id').val()});
	var forma       = document.forms[0];
	var controlador = 'ChequerasClass.php';

	FindRow(parametros,forma,controlador,null,function(resp){
      if($('#guardar'))    $('#guardar').attr("disabled","true");
      if($('#actualizar')) $('#actualizar').attr("disabled","");
      if($('#borrar'))     $('#borrar').attr("disabled","");
      if($('#limpiar'))    $('#limpiar').attr("disabled","");	  
    });
}

function ChequerasOnSaveOnUpdateonDelete(formulario,resp){
	
   Reset(formulario);
   clearFind();
   $("#refresh_QUERYGRID_chequeras").click();
   
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
	
   alertJquery(resp,"Chequeras");
}

function ChequerasOnReset(formulario){
	
	Reset(formulario);
    clearFind();
    setFocusFirstFieldForm(formulario);	
	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
}
