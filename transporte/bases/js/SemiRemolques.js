// JavaScript Document
//funcion para cargar los datos desde BUSCAR
function setDataFormWithResponse(){	

	$('#placa_remolque').val();
	
	RequiredRemove();
	
	FindRow([{campos:"placa_remolque",valores:$('#placa_remolque').val()}],document.forms[0],'SemiRemolquesClass.php');

	if($('#guardar'))    $('#guardar').attr("disabled","true");
	if($('#actualizar')) $('#actualizar').attr("disabled","");
	if($('#borrar'))     $('#borrar').attr("disabled","");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
}

var formSubmitted = false;

function RemolqueOnSaveUpdate(formulario,resp){
				
	if($.trim(resp) == 'true'){	
	
	 if(!formSubmitted){		
	
	  var QueryString = FormSerialize(formulario)+"&ACTIONCONTROLER=sendRemolqueMintransporte";
	  	
	  $.ajax({
		url        : "SemiRemolquesClass.php?rand="+Math.random(),	 
		data       : QueryString,
		beforeSend : function(){
			window.scrollTo(0,0);
			showDivMessage("Reportando al Ministerio de Transporte<br>Por Favor Espere..","../../../framework/media/images/general/cable_data_transfer_md_wht.gif");
			formSubmitted = true;
		},
		success    : function(resp){			
					
		 removeDivMessage();
			
		 showDivMessage(resp,"../../../framework/media/images/general/cable_data_transfer_md_wht.gif");			
		 formSubmitted = false;

	     Reset(formulario);
	     clearFind();
	     $("#estado").val("B");
	   
         $("#refresh_QUERYGRID_placa_remolque").click();
	  
	     if($('#guardar'))    $('#guardar').attr("disabled","");
	     if($('#actualizar')) $('#actualizar').attr("disabled","true");
	     if($('#borrar'))     $('#borrar').attr("disabled","true");
	     if($('#limpiar'))    $('#limpiar').attr("disabled","");
						
		}
		
	  });
	  
	 }
	  
	}else{
		alertJquery(resp);
	 }	
	
}


function RemolqueOnDelete(formulario,resp){
	
	   Reset(formulario);
	   clearFind();
	   $("#estado").val("B");	   
	   
      $("#refresh_QUERYGRID_placa_remolque").click();
	  
	  if($('#guardar'))    $('#guardar').attr("disabled","");
	  if($('#actualizar')) $('#actualizar').attr("disabled","true");
	  if($('#borrar'))     $('#borrar').attr("disabled","true");
	  if($('#limpiar'))    $('#limpiar').attr("disabled","");
	  
	  alertJquery(resp);
}

function remolqueOnReset(formulario){

  Reset(formulario);
  clearFind();
  $("#estado").val("B");  
	    
  if($('#guardar'))    $('#guardar').attr("disabled","");
  if($('#actualizar')) $('#actualizar').attr("disabled","true");
  if($('#borrar'))     $('#borrar').attr("disabled","true");
  if($('#limpiar'))    $('#limpiar').attr("disabled","");

}

//eventos asignados a los objetos
$(document).ready(function(){
  
  //evento que busca la placa duplicada
  $("#placa_remolque").blur(function(){
									 
     var params = new Array({campos:"placa_remolque",valores:$("#placa_remolque").val()});
	 
     validaRegistro(this,params,"SemiRemolquesClass.php",null,function(resp){
																	   
     if(parseInt(resp) != 0 ){
       setDataFormWithResponse();
	 }else{
		 $('#guardar').attr("disabled","");
         $('#actualizar').attr("disabled","true");
         $('#borrar').attr("disabled","true");
         $('#limpiar').attr("disabled","");
	  }
   });
  
});
  
  
});