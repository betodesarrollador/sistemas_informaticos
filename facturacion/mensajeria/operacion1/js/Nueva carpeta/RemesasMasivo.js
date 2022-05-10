var SolicitudId;

$(document).ready(function(){

	$("#divAnulacion").css("display","none");	
    $("#iframeSolicitudRemesa").attr("src","SolicServToRemesaClass.php");	
    $("#iframeOrdenCargueRemesa").attr("src","OrdenCargueToRemesaClass.php");			
    
    $("#importSolcitud").click(function(){
										
        var formulario = document.getElementById('RemesasMasivoForm')		
        Reset(formulario);	
        RemesasMasivoOnReset();  		
												
	    $("#divSolicitudRemesa").dialog({
		    title: 'Solicitud de Servicio para Remesar',
		    width: 950,
		    height: 395,
		    closeOnEscape:true,
		    show: 'scale',
		    hide: 'scale'
	    });
		
    });
	
    $("#importOrdenCargue").click(function(){
										
        var formulario = document.getElementById('RemesasMasivoForm')		
        Reset(formulario);	
        RemesasMasivoOnReset();  		
												
	    $("#divOrdenCargueRemesa").dialog({
		    title: 'Orden de Carga para Remesar',
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

			
				$.ajax({
				  url        : "RemesasMasivoClass.php?rand="+Math.random(),
				  data       : QueryString,
				  beforeSend : function(){
				    showDivLoading();
				  },
				  success    : function(resp){				   
					  updateGridRemesas();
					  removeDivLoading();
					  RemesasMasivoOnSave(formulario,resp);					  
				  }
				});
				


		}else{

				var QueryString = "ACTIONCONTROLER=onclickUpdate&"+FormSerialize(formulario);

				
					$.ajax({
					  url        : "RemesasMasivoClass.php?rand="+Math.random(),
					  data       : QueryString,
					  beforeSend : function(){
						showDivLoading();
					  },
					  success    : function(resp){
						  updateGridRemesas();
						  removeDivLoading();
					      RemesasMasivoOnUpdate(formulario,resp);						  
					  }
					});
					
		   }
	  }											
											
   });
   
   setValorLiquidacion();
   
   setRemesaComplemento();
   getRemesaComplemento();   
   setRangoDesdeHasta();      
	
});


function closeDialog(){
	$("#divSolicitudRemesa,#divOrdenCargueRemesa").dialog('close');
}


//funcion para cargar los datos desde BUSCAR
function setDataFormWithResponse(remesa_id){
	
	var forma 		= document.forms[0];	
	var QueryString = "ACTIONCONTROLER=onclickFind&remesa_id="+remesa_id;
	
	$.ajax({
	  url        : "RemesasMasivoClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
		  showDivLoading();
	  },
	  success    : function(resp){
		  
        try{
			
		  var data           = $.parseJSON(resp);
		  var remesa         = data[0]['remesa'];
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
			
		   //if(estado == 'PD' || estado == 'PC'){
		     if($('#actualizar')) document.getElementById('actualizar').disabled = false;			   
		  // }else{
		       //if($('#actualizar')) document.getElementById('actualizar').disabled = true;
			// }						
			
			if(estado == 'PD' || estado == 'PC' || estado == 'MF'){
              if(document.getElementById('anular')) document.getElementById('anular').disabled = false;				
			}else{
                  if(document.getElementById('anular')) document.getElementById('anular').disabled = true;				
			  }
			  			  
		   if(estado == 'AN'){
		     if($('#importSolcitud')) document.getElementById('importSolcitud').disabled = true;			   
		     if($('#actualizar'))     document.getElementById('actualizar').disabled     = true;			   			 
		   }else if(estado == 'PD' || estado == 'PC'){
		       if($('#importSolcitud')) document.getElementById('importSolcitud').disabled = false;
		       if($('#actualizar'))     document.getElementById('actualizar').disabled     = false;			   			 			   
			 }	
		   
					  
		  if($('#guardar'))    $('#guardar').attr("disabled","true");
	 	  //if($('#actualizar')) $('#actualizar').attr("disabled","");
		  if($('#borrar'))     $('#borrar').attr("disabled","");
		  if($('#limpiar'))    $('#limpiar').attr("disabled","");

			
		}catch(e){
			alertJquery(resp,"Error :");
		  }	  
		  
		 removeDivLoading(); 
		 
		 var remesa_id = $("#remesa_id").val();
		  
		 if(remesa_id > 0){		  
	       document.getElementById('rango_desde').value = remesa_id;	  
	       document.getElementById('rango_hasta').value = remesa_id;			  		  
		 }			 
		  
      }
	  
    });

}


function RemesasMasivoOnSave(formulario,resp){
	
  var remesa_numero = parseInt(resp);

  if(remesa_numero > 0){
	
	alertJquery("<span style='font-weight:bold;font-size:14px'>REMESA : </span><span style='color:red;font-weight:bold;font-size:20px'>"+remesa_numero+"</span>","Remesar");
	
	Reset(formulario);
	RemesasMasivoOnReset();
	
 }else{
	alertJquery(resp,"Error : ");
   }	
	
}


function RemesasMasivoOnUpdate(formulario,resp){
	
	if($.trim(resp) == 'true'){
		
		alertJquery("Se Actualizo de Forma Exitosa");
		Reset(formulario);
		RemesasMasivoOnReset();
		updateGridRemesas();
		updateRangoDesde();
	
	}else{
		alertJquery(resp);
	}
}


function RemesasMasivoOnDelete(formulario,resp){
	Reset(formulario);
	RemesasMasivoOnReset();
	updateGridRemesas();
	updateRangoDesde();	
	alertJquery(resp);
}


function RemesasMasivoOnReset(){
	
    var Tabla = document.getElementById('tableRemesas');
  
	document.getElementById("clase_remesa").value           = 'NN';	
	document.getElementById("numero_remesa_padre").value    = '';		
	document.getElementById("numero_remesa_padre").disabled = true;	
	document.getElementById('estado').value                 = 'PD';
		
    if(document.getElementById('anular')) document.getElementById('anular').disabled                 = true;							  
	if($('#importSolcitud')) document.getElementById('importSolcitud').disabled = false;			   
		
	$("#horas_pactadas_cargue,#horas_pactadas_descargue").val("12");			
	
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
}

function beforePrint(formulario,url,title,width,height){

    var QueryString = "ACTIONCONTROLER=updateRangoDesde";
	
	$.ajax({
          url        : "RemesasMasivoClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
	    showDivLoading();
	  },
	  success    : function(resp){
	    
	    $("#rango_desde").replaceWith(resp);	
	    setRangoDesdeHasta();
	    
	    var QueryString = "ACTIONCONTROLER=updateRangoHasta";
	
	    $.ajax({
             url        : "RemesasMasivoClass.php?rand="+Math.random(),
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
	var url         = "RemesasMasivoClass.php?ACTIONCONTROLER=onclickPrint&rango_desde="+rango_desde+"&rango_hasta="+rango_hasta+"&formato="+formato+"&random="+Math.random();
	
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
      url        : "RemesasMasivoClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
	  },
	  success    : function(resp){
		  $("#rango_desde").replaceWith(resp);		  
		  updateRangoHasta();		  		  
      }
    });
	
	
}

function updateRangoHasta(){
	
	var QueryString = "ACTIONCONTROLER=updateRangoHasta";
	
	$.ajax({
          url        : "RemesasMasivoClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
	  },
	  success    : function(resp){
		  $("#rango_hasta").replaceWith(resp);
      }
    });	
	
	
}

function setContactos(cliente_id,contacto_id){
	
	var QueryString = "ACTIONCONTROLER=setContactos&cliente_id="+cliente_id+"&contacto_id="+contacto_id;
	
	$.ajax({
		url     : "RemesasMasivoClass.php?rand="+Math.random(),
		data    : QueryString,
		success : function(response){
			$("#contacto_id").parent().html(response);
		}
	});
}

function cargaDatos(response){
   
  var formulario = document.getElementById('RemesasMasivoForm');
   
   
  setContactos(response[0]['solicitud'][0]['cliente_id'],response[0]['solicitud'][0]['contacto_id']);    
  
  var solicitud          = response[0]['solicitud'];
  var detalles_solicitud = response[0]['detalle_solicitud'];
  var numDetalles        = detalles_solicitud.length - 1;
      	  
  setFormWithJSON(document.getElementById('RemesasMasivoForm'),solicitud,'true');   
  
  closeDialog();  
  
}

function cargaDatosOrden(response){
   
  var formulario   = document.getElementById('RemesasMasivoForm');  
  var orden_cargue = response[0]['orden_cargue'];
      	  		  		  
  setFormWithJSON(document.getElementById('RemesasMasivoForm'),orden_cargue,'true');   
  
  closeDialog();  
  
}


function resetContactos(){
	$("#contacto_id option").each(function(){
		if(this.value != 'NULL') $(this).remove();
	});
}


function separaCodigoDescripcion(){
	
	var producto            = $('#producto').val().split("-");
	var descripcion_empresa = producto[0];

	$('#producto').val(producto[0]);
	$('#descripcion_producto').val(producto[1]);
}


function updateGridRemesas(){
	$("#refresh_QUERYGRID_RemesasMasivo").click();
}

function setDataSeguroPoliza(amparada_por){

    $("#aseguradora_id,#numero_poliza").removeClass("requerido");		  
	
	if(amparada_por == 'E'){
		
		$("#aseguradora_id").val($("#aseguradora_id_static").val());
		$("#numero_poliza").val($("#numero_poliza_static").val());		
		
		$("#aseguradora,#numero_poliza").addClass("obligatorio");
		
		
		document.getElementById('aseguradora_id').disabled  = true;
		document.getElementById('numero_poliza').readOnly = true;		
		
	}else if(amparada_por == 'N'){
		
		  $("#aseguradora_id").val("NULL");
		  $("#numero_poliza").val("");		
		  $("#aseguradora,#numero_poliza").removeClass("obligatorio");		  
		
		  document.getElementById('aseguradora_id').disabled= true;
		  document.getElementById('numero_poliza').readOnly = true;				
		
	  }else{
		  
		 $("#aseguradora_id").val("NULL");
		 $("#numero_poliza").val("");		
		 
		 $("#aseguradora_id,#numero_poliza").addClass("obligatorio");		 
		
		 document.getElementById('aseguradora_id').disabled = false;
		 document.getElementById('numero_poliza').readOnly = false;				  		  
		  
		 }
	
	
}


function getDataClienteRemitente(cliente_id,cliente,obj){
	
	var QueryString = "ACTIONCONTROLER=getDataClienteRemitente&cliente_id="+cliente_id;
	
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



function getDataPropietario(tercero_id,tercero,obj){
  
  var QueryString = "ACTIONCONTROLER=getDataPropietario&tercero_id="+tercero_id;
  
  $.ajax({
    url        : "RemesasMasivoClass.php?rand="+Math.random(),
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
    url        : "RemesasMasivoClass.php?rand="+Math.random(),
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

function setValorLiquidacion(){

  $("#tipo_liquidacion").change(function(){
										 
     if(this.value == 'P'){
		 
		var peso           =  $("#peso").val();
		var peso_neto      = ((peso * 1) * 0.001);
		var valor_unidad   = removeFormatCurrency($("#valor_unidad_facturar").val());
		var valor_facturar = (peso_neto * valor_unidad);
		
		if(!isNaN(valor_facturar)){
			
			$("#valor_facturar").val(setFormatCurrency(valor_facturar,2));		
		    document.getElementById('valor_unidad_facturar').readOnly = false;
		    document.getElementById('valor_facturar').readOnly        = true;			  			  			
			
		}	
		
		 
	 }else if(this.value == 'V'){
		 
			var peso_volumen   = (removeFormatCurrency($("#peso_volumen").val()) * 1);
			var valor_unidad   = removeFormatCurrency($("#valor_unidad_facturar").val());
			var valor_facturar = (peso_volumen * valor_unidad);
			
			if(!isNaN(valor_facturar)){ 
			
			  $("#valor_facturar").val(setFormatCurrency(valor_facturar,2));		 
		      document.getElementById('valor_unidad_facturar').readOnly = false;
		      document.getElementById('valor_facturar').readOnly        = true;			  			  
			  
			}	 
		 
	  }else if(this.value == 'C'){
		  
		      document.getElementById('valor_unidad_facturar').readOnly = true;
		      document.getElementById('valor_facturar').readOnly        = false;			  
              $("#valor_unidad_facturar").val("0");		  
  			  $("#valor_facturar").val("");
		  
		}										 
										 
  });
  
  $("#valor_unidad_facturar").keyup(function(){

      var tipo_liquidacion = document.getElementById('tipo_liquidacion').value;
					
     if(tipo_liquidacion == 'P'){
		 
		var peso_neto      = (($("#peso").val() * 1) * 0.001);
		var valor_unidad   = removeFormatCurrency(this.value);
		var valor_facturar = (peso_neto * valor_unidad);
		
		if(!isNaN(valor_facturar)){
			
			$("#valor_facturar").val(setFormatCurrency(valor_facturar,2));		
		    document.getElementById('valor_unidad_facturar').readOnly = false;
		    document.getElementById('valor_facturar').readOnly        = true;			  			  			
			
		}
		
		 
	 }else if(tipo_liquidacion == 'V'){
		 
			var peso_volumen   = (removeFormatCurrency($("#peso_volumen").val()) * 1);
			var valor_unidad   = removeFormatCurrency(this.value);
			var valor_facturar = (peso_volumen * valor_unidad);
			
			if(!isNaN(valor_facturar)){ 
			
			  $("#valor_facturar").val(setFormatCurrency(valor_facturar,2));		 
		      document.getElementById('valor_unidad_facturar').readOnly = false;
		      document.getElementById('valor_facturar').readOnly        = true;			  			  
			  
			}
		 
	  }else if(tipo_liquidacion == 'C'){
		  
		      document.getElementById('valor_unidad_facturar').readOnly = true;
		      document.getElementById('valor_facturar').readOnly        = false;			  
              $("#valor_unidad_facturar").val("0");		  
  			  $("#valor_facturar").val("");		  
		  
		}						
									
  });
	
}

function setRemesaComplemento(){
	
	$("#clase_remesa").change(function(){
			
	  var formulario = this.form;
	  
      if(this.value == 'CP'){
 	    Reset(formulario);
	    RemesasMasivoOnReset(formulario);		  
	    document.getElementById("numero_remesa_padre").disabled = false;
	    document.getElementById("clase_remesa").value           = 'CP';		
		$("#numero_remesa_padre").focus();
	  }else{									  
	    document.getElementById("numero_remesa_padre").disabled = true;		
		$("#numero_remesa_padre").val("");	  
		}
	  
    });
	
}

function getRemesaComplemento(){

  $("#numero_remesa_padre").blur(function(){

     var numero_remesa = this.value;
	 var forma         = this .form;
	 var QueryString   = "ACTIONCONTROLER=getRemesaComplemento&numero_remesa="+numero_remesa; 									  
	 	 
	 $.ajax({			
	   url        : "RemesasMasivoClass.php?rand="+Math.random(),		
	   data       : QueryString,
	   beforeSend : function(){
		 showDivLoading();
	   },
	   success    : function(resp){
		  
        try{
					
		  var data           = $.parseJSON(resp);
		  var remesa         = data[0]['remesa'];
		  var contacto_id    = remesa[0]['contacto_id'];		  		
		  var cliente_id     = remesa[0]['cliente_id'];		  		
		
		  setContactos(cliente_id,contacto_id);
		  
          setFormWithJSON(forma,remesa);
		  
  	      document.getElementById("numero_remesa_padre").disabled = false;	
		  document.getElementById("complemento").value = 1;
		  $("#numero_remesa_padre").val(numero_remesa);
		  
					  
		  if($('#guardar'))    $('#guardar').attr("disabled","");
	 	  if($('#actualizar')) $('#actualizar').attr("disabled","true");
		  if($('#borrar'))     $('#borrar').attr("disabled","true");
		  if($('#limpiar'))    $('#limpiar').attr("disabled","");

			
		}catch(e){
			alertJquery(resp,"Error :"+e);
		  }	  
		  
		 removeDivLoading(); 
		  
      


	   }			
	 });
     								  
										  
  });

}

function setRangoDesdeHasta(){

   $("#rango_desde").change(function(){
									 
      document.getElementById('rango_hasta').value = this.value;									 
									 
   });
	
}

function onclickCancellation(formulario){
	
	if($("#divAnulacion").is(":visible")){
	 
	   var formularioPrincipal = document.getElementById('RemesasMasivoForm');
	   var causal_anulacion_id = $("#causal_anulacion_id").val();
	   var observaciones       = $("#observaciones_anulacion").val();
	   
       if(ValidaRequeridos(formulario)){
	
	     var QueryString = "ACTIONCONTROLER=onclickCancellation&"+FormSerialize(formulario)+"&remesa_id="+$("#remesa_id").val();
		
	     $.ajax({
           url  : "RemesasMasivoClass.php",
	       data : QueryString,
	       beforeSend: function(){
			   showDivLoading();
	       },
	       success : function(response){
			 
             Reset(formularioPrincipal);	
             RemesasMasivoOnReset();					  
						  
		     if($.trim(response) == 'true'){
				 alertJquery('Remesa Anulada','Anulado Exitosamente');
			 }else{
				   alertJquery(response,'Inconsistencia Anulando');
			   }
			   
			 removeDivLoading();
             $("#divAnulacion").dialog('close');
			 
	       }
	   
	     });
	   
	   }
	
    }else{
		
	 var remesa_id = $("#remesa_id").val();
	 var estado    = document.getElementById("estado").value;
	 
	 if(parseInt(remesa_id) > 0){		

	    $("input[name=anular]").each(function(){ this.disabled = false; });
		
		$("#divAnulacion").dialog({
		  title: 'Anulacion Remesa',
		  width: 450,
		  height: 280,
		  closeOnEscape:true
		 });
			
	 }else{
		alertJquery('Debe Seleccionar primero una remesa','Anulacion');
	  }		
		
	}  
	  
	
}