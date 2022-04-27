// JavaScript Document
var map;
var points    = new Array();
var markRoute = new Array();

function setDataFormWithResponse(){
		
	var parametros  = new Array({campos:"trafico_id",valores:$('#trafico_id').val()});
	var forma       = document.forms[0];
	var controlador = 'RegistroNovedadesClass.php';
	
	FindRow(parametros,forma,controlador,null,function(resp){	   
    	
		    var data       = $.parseJSON(resp);
			var estado     = data[0]['estado'];
			var trafico_id = data[0]['trafico_id'];
									
			if(estado=='A' || estado=='F'){
			   if($('#actualizar')) $('#actualizar').attr("disabled","true");
			   if($('#saveDetallesSeguimiento'))  $('#saveDetallesSeguimiento').attr("style","display:none");	
			   if($('#deleteDetallesSeguimiento'))  $('#deleteDetallesSeguimiento').attr("style","display:none");	
			   if($('#cambio_ruta'))  $('#cambio_ruta').attr("style","display:none");				   
			   if($('#mensaje_alert'))  $('#mensaje_alert').attr("style","display:none");				   
			   var url  = "DetalleSeguimientoClass.php?trafico_id="+trafico_id+"&rand="+Math.random();
			   $("#detalleSeguimiento").attr("src",url); var url_2  = "DetalleRemesasDespachoClass.php?trafico_id="+trafico_id+"&rand="+Math.random(); $("#iframeDetalleRemesas").attr("src",url_2);
			   $("#estado").attr("disabled","true");
			   
			}else if(estado=='N' || estado=='P' || estado=='R'){
			   $("#estado").attr("disabled","");
			   $('#regresar_trafico').attr("disabled","true");
               if(estado=='N' || estado=='P'){
				   
				   if($('#saveDetallesSeguimiento'))  $('#saveDetallesSeguimiento').attr("style","display:none");	
				   if($('#deleteDetallesSeguimiento'))  $('#deleteDetallesSeguimiento').attr("style","display:none");	
				   if($('#actualizar')) $('#actualizar').attr("disabled","");
				   if($('#cambio_ruta'))  $('#cambio_ruta').attr("style","display:none");				   
				   if($('#mensaje_alert'))  $('#mensaje_alert').attr("style","display:inherit");				   
				   
				   alertJquery('<p align="center">Para proceder a realizar trafico, <br>debe diligenciar los datos del encabezado y hacer click en el boton <b>Trafico</b></p>','Trafico');
				   
				   
			   }else{
				   
				   if($('#saveDetallesSeguimiento'))  $('#saveDetallesSeguimiento').attr("style","display:none");	
				   if($('#deleteDetallesSeguimiento'))  $('#deleteDetallesSeguimiento').attr("style","display:none");	
				   if($('#actualizar')) $('#actualizar').attr("disabled","");
				   if($('#cambio_ruta'))  $('#cambio_ruta').attr("style","display:none");				   
				   if($('#mensaje_alert'))  $('#mensaje_alert').attr("style","display:inherit");				   
				   

			       var url  = "DetalleSeguimientoClass.php?trafico_id="+trafico_id+"&rand="+Math.random();			   
			       $("#detalleSeguimiento").attr("src",url); var url_2  = "DetalleRemesasDespachoClass.php?trafico_id="+trafico_id+"&rand="+Math.random(); $("#iframeDetalleRemesas").attr("src",url_2);
				   
				  }
               

			}else if(estado == 'T'){
				 $("#estado").attr("disabled","true");
				 $('#regresar_trafico').attr("disabled","true");
			   if($('#saveDetallesSeguimiento'))  $('#saveDetallesSeguimiento').attr("style","display:inherit");	
			   if($('#deleteDetallesSeguimiento'))  $('#deleteDetallesSeguimiento').attr("style","display:inherit");	
			   if($('#actualizar')) $('#actualizar').attr("disabled","true");
			   if($('#cambio_ruta'))  $('#cambio_ruta').attr("style","display:inherit");				   
			   if($('#mensaje_alert'))  $('#mensaje_alert').attr("style","display:none");				   
			   

			   var url  = "DetalleSeguimientoClass.php?trafico_id="+trafico_id+"&rand="+Math.random();			   
			  $("#detalleSeguimiento").attr("src",url); var url_2  = "DetalleRemesasDespachoClass.php?trafico_id="+trafico_id+"&rand="+Math.random(); $("#iframeDetalleRemesas").attr("src",url_2);

			}else{
				$("#estado").attr("disabled","true");
			   if($('#saveDetallesSeguimiento'))  $('#saveDetallesSeguimiento').attr("style","display:inherit");	
			   if($('#deleteDetallesSeguimiento'))  $('#deleteDetallesSeguimiento').attr("style","display:inherit");	
			   if($('#actualizar')) $('#actualizar').attr("disabled","");
			   if($('#cambio_ruta'))  $('#cambio_ruta').attr("style","display:inherit");				   
			   if($('#mensaje_alert'))  $('#mensaje_alert').attr("style","display:none");				   
			   

			   var url  = "DetalleSeguimientoClass.php?trafico_id="+trafico_id+"&rand="+Math.random();
			   $("#detalleSeguimiento").attr("src",url); 
			   var url_2  = "DetalleRemesasDespachoClass.php?trafico_id="+trafico_id+"&rand="+Math.random(); $("#iframeDetalleRemesas").attr("src",url_2);

			}
			
			if($('#limpiar'))    $('#limpiar').attr("disabled","");	
			
	        setRuta();			
	
	/*
	   var trafico_id =  $.trim($('#trafico_id').val());
       
	   setCoordinatesMapRoute(trafico_id);
	   setRuta();

		var QueryString = "ACTIONCONTROLER=setEstado&trafico_id="+trafico_id;
		
		$.ajax({
		url     : "RegistroNovedadesClass.php",
		data    : QueryString,
		success : function(estado){
			$("#estado").val(estado);
			if(estado=='A' || estado=='F' ){
			   if($('#actualizar')) $('#actualizar').attr("disabled","true");
			   if($('#saveDetallesSeguimiento'))  $('#saveDetallesSeguimiento').attr("style","display:none");	
			   if($('#deleteDetallesSeguimiento'))  $('#deleteDetallesSeguimiento').attr("style","display:none");	
			   if($('#cambio_ruta'))  $('#cambio_ruta').attr("style","display:none");				   
			   if($('#mensaje_alert'))  $('#mensaje_alert').attr("style","display:none");				   
			   var url  = "DetalleSeguimientoClass.php?trafico_id="+trafico_id+"&rand="+Math.random();
			   $("#detalleSeguimiento").attr("src",url);
			   
			}else if(estado=='N' || estado=='P'){

			   if($('#saveDetallesSeguimiento'))  $('#saveDetallesSeguimiento').attr("style","display:none");	
			   if($('#deleteDetallesSeguimiento'))  $('#deleteDetallesSeguimiento').attr("style","display:none");	
			   if($('#actualizar')) $('#actualizar').attr("disabled","");
			   if($('#cambio_ruta'))  $('#cambio_ruta').attr("style","display:none");				   
			   if($('#mensaje_alert'))  $('#mensaje_alert').attr("style","display:inherit");				   
			   
			   alertJquery('<p align="center">Para proceder a realizar trafico, <br>debe diligenciar los datos del encabezado y hacer click en el boton <b>Trafico</b></p>','Trafico');

			}else{
			   if($('#saveDetallesSeguimiento'))  $('#saveDetallesSeguimiento').attr("style","display:inherit");	
			   if($('#deleteDetallesSeguimiento'))  $('#deleteDetallesSeguimiento').attr("style","display:inherit");	
			   if($('#actualizar')) $('#actualizar').attr("disabled","");
			   if($('#cambio_ruta'))  $('#cambio_ruta').attr("style","display:inherit");				   
			   if($('#mensaje_alert'))  $('#mensaje_alert').attr("style","display:none");				   
			   

			   var url  = "DetalleSeguimientoClass.php?trafico_id="+trafico_id+"&rand="+Math.random();
			   $("#detalleSeguimiento").attr("src",url);

			}
			
			if($('#limpiar'))    $('#limpiar').attr("disabled","");		 
		}
		
		});

		var QueryString = "ACTIONCONTROLER=setPuntos&trafico_id="+trafico_id;
		
		$.ajax({
		url     : "RegistroNovedadesClass.php",
		data    : QueryString,
		success : function(puntos){
			if(parseInt(puntos)>0 ){
			   if($('#imprimir')) $('#imprimir').attr("disabled","");
			}else{
			   if($('#imprimir')) $('#imprimir').attr("disabled","true");
			
			}
		}
		
		});   */
	}); 
		
}

function beforePrint(formulario,url,title,width,height){

	var trafico_id = parseInt($("#trafico_id").val());
	
	if(isNaN(trafico_id)){
	  
	  alertJquery('Debe seleccionar un Trafico a imprimir !!!','Impresion Plan de Ruta');
	  return false;
	  
	}else{	  
	    return true;
	  }
	
}
function ComprobarPuntos(){
	ruta_id=$('#ruta_id').val();
	if(ruta_id!='NULL'){
		var QueryString = "ACTIONCONTROLER=ComprobarPuntos&ruta_id="+ruta_id;
		$.ajax({
		url     : "RegistroNovedadesClass.php",
		data    : QueryString,
		success : function(puntos){
			if(puntos==0){
			   alertJquery("Esta Ruta no tiene definido Puntos Virtuales o Fisicos<br>Las ubicaciones se deben ingresar manualmente");			
			}
			
		}
		
		});
	}

}
function getestado(){
	trafico_id=$('#trafico_id').val();

	var QueryString = "ACTIONCONTROLER=setEstado&trafico_id="+trafico_id;
	
	$.ajax({
	url     : "RegistroNovedadesClass.php",
	data    : QueryString,
	success : function(estado){
		$("#estado").val(estado);
		if(estado=='A' || estado=='F' ){
		   alertJquery("Trafico Finalizado Correctamente");			
		   if($('#actualizar')) $('#actualizar').attr("disabled","true");
		   if($('#saveDetallesSeguimiento'))  $('#saveDetallesSeguimiento').attr("style","display:none");	
		   if($('#deleteDetallesSeguimiento'))  $('#deleteDetallesSeguimiento').attr("style","display:none");	



		}else{
		   if($('#saveDetallesSeguimiento'))  $('#saveDetallesSeguimiento').attr("style","display:inherit");	
		   if($('#deleteDetallesSeguimiento'))  $('#deleteDetallesSeguimiento').attr("style","display:inherit");	
		   if($('#actualizar')) $('#actualizar').attr("disabled","");
		
		}
		
		if($('#limpiar'))    $('#limpiar').attr("disabled","");		 
	}
	
	});

}


function setCoordinatesMapRoute(trafico_id){
  points      = new Array();
  markRoute   = new Array();
  var trafico_id = parseInt(trafico_id);	
  
  if(isNumber(trafico_id)){
	  
	  var QueryString = "ACTIONCONTROLER=setDataMap&trafico_id="+trafico_id;
	  
	  $.ajax({
		url     : "RegistroNovedadesClass.php",
		data    : QueryString,
		success : function(response){
            markRoute = eval("("+ response + ")");
			try{
				//initialize();
				//$("#map_canvas").css("display","");
			}
			catch(e){
				//$("#map_canvas").css("display","none");
			}
			
        }
		
      });

	  
  }

}


function setRuta(){
	
  var trafico_id   = $("#trafico_id").val();
  var QueryString = "ACTIONCONTROLER=setRuta&trafico_id="+ $.trim(trafico_id);
  
  $.ajax({
    url     : "RegistroNovedadesClass.php",
	data    : QueryString,
	success : function(response){

      $("#ruta_id").parent().html(response);
   	  selectedRuta();
    }

  });
	
}

function selectedRuta(){
	
  var trafico_id = $("#trafico_id").val();
  var QueryString   = "ACTIONCONTROLER=selectedRutas&trafico_id="+trafico_id;
  
  $.ajax({
    url      : "RegistroNovedadesClass.php",
	data     : QueryString,
	dataType : "json",
	success  : function(response){
		
      $("#ruta_id option").each(function(){
         $(this).removeAttr("selected");
      });

       if($.isArray(response)){
		   		   
			 
			var ruta_id = response[0]['ruta_id'];
  
            $("#ruta_id option").each(function(){

               if(parseInt(this.value) == parseInt(ruta_id)){
				   
				 $(this).attr("selected","selected");
               }

            });
		   
	   }else{
		   
	   }
    }
  });
	
}



function RegistroNovedadesOnUpdate(formulario,resp){
  
      var estado     = $("#estado").val();
	  var trafico_id = $("#trafico_id").val();
	    
	  if($.trim(resp) == 'true'){
		  
		  if(estado == 'F'){
			  
             reloadGrid();
			 window.close();
			  
		  }else{
					
			if(estado=='A' || estado=='F' ){
			   if($('#actualizar')) $('#actualizar').attr("disabled","true");
			   if($('#saveDetallesSeguimiento'))  $('#saveDetallesSeguimiento').attr("style","display:none");	
			   if($('#deleteDetallesSeguimiento'))  $('#deleteDetallesSeguimiento').attr("style","display:none");	
			   if($('#cambio_ruta'))  $('#cambio_ruta').attr("style","display:none");				   
			   if($('#mensaje_alert'))  $('#mensaje_alert').attr("style","display:none");				   
			   
			}else if(estado=='N' || estado=='P' || estado=='R' ){

			   if($('#saveDetallesSeguimiento'))  $('#saveDetallesSeguimiento').css("display","");	
			   if($('#deleteDetallesSeguimiento'))  $('#deleteDetallesSeguimiento').css("display","");	
			   if($('#actualizar')) $('#actualizar').attr("disabled","tue");
			   if($('#cambio_ruta'))  $('#cambio_ruta').css("display","");				   
			   if($('#mensaje_alert'))  $('#mensaje_alert').attr("style","display:inherit");
			   
			   var url  = "DetalleSeguimientoClass.php?trafico_id="+trafico_id+"&rand="+Math.random();
			   $("#detalleSeguimiento").attr("src",url); var url_2  = "DetalleRemesasDespachoClass.php?trafico_id="+trafico_id+"&rand="+Math.random(); $("#iframeDetalleRemesas").attr("src",url_2);
			   

			}
			
			if($('#limpiar'))    $('#limpiar').attr("disabled","");	
								
			reloadGrid();				
					
					
				/*	
			  var trafico_id = $("#trafico_id").val();
	
			  var QueryString = "ACTIONCONTROLER=setEstado&trafico_id="+trafico_id;
			  
			  $.ajax({
				url     : "RegistroNovedadesClass.php",
				data    : QueryString,
				success : function(estado){
					$("#estado").val(estado);

					if(estado=='A' || estado=='F' ){
					   if($('#actualizar')) $('#actualizar').attr("disabled","true");
					   if($('#saveDetallesSeguimiento'))  $('#saveDetallesSeguimiento').attr("style","display:none");	
					   if($('#deleteDetallesSeguimiento'))  $('#deleteDetallesSeguimiento').attr("style","display:none");	
					   if($('#cambio_ruta'))  $('#cambio_ruta').attr("style","display:none");				   
					   if($('#mensaje_alert'))  $('#mensaje_alert').attr("style","display:none");				   
					   
					}else if(estado=='N' || estado=='P' || estado=='R' ){
		
					   if($('#saveDetallesSeguimiento'))  $('#saveDetallesSeguimiento').attr("style","display:none");	
					   if($('#deleteDetallesSeguimiento'))  $('#deleteDetallesSeguimiento').attr("style","display:none");	
					   if($('#actualizar')) $('#actualizar').attr("disabled","");
					   if($('#cambio_ruta'))  $('#cambio_ruta').attr("style","display:none");				   
					   if($('#mensaje_alert'))  $('#mensaje_alert').attr("style","display:inherit");				   
					   
		
					}else{
					   if($('#saveDetallesSeguimiento'))  $('#saveDetallesSeguimiento').attr("style","display:inherit");	
					   if($('#deleteDetallesSeguimiento'))  $('#deleteDetallesSeguimiento').attr("style","display:inherit");	
					   if($('#actualizar')) $('#actualizar').attr("disabled","");
					   if($('#cambio_ruta'))  $('#cambio_ruta').attr("style","display:inherit");				   
					   if($('#mensaje_alert'))  $('#mensaje_alert').attr("style","display:none");				   
		
					   var url  = "DetalleSeguimientoClass.php?trafico_id="+trafico_id+"&rand="+Math.random();
					   $("#detalleSeguimiento").attr("src",url);
		
					}
					
					if($('#limpiar'))    $('#limpiar').attr("disabled","");	
										
					window.opener.reloadGrid();
				}
				
			  });
				
				var QueryString = "ACTIONCONTROLER=setPuntos&trafico_id="+trafico_id;
				
				$.ajax({
				url     : "RegistroNovedadesClass.php",
				data    : QueryString,
				success : function(puntos){
					if(parseInt(puntos)>0 ){
					   if($('#imprimir')) $('#imprimir').attr("disabled","");
					}else{
					   if($('#imprimir')) $('#imprimir').attr("disabled","true");
					
					}
				}
				
				});
				setCoordinatesMapRoute(trafico_id);
				
				
				*/
				
				if(estado == 'P' || estado == 'R'){
					
				   document.getElementById('estado').value       = 'T';	
				   document.getElementById('estadohidden').value = 'T';	
					
			    }
	
			 }
			 
			var msj1 = '';
						
		    msj1 = "<div align='center'><b>Desea reportar el Seguimiento a Webservice Faro?</br></div>";
				   
			jConfirm(msj1, "Trafico",  
			function(r) {  
																						   
			  if(r) {  

				  var QueryString   = "ACTIONCONTROLER=set_webservice&trafico_id="+trafico_id;
				  
				  $.ajax({
					url      : "RegistroNovedadesClass.php?rand="+Math.random(),
					data     : QueryString,
					beforeSend : function(){
					   showDivLoading();
					},
					success  : function(response){
					   removeDivLoading();	
					   if(response!=''){
							alertJquery(response,"Webservice Faro");								   
					   }
					}
				  });
					   
			  }   
			 }); 
		

		  
      }else{
         alertJquery(resp);
	  }

}



function RegistroNovedadesOnReset(){
	
  resetContactos();
  $("#detalleSeguimiento").attr("src","/roa/framework/tpl/blank.html");
  
  $('#actualizar').attr("disabled","true");
  $('#limpiar').attr("disabled","true");  
  //initialize();
}

function resetContactos(){

  $("#ruta_id option").each(function(){
    if(this.value != 'NULL') $(this).remove();
  });

}

function cambio_puntos(trafico_id){
	if(parseInt(trafico_id)>0){

		$("#iframeCambioRuta").attr("src","CambioClass.php?trafico_id="+trafico_id+"&rand="+Math.random());
		$("#divCambioRuta").dialog({
			title: 'Adicionar Puntos a Ruta',
			width: 1100,
			height: 450,
			closeOnEscape:true,
			show: 'scale',
			hide: 'scale'
		});
							
	}else{
		alertJquery("Por Favor Seleccione un Seguimiento","Trafico");			   
	}
	
}

function closeDialogCambios(){
	$("#divCambioRuta").dialog('close');
	var trafico_id  = $('#trafico_id').val();
	var url         = "DetalleSeguimientoClass.php?trafico_id="+trafico_id+"&rand="+Math.random();
	$("#detalleSeguimiento").attr("src",url);
	getestado();
	
}

function cargardivedit(detalle_seg_id){
	var trafico_id  = $('#trafico_id').val();

	if(parseInt(trafico_id)>0){

		$("#iframeSolicitudEdit").attr("src","SolicEditClass.php?trafico_id="+trafico_id+"&detalle_seg_id="+detalle_seg_id+"&rand="+Math.random());
		$("#divSolicitudRemesasEdit").dialog({
			title: 'Remesas Manifiesto',
			width: 950,
			height: 395,
			closeOnEscape:true,
			show: 'scale',
			hide: 'scale'
		});
							
	}else{
		alertJquery("Por Favor Seleccione un Seguimiento","Trafico");			   
	}
}

function closeDialogedit(){
	$("#divSolicitudRemesasEdit").dialog('close');
	var trafico_id  = $('#trafico_id').val();
	var url         = "DetalleSeguimientoClass.php?trafico_id="+trafico_id+"&rand="+Math.random();
	$("#detalleSeguimiento").attr("src",url);
	getestado();
	
}

function onclickMoveToUrban(formulario){

   var QueryString = "ACTIONCONTROLER=onclickMoveToUrban&"+$(formulario).serialize();
   
   $.ajax({
		  
	 url        : "RegistroNovedadesClass.php?rand="+Math.random(),	  
	 data       : QueryString,
	 beforeSend : function(){
		showDivLoading();
	 },
	 success    : function(resp){
		 
		 removeDivLoading();
		 
		 if($.trim(resp) == 'true'){			 
           reloadGrid();
		   window.close();			 
		 }else{
			 alertJquery(resp,'Inconsistencia');
		   }
		 
	 }
	 
   });


}
function onclickRegresarTrafico(formulario){

   var QueryString = "ACTIONCONTROLER=onclickRegresarTrafico&"+$(formulario).serialize();
   
   $.ajax({
		  
	 url        : "RegistroNovedadesClass.php?rand="+Math.random(),	  
	 data       : QueryString,
	 beforeSend : function(){
		showDivLoading();
	 },
	 success    : function(resp){
		 
		 removeDivLoading();
		  
		 if($.trim(resp) == 'true'){			 
           reloadGrid();
		   window.close();			 
		 }else{
			 alertJquery(resp,'Inconsistencia');
		   }
	 }
	 
   });


}


function onclickCancellation(formulario){
	
	if($("#divAnulacion").is(":visible")){

	   var causal_anulacion_id 			= $("#causal_anulacion_id").val();
	   var desc_anul_trafico  			= $("#desc_anul_trafico").val();
	   var anul_trafico   				= $("#anul_trafico").val();
	   
       if(ValidaRequeridos(formulario)){
	
	     var QueryString = "ACTIONCONTROLER=onclickCancellation&"+FormSerialize(formulario)+"&trafico_id="+$("#trafico_id").val();
		
	     $.ajax({
           url  : "RegistroNovedadesClass.php",
	       data : QueryString,
	       beforeSend: function(){
			   showDivLoading();
	       },
	       success : function(response){
			              
		     if($.trim(response) == 'true'){
				 alertJquery('Trafico Anulada','Anulado Exitosamente');
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
		
	 var trafico_id 		= $("#trafico_id").val();
	 var estado   = $("#estado").val();
	 
	 if(parseInt(trafico_id) > 0){		

	 var QueryString = "ACTIONCONTROLER=getEstadoEncabezadoRegistro&trafico_id="+trafico_id;
	 
	 $.ajax({
       url        : "RegistroNovedadesClass.php",
	   data       : QueryString,
	   beforeSend : function(){
		 showDivLoading();
	   },
	   success : function(response){
		   	   
		   var estado = response;
		   
		   if($.trim(estado) == 'P' || $.trim(estado) == 'R' || $.trim(estado) == 'T' || $.trim(estado) == 'N'){
			   
		    $("#divAnulacion").dialog({
			  title: 'Anulacion Trafico',
			  width: 450,
			  height: 280,
			  closeOnEscape:true
             });
			
		   }else{
		      alertJquery('Solo se permite anular Trafico en estado : <b>EN TRANSITO/PENDIENTE DE RUTA/CON RUTA/NOCTURNO</b>','Anulacion');			   
		   }  
			 
	     removeDivLoading();			 
	     }
		 
	 });
	 
		
	 }else{
		alertJquery('Debe Seleccionar primero un Trafico','Anulacion');
	  }		
		
	}  
}


//eventos asignados a los objetos
$(document).ready(function(){
						   
  $("#nota_controlador").click(function(){
	if ($("#numero").val()!="") {
		$("#guardar_nota").attr("disabled","");
	}else if ($("#numero").val()=="") {
		$("#guardar_nota").attr("disabled","true");
	}
   });
		

  $("#actualizar").click(function(){

     var obj         = this;
     var formulario  = this.form;								  
     var QueryString = "ACTIONCONTROLER=onclickUpdate&"+FormSerialize(formulario);								  
	 
	 if(ValidaRequeridos(formulario)){
	 	 
	 $.ajax({
       url        : "RegistroNovedadesClass.php?rand="+Math.random(),
	   data       : QueryString,
	   beforeSend : function(){
		   obj.disabled = true;
		   showDivLoading();
	   },
	   success    : function(resp){
		   		   
		   if($.trim(resp) == 'true'){
			  obj.disabled = true; 
		   }
		   		   
		   removeDivLoading();
		   RegistroNovedadesOnUpdate(formulario,resp);
       }
	   
     });
	 
    }
								  
  });						   
    
	$("#guardar_nota").click(function(){
	var obj 				= this;
	var nota_controlador	= $("#nota_controlador").val();
	var trafico_id			= $("#trafico_id").val();
	if(nota_controlador!=""){
		// alertJquery(nota_controlador,"Hola mundo");
		var QueryString = "ACTIONCONTROLER=onclickUpdateNota"+"&nota_controlador="+nota_controlador+"&trafico_id="+trafico_id;
		$.ajax({
			url        : "RegistroNovedadesClass.php?rand="+Math.random(),
			data       : QueryString,
			beforeSend : function(){
				showDivLoading();
			},
			success    : function(resp){
				if (resp=='true') {
					alertJquery("Notas actualizadas correctamente.","Guardado");
				}else{
					alertJquery("Ocurrio una inconsistencia, porfavor comuniqueselo al area de soporte.","Error");
				}
				removeDivLoading();
			}
		});
	}else{
		alertJquery("Debe ingresar datos en el campo de notas de controlador.","Validación");
	}
});
	
  $("#detalleRuta").attr("src","/roa/framework/tpl/blank.html");
  
  $("#saveDetallesSeguimiento").click(function(){
										
    window.frames[1].saveDetallesSeguimiento();
	
  });
  
  
  $("#deleteDetallesSeguimiento").click(function(){
										
    window.frames[1].deleteDetallesSeguimiento();
	
  });
  
  /*$("#renderMap").click(function(){
    setCoordinatesMapRoute($("#trafico_id").val());
  });*/

  $("#cambio_ruta").click(function(){
    cambio_puntos($("#trafico_id").val());
  });

  $( function (){
       
      $("#seleccionar").click( function (){
         $('#ruta_id option:selected').clone().appendTo("#ruta_seleccionada_id");
         $('#ruta_id option:selected').remove();
      });
					  
      $("#deseleccionar").click( function (){
        $('#ruta_seleccionada_id option:selected').clone().appendTo("#ruta_id");
        $('#ruta_seleccionada_id option:selected').remove();
      });					  
                     
   });
  
  
  
  $("#importRoute").click(function(){

    $("#divRutas").dialog({
		width: 450, 
		height: 200,
		closeOnEscape:true,
		show: 'scale',
		hide: 'scale'
	});


  });
  
  
  var trafico_id = $("#trafico_id").val();
  
  if(trafico_id.length > 0){
     setDataFormWithResponse();
  }
  
  
  $("#estado").change(function(){
						
      var estado        = this.value;						
      var estadoTrafico = $("#estadohidden").val();
	  
	  if(estado != 'F' && estado != estadoTrafico){
	  
	    document.getElementById('estado').value = estadoTrafico;
	    
	  }
	  
	  
	  if(estado == 'F'){
		$("#actualizar").attr("disabled","");
	  }else{
		  
		  if(estadoTrafico != 'P' && estadoTrafico != 'R'){
			 $("#actualizar").attr("disabled","true");
		  } 
		  
	    }
							   
  });
  
  
});
  
  

/**
* se construye el mapa con sus 
* respectivas opciones
*/

/*
function initialize() {
	
try{
	  
  if(markRoute){
    var myLatlng = new google.maps.LatLng(markRoute[0].lat,markRoute[0].lon);
      var myOptions = {
        zoom: 8,
        center: myLatlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
      }
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
  
  
    for(var i = 0; i < markRoute.length; i++){
	  points[i] = addMarkerPlace(markRoute[i].lat,markRoute[i].lon,markRoute[i].nom);
    }
  
  
    var rutaView = new google.maps.Polyline({
  	  map:map,
	  path: points,
	  strokeColor: "#FF0000",
	  strokeOpacity: 1.0,
	  strokeWeight: 2
    });
  }
  
}catch(e){
	//alertJquery('Error google');
  }
  
}

/**
* se agregan las marcas en el mapa
* luego de que se carga la informacion
* de la ubicacion en el formulario

function addMarkerPlace(lat,lon,nom){
	
	marker = new google.maps.Marker({
        position: new google.maps.LatLng(lat,lon), 
        map: map,
        title:nom
    });
	return marker.position;
}

*/



function reloadGrid(){
	window.opener.reloadGrid();
}