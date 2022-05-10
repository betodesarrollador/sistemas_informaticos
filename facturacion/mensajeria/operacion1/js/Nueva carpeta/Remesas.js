// JavaScript Document
var SolicitudId;

$(document).ready(function(){
	
    setOrdenCargue();	
    reloadListProductos();
	
	$("#divAnulacion").css("display","none");	
	
    /**
    * cargamos el grid con las solicitudes de servicio
    */
    $("#iframeSolicitudRemesa").attr("src","SolicServToRemesaPaqueteoClass.php");	
    
    $("#importSolcitud").click(function(){
		
        var formulario = document.getElementById('RemesasForm');		
        Reset(formulario);	
        RemesasOnReset();						
										
	    $("#divSolicitudRemesa").dialog({
		    title: 'Solicitud de Servicio para Remesar',
		    width: 950,
		    height: 395,
		    closeOnEscape:true,
		    show: 'scale',
		    hide: 'scale'
	    });
    });
	
    $("a[name=saveDetalleRemesa]").click(function(){
      addRowProduct(this);
    });
	
	
    $("#print_out").click(function(){
       printOut();								   
    });
	
    $("#print_cancel").click(function(){
       printCancel();									  
    });
	
    $("#amparada_por").change(function(){
       setDataSeguroPoliza(this.value);									  							  
    });
	
    $("#saveDetallesRemesa").click(function(){
      window.frames[1].saveDetallesRemesa();
    });
    
    $("#deleteDetallesRemesa").click(function(){
	window.frames[1].deleteDetallesRemesa();
    });
	
   $("a[name=saveDetalleRemesa]").focus(function(){    
       $(this).parent().addClass("focusSaveRow");
    });
	
   $("a[name=saveDetalleRemesa]").blur(function(){
       $(this).parent().removeClass("focusSaveRow");
   });	
   
   $("#guardar,#actualizar").click(function(){
											
											
	  var formulario = this.form;
	  
	  if(ValidaRequeridos(formulario)){ 
	  
	    //$("#propietario_mercancia").val($("#propietario_mercancia_txt").val());
	    
	    if(this.id == 'guardar'){

			var QueryString = "ACTIONCONTROLER=onclickSave&"+FormSerialize(formulario);
			var numDetalle  = 0;
		  
			$("#tableRemesas").find("*[name=remove]").each(function(){
														
				var Row  = this.parentNode.parentNode.parentNode;																
				
				$(Row).find("input").each(function(){
					QueryString += "&detalle_remesa["+numDetalle+"]["+this.name+"]="+this.value;
				});								
														
				numDetalle++;									
																
			});
			
			if(parseInt(numDetalle) > 0){			
			
				$.ajax({
				  url        : "RemesasClass.php?rand="+Math.random(),
				  data       : QueryString,
				  beforeSend : function(){
				    showDivLoading();
				  },
				  success    : function(resp){				   
					  updateGridRemesas();
					  removeDivLoading();
					  RemesasOnSave(formulario,resp);					  
				  }
				});
				
			}else{
				alertJquery("Debe ingresar almenos un producto","Validacion Remesas");
				return false;
			  }

		}else{

				var QueryString = "ACTIONCONTROLER=onclickUpdate&"+FormSerialize(formulario);
				var numDetalle  = 0;
			  
				$("#tableRemesas").find("*[name=remove]").each(function(){
															
					var Row  = this.parentNode.parentNode.parentNode;																
					
					$(Row).find("input").each(function(){
						QueryString += "&detalle_remesa["+numDetalle+"]["+this.name+"]="+this.value;
					});									
															
					numDetalle++;											
																	
				});
				
				if(parseInt(numDetalle) > 0){
				
					$.ajax({
					  url        : "RemesasClass.php?rand="+Math.random(),
					  data       : QueryString,
					  beforeSend : function(){
						showDivLoading();
					  },
					  success    : function(resp){
						  updateGridRemesas();
						  removeDivLoading();
					      RemesasOnUpdate(formulario,resp);						  
					  }
					});
				}
		   }
	   }										
   });
      
   recalculaValor();
   recalculaCantidad();
   recalculaPeso();   
   recalculaPesoVolumen();      
   setRemesaComplemento();
   getRemesaComplemento();
   setRangoDesdeHasta();       
   setValorLiquidacion();	   
	
});

function closeDialog(){
	$("#divSolicitudRemesa").dialog('close');
}

//funcion para cargar los datos desde BUSCAR
function setDataFormWithResponse(remesa_id){
	
	var forma 		= document.forms[0];	
	var QueryString = "ACTIONCONTROLER=onclickFind&remesa_id="+remesa_id;
	
	$.ajax({
	  url        : "RemesasClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
		  showDivLoading();
	  },
	  success    : function(resp){
		  
        try{
			
		  var data           = $.parseJSON(resp);
		  var guia         = data[0]['guia'];
		  var detalle_remesa = data[0]['detalle_remesa'];
		  var contacto_id    = remesa[0]['contacto_id'];		  		
		  var cliente_id     = remesa[0]['cliente_id'];		  		
		  var clase_remesa   = remesa[0]['clase_remesa'];		  
		  var estado         = remesa[0]['estado'];
		  		
		  setContactos(cliente_id,contacto_id);
		  
          setFormWithJSON(forma,remesa);
		  
		  if(clase_remesa == 'CP'){	  
			document.getElementById('numero_remesa_padre').disabled = true;
		  }else{	  			  
			 document.getElementById('numero_remesa_padre').disabled = false;			  
			}
			
		   if(estado == 'PD' || estado == 'PC'){
		     if($('#actualizar')) document.getElementById('actualizar').disabled = false;			   
		   }else{
		       //if($('#actualizar')) document.getElementById('actualizar').disabled = true;
			 }						
			
			if(estado == 'PD' || estado == 'PC' || estado == 'MF'){
              if(document.getElementById('anular')) document.getElementById('anular').disabled = false;				
			}else{
                  if(document.getElementById('anular')) document.getElementById('anular').disabled = true;				
			  }
			  			  
		   if(estado == 'AN'){
		     if($('#importSolcitud')) document.getElementById('importSolcitud').disabled = true;			   
		     if($('#actualizar'))     document.getElementById('actualizar').disabled     = true;			   			 
		   }else{
		       if($('#importSolcitud')) document.getElementById('importSolcitud').disabled = false;
		       if($('#actualizar'))     document.getElementById('actualizar').disabled     = false;			   			 			   
			 }				  
			
	  if(detalle_remesa){			  
		  var Tabla = document.getElementById('tableRemesas');		
		      $(Tabla.rows).each(function(){
			if(this.rowIndex > 0){
			      $(this).remove();
			}
		      });				
		  
		  for(var i = 0; i < detalle_remesa.length; i++){
			  
			var newRow = insertaFilaAbajoClon(Tabla);
			var item   = parseInt(i);
		
            $(newRow).find("a[name=saveDetalleRemesa]").html('<img name="remove" src="/velotax/framework/media/images/grid/close.png" />')				
			$(newRow).find("input[name=item]").val(item);    
			$(newRow).find("a[name=saveDetalleRemesa]").focus(function(){
			  $(this).parent().addClass("focusSaveRow");
			});
			
			$(newRow).find("a[name=saveDetalleRemesa]").blur(function(){
			  $(this).parent().removeClass("focusSaveRow");
			});	
			
			$(newRow).find("a[name=saveDetalleRemesa]").click(function(){
			  removeRowProduct(this);
			});					
			
			for(var llave in detalle_remesa[i]){				
				$(newRow).find("input[name="+llave+"]").val(detalle_remesa[i][llave]);				
			}			  
		  }		  
		  
		if(i < 7){
			  
			  var newRow = insertaFilaAbajoClon(Tabla);
			  var item   = parseInt(i) + 1;
		
			  $(newRow).find("input[name=item]").val(item);    
			  
			  $(newRow).find("a[name=saveDetalleRemesa]").focus(function(){
			    $(this).parent().addClass("focusSaveRow");
			  });
			  
			  $(newRow).find("a[name=saveDetalleRemesa]").blur(function(){
			    $(this).parent().removeClass("focusSaveRow");
			  });	
			  
			  $(newRow).find("a[name=saveDetalleRemesa]").click(function(){
			    addRowProduct(this);
			  }); 						  
		  }
		  
          recalculaValor();
          recalculaCantidad();
          recalculaPeso();   
		  recalculaPesoVolumen();
		  
         }
					  
		  if($('#guardar'))    $('#guardar').attr("disabled","true");
		  if($('#borrar'))     $('#borrar').attr("disabled","");
		  if($('#limpiar'))    $('#limpiar').attr("disabled","");
			
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
         	 
		 var remesa_id = $("#guia_id").val();
		  
		 if(guia_id > 0){		  
	       document.getElementById('rango_desde').value = guia_id;	  
	       document.getElementById('rango_hasta').value = guia_id;			  		  
		 }	
      }	  
    });
}


function RemesasOnSave(formulario,resp){
	
  var guia_numero = parseInt(resp);

  if(guia_numero > 0){
	
	alertJquery("<span style='font-weight:bold;font-size:14px'>REMESA : </span><span style='color:red;font-weight:bold;font-size:20px'>"+guia_numero+"</span>","Remesar");
	
	Reset(formulario);
	RemesasOnReset();
	
 }else{
	alertJquery(resp,"Error : ");
   }	
	
}


function RemesasOnUpdate(formulario,resp){
	
	if($.trim(resp) == 'true'){
		
		alertJquery("Se Actualizo de Forma Exitosa");
		Reset(formulario);
		RemesasOnReset();
		updateGridRemesas();
		updateRangoDesde();
	
	}else{
		alertJquery(resp);
	}
}


function RemesasOnDelete(formulario,resp){
	Reset(formulario);
	RemesasOnReset();
	updateGridRemesas();
	updateRangoDesde();	
	alertJquery(resp);
}


function RemesasOnReset(){
	
    var Tabla = document.getElementById('tableRemesas');

	document.getElementById("clase_remesa").value           = 'NN';	
	document.getElementById("numero_remesa_padre").value    = '';		
	document.getElementById("numero_remesa_padre").disabled = true;	
	document.getElementById('estado').value                 = 'PD';
	document.getElementById('planilla').value               = 1;	
		
    if(document.getElementById('anular')) document.getElementById('anular').disabled = true;							  
	if($('#importSolcitud')) document.getElementById('importSolcitud').disabled = false;			   
		
	$("#horas_pactadas_cargue,#horas_pactadas_descargue").val("12");
  
    $(Tabla.rows).each(function(){
	  if(this.rowIndex > 0){
	    $(this).remove();
 	  }
    });	
	
    var newRow = insertaFilaAbajoClon(Tabla);
    var item   = 1;

    $(newRow).find("input[name=item]").val(item);    
	  
    $(newRow).find("a[name=saveDetalleRemesa]").focus(function(){
      $(this).parent().addClass("focusSaveRow");
    });
    
    $(newRow).find("a[name=saveDetalleRemesa]").blur(function(){
      $(this).parent().removeClass("focusSaveRow");
    });	
    
    $(newRow).find("a[name=saveDetalleRemesa]").click(function(){
      addRowProduct(this);
    }); 


	resetContactos();
	clearFind();
	
    document.getElementById('naturaleza_id').value  = 1;
    document.getElementById('empaque_id').value     = 1;
    document.getElementById('medida_id').value      = 77;	
	
	$("#fecha_remesa").val($("#fecha").val());
	$("#oficina_id").val($("#oficina_id_static").val());	
	$("#amparada_por").val("E");			
	$("#aseguradora_id").val($("#aseguradora_id_static").val());		
	$("#numero_poliza").val($("#numero_poliza_static").val());	
    document.getElementById('aseguradora_id').disabled = true;
	
	$('#guardar').attr("disabled","");
	$('#actualizar').attr("disabled","true");
	$('#borrar').attr("disabled","true");
	$('#limpiar').attr("disabled","");	
	
    recalculaValor();
    recalculaCantidad();
    recalculaPeso();   
    recalculaPesoVolumen();	
	
	 $("input[name=valor_detalle],input[name=peso_volumen_detalle]").each(function(){
																				   
	   if(this.id == 'valor_detalle'){																					   
		 setFormatCurrencyInput(this,2);																																	
	   }else{
			setFormatCurrencyInput(this,3);																																				
		  }
		  
	 });
}

function beforePrint(formulario,url,title,width,height){

    var QueryString = "ACTIONCONTROLER=updateRangoDesde";
	
	$.ajax({
          url        : "RemesasClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
	    showDivLoading();
	  },
	  success    : function(resp){
	    
	    $("#rango_desde").replaceWith(resp);
		setRangoDesdeHasta();
	    
	    var QueryString = "ACTIONCONTROLER=updateRangoHasta";
	
	    $.ajax({
             url        : "RemesasClass.php?rand="+Math.random(),
	     data       : QueryString,
	     beforeSend : function(){
	     },
	     success    : function(resp){
	       
		  $("#rango_hasta").replaceWith(resp);
		  
		  var remesa_id = $("#remesa_id").val();
		  
		  if(remesa_id > 0){		  
	       document.getElementById('rango_desde').value = remesa_id;	  
	       document.getElementById('rango_hasta').value = remesa_id;			  		  
		  }
		  
		  $("#rangoImp").dialog({
			  title: 'Impresion de Remesas',
			  width: 700,
			  height: 120,
				  closeOnEscape:true,
				  show: 'scale',
				  hide: 'scale'
		  });		  
		  
		  removeDivLoading();
		  
            }            
         });		
        }        
    });	

   return false;

}

function printOut(){	
	
	var rango_desde = document.getElementById("rango_desde").value;
	var rango_hasta = document.getElementById("rango_hasta").value;
	var formato     = document.getElementById("formato").value;
	var url = "RemesasClass.php?ACTIONCONTROLER=onclickPrint&rango_desde="+rango_desde+"&rango_hasta="+rango_hasta+"&formato="+formato+"&random="+Math.random();
	
	printCancel();
	
    onclickPrint(null,url,"Impresion Remesas","950","600");	
	
}

function printCancel(){
	$("#rangoImp").dialog('close');	
	removeDivLoading();
}

function updateRangoDesde(){	
	var QueryString = "ACTIONCONTROLER=updateRangoDesde";	
	$.ajax({
      url        : "RemesasClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
	  },
	  success    : function(resp){		  
		  $("#rango_desde").replaceWith(resp);			  
		  var remesa_id = $("#remesa_id").val();		  
		  if(remesa_id > 0){		  
	  	    document.getElementById('rango_desde').value = $("#remesa_id").val();		  
		  }		  		  
		  updateRangoHasta();	 	
      }	  
    });	
}

function updateRangoHasta(){
	
	var QueryString = "ACTIONCONTROLER=updateRangoHasta";	
	$.ajax({
          url        : "RemesasClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
	  },
	  success    : function(resp){		  
		  $("#rango_hasta").replaceWith(resp);		  
		  var guia_id = $("#guia_id").val(); 		  
		  if(guia_id > 0){		  
	  	    document.getElementById('rango_hasta').value = $("#guia_id").val();		  
		  }		  
      }
    });		
}

function setContactos(cliente_id,contacto_id){	
	var QueryString = "ACTIONCONTROLER=setContactos&cliente_id="+cliente_id+"&contacto_id="+contacto_id;	
	$.ajax({
		url     : "RemesasClass.php?rand="+Math.random(),
		data    : QueryString,
		success : function(response){
			$("#contacto_id").parent().html(response);
		}
	});
}

function cargaDatos(response){	
  var formulario = document.getElementById('RemesasForm');
  setContactos(response[0]['solicitud'][0]['cliente_id'],response[0]['solicitud'][0]['contacto_id']);  
  var solicitud          = response[0]['solicitud'];
  var detalles_solicitud = response[0]['detalle_solicitud'];
  var numDetalles        = detalles_solicitud.length - 1;  
  $("textarea[id=observaciones]").val($.trim(solicitud[0]['origen']));      	  
  setFormWithJSON(document.getElementById('RemesasForm'),solicitud,'true');  
  var Tabla = document.getElementById('tableRemesas');  
  $(Tabla.rows).each(function(){
    if(this.rowIndex > 0){
      $(this).remove();
    }
  });
  
  var totalCantidad    = 0;
  var totalPeso        = 0;
  var totalPesoVolumen = 0;
  var totalValor       = 0;
  
  for(var i = 0; i < detalles_solicitud.length; i++){

    var newRow = insertaFilaAbajoClon(Tabla);    
    $(newRow).find("a[name=saveDetalleRemesa]").html('<img name="remove" src="/velotax/framework/media/images/grid/close.png" />')
    $(newRow).find("input[name=item]").val(i);                
    $(newRow).find("a[name=saveDetalleRemesa]").focus(function(){
      $(this).parent().addClass("focusSaveRow");
    });
      
    $(newRow).find("a[name=saveDetalleRemesa]").blur(function(){
      $(this).parent().removeClass("focusSaveRow");
    });	
      
    $(newRow).find("a[name=saveDetalleRemesa]").click(function(){	
      removeRowProduct(this);		
    });

       
    for(llave in detalles_solicitud[i]){
      
      if(llave == 'peso_detalle'){
		if(detalles_solicitud[i][llave]){
	     totalPeso += (detalles_solicitud[i][llave] * 1);
         $(newRow).find("[name="+llave+"]").val(detalles_solicitud[i][llave]);					
		}
      }else if(llave == 'valor_detalle'){
		if(detalles_solicitud[i][llave]){		  
	      totalValor += (detalles_solicitud[i][llave] * 1);
          $(newRow).find("[name="+llave+"]").val(setFormatCurrency(detalles_solicitud[i][llave],2));		  
		}
       }else if(llave == 'cantidad_detalle'){
		  if(detalles_solicitud[i][llave]){		   
	       totalCantidad += (detalles_solicitud[i][llave] * 1);
           $(newRow).find("[name="+llave+"]").val(detalles_solicitud[i][llave]);				   
		  }
        }else if(llave == 'peso_volumen_detalle'){
		   if(detalles_solicitud[i][llave]){			
	         totalPesoVolumen += (detalles_solicitud[i][llave] * 1);
             $(newRow).find("[name="+llave+"]").val(setFormatCurrency(detalles_solicitud[i][llave],3));		  			 
		   }
	      }else{
			  if(detalles_solicitud[i][llave]){
               $(newRow).find("[name="+llave+"]").val(detalles_solicitud[i][llave]);		  
			  }
		    }                 
    }
  }

  $("#valor").val(setFormatCurrency(totalValor,2));
  $("#cantidad").val(totalCantidad);
  $("#peso").val(totalPeso);
  $("#peso_volumen").val(setFormatCurrency(totalPesoVolumen,3));  
    
  if(i < maxProductosRemesas){
    
    var newRow = insertaFilaAbajoClon(Tabla);
    var item   = parseInt(i) + parseInt(1);

    $(newRow).find("input[name=item]").val(item);  	  
    $(newRow).find("a[name=saveDetalleRemesa]").focus(function(){
      $(this).parent().addClass("focusSaveRow");
    });
    
    $(newRow).find("a[name=saveDetalleRemesa]").blur(function(){
      $(this).parent().removeClass("focusSaveRow");
    });	
    
    $(newRow).find("a[name=saveDetalleRemesa]").click(function(){
      addRowProduct(this);
    });      
  }
  
 $("input[name=valor_detalle],input[name=peso_volumen_detalle]").each(function(){
																			   
   if(this.id == 'valor_detalle'){																					   
	 setFormatCurrencyInput(this,2);																																	
   }else{
		setFormatCurrencyInput(this,3);																																				
	  }
	  
 });
  
  closeDialog();    
  recalculaValor();
  recalculaCantidad();
  recalculaPeso();   
  recalculaPesoVolumen();  
  
}

function resetContactos(){
	$("#contacto_id option").each(function(){
		if(this.value != 'NULL') $(this).remove();
	});
}

function separaCodigoDescripcion(){}

function updateGridRemesas(){
	$("#refresh_QUERYGRID_remesas").click();
}

function setDataSeguroPoliza(amparada_por){}

var maxProductosRemesas = 7;

function addRowProduct(obj){}

function removeRowProduct(obj){}

function getDataClienteRemitente(cliente_id,cliente,obj){
	
  var QueryString = "ACTIONCONTROLER=getDataClienteRemitente&cliente_id="+cliente_id;
	
	
   $.ajax({
	 url        : "RemesasClass.php?rand="+Math.random(),
	 data       : QueryString,
	 beforeSend : function(){
		 showDivLoading();
	 },
	 success    : function(resp){
		 
         try{
			 
		  var dataResp = $.parseJSON(resp);	 
		  
		  $("#remitente").val(dataResp[0]['remitente_destinatario']);
		  $("#remitente_hidden").val(dataResp[0]['remitente_destinatario_id']);				 
		  $("#doc_remitente").val(dataResp[0]['numero_identificacion']);				 				 
		  $("#tipo_identificacion_remitente_id").val(dataResp[0]['tipo_identificacion_id']);				 				 				 				             $("#direccion_remitente").val(dataResp[0]['direccion']);				 				 				 
		  $("#telefono_remitente").val(dataResp[0]['telefono']);				 				 				 	
                  getDataClientePropietario(cliente_id,obj);
		 
		 }catch(e){
			   alertJquery(resp,"Error :"+e);
			}		 
		 removeDivLoading();
	 }	
   });	
}

function setDataRemitente(remitente_id,remitente,input){
		   		   		   
	var QueryString = "ACTIONCONTROLER=getDataRemitenteDestinatario&remitente_destinatario_id="+remitente_id;
	
   $.ajax({
	 url        : "RemesasMasivoClass.php?rand="+Math.random(),
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
		 
		 }catch(e){
			   alertJquery(resp,"Error :"+e);
			}
		 
		 removeDivLoading();
	 }	
   });
}

function setDataDestinatario(destinatario_id,destinatario,input){
		   		   		   
	var QueryString = "ACTIONCONTROLER=getDataRemitenteDestinatario&remitente_destinatario_id="+destinatario_id;
	
   $.ajax({
	 url        : "RemesasMasivoClass.php?rand="+Math.random(),
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
			 $("#tipo_identificacion_destinatario_id").val(dataResp[0]['tipo_identificacion_id']);				 				 				 				             $("#direccion_destinatario").val(dataResp[0]['direccion']);				 				 				 
			 $("#telefono_destinatario").val(dataResp[0]['telefono']);				 				 				 	

		 
		 }catch(e){
			   alertJquery(resp,"Error :"+e);
			}
		 
		 removeDivLoading();
	 }	
   });
  }

function recalculaCantidad(){}

function recalculaPeso(){}

function recalculaPesoVolumen(){}

function recalculaValor(){}

function getDataPropietario(tercero_id,tercero,obj){
  
  var QueryString = "ACTIONCONTROLER=getDataPropietario&tercero_id="+tercero_id;
  
  $.ajax({
    url        : "RemesasClass.php?rand="+Math.random(),
    data       : QueryString,
    beforeSend : function(){
      showDivLoading();
    },
    success    : function(resp){
      
      try{
	
	var data  = $.parseJSON(resp);
	var forma = obj.form;
	
	for(var llave in data[0]){
	  $(forma).find("input[name="+llave+"]").val(data[0][llave]);
	}
		
      }catch(e){
	  alertJquery(resp,"Error: "+e);
       }
      
      removeDivLoading();
      
    }
  });  
}

function getDataClientePropietario(cliente_id,obj){
  
   var QueryString = "ACTIONCONTROLER=getDataClientePropietario&cliente_id="+cliente_id;
  
  $.ajax({
    url        : "RemesasClass.php?rand="+Math.random(),
    data       : QueryString,
    beforeSend : function(){
      showDivLoading();
    },
    success    : function(resp){
      
      try{

	var data  = $.parseJSON(resp);
	var forma = obj.form;   
	
	for(var llave in data[0]){	  
	  $(forma).find("input[name="+llave+"]").val(data[0][llave]);
	}
		
      }catch(e){
	  alertJquery(resp,"Error: "+e);
       }
      
      removeDivLoading();
      
    }
  });   
}

function setRemesaComplemento(){}

function getRemesaComplemento(){}

function setRangoDesdeHasta(){

   $("#rango_desde").change(function(){
									 
      document.getElementById('rango_hasta').value = this.value;									 
									 
   });	
}

function onclickCancellation(formulario){}

function setObservaciones(id,text,obj){}

function reloadListProductos(){}

function setOrdenCargue(){}

function setValorLiquidacion(){}