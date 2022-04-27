// JavaScript Document

function setDataFormWithResponse(){
	
$("#tipo_identificacion_id").trigger("change"); 	
	
RequiredRemove();

FindRow([{campos:"remitente_destinatario_id",valores:$('#remitente_destinatario_id').val()}],document.forms[0],'RemitenteClass.php',null,function(){
  
  $("#tipo").val("R"); 
  
  calculaDigitoTercero();
  ocultaFilaNombresRazon(this.value);  
  
  if($('#guardar'))    $('#guardar').attr("disabled","true");
  if($('#actualizar')) $('#actualizar').attr("disabled","");
  if($('#borrar'))     $('#borrar').attr("disabled","");
  if($('#limpiar'))    $('#limpiar').attr("disabled","");
	
});


}

function RemitenteOnSaveOnUpdateonDelete(formulario,resp){
	
	
	if($.trim(resp) == 'true'){		
	
	  var QueryString = FormSerialize(formulario)+"&ACTIONCONTROLER=sendRemitenteDestinatarioMintransporte";
	  	
	  $.ajax({
		url        : "RemitenteClass.php?rand="+Math.random(),	 
		data       : QueryString,
		beforeSend : function(){
			window.scrollTo(0,0);
			showDivMessage("Reportando al Ministerio de Transporte<br>Por Favor Espere..","/velotax/framework/media/images/general/cable_data_transfer_md_wht.gif");
		},
		success    : function(resp){			
					
			removeDivMessage();
			
			showDivMessage(resp,"/velotax/framework/media/images/general/cable_data_transfer_md_wht.gif");			

		   Reset(formulario);
		   clearFind();
		   $("#tipo").val("R");  
		   $("#estado").val("D");     
		   $("#refresh_QUERYGRID_remitente").click();
		   
		   if($('#guardar'))    $('#guardar').attr("disabled","");
		   if($('#actualizar')) $('#actualizar').attr("disabled","true");
		   if($('#borrar'))     $('#borrar').attr("disabled","true");
		   if($('#limpiar'))    $('#limpiar').attr("disabled","");
						
		}
		
	  });
		
	
	}else{
		alertJquery(resp);
	 }
	   
}
function RemitenteOnReset(formulario){
	
    Reset(formulario);
    clearFind();	
	
    $("#tipo").val("D");
    $("#estado").val("D");     	
    $("#primer_apellido,#segundo_apellido").removeClass("obligatorio");	
	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
}

$(document).ready(function(){
						   
  $("#tipo_identificacion_id").change(function(){
											   
    if(this.value != '2' && this.value != 'NULL'){	  
	  $("#primer_apellido,#segundo_apellido").addClass("obligatorio");	  
	  $("#telefono").removeClass("obligatorio");	  
	  $("#telefono").removeClass("requerido");	  	  
	}else{
	    $("#telefono").addClass("obligatorio");	  		
 	    $("#primer_apellido,#segundo_apellido").removeClass("obligatorio");
 	    $("#primer_apellido,#segundo_apellido").removeClass("requerido");		
	  }											   
											   
  });						   
  
  $("#tipo_identificacion_id").trigger("change");  
						   
  $("#filaApellidos").css("display","none");						   
						   
  $("#tipo_identificacion_id").change(function(){
    calculaDigitoTercero();
    ocultaFilaNombresRazon(this.value);
  });
  
  $("#numero_identificacion").blur(function(){
											
     var remitente_destinatario_id            = $("#remitente_destinatario_id").val();
     var numero_identificacion = this.value;
     var params                = new Array({campos:"numero_identificacion",valores:numero_identificacion});	 
	 
	 if(!remitente_destinatario_id > 0){
	 
           validaRegistro(this,params,"RemitenteClass.php",null,function(resp){    
																		 
           if(parseInt(resp) != 0 ){
	     
	        var params     = new Array({campos:"numero_identificacion",valores:numero_identificacion});
	        var formulario = document.forms[0];
	        var url        = 'RemitenteClass.php';

	        FindRow(params,formulario,url,null,function(resp){
		
		      var data = $.parseJSON(resp);
      
		      ocultaFilaNombresRazon(data[0]['tipo_persona_id']);	     
													      
		      clearFind();		

              $("#tipo_identificacion_id").attr("disabled","true");			  			    			  
		    
		      $('#guardar').attr("disabled","");
		      $('#actualizar').attr("disabled","true");
		      $('#borrar').attr("disabled","true");
		      $('#limpiar').attr("disabled","");	
													 
           },true);
		 
	    }else{	   		  
            calculaDigitoTercero();	
			
            $("#tipo_identificacion_id").attr("disabled","");			  			  
			
			
		    $('#guardar').attr("disabled","");
            $('#actualizar').attr("disabled","true");
            $('#borrar').attr("disabled","true");
            $('#limpiar').attr("disabled","");
		   }
       });
	 
	 }
  
  });
     

});
	
