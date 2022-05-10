// JavaScript Document
//eventos asignados a los objetos
function setDataFormWithResponse(){
	
	var forma 		= document.forms[0];	
	var QueryString = "ACTIONCONTROLER=onclickFind&seguimiento_id="+$('#seguimiento_id').val();
	
	$.ajax({
       url        : 'SeguimientoClass.php?random='+Math.random(),
	   data       : QueryString,
	   beforeSend : function(){
		   showDivLoading();
	   },
	   success    : function(resp){
		   
		   var data       = $.parseJSON(resp);
		   
	       setFormWithJSON(forma,data,false,function(){
		   if($('#guardar')) 	$('#guardar').attr("disabled","true");
			if($('#estado').val()=='P'){
				if($('#anular')) 	 $('#anular').attr("disabled","");
		   		if($('#actualizar')) $('#actualizar').attr("disabled","");				
			}else{
				if($('#anular')) 	 $('#anular').attr("disabled","true");
				if($('#actualizar')) $('#actualizar').attr("disabled","true");				
			}

		   if($('#imprimir'))   $('#imprimir').attr("disabled","");
		   if($('#limpiar'))    $('#limpiar').attr("disabled","");
		   
			$("#oficina_id").val($("#oficina_id_static").val());	
			$("#fecha_ingreso").val($("#fecha_ingreso_static").val());	
			$("#usuario_id").val($("#usuario_id_static").val());	

		   setContactos(0);		
		   
														  
         });		   
		   		   
		 removeDivLoading();
		 
	   }
    });

}


function SeguimientoOnSave(formulario,resp){
	   
	try{
		
	  updateGrid();
	  
	  	resp = $.parseJSON(resp);		  
	    $("#seguimiento_id").val(resp[0]['seguimiento_id']);
		$("#servicio_transporte_id").val(resp[0]['servicio_transporte_id']);
		alertJquery("Orden de Seguimiento a Terceros Guardada Exitosamente");

		if($('#guardar'))    $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#anular')) 	   $('#anular').attr("disabled","");
		if($('#imprimir'))   $('#imprimir').attr("disabled","");	  
		if($('#limpiar'))    $('#limpiar').attr("disabled","")

  
	}catch(e){
	  
		alertJquery("Ocurrio una inconsistencia : "+resp,"Error Insercion Orden de Seguimiento a Terceros");
		
		if($('#guardar'))    $('#guardar').attr("disabled","");
		if($('#actualizar')) $('#actualizar').attr("disabled","true");
		if($('#anular')) 	   $('#anular').attr("disabled","true");
		if($('#imprimir'))   $('#imprimir').attr("disabled","true");	  
		if($('#limpiar'))    $('#limpiar').attr("disabled","");		 
		
	  }
	
}

function SeguimientoOnUpdate(formulario,resp){

    if($.trim(resp) ==  'true'){
		alertJquery("Orden de Seguimiento Actualizada Exitosamente","Orden de Seguimiento");
		if($('#guardar'))    $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#estado').val()=='P'){
			if($('#anular')) 	 $('#anular').attr("disabled","");
		}else{
			if($('#anular')) 	 $('#anular').attr("disabled","true");
		}
		if($('#imprimir'))   $('#imprimir').attr("disabled","");	  
		if($('#limpiar'))    $('#limpiar').attr("disabled","")
	  
	}else{
	    alertJquery(resp,"Error Actualizacion Orden de Seguimiento");
	}
	
	updateGrid();

}

function beforePrint(formulario,url,title,width,height){

	var seguimiento_id = parseInt($("#seguimiento_id").val());
	
	if(isNaN(seguimiento_id)){
	  
	  alertJquery('Debe seleccionar una Orden de Seguimiento a imprimir !!!','Impresion Orden de Seguimiento');
	  return false;
	  
	}else{	  
	    return true;
	  }
	
}


function separaNombre(conductor_id){
		
	var QueryString = "ACTIONCONTROLER=setDataConductor&conductor_id="+conductor_id;
	
	$.ajax({
	  url        : "SeguimientoClass.php?random="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
		showDivLoading();
      },
	  success    : function(resp){		  
         setFormWithJSON(document.forms[0],resp,true);
	     removeDivLoading();
	  }
	});
	
	
}

function SeguimientoOnReset(){
	
	clearFind();
	resetContactos();
	$("#oficina_id").val($("#oficina_id_static").val());	
	$("#fecha_ingreso").val($("#fecha_ingreso_static").val());	
	$("#usuario_id").val($("#usuario_id_static").val());
	$("#estado").val('P');
	$("#estado_select").val('P');
    $("#remolque").val("0");		
	
	$('#guardar').attr("disabled","");
	$('#actualizar').attr("disabled","true");
	$('#imprimir').attr("disabled","true");
	$('#anular').attr("disabled","true");
	$('#limpiar').attr("disabled","");
	
}

function resetContactos(){

  $("#contacto_id option").each(function(){
    if(this.value != 'NULL') $(this).remove();
  });

}

function updateGrid(){
	$("#refresh_QUERYGRID_Seguimiento").click();
}

function setDataVehiculo(placa_id,placa){
		  
  if(parseInt(placa_id) > 0){
	  
	  var QueryString = "ACTIONCONTROLER=setDataVehiculo&placa_id="+placa_id;
	  
	  $.ajax({
	    url        : "SeguimientoClass.php?rand="+Math.random(),
		data       : QueryString,
		beforeSend : function(){
		  showDivLoading()
		},
		success    : function(resp){
            setFormWithJSON(document.forms[0],resp,true);
		    removeDivLoading();
		}
      });
	  	  
  }

}


function setDataCliente(cliente_id){
    
  var QueryString = "ACTIONCONTROLER=setDataCliente&cliente_id="+cliente_id;
  
  $.ajax({
    url        : "SeguimientoClass.php?rand="+Math.random(),
    data       : QueryString,
    beforeSend : function(){
      
    },
    success    : function(response){
      
      try{
	
		var responseArray       = $.parseJSON(response); 
		var cliente_tel        	= responseArray[0]['cliente_tel'];
		var direccion_cargue   	= responseArray[0]['direccion_cargue'];
		var cliente_nit    		= responseArray[0]['cliente_nit'];
		var cliente_movil 		= responseArray[0]['cliente_movil'];
		var cliente	    		= responseArray[0]['cliente'];	
		
		$("#cliente_tel").val(cliente_tel);
		$("#direccion_cargue").val(direccion_cargue);
		$("#cliente_nit").val(cliente_nit);
		$("#cliente").val(cliente);
		$("#cliente_movil").val(cliente_movil);	
		 setContactos(cliente_id);
	
      }catch(e){
	  	alertJquery(e);
      }
      
    }
    
  });
  
}


function setContactos(cliente_id){

	var cliente_id = cliente_id>0 ? cliente_id:$("#cliente_hidden").val();
	var QueryString = "ACTIONCONTROLER=setContactos&cliente_id="+cliente_id+'&seguimiento_id='+$("#seguimiento_id").val();
	
	$.ajax({
		url     : "SeguimientoClass.php",
		data    : QueryString,
		success : function(response){			
			$("#contacto_id").parent().html(response);
			selectedContactos();
		}
	});	
}

function selectedContactos(){
	
  var SeguimientoId = $("#seguimiento_id").val();
  var QueryString   = "ACTIONCONTROLER=selectedContactos&seguimiento_id="+SeguimientoId;
  
  $.ajax({
    url      : "SeguimientoClass.php",
	data     : QueryString,
	dataType : "json",
	success  : function(response){
		
      $("#contacto_id option").each(function(){
         $(this).removeAttr("selected");
      });

       if($.isArray(response)){
		   		   
         for(var i = 0; i < response.length; i++){
			 
			var contacto_id = response[i]['contacto_id'];
  
            $("#contacto_id option").each(function(){

               if(parseInt(this.value) == parseInt(contacto_id)){
				   
				 $(this).attr("selected","selected");
               }

            });
			 
		 }
  
		   
		   
	   }else{
		   //alertJquery(response);
		 }
   
    }

  });

	
	
}


function onclickCancellation(formulario){
	
	if($("#divAnulacion").is(":visible")){
	 
	   var desc_anul_seguimiento    = $("#desc_anul_seguimiento").val();
	   var anul_seguimiento   		= $("#anul_seguimiento").val();
	   
       if(ValidaRequeridos(formulario)){
	
	     var QueryString = "ACTIONCONTROLER=onclickCancellation&"+FormSerialize(formulario)+"&seguimiento_id="+$("#seguimiento_id").val();
		
	     $.ajax({
           url  : "SeguimientoClass.php",
	       data : QueryString,
	       beforeSend: function(){
			   showDivLoading();
	       },
	       success : function(response){
			              
		     if($.trim(response) == 'true'){
				 alertJquery('Orden de Seguimiento Anulada','Anulado Exitosamente');
				 updateGrid();
				 setDataFormWithResponse();
			 }else{
				   alertJquery(response,'Inconsistencia Anulando');
			   }
			   
			 removeDivLoading();
             $("#divAnulacion").dialog('close');
			 
	       }
	   
	     });
	   
	   }
	
    }else{
		
		 var seguimiento_id 	= $("#seguimiento_id").val();
		 var estado    			= $("#estado").val();
		 
		 if(parseInt(seguimiento_id) > 0){		
	

			 var QueryString = "ACTIONCONTROLER=ComprobarTrafico&seguimiento_id="+seguimiento_id;
			
			 $.ajax({
			   url  : "SeguimientoClass.php",
			   data : QueryString,
			   success : function(estado_trafico){


				if((estado == 'P' || estado == 'T') && (estado_trafico == 'A' || estado_trafico == '')){
				   
					$("#divAnulacion").dialog({
					  title: 'Anulacion Orden de Seguimiento',
					  width: 450,
					  height: 280,
					  closeOnEscape:true
					 });
				
				}else if((estado == 'P' || estado == 'T')  && estado_trafico != 'A' && estado_trafico != ''){
				  alertJquery('Por favor Anule el Trafico para Anular La Orden de Seguimiento','Anulacion');			   
				}else{  
				  alertJquery('Solo se permite anular orden de Seguimiento en estado : <b>PENDIENTE</b> o <b>TRANSITO</b>','Anulacion');			   
				}

			   }
		   
			 });

			 removeDivLoading();			 
			
		 }else{
			alertJquery('Debe Seleccionar primero una Orden de Seguimiento','Anulacion');
		 }		
		
	}  
	  
	
}


$(document).ready(function(){
						   
   $("#divAnulacion").css("display","none");						   
						   
   $("#guardar,#actualizar").click(function(){
											
	  var remolque = parseInt(document.getElementById('remolque').value);												
	  
	  if(remolque == 1){
				  
		var placa_remolque_id = document.getElementById('placa_remolque_hidden').value;	  
				  
		if(!placa_remolque_id > 0){
			alertJquery("Debe seleccionar un remolque para este tipo de vehiculo!!","Validacion Tipo de Vehiculo");
			return false;
		}
				  
	  }	 
	  
      if(this.name == 'guardar'){		  
         Send(this.form,'onclickSave',null,SeguimientoOnSave,false);		  		  
      }else{		  
		  Send(this.form,'onclickUpdate',null,SeguimientoOnUpdate,false);		  		  
		}											
											
   });						   
						   
});