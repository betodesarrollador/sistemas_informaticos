// JavaScript Document

function LlenarFormPeriodo(){
	
 RequiredRemove();

 var params     = new Array({campos:"periodo_uiaf_id",valores:$('#periodo_uiaf_id').val()});
 var formulario = document.forms[0];
 var url        = 'PeriodosUIAFClass.php';

 FindRow(params,formulario,url,null,function(){
											
  if($('#guardar'))    $('#guardar').attr("disabled","true");
  if($('#actualizar')) $('#actualizar').attr("disabled","");
  if($('#borrar'))     $('#borrar').attr("disabled","");
  if($('#limpiar'))    $('#limpiar').attr("disabled","");											
											
 });


}

function PeriodosUIAFOnSaveOnUpdateonDelete(formulario,resp){

   Reset(formulario);
   clearFind();
   setFocusFirstFieldForm(formulario);   
   $("#refresh_QUERYGRID_periodo_uiaf").click();
   
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
	
   alertJquery(resp,"Centros Costo");
   
}
function PeriodosUIAFOnReset(formulario){
	
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