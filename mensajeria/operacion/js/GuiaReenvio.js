// JavaScript Document
var SolicitudId;

$(document).ready(function(){	
    setOrdenCargue();	
	$("#divAnulacion").css("display","none");	
    /**
    * cargamos el grid con las solicitudes de servicio
    */
    $("#iframeSolicitudGuiaReenvio").attr("src","SolicServToGuiaReenvioPaqueteoClass.php");	    
    $("#importSolcitud").click(function(){		
        var formulario = document.getElementById('GuiaReenvioForm');		
        Reset(formulario);	
        GuiaReenvioOnReset();				
	    $("#divSolicitudGuiaReenvio").dialog({
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
	
    $("a[name=saveDetalleGuiaReenvio]").click(function(){
      addRowProduct(this);
    });		
    $("#print_out").click(function(){
       printOut();								   
    });	
    $("#print_cancel").click(function(){
       printCancel();									  
    });	
/*   $("#amparada_por").change(function(){
       setDataSeguroPoliza(this.value);									  							  
    });	*/
    $("#saveDetallesGuiaReenvio").click(function(){
      window.frames[1].saveDetallesGuiaReenvio();
    });    
    $("#deleteDetallesGuiaReenvio").click(function(){
	window.frames[1].deleteDetallesGuiaReenvio();
    });	
   $("a[name=saveDetalleGuiaReenvio]").focus(function(){    
       $(this).parent().addClass("focusSaveRow");
    });	
   $("a[name=saveDetalleGuiaReenvio]").blur(function(){
       $(this).parent().removeClass("focusSaveRow");
   });	   
   $("#guardar,#actualizar").click(function(){
	  var formulario = this.form;	  
	  if(ValidaRequeridos(formulario)){ 	  
	    //$("#propietario_mercancia").val($("#propietario_mercancia_txt").val());	    
	    if(this.id == 'guardar'){ 
			var QueryString = "ACTIONCONTROLER=onclickSave&"+FormSerialize(formulario);
			var numDetalle  = 0;
			$("#tableGuiaReenvio").find("*[name=remove]").each(function(){	
					
			  var Row  = this.parentNode.parentNode.parentNode;	
				$(Row).find("input").each(function(){
					QueryString += "&detalle_guia["+numDetalle+"]["+this.name+"]="+this.value;
				});	
				
				numDetalle++;								
			});			
			if(parseInt(numDetalle) > 0){	
				$.ajax({
				  url        : "GuiaReenvioClass.php?rand="+Math.random(),
				  data       : QueryString,
				  beforeSend : function(){
				    showDivLoading();
				  },
				  success    : function(resp){				   
					  updateGridGuiaReenvio();
					  removeDivLoading();
					  GuiaReenvioOnSave(formulario,resp);					  
				  }
				});				
			}else{
				alertJquery("Debe ingresar al menos un producto","Validacion GuiaReenvio");
				return false;
			  }
		}else{
				var QueryString = "ACTIONCONTROLER=onclickUpdate&"+FormSerialize(formulario);
				var numDetalle  = 0;			  
				$("#tableGuiaReenvio").find("*[name=remove]").each(function(){															
					var Row  = this.parentNode.parentNode.parentNode;
					$(Row).find("input").each(function(){
						QueryString += "&detalle_guia["+numDetalle+"]["+this.name+"]="+this.value;
					});							
					numDetalle++;								
				});				
				if(parseInt(numDetalle) > 0){
					$.ajax({
					  url        : "GuiaReenvioClass.php?rand="+Math.random(),
					  data       : QueryString,
					  beforeSend : function(){
						showDivLoading();
					  },
					  success    : function(resp){
						  updateGridGuiaReenvio();
						  removeDivLoading();
					      GuiaReenvioOnUpdate(formulario,resp);						  
					  }
				   });
			    }
		    }
	   }							
   });

	$("#tipo_servicio_mensajeria_id").change(function(){	  
	  if(this.value != ''){
		   recalculaValor();
	  }
	 });	

	// $("#tipo_envio_id").change(function(){	  
	//   if(this.value != ''){
	// 	   recalculaValor();
	//   }
	//  });

	$("#origen").blur(function(){	  
	   recalculaValor();
	 });

	$("#destino").blur(function(){	  
	   recalculaValor();
	 });

	$("#destino_hidden").change(function(){	  
	   recalculaValor();
	 });
	
	$("#valor_otros").blur(function(){	  
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
   setGuiaPadre();
});


function closeDialog(){
	$("#divSolicitudGuiaReenvio").dialog('close');
}
//funcion para cargar los datos desde BUSCAR
function setDataFormWithResponse(guia_id){	
	var forma 		= document.forms[0];	
	var QueryString = "ACTIONCONTROLER=onclickFind&guia_id="+guia_id;	
	$.ajax({
	  url        : "GuiaReenvioClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
		  showDivLoading();
	  },
	  success    : function(resp){		  
        try{			
		  var data         = $.parseJSON(resp);
		  var guia         = data[0]['guia'];
		  var detalle_guia = data[0]['detalle_guia'];
		  var clase_guia   = guia[0]['clase_guia'];		  
		  var estado       = guia[0]['estado'];		  		
//		  setContactos(cliente_id,contacto_id);
		  setFormWithJSON(forma,guia);
		  
/*		  if(clase_guia == 'CP'){	  
			document.getElementById('id_padre').disabled = true;
		  }else{	  			  
			 document.getElementById('id_padre').disabled = false;			  
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
			 }	*/			  
			
	  if(detalle_guia){			  
		  var Tabla = document.getElementById('tableGuiaReenvio');		
		      $(Tabla.rows).each(function(){
			if(this.rowIndex > 0){
			      $(this).remove();
			}
	   });				  
		  for(var i = 0; i < detalle_guia.length; i++){			  
			var newRow = insertaFilaAbajoClon(Tabla);
			var item   = parseInt(i);		
            $(newRow).find("a[name=saveDetalleGuiaReenvio]").html('<img name="remove" src="/velotax/framework/media/images/grid/close.png" />')				
			$(newRow).find("input[name=item]").val(item);    
			$(newRow).find("a[name=saveDetalleGuiaReenvio]").focus(function(){
			  $(this).parent().addClass("focusSaveRow");
			});
			
			$(newRow).find("a[name=saveDetalleGuiaReenvio]").blur(function(){
			  $(this).parent().removeClass("focusSaveRow");
			});	
			
			$(newRow).find("a[name=saveDetalleGuiaReenvio]").click(function(){
			  removeRowProduct(this);
			});					
			
			for(var llave in detalle_guia[i]){				
				$(newRow).find("input[name="+llave+"]").val(detalle_guia[i][llave]);				
			}			  
		  }				  

         }					  
		  if($('#guardar'))    $('#guardar').attr("disabled","");
		  if($('#borrar'))     $('#borrar').attr("disabled","true");
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
         	 
		 var guia_id = $("#guia_id").val();
		  
		 if(guia_id > 0){		  
	       //document.getElementById('rango_desde').value = guia_id;	  
	       //document.getElementById('rango_hasta').value = guia_id;			  		  
		 }	
       }	  
    });
}
//funcion para cargar los datos desde GUIA PADRE
function setGuiaPadre(){
	$("#numero_guia_padre").blur(function(){
		var formulario				= this.form;
		var numero_guia_padre		= this.value;
		var forma					= this.form;
		var QueryString				= "ACTIONCONTROLER=getGuiaPadre&numero_guia_padre="+numero_guia_padre;
		if(numero_guia_padre > 0){
			$.ajax({
				url			: "GuiaReenvioClass.php?rand="+Math.random(),
				data		: QueryString,
				beforeSend	: function(){
					showDivLoading();
				},
				success		: function(resp){
					try{
						var data			= $.parseJSON(resp);
						// alertJquery(guia_id_padre,"Valor");
						if(isNaN(parseInt(data[0]['numero_guia_padre']))){
							alertJquery("<span style='font-weight:bold;font-size:14px'>No existe la GUIA en guias Devueltas: </span><span style='color:red;font-weight:bold;font-size:20px'>"+numero_guia+"</span>","Guia Reenvios");
							Reset(formulario);
							GuiaReenvioOnReset();
							return false;
						}
						setFormWithJSON(forma,data);
						$("#numero_guia_padre").val(numero_guia_padre);
						if($('#actualizar'))	$('#actualizar').attr("disabled","true");
						if($('#borrar'))		$('#borrar').attr("disabled","true");
						if($('#limpiar'))		$('#limpiar').attr("disabled","");
					}catch(e){
						alertJquery(resp,"Error :"+e);
					}
					removeDivLoading(); 
				}
			});
		}
	});	
}

function GuiaReenvioOnSave(formulario,resp){
  var guia_numero = parseInt(resp);
  if(guia_numero > 0){
	alertJquery("<span style='font-weight:bold;font-size:14px'>GUIA : </span><span style='color:red;font-weight:bold;font-size:20px'>"+guia_numero+"</span>","GuiaReenvio");	
	Reset(formulario);
	GuiaReenvioOnReset();	
 }else{
	alertJquery(resp,"Error : ");
   }
}

function GuiaReenvioOnUpdate(formulario,resp){	
	if($.trim(resp) == 'true'){		
		alertJquery("Se Actualizo de Forma Exitosa");
		Reset(formulario);
		GuiaReenvioOnReset();
		updateGridGuiaReenvio();
		//updateRangoDesde();	
	}else{
		alertJquery(resp);
	}
}

function GuiaReenvioOnDelete(formulario,resp){
	Reset(formulario);
	GuiaReenvioOnReset();
	updateGridGuiaReenvio();
	//updateRangoDesde();	
	alertJquery(resp);
}

function GuiaReenvioOnReset(){	
    var Tabla = document.getElementById('tableGuiaReenvio');
	document.getElementById('estado_mensajeria_id').value= '1';
	document.getElementById('forma_pago_mensajeria_id').value='2';
		
    if(document.getElementById('anular')) document.getElementById('anular').disabled = true;							  
   /* $(Tabla.rows).each(function(){
	  if(this.rowIndex > 0){
	    $(this).remove();
 	  }
    });	
	
    var newRow = insertaFilaAbajoClon(Tabla);
    var item   = 1;

    $(newRow).find("input[name=item]").val(item);    
	  
    $(newRow).find("a[name=saveDetalleGuiaReenvio]").focus(function(){
      $(this).parent().addClass("focusSaveRow");
    });
    
    $(newRow).find("a[name=saveDetalleGuiaReenvio]").blur(function(){
      $(this).parent().removeClass("focusSaveRow");
    });	
    
    $(newRow).find("a[name=saveDetalleGuiaReenvio]").click(function(){
      addRowProduct(this);
    }); */
	
	clearFind();
	
	
	$("#fecha_guia").val($("#fecha").val());
	$("#oficina_id").val($("#oficina_id_static").val());	
	
	$('#guardar').attr("disabled","");
	$('#actualizar').attr("disabled","true");
	$('#borrar').attr("disabled","true");
	$('#limpiar').attr("disabled","");	
	 document.getElementById('estado_mensajeria_id').disabled = true;	
    // recalculaValor();

	
	 $("input[name=valor],input[name=peso_volumen]").each(function(){
																				   
	   if(this.id == 'valor'){																					   
		 setFormatCurrencyInput(this,2);																																	
	   }else{
			setFormatCurrencyInput(this,3);																																				
		  }		  
	 });
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
	  title: 'Impresion de Guia Reenvios, Puede filtrar por rango, Orden o Fecha',
	  width: 700,
	  height: 180,
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
	var url = "GuiaReenvioClass.php?ACTIONCONTROLER=onclickPrint&rango_desde="+rango_desde+"&rango_hasta="+rango_hasta+"&formato="+formato+"&orden_servicio="+orden_servicio+"&fecha_guia_crea="+fecha_guia_crea+"&random="+Math.random();	
	
	if( ((parseInt(rango_desde)>0 && parseInt(rango_hasta)>0) || (parseInt(orden_servicio)>0) || (fecha_guia_crea!='' && fecha_guia_crea!='null')) && formato!='NULL'  ){
		printCancel();
		onclickPrint(null,url,"Impresion GuiaReenvio","950","600");		
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

function updateRangoDesde(){
	/*
	var QueryString = "ACTIONCONTROLER=updateRangoDesde";	
	$.ajax({
      url        : "GuiaReenvioClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
	  },
	  success    : function(resp){		  
		  $("#rango_desde").replaceWith(resp);			  
		  var guia_id = $("#guia_id").val();		  
		  if(guia_id > 0){		  
	  	    document.getElementById('rango_desde').value = $("#guia_id").val();		  
		  }		  		  
		  updateRangoHasta();	 	
       }	  
   });	*/
}

function updateRangoHasta(){	
	/*
	var QueryString = "ACTIONCONTROLER=updateRangoHasta";	
	$.ajax({
          url        : "GuiaReenvioClass.php?rand="+Math.random(),
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
	*/
}

/*function setContactos(cliente_id,contacto_id){	
	var QueryString = "ACTIONCONTROLER=setContactos&cliente_id="+cliente_id+"&contacto_id="+contacto_id;	
	$.ajax({
		url     : "GuiaReenvioClass.php?rand="+Math.random(),
		data    : QueryString,
		success : function(response){
			$("#contacto_id").parent().html(response);
		}
	});
}*/

function cargaDatos(response){	
  var formulario = document.getElementById('GuiaReenvioForm');
//  setContactos(response[0]['solicitud'][0]['cliente_id'],response[0]['solicitud'][0]['contacto_id']);  
  var solicitud          = response[0]['solicitud'];
  var detalles_solicitud = response[0]['detalle_solicitud'];
  var numDetalles        = detalles_solicitud.length - 1;  
  $("textarea[id=observaciones]").val($.trim(solicitud[0]['origen']));      	  
  setFormWithJSON(document.getElementById('GuiaReenvioForm'),solicitud,'true');  
  var Tabla = document.getElementById('tableGuiaReenvio');  
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
    $(newRow).find("a[name=saveDetalleGuiaReenvio]").html('<img name="remove" src="/velotax/framework/media/images/grid/close.png" />')
    $(newRow).find("input[name=item]").val(i);                

    $(newRow).find("a[name=saveDetalleGuiaReenvio]").focus(function(){
      $(this).parent().addClass("focusSaveRow");
    });
      
    $(newRow).find("a[name=saveDetalleGuiaReenvio]").blur(function(){
      $(this).parent().removeClass("focusSaveRow");
    });	
      
    $(newRow).find("a[name=saveDetalleGuiaReenvio]").click(function(){	
      removeRowProduct(this);		
    });
       
    for(llave in detalles_solicitud[i]){      
      if(llave == 'peso'){
		if(detalles_solicitud[i][llave]){
	     totalPeso += (detalles_solicitud[i][llave] * 1);
         $(newRow).find("[name="+llave+"]").val(detalles_solicitud[i][llave]);					
		}
      }else if(llave == 'valor'){
		if(detalles_solicitud[i][llave]){		  
	      totalValor += (detalles_solicitud[i][llave] * 1);
          $(newRow).find("[name="+llave+"]").val(setFormatCurrency(detalles_solicitud[i][llave],2));		  
		}
       }else if(llave == 'cantidad'){
		  if(detalles_solicitud[i][llave]){		   
	       totalCantidad += (detalles_solicitud[i][llave] * 1);
           $(newRow).find("[name="+llave+"]").val(detalles_solicitud[i][llave]);				   
		  }
        }else if(llave == 'peso_volumen'){
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
    
  if(i < maxProductosGuiaReenvio){    
    var newRow = insertaFilaAbajoClon(Tabla);
    var item   = parseInt(i) + parseInt(1);
    $(newRow).find("input[name=item]").val(item);  	  
    
	$(newRow).find("a[name=saveDetalleGuiaReenvio]").focus(function(){
      $(this).parent().addClass("focusSaveRow");
    });
    
    $(newRow).find("a[name=saveDetalleGuiaReenvio]").blur(function(){
      $(this).parent().removeClass("focusSaveRow");
    });	
    
    $(newRow).find("a[name=saveDetalleGuiaReenvio]").click(function(){
      addRowProduct(this);
    });      
  }
  
 $("input[name=valor],input[name=peso_volumen]").each(function(){																			   
   if(this.id == 'valor'){																					   
	 setFormatCurrencyInput(this,2);																																	
   }else{
		setFormatCurrencyInput(this,3);																																				
	  }	  
 });  
  closeDialog();    
  recalculaValor();

}


// function getOptionsTipoEnvio(){

// 	var TipoServicioId   = $("#tipo_servicio_mensajeria_id").val();
// 	var QueryString = "ACTIONCONTROLER=getOptionsTipoEnvio&tipo_servicio_mensajeria_id="+TipoServicioId;

// 	if(TipoServicioId != 'NULL'){
	
// 		$.ajax({
// 			url     : "GuiaReenvioClass.php",
// 			data    : QueryString,
// 			success : function(response){
// 				$("#tipo_envio_id").parent().html(response);
// 			}
// 		});
// 	}
// }

function separaCodigoDescripcion(){}

function updateGridGuiaReenvio(){
	$("#refresh_QUERYGRID_guia").click();
}

//function setDataSeguroPoliza(amparada_por){}

var maxProductosGuiaReenvio = 7;

function addRowProduct(obj){         
      var Tabla    = obj.parentNode.parentNode.parentNode;	                  
      var Fila     = obj.parentNode.parentNode;
      var item     = 1;
      var tam      = Tabla.rows.length - 1;
      var actmayor = 0;
      var cont     = 0;      
      if(validaRequeridosDetalle(obj,Fila)){        
	  if(tam == maxProductosGuiaReenvio){
		$(Fila).find("a[name=saveDetalleGuiaReenvio]").each(function(){		  
		  var newLink2           = document.createElement("a");
		      newLink2.href      = "javascript:void(0)";
		      newLink2.name      = "saveDetalleGuiaReenvio";
		      newLink2.innerHTML = '<img name="remove" src="/velotax/framework/media/images/grid/close.png" />';
		      
		      $(newLink2).focus(function(){
			$(this).parent().addClass("focusSaveRow");
		      });
		      
		      $(newLink2).blur(function(){
			$(this).parent().removeClass("focusSaveRow");
		      });		  
		      
		      $(newLink2).click(function(){
		      removeRowProduct(this);
		      });
		  
		      var celda = this.parentNode;
		  
		      $(this).remove();
		      $(celda).html(newLink2);  		  
		}); 
	    return false;
	  }

	  var vector   = new Array(tam);	  
	  $(Tabla).find("input[name=item]").each(function(){	    
	    vector[cont] = this.value;
	    if( parseInt(vector[cont]) > parseInt(actmayor)) actmayor = vector[cont];	    
	  });
	  item       = parseInt(actmayor) + parseInt(1);   
	  
	  var newRow = insertaFilaAbajoClon(Tabla);	 
	  $(newRow).find("input[name=item]").val(item);    
		
	  $(newRow).find("a[name=saveDetalleGuiaReenvio]").focus(function(){
	    $(this).parent().addClass("focusSaveRow");
	  });
	  
	  $(newRow).find("a[name=saveDetalleGuiaReenvio]").blur(function(){
	    $(this).parent().removeClass("focusSaveRow");
	  });	
	  
	  $(newRow).find("a[name=saveDetalleGuiaReenvio]").click(function(){
	    addRowProduct(this);
	  });    
	  
	  var newLink           = document.createElement("a");
	      newLink.href      = "javascript:void(0)";
	      newLink.name      = "saveDetalleGuiaReenvio";
	      newLink.innerHTML = '<img name="remove" src="/velotax/framework/media/images/grid/close.png" />';
	      
	      $(newLink).focus(function(){
		    $(this).parent().addClass("focusSaveRow");
	      });
	      
	      $(newLink).blur(function(){
		    $(this).parent().removeClass("focusSaveRow");
	      });		  
	      
	      $(newLink).click(function(){
	      removeRowProduct(this);
	      });
	  
	      $(obj).parent().removeClass("focusSaveRow");      
	      
	      var celda = obj.parentNode;	      
	      $(obj).remove();	      
	      $(celda).html(newLink);
	      
		  var rowsNow = (parseInt(Tabla.rows.length) - 1);		  
	      if(rowsNow == maxProductosGuiaReenvio){
		
		$(newRow).find("a[name=saveDetalleGuiaReenvio]").each(function(){		  
		  var newLink2           = document.createElement("a");
		      newLink2.href      = "javascript:void(0)";
		      newLink2.name      = "saveDetalleGuiaReenvio";
		      newLink2.innerHTML = '<img name="remove" src="/velotax/framework/media/images/grid/close.png" />';
		      
		      $(newLink2).focus(function(){
			$(this).parent().addClass("focusSaveRow");
		      });
		      
		      $(newLink2).blur(function(){
			$(this).parent().removeClass("focusSaveRow");
		      });		  
		      
		      $(newLink2).click(function(){
		      removeRowProduct(this);
		      });
		  
		      var celda = this.parentNode;
		  
		      $(this).remove();
		      $(celda).html(newLink2); 		  
		}); 
	      }	  
      }

   recalculaValor();
   
 $("input[name=valor],input[name=peso_volumen]").each(function(){																			   
   if(this.id == 'valor'){																					   
	 setFormatCurrencyInput(this,2);																																	
   }else{
		setFormatCurrencyInput(this,3);																																				
	  }	  
 });	
	}

function removeRowProduct(obj){
  
  var Tabla  = obj.parentNode.parentNode.parentNode;
  var numAdd = 0;
  
  $(Tabla).find("img[name=add]").each(function(){
    numAdd++;
  });
  
  var rowsNow = (parseInt(Tabla.rows.length) - 1); 
  
  if(rowsNow == maxProductosGuiaReenvio && numAdd == 0){     
      var item     = 1;
      var tam      = Tabla.rows.length;
      var actmayor = 0;
      var cont     = 0;

      var vector   = new Array(tam);
      
      $(Tabla).find("input[name=item]").each(function(){	
	vector[cont] = this.value;
	if( parseInt(vector[cont]) > parseInt(actmayor)) actmayor = vector[cont];	
      });

      item       = parseInt(actmayor) + parseInt(1);                
      var newRow = insertaFilaAbajoClon(Tabla);

      $(newRow).find("input[name=item]").val(item);    
      
      $(newRow).find("a[name=saveDetalleGuiaReenvio]").focus(function(){
	  $(this).parent().addClass("focusSaveRow");
      });
      
      $(newRow).find("a[name=saveDetalleGuiaReenvio]").blur(function(){
	  $(this).parent().removeClass("focusSaveRow");
      });	
      
      $(newRow).find("a[name=saveDetalleGuiaReenvio]").click(function(){
	  addRowProduct(this);
      }); 
  }
  
  $(obj.parentNode.parentNode).remove();    
  
  var valorTotal = 0;  
  var Tabla      = document.getElementById('tableGuiaReenvio');

  $(Tabla).find("input[name=cantidad]").each(function(){ 															  
    var valor = removeFormatCurrency(this.value);															  
    valorTotal += (valor * 1); 	
  });	   
  
  $("#cantidad").val(valorTotal);
     
  var pesoTotal = 0;
  var Tabla     = document.getElementById('tableGuiaReenvio');

  $(Tabla).find("input[name=peso]").each(function(){ 
        var valor = removeFormatCurrency(this.value);															  
        pesoTotal += (valor * 1) 
  });	   
  
  $("#peso").val(pesoTotal);
    
  var valorTotal = 0;
  var Tabla      = document.getElementById('tableGuiaReenvio');

  $(Tabla).find("input[name=valor]").each(function(){ 
    var valor = removeFormatCurrency(this.value);   
    valorTotal += (valor * 1) 
  });	   
  
  $("#valor").val(setFormatCurrency(valorTotal));    
  
 $("input[name=valor],input[name=peso_volumen]").each(function(){
																			   
   if(this.id == 'valor'){																					   
	 setFormatCurrencyInput(this,2);																																	
   }else{
		setFormatCurrencyInput(this,3);																																				
	  }	  
 });   
}

function getDataClienteRemitente(cliente_id,cliente,obj){
	
  var QueryString = "ACTIONCONTROLER=getDataClienteRemitente&cliente_id="+cliente_id;  
   $.ajax({
	 url        : "GuiaReenvioClass.php?rand="+Math.random(),
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
		  $("#tipo_identificacion_remitente_id").val(dataResp[0]['tipo_identificacion_id']);				 				 				 				            
		  $("#direccion_remitente").val(dataResp[0]['direccion']);				 				 				 
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
	 url        : "GuiaReenvioClass.php?rand="+Math.random(),
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

// function validaTipoEnvio(valor){
	
// 	    var valuetipo_envio_id = valor;
				
// 		if( valuetipo_envio_id != 'NULL'){			
				
// 				var QueryString = "ACTIONCONTROLER=validaTipoEnvio&tipo_envio_id="+ valuetipo_envio_id;
// 				$.ajax({
// 					url     : "GuiaReenvioClass.php?rand="+Math.random(),
// 					data    : QueryString,
// 					success : function(response){
												
// 						var tipo_servicio_mensajeria_id = parseInt(response);
												
// 					    if(tipo_servicio_mensajeria_id > 0){
// 						  $("#tipo_servicio_mensajeria_id").val(tipo_servicio_mensajeria_id);
// 						  setDataFormWithResponse();
							 
// 							if($('#guardar')) $('#guardar').attr("disabled","");
// 							if($('#actualizar')) $('#actualizar').attr("disabled","true");
// 							if($('#borrar'))     $('#borrar').attr("disabled","true");
// 							if($('#limpiar'))    $('#limpiar').attr("disabled","");							 
							 							 					 
// 						  }								
// 					  }
// 				});
// 		}
// }

function setDataDestinatario(destinatario_id,destinatario,input){		   		   		   
	var QueryString = "ACTIONCONTROLER=getDataRemitenteDestinatario&remitente_destinatario_id="+destinatario_id;	
   $.ajax({
	 url        : "GuiaReenvioClass.php?rand="+Math.random(),
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
		$("#peso_volumen").val(Math.ceil(pesovol)); 
	}
	
}
// function recalculaValor(){

// 	var tipo_envio_id= document.getElementById('tipo_envio_id').value;
// 	var tipo_servicio_mensajeria_id = $("#tipo_servicio_mensajeria_id").val();
// 	var origen_id = $("#origen_hidden").val();
// 	var destino_id = $("#destino_hidden").val();
// 	var peso = $("#peso").val();
// 	var valor = removeFormatCurrency($("#valor").val());
// 	var valor_otros = removeFormatCurrency($("#valor_otros").val());
	
// 	if(parseInt(tipo_envio_id)>0 && parseInt(tipo_servicio_mensajeria_id)>0 && origen_id!='NULL' && origen_id!='' && destino_id!='NULL' && destino_id!='' && parseFloat(peso)>0 && parseFloat(valor)>0   ){
		
// 		var QueryString = "ACTIONCONTROLER=CalcularTarifa&tipo_envio_id="+tipo_envio_id+"&tipo_servicio_mensajeria_id="+tipo_servicio_mensajeria_id
// 		+"&origen_id="+origen_id+"&destino_id="+destino_id+"&peso="+peso+"&valor="+valor+"&valor_otros="+valor_otros;	
// 	   $.ajax({
// 		 url        : "GuiaReenvioClass.php?rand="+Math.random(),
// 		 data       : QueryString,
// 		 beforeSend : function(){
// 			 showDivLoading();
// 		 },
// 		 success    : function(resp){		 
// 			 try{			 
// 				 var dataResp = $.parseJSON(resp);	
				 
// 				 $("#valor_flete").val(dataResp['valor_flete']);
// 				 $("#valor_seguro").val(dataResp['valor_declarado']);				 
// 				 $("#valor_total").val(dataResp['total']);		
// 				 $("#valor_manejo").val(dataResp['valor_manejo']);		
// 			 }catch(e){
// 				   alertJquery(resp,"Error :"+e);
// 				}		 
// 			 removeDivLoading();
// 		 }	
// 	   });
		
// 	}


// }

/*function getDataPropietario(tercero_id,tercero,obj){  
  var QueryString = "ACTIONCONTROLER=getDataPropietario&tercero_id="+tercero_id;  
  $.ajax({
    url        : "GuiaReenvioClass.php?rand="+Math.random(),
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
}*/

/*function getDataClientePropietario(cliente_id,obj){  
   var QueryString = "ACTIONCONTROLER=getDataClientePropietario&cliente_id="+cliente_id;  
  $.ajax({
    url        : "GuiaReenvioClass.php?rand="+Math.random(),
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
}*/



function setRangoDesdeHasta(){
   $("#rango_desde").change(function(){									 
      document.getElementById('rango_hasta').value = this.value;
   });	
}

function onclickCancellation(formulario){}
function setObservaciones(id,text,obj){}
function setOrdenCargue(){}
function setValorLiquidacion(){}