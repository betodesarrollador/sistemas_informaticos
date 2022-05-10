// JavaScript Document
//funcion para cargar los datos desde BUSCAR
function setDataFormWithResponse(){
		
	var parametros  = new Array({campos:"parametros_reporte_trafico_id",valores:$('#parametros_reporte_trafico_id').val()});
	var forma       = document.forms[0];
	var controlador = 'ParametrosClass.php';
	
	FindRow(parametros,forma,controlador,null,function(resp){

	  if($('#guardar'))    $('#guardar').attr("disabled","true");
	  if($('#actualizar')) $('#actualizar').attr("disabled","");
	  if($('#borrar'))     $('#borrar').attr("disabled","");
	  if($('#limpiar'))    $('#limpiar').attr("disabled","");
	});
}


function ParametrosOnSave(formulario,resp){

  	  var parametros_reporte_trafico_id = parseInt(resp);
	  	  
      if(isNumber(parametros_reporte_trafico_id)){

      	$("#refresh_QUERYGRID_Parametros").click();
	 
	  	if($('#guardar'))    $('#guardar').attr("disabled","true");
	  	if($('#actualizar')) $('#actualizar').attr("disabled","");
	  	if($('#borrar'))     $('#borrar').attr("disabled","");
	  	if($('#limpiar'))    $('#limpiar').attr("disabled","");
		alertJquery("Guardado Exitosamente ","Parametros");  
	  }else{
	  	if($('#guardar'))    $('#guardar').attr("disabled","");
	  	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	  	if($('#borrar'))     $('#borrar').attr("disabled","true");
	  	if($('#limpiar'))    $('#limpiar').attr("disabled","");
		alertJquery("Ocurrio una inconsistencia : "+resp,"Parametros");  
	  }
}

function ParametrosOnUpdate(formulario,resp){

	  var parametros_reporte_trafico_id = $('#parametros_reporte_trafico_id').val();	 
	
      $("#refresh_QUERYGRID_Parametros").click();
	  if($('#guardar'))    $('#guardar').attr("disabled","true");
	  if($('#actualizar')) $('#actualizar').attr("disabled","");
	  if($('#borrar'))     $('#borrar').attr("disabled","");
	  if($('#limpiar'))    $('#limpiar').attr("disabled","");
	  alertJquery($.trim(resp),"Parametros");
}


function ParametrosOnDelete(formulario,resp){
   Reset(document.getElementById('ParametrosForm'));
   clearFind();  
   $("#refresh_QUERYGRID_Parametros").click();
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
   	alertJquery($.trim(resp),"Parametros");  
}

function ParametrosOnReset(){
  clearFind();	
  $('#guardar').attr("disabled","");
  $('#actualizar').attr("disabled","true");
  $('#borrar').attr("disabled","true");
  $('#limpiar').attr("disabled","");  
}

function updateGrid(){
   $("#refresh_QUERYGRID_Parametros").click();   	
}
function setDataCliente(cliente_id){
    
  var QueryString = "ACTIONCONTROLER=setDataCliente&cliente_id="+cliente_id;
  
  $.ajax({
    url        : "ParametrosClass.php?rand="+Math.random(),
    data       : QueryString,
    beforeSend : function(){
      
    },
    success    : function(response){
      
      try{
	
		var responseArray   = $.parseJSON(response); 
		var parametros_reporte_trafico_id   = responseArray[0]['parametros_reporte_trafico_id'];
		var cliente_id      				= responseArray[0]['cliente_id'];
		var cliente   		= responseArray[0]['cliente'];
		var minuto    		= responseArray[0]['minuto'];
		var horas 			= responseArray[0]['horas'];
		var dias	    	= responseArray[0]['dias'];	
		var tiempo_rojo		= responseArray[0]['tiempo_rojo'];
		var tiempo_amarillo	= responseArray[0]['tiempo_amarillo'];
		var tiempo_verde   	= responseArray[0]['tiempo_verde'];	
		var estado	    	= responseArray[0]['estado'];	
		
		$("#parametros_reporte_trafico_id").val(parametros_reporte_trafico_id);
		$("#cliente_id").val(cliente_id);
		$("#cliente").val(cliente);
		$("#minuto").val(minuto);
		$("#horas").val(horas);
		$("#dias").val(dias);	
		$("#tiempo_rojo").val(tiempo_rojo);
		$("#tiempo_amarillo").val(tiempo_amarillo);
		$("#tiempo_verde").val(tiempo_verde);	
		$("#estado").val(estado);	

	   if($('#guardar'))    $('#guardar').attr("disabled","true");
	   if($('#actualizar')) $('#actualizar').attr("disabled","");
	   if($('#borrar'))     $('#borrar').attr("disabled","");
	   if($('#limpiar'))    $('#limpiar').attr("disabled","");

	
      }catch(e){

      }
      
    }
    
  });
  
}
