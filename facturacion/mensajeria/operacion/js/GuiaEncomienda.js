// JavaScript Document
var SolicitudId;
$(document).ready(function(){	
	// document.getElementById('forma_pago_mensajeria_id').value='1';
	
    // $("#aplica_descuento").click(function(){
	// 	calcula_descuento();										  
    // });	

   	$("#cantidad").val(1);
	$("#divAnulacion").css("display","none");	
    /**
    * cargamos el grid con las solicitudes de servicio
    */
    $("#iframeSolicitudGuia").attr("src","SolicServToGuiaPaqueteoClass.php");	    
    $("#importSolcitud").click(function(){		
        var formulario = document.getElementById('GuiaForm');		
        Reset(formulario);	
        GuiaOnReset();				
	    $("#divSolicitudGuia").dialog({
		    title: 'Solicitud de Servicio para Enviar',
		    width: 950,
		    height: 400,
		    closeOnEscape:true,
		    show: 'scale',
		    hide: 'scale'
	    });
    });	
	
	$("#tipo_servicio_mensajeria_id").change(function(){
		getOptionsTipoEnvio();
	});	
	
	$("#forma_pago_mensajeria_id").change(function(){
		getPrefijo(this.value);
	});	
	
    $("a[name=saveDetalleGuia]").click(function(){
      addRowProduct(this);
    });		
    $("#print_out").click(function(){
       printOut();								   
    });	
    $("#print_cancel").click(function(){
       printCancel();									  
    });	
    $("#saveDetallesGuia").click(function(){
      window.frames[1].saveDetallesGuia();
    });    
    $("#deleteDetallesGuia").click(function(){
	window.frames[1].deleteDetallesGuia();
    });	
   $("a[name=saveDetalleGuia]").focus(function(){    
       $(this).parent().addClass("focusSaveRow");
    });	
   $("a[name=saveDetalleGuia]").blur(function(){
       $(this).parent().removeClass("focusSaveRow");
   });	   
   $("#guardar,#actualizar").click(function(){
	  var formulario = this.form;	  
	  if(validaDestinoTipoServicio() && validaPesoTipoServicio(15,'peso_volumen') && validaPesoTipoServicio(15000,'peso') && ValidaRequeridos(formulario)){ 	  

		recalculaValor();
	    if(this.id == 'guardar'){ 
			$('#guardar').attr("disabled","true");	
			var QueryString = "ACTIONCONTROLER=onclickSave&"+FormSerialize(formulario);
			$.ajax({
			  url        : "GuiaEncomiendaClass.php?rand="+Math.random(),
			  data       : QueryString,
			  beforeSend : function(){
				showDivLoading();
			  },
			  success    : function(resp){				   
				  updateGridGuia();
				  removeDivLoading();
				  GuiaOnSave(formulario,resp);					  
			  }
			});				
		}else{
				var QueryString = "ACTIONCONTROLER=onclickUpdate&"+FormSerialize(formulario);
				$.ajax({
				  url        : "GuiaEncomiendaClass.php?rand="+Math.random(),
				  data       : QueryString,
				  beforeSend : function(){
					showDivLoading();
				  },
				  success    : function(resp){
					  updateGridGuia();
					  removeDivLoading();
					  GuiaOnUpdate(formulario,resp);						  
				  }
			   });
			    
		    }
	   }							
   });

	$("#tipo_servicio_mensajeria_id").change(function(){	  
	  if(this.value != ''){
		   recalculaValor();
	  }
	 });	

	$("#tipo_envio_id").change(function(){	  
	  if(this.value != ''){
		   recalculaValor();
	  }
	 });

	$("#doc_remitente").blur(function(){	  
	   validar_remitente();
	 });
	$("#doc_destinatario").blur(function(){	  
	   validar_destinatario();
	 });

	$("#origen").blur(function(){	  
	   recalculaValor();
	 });

	$("#peso").blur(function(){	  
		if(validaPesoTipoServicio(15000,'peso')) recalculaValor();
	 });

	$("#destino").blur(function(){	  
		 var obj = this.value;
		setTimeout(function() {
			if(obj!=''){
				if( validaDestinoTipoServicio()) recalculaValor();
			}
		}, 1000);
	 });

	$("#destino_hidden").change(function(){	  
	   recalculaValor();
	 });
	
	$("#valor_otros").blur(function(){	  
	   recalculaValor();
	 });

	$("#valor").blur(function(){	  
	   recalculaValor();
	 });

	$("#valor_flete").blur(function(){	  
	   recalculaValor();
	 });

	$("#largo").blur(function(){	 
	   recalculaValorvol();
	 });

	$("#ancho").blur(function(){	  
	   recalculaValorvol();
	 });

	$("#alto").blur(function(){	  
	   recalculaValorvol();
	 });

    setRangoDesdeHasta();       
    setValorLiquidacion();	

	//para chequear si es una oficina de cliente
	var QueryString = "ACTIONCONTROLER=chequear";

	$.ajax({
	  url        : "GuiaEncomiendaClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
		showDivLoading();
	  },
	  success    : function(resp){
		  if(resp=='false'){

			if($('#origen'))    						  $('#origen').attr("disabled","");			  			
			if($('#tipo_identificacion_remitente_id'))    $('#tipo_identificacion_remitente_id').attr("disabled","");					  						
			if($('#remitente'))    						  $('#remitente').attr("disabled","");				  									
			if($('#doc_remitente'))   					  $('#doc_remitente').attr("disabled","");				
			if($('#direccion_remitente'))  				  $('#direccion_remitente').attr("disabled","");		
			if($('#telefono_remitente'))   				  $('#telefono_remitente').attr("disabled","");					
			if($('#correo_remitente')) 					  $('#correo_remitente').attr("disabled","");
		  }else{
		  	var data         = $.parseJSON(resp);  
			if(parseInt(data[0]['cliente_id'])>0){			
				if($('#origen_hidden'))                       $('#origen_hidden').val(data[0]['origen_id']);
				//if($('#cliente_id'))    $('#cliente_id').val(data[0]['cliente_id']);
				if($('#origen'))    						  $('#origen').val(data[0]['origen']);			  			
				if($('#tipo_identificacion_remitente_id'))    $('#tipo_identificacion_remitente_id').val(data[0]['tipo_identificacion_remitente_id']);			  						
				if($('#remitente'))    						  $('#remitente').val(data[0]['remitente']);			  									
				if($('#doc_remitente'))   					  $('#doc_remitente').val(data[0]['doc_remitente']);		
				if($('#direccion_remitente')) 			      $('#direccion_remitente').val(data[0]['direccion_remitente']);	
				if($('#telefono_remitente'))   				  $('#telefono_remitente').val(data[0]['telefono_remitente']);	
				if($('#correo_remitente')) 					  $('#correo_remitente').val(data[0]['correo_remitente']);
	
				if($('#origen'))   							  $('#origen').attr("disabled","true");			  			
				if($('#tipo_identificacion_remitente_id'))    $('#tipo_identificacion_remitente_id').attr("disabled","true");					  						
				if($('#remitente'))    						  $('#remitente').attr("disabled","true");				  									
				if($('#doc_remitente'))  					  $('#doc_remitente').attr("disabled","true");				
				if($('#direccion_remitente'))   			  $('#direccion_remitente').attr("disabled","true");		
				if($('#telefono_remitente'))   				  $('#telefono_remitente').attr("disabled","true");					
				if($('#correo_remitente')) 					  $('#correo_remitente').attr("disabled","true");
			}else{
				if($('#origen'))    					  	  $('#origen').attr("disabled","");			  			
				if($('#tipo_identificacion_remitente_id'))    $('#tipo_identificacion_remitente_id').attr("disabled","");					  						
				if($('#remitente'))    						  $('#remitente').attr("disabled","");				  									
				if($('#doc_remitente'))    					  $('#doc_remitente').attr("disabled","");				
				if($('#direccion_remitente'))  				  $('#direccion_remitente').attr("disabled","");		
				if($('#telefono_remitente'))   				  $('#telefono_remitente').attr("disabled","");					
				if($('#correo_remitente')) 					  $('#correo_remitente').attr("disabled","");
			}
			
		  }
		   removeDivLoading(); 
		  
	  }
   });
	//para chequear si es una oficina de cliente fin

});


function validaDestinoTipoServicio(){
	
	var TipoServicioId   = $("#tipo_servicio_mensajeria_id").val();
	var destino_id       = $("#destino_hidden").val();
	
	console.log('TipoServicioId:', TipoServicioId);
	console.log('destino_id:', destino_id);
	
	if(destino_id != 73001000 && TipoServicioId == '7'){ //Valida TERMINAL A DOMICILIO
		
		alertJquery("El tipo de servicio <b>TERMINAL A DOMICILIO</b>, solo permite destino IBAGUE -TOLIMA","validacion");
		
		$("#destino").css("boxShadow", "0 0 5px 1px red").focus().val('');
		$("#destino_hidden").val('');
		
		return false;
		
	}else{
		
		$("#destino").css("boxShadow", "none");
		
		return true;
		
	}
	
}

function validaPesoTipoServicio(peso,campo){
	
	var TipoServicioId   = $("#tipo_servicio_mensajeria_id").val();
	var valor_campo      = $("#"+campo).val();
	
	console.log('TipoServicioId:', TipoServicioId);
	console.log('peso:', peso);
	console.log('campo:', campo);
	console.log('valor_campo:', valor_campo);
	
	if(valor_campo > peso && TipoServicioId == '7'){ //Valida TERMINAL A DOMICILIO
		
		alertJquery("El tipo de servicio <b>TERMINAL A DOMICILIO</b>, solo permite un peso maximo de 15 kg (15.000 gramos)","validacion");
		
		$("#"+campo).css("boxShadow", "0 0 5px 1px red").focus().val('');
		
		return false;
		
	}else{
		
		$("#"+campo).css("boxShadow", "none");
		
		return true;
		
	}
	
}

function getPrefijo(forma_pago_mensajeria_id){
	
	var QueryString = "ACTIONCONTROLER=getPrefijo&forma_pago_mensajeria_id="+forma_pago_mensajeria_id;	
	
	$.ajax({
	  url        : "GuiaEncomiendaClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
		  showDivLoading();
	  },
	  success    : function(resp){	 		 
		  try{	
			  		 
			  var prefijo = resp;		
					 
			  $("#prefijo").val(prefijo);				 				 
			 	 
		  }catch(e){
			 
			 alertJquery(e,"Error");
			  
		 }		 
		  removeDivLoading();
	   }	
	});
	
}

// function calcula_descuento(){

// 	if(document.getElementById('aplica_descuento').checked==true){    
// 		$('#valor_descuento').attr("disabled","");	
// 		if(removeFormatCurrency($('#valor_total').val())>0){
// 			var valor_flete = removeFormatCurrency($('#valor_flete').val());
// 			var valor_seguro = removeFormatCurrency($('#valor_seguro').val());
// 			var descuento =  parseInt(((parseInt(valor_flete))*10)/100);
// 			var valor_otros = removeFormatCurrency($('#valor_otros').val());		

// 			valor_flete = parseInt(valor_flete)>0 ? valor_flete : 0;
// 			valor_seguro = parseInt(valor_seguro)>0 ? valor_seguro : 0;
// 			valor_otros = parseInt(valor_otros)>0 ? valor_otros : 0;

// 			var valor_total = parseInt((parseInt(valor_flete)+parseInt(valor_seguro)+parseInt(valor_otros))-parseInt(descuento));
// 			$('#valor_descuento').val(setFormatCurrency(descuento));				
// 			$('#valor_total').val(setFormatCurrency(valor_total));
			
// 		}else{
// 			$('#valor_descuento').attr("disabled","true");		
// 			$('#valor_descuento').val('');			
// 			document.getElementById('aplica_descuento').checked=false;
// 			alertJquery('Previamente debe tener una tarifa Calculada','Validacion Descuento');

// 			var valor_flete = removeFormatCurrency($('#valor_flete').val());
// 			var valor_seguro = removeFormatCurrency($('#valor_seguro').val());
// 			var valor_otros = removeFormatCurrency($('#valor_otros').val());
// 			valor_flete = parseInt(valor_flete)>0 ? valor_flete : 0;
// 			valor_seguro = parseInt(valor_seguro)>0 ? valor_seguro : 0;
// 			valor_otros = parseInt(valor_otros)>0 ? valor_otros : 0;
			
// 			var valor_total = parseInt((parseInt(valor_flete)+parseInt(valor_seguro)+parseInt(valor_otros)));
// 			$('#valor_total').val(setFormatCurrency(valor_total));
			
// 		}
		
// 	}else{
// 		$('#valor_descuento').attr("disabled","true");		
// 		$('#valor_descuento').val('');	
// 		var valor_flete = removeFormatCurrency($('#valor_flete').val());
// 		var valor_seguro = removeFormatCurrency($('#valor_seguro').val());
// 		var valor_otros = removeFormatCurrency($('#valor_otros').val());
// 		valor_flete = parseInt(valor_flete)>0 ? valor_flete : 0;
// 		valor_seguro = parseInt(valor_seguro)>0 ? valor_seguro : 0;
// 		valor_otros = parseInt(valor_otros)>0 ? valor_otros : 0;
// 		var valor_total = parseInt((parseInt(valor_flete)+parseInt(valor_seguro)+parseInt(valor_otros)));
// 		$('#valor_total').val(setFormatCurrency(valor_total));
		
// 	}

// }
function validar_remitente(){
	var doc_remitente=  $("#doc_remitente").val();
	if(doc_remitente!=''){
	   var QueryString = "ACTIONCONTROLER=getDataRemitenteDestinatarioDoc&doc_remitente="+doc_remitente;	
	   $.ajax({
		 url        : "GuiaEncomiendaClass.php?rand="+Math.random(),
		 data       : QueryString,
		 beforeSend : function(){
			 showDivLoading();
		 },
		 success    : function(resp){	 		 
			 try{			 
				 var dataResp = $.parseJSON(resp);			
				document.getElementById('origen').value= document.getElementById('origencopia').value;
				document.getElementById('origen_hidden').value= document.getElementById('origencopia_id').value;	
				 
				 //$("#origen").val(dataResp[0]['ubicacion']);
				 //$("#origen_hidden").val(dataResp[0]['ubicacion_id']);			 
				 $("#remitente").val(dataResp[0]['remitente_destinatario']);
				 $("#remitente_hidden").val(dataResp[0]['remitente_destinatario_id']);				 
				 $("#doc_remitente").val(dataResp[0]['numero_identificacion']);				 				 
				 if($("#direccion_remitente").val()=='') $("#direccion_remitente").val(dataResp[0]['direccion']);	 			 				 				 
				 if($("#telefono_remitente").val()=='') $("#telefono_remitente").val(dataResp[0]['telefono']);	 
				 if($('#correo_remitente').val()='') 	 $('#correo_remitente').val(dataResp[0]['correo_remitente']);
				}catch(e){
				 //alertJquery(resp,"Error :"+e);
				 $("#remitente_id").val('');				 
				 
			}		 
			 removeDivLoading();
		  }	
	   });
	}
}
function validar_destinatario(){
	var doc_destinatario=  $("#doc_destinatario").val();
	if(doc_destinatario!=''){
		
		var QueryString = "ACTIONCONTROLER=getDataRemitenteDestinatarioDoc&doc_remitente="+doc_destinatario;	
	   $.ajax({
		 url        : "GuiaEncomiendaClass.php?rand="+Math.random(),
		 data       : QueryString,
		 beforeSend : function(){
			 showDivLoading();
		 },
		 success    : function(resp){	 		 
			 try{			 
				 var dataResp = $.parseJSON(resp);		
				 $("#destino").val(dataResp[0]['ubicacion']);
				 $("#destino_hidden").val(dataResp[0]['ubicacion_id']);			 
				 $("#destinatario").val(dataResp[0]['remitente_destinatario']);
				 $("#destinatario_hidden").val(dataResp[0]['remitente_destinatario_id']);				 
				 $("#doc_destinatario").val(dataResp[0]['numero_identificacion']);				 				 
				 if($("#direccion_destinatario").val()=='') $("#direccion_destinatario").val(dataResp[0]['direccion']);				 				 				 
				 if($("#telefono_destinatario").val()=='') $("#telefono_destinatario").val(dataResp[0]['telefono']);	 
				 if($('#correo_destinatario').val()='') 	      $('#correo_destinatario').val(dataResp[0]['correo_destinatario']);
				}catch(e){
				 $("#destinatario_id").val('');				 
				   //alertJquery(resp,"Error :"+e);
			}		 
			 removeDivLoading();
		  }	
	   });
	}
}


function chequear(){

	//para chequear si es una oficina de cliente
	var QueryString = "ACTIONCONTROLER=chequear";

	$.ajax({
	  url        : "GuiaEncomiendaClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
		showDivLoading();
	  },
	  success    : function(resp){
		  if(resp=='false'){

			if($('#origen'))              				  $('#origen').attr("disabled","");			  			
			if($('#tipo_identificacion_remitente_id'))    $('#tipo_identificacion_remitente_id').attr("disabled","");					  						
			if($('#remitente'))    						  $('#remitente').attr("disabled","");				  									
			if($('#doc_remitente'))    					  $('#doc_remitente').attr("disabled","");				
			if($('#direccion_remitente'))  				  $('#direccion_remitente').attr("disabled","");		
			if($('#telefono_remitente'))   			      $('#telefono_remitente').attr("disabled","");					
			if($('#correo_remitente'))                    $('#correo_remitente').attr("disabled","");
		  
		  }else{
		  	var data         = $.parseJSON(resp);  
			if(parseInt(data[0]['cliente_id'])>0){			
				if($('#origen_hidden'))  				 	  $('#origen_hidden').val(data[0]['origen_id']);
				if($('#cliente_id'))    				 	  $('#cliente_id').val(data[0]['cliente_id']);
				if($('#origen'))   						 	  $('#origen').val(data[0]['origen']);			  			
				if($('#tipo_identificacion_remitente_id'))    $('#tipo_identificacion_remitente_id').val(data[0]['tipo_identificacion_remitente_id']);			  						
				if($('#remitente'))    						  $('#remitente').val(data[0]['remitente']);			  									
				if($('#doc_remitente'))        	              $('#doc_remitente').val(data[0]['doc_remitente']);		
				if($('#direccion_remitente'))                 $('#direccion_remitente').val(data[0]['direccion_remitente']);	
				if($('#telefono_remitente'))                  $('#telefono_remitente').val(data[0]['telefono_remitente']);	
				if($('#correo_remitente')) 	                  $('#correo_remitente').val(data[0]['correo_remitente']);
	
				if($('#origen'))    						  $('#origen').attr("disabled","true");			  			
				if($('#tipo_identificacion_remitente_id'))    $('#tipo_identificacion_remitente_id').attr("disabled","true");					  						
				if($('#remitente'))                           $('#remitente').attr("disabled","true");				  									
				if($('#doc_remitente'))                       $('#doc_remitente').attr("disabled","true");				
				if($('#direccion_remitente'))                 $('#direccion_remitente').attr("disabled","true");		
				if($('#telefono_remitente'))                  $('#telefono_remitente').attr("disabled","true");					
				if($('#correo_remitente'))                    $('#correo_remitente').attr("disabled","true");

			}else{
				if($('#origen'))                              $('#origen').attr("disabled","");			  			
				if($('#tipo_identificacion_remitente_id'))    $('#tipo_identificacion_remitente_id').attr("disabled","");					  						
				if($('#remitente'))                           $('#remitente').attr("disabled","");				  									
				if($('#doc_remitente'))                       $('#doc_remitente').attr("disabled","");				
				if($('#direccion_remitente'))                 $('#direccion_remitente').attr("disabled","");		
				if($('#telefono_remitente'))                  $('#telefono_remitente').attr("disabled","");					
				if($('#correo_remitente'))                    $('#correo_remitente').attr("disabled","");

			}
			
		  }
		   removeDivLoading(); 
		  
	  }
   });
	//para chequear si es una oficina de cliente fin
}

function closeDialog(){
	$("#divSolicitudGuia").dialog('close');
}
//funcion para cargar los datos desde BUSCAR
function setDataFormWithResponse(guia_encomienda_id){	
	var forma 		= document.forms[0];	
	var QueryString = "ACTIONCONTROLER=onclickFind&guia_encomienda_id="+guia_encomienda_id;	
	$.ajax({
	  url        : "GuiaEncomiendaClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
		  showDivLoading();
	  },
	  success    : function(resp){		  
        try{			
			
		  var data         = $.parseJSON(resp);
		  
		  var guia_encomienda         = data[0]['guia_encomienda'];
		  var clase_guia_encomienda   = guia_encomienda[0]['clase_guia_encomienda'];		  
		  var estado       			  = guia_encomienda[0]['estado_mensajeria_id'];	
		  var valor_descuento         = guia_encomienda[0]['valor_descuento'];	

		  setFormWithJSON(forma,guia_encomienda);

			// if(parseInt(valor_descuento) >0 ){
			// 	// document.getElementById('aplica_descuento').checked=true;    javier//
			// }else{
			// 	// document.getElementById('aplica_descuento').checked=false;    
			// }

			if(estado == 1 ){
				if($('#guardar'))    $('#guardar').attr("disabled","true");
				if($('#actualizar')) $('#actualizar').attr("disabled","");
				if(document.getElementById('anular') )    $('#anular').attr("disabled","");
				if($('#limpiar'))    $('#limpiar').attr("disabled","");
				$("#tipo_envio_id").removeClass("obligatorio")
			}else{
				if($('#guardar'))    $('#guardar').attr("disabled","true");
				if($('#actualizar')) $('#actualizar').attr("disabled","true");
				if(document.getElementById('anular') )     $('#anular').attr("disabled","true");
				if($('#limpiar'))    $('#limpiar').attr("disabled","");
			}
			
			$('#forma_pago_mensajeria_id').attr("disabled","true");
			
		}catch(e){
			alertJquery(resp,"Error :"+e);
		  }	 		  
		 removeDivLoading(); 		 
		 $("input[name=valor],input[name=peso_volumen]").each(function(){																					   
           if(this.id == 'valor'){																					   
             setFormatCurrencyInput(this,2);																																	
		   }else{
                setFormatCurrencyInput(this,3);																																				
			  }			  
         });
         	 
		 var guia_encomienda_id = $("#guia_encomienda_id").val();
		  
       }	  
    });
}

function GuiaOnSave(formulario,resp){
  
  var guia_encomienda_numero    = parseInt(resp);
  var forma_pago_mensajeria_id  = $("#forma_pago_mensajeria_id :selected").val();
	
  if(guia_encomienda_numero > 0){
	  
	alertJquery("<span style='font-weight:bold;font-size:14px'>GUIA : </span><span style='color:red;font-weight:bold;font-size:20px'>"+guia_encomienda_numero+"</span>","Guia");	

	var url = "GuiaEncomiendaClass.php?ACTIONCONTROLER=onclickPrint&rango_desde="+guia_encomienda_numero+"&rango_hasta="+guia_encomienda_numero+"&forma_pago_mensajeria_id="+forma_pago_mensajeria_id+"&formato=SI&random="+Math.random();	
	
	onclickPrint(null,url,"Impresion Guia","950","600");		
	
	Reset(formulario);
	GuiaOnReset();	
 }else{
	alertJquery(resp,"Error : ");
	$('#guardar').attr("disabled","");	
  }
}

function GuiaOnUpdate(formulario,resp){	
	if($.trim(resp) == 'true'){		
		alertJquery("Se Actualizo de Forma Exitosa");
		Reset(formulario);
		GuiaOnReset();
		updateGridGuia();
	}else{
		alertJquery(resp);
	}
}

function GuiaOnDelete(formulario,resp){
	Reset(formulario);
	GuiaOnReset();
	updateGridGuia();
	alertJquery(resp);
}

function GuiaOnReset(){	
    var Tabla = document.getElementById('tableGuia');
	
	$("#cantidad").val(1);
	
	$("#tipo_guia").val(1);
	
	$('#forma_pago_mensajeria_id').removeAttr("disabled");
	
	$('#forma_pago_mensajeria_id').val('1');
	
	$('#forma_pago_mensajeria_id').trigger('change');
	
	updateGridGuia();
	
	document.getElementById('estado_mensajeria_id').value= '1';
	document.getElementById('forma_pago_mensajeria_id').value='1';
	document.getElementById('medida_id').value= '38';
	document.getElementById('tipo_servicio_mensajeria_id').value= '5';

	document.getElementById('origen').value= document.getElementById('origencopia').value;
	document.getElementById('origen_hidden').value= document.getElementById('origencopia_id').value;	

		
    if(document.getElementById('anular')) document.getElementById('anular').disabled = true;							  
	
	clearFind();
	
	
	$("#fecha_guia").val($("#fecha").val());
	$("#oficina_id").val($("#oficina_id_static").val());	
	
	$('#guardar').attr("disabled","");
	$('#actualizar').attr("disabled","true");
	$('#borrar').attr("disabled","true");
	$('#limpiar').attr("disabled","");	
	 document.getElementById('estado_mensajeria_id').disabled = true;	
    recalculaValor();

	
	 $("input[name=valor],input[name=peso_volumen]").each(function(){
																				   
	   if(this.id == 'valor'){																					   
		 setFormatCurrencyInput(this,2);																																	
	   }else{
			setFormatCurrencyInput(this,3);																																				
		  }		  
	 });
	 chequear();
}

function beforePrint(formulario,url,title,width,height){
	document.getElementById("rango_desde").style.width="120px";
	document.getElementById("rango_desde").style.height="16px";	
	document.getElementById("rango_hasta").style.width="120px";
	document.getElementById("rango_hasta").style.height="16px";	

	document.getElementById("orden_servicio").style.width="120px";
	document.getElementById("orden_servicio").style.height="16px";	
	document.getElementById("fecha_guia_crea").style.width="120px";
	document.getElementById("fecha_guia_crea").style.height="16px";	

	document.getElementById("rango_desde").style.fontSize="14px";
	document.getElementById("rango_hasta").style.fontSize="14px";

	document.getElementById("orden_servicio").style.fontSize="14px";
	document.getElementById("fecha_guia_crea").style.fontSize="14px";



  $("#rangoImp").dialog({
	  title: 'Impresion de Guias, Puede filtrar por rango, Orden o Fecha',
	  width: 700,
	  height: 210,
		  closeOnEscape:true,
		  show: 'scale',
		  hide: 'scale'
  });			  
	
   return false;
}

function printOut(){		
	var rango_desde = document.getElementById("rango_desde").value;
	var rango_hasta = document.getElementById("rango_hasta").value;
	var formato     = document.getElementById("formato").value;
	var orden_servicio     = document.getElementById("orden_servicio").value;
	var fecha_guia_crea     = document.getElementById("fecha_guia_crea").value;
	var fecha_guia_crea     = document.getElementById("fecha_guia_crea").value;
	var forma_pago_mensajeria_id     = $("#tipo_guia :selected").val();
	
	var url = "GuiaEncomiendaClass.php?ACTIONCONTROLER=onclickPrint&rango_desde="+rango_desde+"&rango_hasta="+rango_hasta+"&formato="+formato+"&orden_servicio="+orden_servicio+"&fecha_guia_crea="+fecha_guia_crea+"&forma_pago_mensajeria_id="+forma_pago_mensajeria_id+"&random="+Math.random();	
	
	if( ((parseInt(rango_desde)>0 && parseInt(rango_hasta)>0) || (parseInt(orden_servicio)>0) || (fecha_guia_crea!='' && fecha_guia_crea!='null')) && formato!='NULL'  ){
		printCancel();
		onclickPrint(null,url,"Impresion Guia","950","600");		
	}else{
		alertJquery("Por favor indique algunos de los items: Rango (desde-hasta), Orden o Fecha","Validacion Impresion");
	}
}

function printCancel(){
	$("#rangoImp").dialog('close');	
	document.getElementById("rango_desde").style.width="120px";
	document.getElementById("rango_desde").style.height="16px";	
	document.getElementById("rango_hasta").style.width="120px";
	document.getElementById("rango_hasta").style.height="16px";	

	removeDivLoading();
}




function getOptionsTipoEnvio(){

	var TipoServicioId   = $("#tipo_servicio_mensajeria_id").val();
	var QueryString = "ACTIONCONTROLER=getOptionsTipoEnvio&tipo_servicio_mensajeria_id="+TipoServicioId;

	if(TipoServicioId != 'NULL'){
	
		$.ajax({
			url     : "GuiaEncomiendaClass.php",
			data    : QueryString,
			success : function(response){
				$("#tipo_envio_id").parent().html(response);
			}
		});
	}
}

function separaCodigoDescripcion(){}

function updateGridGuia(){
	$("#refresh_QUERYGRID_GuiaOficinas").click();
}


function setDataRemitente(remitente_id,remitente,input){		   		   		   
	var QueryString = "ACTIONCONTROLER=getDataRemitenteDestinatario&remitente_destinatario_id="+remitente_id;	
   $.ajax({
	 url        : "GuiaEncomiendaClass.php?rand="+Math.random(),
	 data       : QueryString,
	 beforeSend : function(){
		 showDivLoading();
	 },
	 success    : function(resp){	 		 
		 try{			 
			 var dataResp = $.parseJSON(resp);				 
			 $("#remitente").val(dataResp[0]['remitente_destinatario']);
			 $("#remitente_id").val(dataResp[0]['remitente_destinatario_id']);				 
			 $("#doc_remitente").val(dataResp[0]['numero_identificacion']);				 				 
			 $("#tipo_identificacion_remitente_id").val(dataResp[0]['tipo_identificacion_id']);
			 $("#direccion_remitente").val(dataResp[0]['direccion']);				 				 				 
			 $("#telefono_remitente").val(dataResp[0]['telefono']);	 
			 $("#correo_remitente").val(dataResp[0]['correo_remitente']);
			}catch(e){
			   alertJquery(resp,"Error :"+e);
			}		 
		 removeDivLoading();
	  }	
   });
}

function validaTipoEnvio(valor){
	
	    var valuetipo_envio_id = valor;
				
		if( valuetipo_envio_id != 'NULL'){			
				
				var QueryString = "ACTIONCONTROLER=validaTipoEnvio&tipo_envio_id="+ valuetipo_envio_id;
				$.ajax({
					url     : "GuiaEncomiendaClass.php?rand="+Math.random(),
					data    : QueryString,
					success : function(response){
												
						var tipo_servicio_mensajeria_id = parseInt(response);
												
					    if(tipo_servicio_mensajeria_id > 0){
						  $("#tipo_servicio_mensajeria_id").val(tipo_servicio_mensajeria_id);
						  setDataFormWithResponse();
							 
							if($('#guardar')) $('#guardar').attr("disabled","");
							if($('#actualizar')) $('#actualizar').attr("disabled","true");
							if($('#borrar'))     $('#borrar').attr("disabled","true");
							if($('#limpiar'))    $('#limpiar').attr("disabled","");							 
							 							 					 
						  }								
					  }
				});
		}
}

function setDataDestinatario(destinatario_id,destinatario,input){		   		   		   
	var QueryString = "ACTIONCONTROLER=getDataRemitenteDestinatario&remitente_destinatario_id="+destinatario_id;	
   $.ajax({
	 url        : "GuiaEncomiendaClass.php?rand="+Math.random(),
	 data       : QueryString,
	 beforeSend : function(){
		 showDivLoading();
	 },
	 success    : function(resp){		 
		 try{			 
			 var dataResp = $.parseJSON(resp);				 
			 $("#destinatario").val(dataResp[0]['remitente_destinatario']);
			 $("#destinatario_id").val(dataResp[0]['remitente_destinatario_id']);				 
			 $("#doc_destinatario").val(dataResp[0]['numero_identificacion']);				 				 
			 $("#tipo_identificacion_destinatario_id").val(dataResp[0]['tipo_identificacion_id']);				 				 				 				             
			 $("#direccion_destinatario").val(dataResp[0]['direccion']);				 				 				 
			 $("#telefono_destinatario").val(dataResp[0]['telefono']);
			 $("#correo_destinatario").val(dataResp[0]['correo_destinatario']);
			}catch(e){
			   alertJquery(resp,"Error :"+e);
			}		 
		 removeDivLoading();
	 }	
   });
  }


function recalculaValorvol(){
	var largo = $("#largo").val();
	var ancho = $("#ancho").val();
	var alto = $("#alto").val();

	if(parseInt(largo)>0 && parseInt(ancho)>0 && parseInt(alto)>0){ 
		var pesovol=(parseInt(largo) * parseInt(ancho) * parseInt(alto))/6000;
		
		if(validaPesoTipoServicio(15,'peso_volumen')) $("#peso_volumen").val(Math.ceil(pesovol)); 
		 
		 recalculaValor();
		 
		 
	}
	
}
function recalculaValor(){

	var tipo_envio_id= document.getElementById('tipo_envio_id').value;
	var tipo_servicio_mensajeria_id = $("#tipo_servicio_mensajeria_id").val();
	var origen_id = $("#origen_hidden").val();
	var destino_id = $("#destino_hidden").val();
	var peso = $("#peso").val();
	var peso_volumen = $("#peso_volumen").val();
	var valor = removeFormatCurrency($("#valor").val());
	var valor_otros = removeFormatCurrency($("#valor_otros").val());
	var valor_flete = removeFormatCurrency($("#valor_flete").val());
	//var valor_manejo = removeFormatCurrency($("#valor_manejo").val());
	var valor_manejo=0;
	var valor_total=0;

	if(parseInt(tipo_servicio_mensajeria_id)>0 && origen_id!='NULL' && origen_id!='' && destino_id!='NULL' && destino_id!='' && parseFloat(peso)>0 && parseFloat(valor)>0   ){
		
		var QueryString = "ACTIONCONTROLER=CalcularTarifa&tipo_envio_id="+tipo_envio_id+"&tipo_servicio_mensajeria_id="+tipo_servicio_mensajeria_id
		+"&origen_id="+origen_id+"&destino_id="+destino_id+"&peso="+peso+"&valor="+valor+"&valor_otros="+valor_otros+"&peso_volumen="+peso_volumen;	
	   $.ajax({
		 url        : "GuiaEncomiendaClass.php?rand="+Math.random(),
		 data       : QueryString,
		 beforeSend : function(){
			 //showDivLoading();
		 },
		 success    : function(resp){		 
			 try{			 
				 var dataResp = $.parseJSON(resp);	
				 
				 $("#valor_flete").val(dataResp['valor_flete']);
				 $("#valor_seguro").val(dataResp['valor_declarado']);				 
				 valor_flete = dataResp['valor_flete'];
				 valor = dataResp['valor'];
				 $("#valor").val(setFormatCurrency(valor));				 
				// $("#valor_manejo").val(dataResp['valor_manejo']);		
				 $("#tipo_envio_id").val(dataResp['tipo_envio_id']);
				 valor_flete = parseFloat(valor_flete)>0 ? valor_flete : 0;
				 valor_otros = parseFloat(valor_otros)>0 ? valor_otros : 0;				 
				 valor_manejo = parseFloat(valor_manejo)>0 ? valor_manejo : 0;		
				 var valor_declarado = parseFloat(dataResp['valor_declarado'])>0 ? dataResp['valor_declarado'] : 0;
				 valor_total = parseFloat(valor_flete) + parseFloat(valor_otros) + parseFloat(valor_manejo) + parseFloat(valor_declarado);
				 //$("#valor_total").val(dataResp['total']);		
				 $("#valor_total").val(setFormatCurrency(valor_total));
				//  calcula_descuento();	
			 }catch(e){
				alertJquery(resp,"Error :"+e);
				// calcula_descuento();	
				   
			}		 
			 //removeDivLoading();
		 }	
	   });
		
	}
	

}



function setRangoDesdeHasta(){
   $("#rango_desde").change(function(){									 
      document.getElementById('rango_hasta').value = this.value;
   });	
}

function onclickCancellation(formulario){
	
	if($("#divAnulacion").is(":visible")){
	 
	   var formularioPrincipal = document.forms[0];
	   var causal_anulacion_id = $("#causal_anulacion_id").val();
	   var observaciones       = $("#observacion_anulacion").val();
	   
       if(ValidaRequeridos(formulario)){
	
	     var QueryString = "ACTIONCONTROLER=onclickCancellation&"+FormSerialize(formulario)+"&guia_encomienda_id="+$("#guia_encomienda_id").val();
		
	     $.ajax({
           url  : "GuiaEncomiendaClass.php",
	       data : QueryString,
	       beforeSend: function(){
			   showDivLoading();
	       },
	       success : function(response){
			 
			 Reset(formularioPrincipal);
             GuiaOnReset(formulario);						  
						  
		     if($.trim(response) == 'true'){
				 alertJquery('Guia Anulada','Anulado Exitosamente');
			 }else{
				   alertJquery(response,'Inconsistencia Anulando');
			   }
			   
			 removeDivLoading();
             $("#divAnulacion").dialog('close');
			 
	       }
	    });	   
	  }
	
    }else{
		
	 var guia_encomienda_id = $("#guia_encomienda_id").val();
	 var estado        = document.getElementById("estado_mensajeria_id").value;
	 
	 if(parseInt(guia_encomienda_id) > 0){		
       
		$("#divAnulacion").dialog({
		  title: 'Anulacion Guia CRM',
		  width: 450,
		  height: 280,
		  closeOnEscape:true
		 });
			
	 }else{
		alertJquery('Debe Seleccionar primero una Guia CRM','Anulacion');
	  }		
   }  
}

function setObservaciones(id,text,obj){}
function setValorLiquidacion(){}