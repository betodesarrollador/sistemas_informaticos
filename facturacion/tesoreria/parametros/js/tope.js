// JavaScript Document
function LlenarFormPeriodo(){
	
RequiredRemove();

var params     = new Array({campos:"tope_reembolso_id",valores:$('#tope_reembolso_id').val()});
var formulario = document.forms[0];
var url        = 'TopeClass.php';

FindRow(params,formulario,url,null,null);

if($('#guardar'))    $('#guardar').attr("disabled","true");
if($('#actualizar')) $('#actualizar').attr("disabled","");
if($('#borrar'))     $('#borrar').attr("disabled","");
if($('#limpiar'))    $('#limpiar').attr("disabled","");
}

/*function setDataFormWithResponse(){	
RequiredRemove();

FindRow([{campos:"tope_reembolso_id",valores:$('#tope_reembolso_id').val()}],document.forms[0],'TopeClass.php', 
  function(resp){
	  
	try{
		
	var data          = $.parseJSON(resp);  
	var tope_reembolso_id = data[0]['tope_reembolso_id']; 
		
	document.getElementById('TopeFormaPago').src = "TopeClass.php?tope_reembolso_id="+tope_reembolso_id+"&rand="+Math.random();
  
    if($('#guardar'))    $('#guardar').attr("disabled","true");
    if($('#actualizar')) $('#actualizar').attr("disabled","");
    if($('#borrar'))     $('#borrar').attr("disabled","");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");
	
	}catch(e){
		 alertJquery(resp,"Error :"+e);
	  }	
  });
}*/

function setDataFormWithResponse(){
    var parametrosId = $('#tope_reembolso_id').val();
    RequiredRemove();

    var parametros  = new Array({campos:"tope_reembolso_id",valores:$('#tope_reembolso_id').val()});
	var forma       = document.forms[0];
	var controlador = 'TopeClass.php';

	FindRow(parametros,forma,controlador,null,function(resp){
      if($('#guardar'))    $('#guardar').attr("disabled","true");
      if($('#actualizar')) $('#actualizar').attr("disabled","");
      if($('#borrar'))     $('#borrar').attr("disabled","");
      if($('#limpiar'))    $('#limpiar').attr("disabled","");	  
    });
}

function TopeOnSaveOnUpdateonDelete(formulario,resp){
	
   Reset(formulario);
   clearFind();
   $("#refresh_QUERYGRID_tope").click();
   
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
	
   alertJquery(resp,"Tope");
}

function TopeOnReset(formulario){
	
	$("#periodo_contable_id option").each(function(){
     if(this.value != 'NULL'){
	   $(this).remove();	 
     }
    });
	
	Reset(formulario);
    clearFind();
    setFocusFirstFieldForm(formulario);	
	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
}
