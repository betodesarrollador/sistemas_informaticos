// JavaScript Document

function LlenarFormPeriodo(){
	
RequiredRemove();

var params     = new Array({campos:"periodo_contable_id",valores:$('#periodo_contable_id').val()});
var formulario = document.forms[0];
var url        = 'PeriodosClass.php';

FindRow(params,formulario,url,null,null);

if($('#guardar'))    $('#guardar').attr("disabled","true");
if($('#actualizar')) $('#actualizar').attr("disabled","");
if($('#borrar'))     $('#borrar').attr("disabled","");
if($('#limpiar'))    $('#limpiar').attr("disabled","");
}

function PeriodoOnSaveOnUpdateonDelete(formulario,resp){

   Reset(formulario);
   clearFind();
   setFocusFirstFieldForm(formulario);   
   $("#refresh_QUERYGRID_periodo_contable").click();
   
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
	
   alertJquery(resp,"Centros Costo");
   
}
function PeriodoOnReset(formulario){
	
	Reset(formulario);
    clearFind();	
    setFocusFirstFieldForm(formulario);	
	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
}