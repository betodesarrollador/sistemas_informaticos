// JavaScript Document
function LlenarFormImpuesto(){
	
RequiredRemove();
var params     = new Array({campos:"impuesto_oficina_id",valores:$('#impuesto_oficina_id').val()});
var formulario = document.forms[0];
var url        = 'ImpuestosOficinaClass.php';
FindRow(params,formulario,url,null,null);
if($('#guardar'))    $('#guardar').attr("disabled","true");
if($('#actualizar')) $('#actualizar').attr("disabled","");
if($('#borrar'))     $('#borrar').attr("disabled","");
if($('#limpiar'))    $('#limpiar').attr("disabled","");
}
function setFormImpuesto(id,text){
 var params     = new Array({campos:"impuesto_id",valores:id});
 var formulario = document.forms[0];
 var url        = 'ImpuestosClass.php';
 FindRow(params,formulario,url,null,null,true);
}
function ImpuestoOnSaveOnUpdateonDelete(formulario,resp){
   Reset(formulario);
   clearFind();
   setFocusFirstFieldForm(formulario);   
   $("#refresh_QUERYGRID_impuesto_oficina").click();
   
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
	
   alertJquery(resp,"Impuestos");
   
}
function ImpuestoOnReset(formulario){
	
	Reset(formulario);
    clearFind();	
    setFocusFirstFieldForm(formulario);	
	
	$("#naturaleza").val("D");
	
	$("#oficina_id option").each(function(){
      if(this.value != 'NULL'){
		  $(this).remove();
      }
    });	
	
	$("#formula").val("(BASE/100)*PORCENTAJE");
	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
}