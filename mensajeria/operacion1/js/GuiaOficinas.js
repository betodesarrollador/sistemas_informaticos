// JavaScript Document
var SolicitudId;

$(document).ready(function(){
	
    setOrdenCargue();	
    reloadListProductos();
	
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
		    title: 'Solicitud de Servicio para Guiar',
		    width: 950,
		    height: 395,
		    closeOnEscape:true,
		    show: 'scale',
		    hide: 'scale'
	    });
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
	
    $("#amparada_por").change(function(){
       setDataSeguroPoliza(this.value);									  							  
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
	  
	  if(ValidaRequeridos(formulario)){ 
	  
	    //$("#propietario_mercancia").val($("#propietario_mercancia_txt").val());
	    
	    if(this.id == 'guardar'){

			var QueryString = "ACTIONCONTROLER=onclickSave&"+FormSerialize(formulario);
			var numDetalle  = 0;
		  
			$("#tableGuia").find("*[name=remove]").each(function(){
														
				var Row  = this.parentNode.parentNode.parentNode;																
				
				$(Row).find("input").each(function(){
					QueryString += "&detalle_guia["+numDetalle+"]["+this.name+"]="+this.value;
				});									
														
				numDetalle++;											
																
			});
			
			if(parseInt(numDetalle) > 0){
			
			
				$.ajax({
				  url        : "GuiaClass.php?rand="+Math.random(),
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
				alertJquery("Debe ingresar almenos un producto","Validacion Guia");
				return false;
			  }

		}else{

				var QueryString = "ACTIONCONTROLER=onclickUpdate&"+FormSerialize(formulario);
				var numDetalle  = 0;
			  
				$("#tableGuia").find("*[name=remove]").each(function(){
															
					var Row  = this.parentNode.parentNode.parentNode;																
					
					$(Row).find("input").each(function(){
						QueryString += "&detalle_guia["+numDetalle+"]["+this.name+"]="+this.value;
					});									
															
					numDetalle++;											
																	
				});				
				
				if(parseInt(numDetalle) > 0){
				
				
					$.ajax({
					  url        : "GuiaClass.php?rand="+Math.random(),
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
					
				}else{
					alertJquery("Debe ingresar almenos un producto","Validacion Guia");
					return false;
				  }		
		  }
	  }											
											
   });
      
   recalculaValor();
   recalculaCantidad();
   recalculaPeso();   
   recalculaPesoVolumen();
      
   setGuiaComplemento();
   getGuiaComplemento();
   setRangoDesdeHasta();       
	
});

function closeDialog(){
	$("#divSolicitudGuia").dialog('close');
}

//funcion para cargar los datos desde BUSCAR
function setDataFormWithResponse(guia_id){
	
	var forma 		= document.forms[0];	
	var QueryString = "ACTIONCONTROLER=onclickFind&guia_id="+guia_id;
	
	$.ajax({
	  url        : "GuiaClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
		  showDivLoading();
	  },
	  success    : function(resp){
		  
        try{
			
		  var data           = $.parseJSON(resp);
		  var guia         = data[0]['guia'];
		  var detalle_guia = data[0]['detalle_guia'];
		  var contacto_id    = guia[0]['contacto_id'];		  		
		  var cliente_id     = guia[0]['cliente_id'];		  		
		  var clase_guia   = guia[0]['clase_guia'];		  
		  var estado         = guia[0]['estado'];
		  		
		  setContactos(cliente_id,contacto_id);
		  
          setFormWithJSON(forma,guia);
		  
		  if(clase_guia == 'CP'){	  
			document.getElementById('numero_guia_padre').disabled = true;
		  }else{	  			  
			 document.getElementById('numero_guia_padre').disabled = false;			  
			}
			
		   if(estado == 'PD' || estado == 'PC'){
		     if($('#actualizar')) document.getElementById('actualizar').disabled = false;			   
		   }else{
		       if($('#actualizar')) document.getElementById('actualizar').disabled = true;
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
			
	  if(detalle_guia){			
		  
		  var Tabla = document.getElementById('tableGuia');
		
		      $(Tabla.rows).each(function(){
			if(this.rowIndex > 0){
			      $(this).remove();
			}
		      });	
			
		  
		  for(var i = 0; i < detalle_guia.length; i++){
			  
			var newRow = insertaFilaAbajoClon(Tabla);
			var item   = parseInt(i);
		
            $(newRow).find("a[name=saveDetalleGuia]").html('<img name="remove" src="/velotax/framework/media/images/grid/close.png" />')				
			$(newRow).find("input[name=item]").val(item);    
			$(newRow).find("a[name=saveDetalleGuia]").focus(function(){
			  $(this).parent().addClass("focusSaveRow");
			});
			
			$(newRow).find("a[name=saveDetalleGuia]").blur(function(){
			  $(this).parent().removeClass("focusSaveRow");
			});	
			
			$(newRow).find("a[name=saveDetalleGuia]").click(function(){
			  removeRowProduct(this);
			});		  			
			
			for(var llave in detalle_guia[i]){
				
				$(newRow).find("input[name="+llave+"]").val(detalle_guia[i][llave]);				
			}			  
		  }		  
		  
		if(i < 7){
			  
			  var newRow = insertaFilaAbajoClon(Tabla);
			  var item   = parseInt(i) + 1;
		
			  $(newRow).find("input[name=item]").val(item);    
			  
			  $(newRow).find("a[name=saveDetalleGuia]").focus(function(){
			    $(this).parent().addClass("focusSaveRow");
			  });
			  
			  $(newRow).find("a[name=saveDetalleGuia]").blur(function(){
			    $(this).parent().removeClass("focusSaveRow");
			  });	
			  
			  $(newRow).find("a[name=saveDetalleGuia]").click(function(){
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
      }
    });
}

function GuiaOnSave(formulario,resp){
	
  var guia_numero = parseInt(resp);

  if(guia_numero > 0){
	
	alertJquery("<span style='font-weight:bold;font-size:14px'>GUIA : </span><span style='color:red;font-weight:bold;font-size:20px'>"+guia_numero+"</span>","Guiar");
	
	Reset(formulario);
	GuiaOnReset();
	
 }else{
	alertJquery(resp,"Error : ");
   }		
}

function GuiaOnUpdate(formulario,resp){
	
	if($.trim(resp) == 'true'){
		
		alertJquery("Se Actualizo de Forma Exitosa");
		Reset(formulario);
		GuiaOnReset();
		updateGridGuia();
		updateRangoDesde();
	
	}else{
		alertJquery(resp);
	}
}


function GuiaOnDelete(formulario,resp){
	Reset(formulario);
	GuiaOnReset();
	updateGridGuia();
	updateRangoDesde();	
	alertJquery(resp);
}

function GuiaOnReset(){
	
    var Tabla = document.getElementById('tableGuia');

	document.getElementById("clase_guia").value           = 'NN';	
	document.getElementById("numero_guia_padre").value    = '';		
	document.getElementById("numero_guia_padre").disabled = true;	
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
	  
    $(newRow).find("a[name=saveDetalleGuia]").focus(function(){
      $(this).parent().addClass("focusSaveRow");
    });
    
    $(newRow).find("a[name=saveDetalleGuia]").blur(function(){
      $(this).parent().removeClass("focusSaveRow");
    });	
    
    $(newRow).find("a[name=saveDetalleGuia]").click(function(){
      addRowProduct(this);
    }); 

	resetContactos();
	clearFind();
	
//    document.getElementById('naturaleza_id').value  = 1;
//    document.getElementById('empaque_id').value     = 1;
//    document.getElementById('medida_id').value      = 77;	
	
	$("#fecha_guia").val($("#fecha").val());
	$("#oficina_id").val($("#oficina_id_static").val());	
//	$("#amparada_por").val("E");			
//	$("#aseguradora_id").val($("#aseguradora_id_static").val());		
//	$("#numero_poliza").val($("#numero_poliza_static").val());	
//    document.getElementById('aseguradora_id').disabled = true;
	
	$('#guardar').attr("disabled","");
	$('#actualizar').attr("disabled","true");
	$('#borrar').attr("disabled","true");
	$('#limpiar').attr("disabled","");	
	
    recalculaValor();
    recalculaCantidad();
    recalculaPeso();   
    recalculaPesoVolumen();	
	
	 $("input[name=valor],input[name=peso_volumen]").each(function(){
																				   
	   if(this.id == 'valor'){																					   
		 setFormatCurrencyInput(this,2);																																	
	   }else{
			setFormatCurrencyInput(this,3);																																				
		  }		  
	 });
}

function beforePrint(formulario,url,title,width,height){

    var QueryString = "ACTIONCONTROLER=updateRangoDesde";
	
	$.ajax({
          url        : "GuiaClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
	    showDivLoading();
	  },
	  success    : function(resp){
	    
	    $("#rango_desde").replaceWith(resp);
		setRangoDesdeHasta();
	    
	    var QueryString = "ACTIONCONTROLER=updateRangoHasta";
	
	    $.ajax({
             url        : "GuiaClass.php?rand="+Math.random(),
	     data       : QueryString,
	     beforeSend : function(){
	     },
	     success    : function(resp){
	       
		  $("#rango_hasta").replaceWith(resp);
		  
		  $("#rangoImp").dialog({
			  title: 'Impresion de Guia',
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
	var url = "GuiaClass.php?ACTIONCONTROLER=onclickPrint&rango_desde="+rango_desde+"&rango_hasta="+rango_hasta+"&formato="+formato+"&random="+Math.random();
	
	printCancel();
	
    onclickPrint(null,url,"Impresion Guias","950","600");		
}

function printCancel(){
	$("#rangoImp").dialog('close');	
	removeDivLoading();
}

function updateRangoDesde(){
	
	var QueryString = "ACTIONCONTROLER=updateRangoDesde";
	
	$.ajax({
      url        : "GuiaClass.php?rand="+Math.random(),
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
          url        : "GuiaClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
	  },
	  success    : function(resp){
		  $("#rango_hasta").replaceWith(resp);
      }
    });		
}

/*function setContactos(cliente_id,contacto_id){
	
	var QueryString = "ACTIONCONTROLER=setContactos&cliente_id="+cliente_id+"&contacto_id="+contacto_id;
	
	$.ajax({
		url     : "GuiaClass.php?rand="+Math.random(),
		data    : QueryString,
		success : function(response){
			$("#contacto_id").parent().html(response);
		}
	});
}*/

function cargaDatos(response){
	
  var formulario = document.getElementById('GuiaForm');
//  setContactos(response[0]['solicitud'][0]['cliente_id'],response[0]['solicitud'][0]['contacto_id']);    
  
  var solicitud          = response[0]['solicitud'];
  var detalles_solicitud = response[0]['detalle_solicitud'];
  var numDetalles        = detalles_solicitud.length - 1;
  
  $("textarea[id=observaciones]").val($.trim(solicitud[0]['origen']));
      	  
  setFormWithJSON(document.getElementById('GuiaForm'),solicitud,'true');
  
  var Tabla = document.getElementById('tableGuia');
  
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
    
    $(newRow).find("a[name=saveDetalleGuia]").html('<img name="remove" src="/velotax/framework/media/images/grid/close.png" />')

    $(newRow).find("input[name=item]").val(i);    
            
    $(newRow).find("a[name=saveDetalleGuia]").focus(function(){
      $(this).parent().addClass("focusSaveRow");
    });
      
    $(newRow).find("a[name=saveDetalleGuia]").blur(function(){
      $(this).parent().removeClass("focusSaveRow");
    });	
      
    $(newRow).find("a[name=saveDetalleGuia]").click(function(){	
      removeRowProduct(this);		
    });

       
    for(llave in detalles_solicitud[i]){
      
      if(llave == 'peso'){
	    totalPeso += (detalles_solicitud[i][llave] * 1);
        $(newRow).find("[name="+llave+"]").val(detalles_solicitud[i][llave]);		
      }else if(llave == 'valor'){
	      totalValor += (detalles_solicitud[i][llave] * 1);
          $(newRow).find("[name="+llave+"]").val(setFormatCurrency(detalles_solicitud[i][llave],2));		  
       }else if(llave == 'cantidad'){
	       totalCantidad += (detalles_solicitud[i][llave] * 1);
           $(newRow).find("[name="+llave+"]").val(detalles_solicitud[i][llave]);				   
        }else if(llave == 'peso_volumen'){
	         totalPesoVolumen += (detalles_solicitud[i][llave] * 1);
             $(newRow).find("[name="+llave+"]").val(setFormatCurrency(detalles_solicitud[i][llave],3));		  			 
	      }else{
               $(newRow).find("[name="+llave+"]").val(detalles_solicitud[i][llave]);		  
		    }                 
    }    
  }  

  $("#valor").val(setFormatCurrency(totalValor,2));
  $("#cantidad").val(totalCantidad);
  $("#peso").val(totalPeso);
  $("#peso_volumen").val(setFormatCurrency(totalPesoVolumen,3));  
    
  if(i < maxProductosGuia){
    
    var newRow = insertaFilaAbajoClon(Tabla);
    var item   = parseInt(i) + parseInt(1);

    $(newRow).find("input[name=item]").val(item);    
	  
    $(newRow).find("a[name=saveDetalleGuia]").focus(function(){
      $(this).parent().addClass("focusSaveRow");
    });
    
    $(newRow).find("a[name=saveDetalleGuia]").blur(function(){
      $(this).parent().removeClass("focusSaveRow");
    });	
    
    $(newRow).find("a[name=saveDetalleGuia]").click(function(){
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
  recalculaCantidad();
  recalculaPeso();   
  recalculaPesoVolumen();  
  
}

function resetContactos(){
	$("#contacto_id option").each(function(){
		if(this.value != 'NULL') $(this).remove();
	});
}

function separaCodigoDescripcion(){
		
	var producto            = $('#producto_id option:selected').text().split("-");
	var descripcion_empresa = producto[0];

	$('#descripcion_producto').val(descripcion_empresa);
}

function updateGridGuia(){
	$("#refresh_QUERYGRID_guia").click();
}

function setDataSeguroPoliza(amparada_por){

   /* $("#aseguradora_id,#numero_poliza").removeClass("requerido");		  
	
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
		  
		 }*/	
}

var maxProductosGuia = 7;

function addRowProduct(obj){  	
       
      var Tabla    = obj.parentNode.parentNode.parentNode;	                  
      var Fila     = obj.parentNode.parentNode;
      var item     = 1;
      var tam      = Tabla.rows.length - 1;
      var actmayor = 0;
      var cont     = 0;
      
      if(validaRequeridosDetalle(obj,Fila)){      
      
	  if(tam == maxProductosGuia){
		$(Fila).find("a[name=saveDetalleGuia]").each(function(){
		  
		  var newLink2           = document.createElement("a");
		      newLink2.href      = "javascript:void(0)";
		      newLink2.name      = "saveDetalleGuia";
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
		
	  $(newRow).find("a[name=saveDetalleGuia]").focus(function(){
	    $(this).parent().addClass("focusSaveRow");
	  });
	  
	  $(newRow).find("a[name=saveDetalleGuia]").blur(function(){
	    $(this).parent().removeClass("focusSaveRow");
	  });	
	  
	  $(newRow).find("a[name=saveDetalleGuia]").click(function(){
	    addRowProduct(this);
	  });      
	  
	  
	  var newLink           = document.createElement("a");
	      newLink.href      = "javascript:void(0)";
	      newLink.name      = "saveDetalleGuia";
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
		  
	      if(rowsNow == maxProductosGuia){
		
		$(newRow).find("a[name=saveDetalleGuia]").each(function(){
		  
		  var newLink2           = document.createElement("a");
		      newLink2.href      = "javascript:void(0)";
		      newLink2.name      = "saveDetalleGuia";
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
   recalculaCantidad();
   recalculaPeso();   
   recalculaPesoVolumen();
   
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
  
  if(rowsNow == maxProductosGuia && numAdd == 0){      

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
      
      $(newRow).find("a[name=saveDetalleGuia]").focus(function(){
	$(this).parent().addClass("focusSaveRow");
      });
      
      $(newRow).find("a[name=saveDetalleGuia]").blur(function(){
	$(this).parent().removeClass("focusSaveRow");
      });	
      
      $(newRow).find("a[name=saveDetalleGuia]").click(function(){
	addRowProduct(this);
      });  
  }
  
  $(obj.parentNode.parentNode).remove();    
  
  var valorTotal = 0;  
  var Tabla      = document.getElementById('tableGuia');

  $(Tabla).find("input[name=cantidad]").each(function(){ 															  
    var valor = removeFormatCurrency(this.value);															  
    valorTotal += (valor * 1); 	
  });	   
  
  $("#cantidad").val(valorTotal);
     
  var pesoTotal = 0;
  var Tabla     = document.getElementById('tableGuia');

  $(Tabla).find("input[name=peso]").each(function(){ 
        var valor = removeFormatCurrency(this.value);															  
        pesoTotal += (valor * 1) 
  });	   
  
  $("#peso").val(pesoTotal);
    
  var valorTotal = 0;
  var Tabla      = document.getElementById('tableGuia');

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
	 url        : "GuiaClass.php?rand="+Math.random(),
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
	 url        : "GuiaMasivoClass.php?rand="+Math.random(),
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
	 url        : "GuiaMasivoClass.php?rand="+Math.random(),
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

function recalculaCantidad(){
   
  $("input[name=cantidad_detalle]").blur(function(){

      var valorTotal = 0;
      var Tabla = document.getElementById('tableGuia');
    
      $(Tabla).find("input[name=cantidad]").each(function(){ 
        var valor = this.value;  																	  
        valorTotal += (valor * 1) 
	  });	   
      	  
      $("#cantidad").val(valorTotal);
    
  });
  
}

function recalculaPeso(){
   
  $("input[name=peso]").blur(function(){

      var pesoTotal = 0;
      var Tabla = document.getElementById('tableGuia');
    
      $(Tabla).find("input[name=peso]").each(function(){ 
        var valor = this.value;  																  															
        pesoTotal += (valor * 1) 
	   });	   
      
      $("#peso").val(pesoTotal);
    
  });
    
}

function recalculaPesoVolumen(){
   
  $("input[name=peso_volumen]").blur(function(){

      var pesoTotal = 0;
      var Tabla = document.getElementById('tableGuia');
    
      $(Tabla).find("input[name=peso_volumen]").each(function(){ 
        var valor = removeFormatCurrency(this.value);  																  
        pesoTotal += (valor * 1) 
	  });	   
      	  
      $("#peso_volumen").val(setFormatCurrency(pesoTotal,3));
    
  });    
}

function recalculaValor(){ 
  
  $("input[name=valor]").blur(function(){

      var valorTotal = 0;
      var Tabla = document.getElementById('tableGuia');
    
      $(Tabla).find("input[name=valor]").each(function(){ 
        var valor = removeFormatCurrency(this.value);  														  
        valorTotal += (valor * 1);
	  });	   
      	  
      $("#valor").val(setFormatCurrency(valorTotal,2));
    
  });   
}

function getDataPropietario(tercero_id,tercero,obj){
  
  var QueryString = "ACTIONCONTROLER=getDataPropietario&tercero_id="+tercero_id;
  
  $.ajax({
    url        : "GuiaClass.php?rand="+Math.random(),
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
    url        : "GuiaClass.php?rand="+Math.random(),
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

function setGuiaComplemento(){
	
	$("#clase_guia").change(function(){
			
	  var formulario = this.form;
	  
      if(this.value == 'CP'){
 	    Reset(formulario);
	    GuiaOnReset(formulario);		  
	    document.getElementById("numero_guia_padre").disabled = false;
	    document.getElementById("clase_guia").value           = 'CP';		
		$("#numero_guia_padre").focus();
	  }else{									  
	    document.getElementById("numero_guia_padre").disabled = true;		
		$("#numero_guia_padre").val("");	  
		}
	  
    });
	
}

function getGuiaComplemento(){

  $("#numero_guia_padre").blur(function(){

     var formulario    = this.form;
     var numero_guia = this.value;
	 var forma         = this .form;
	 var QueryString   = "ACTIONCONTROLER=getGuiaComplemento&numero_guia="+numero_guia; 									  
	 	 
     if(numero_guia > 0){		 
		 
	 $.ajax({			
	   url        : "GuiaClass.php?rand="+Math.random(),		
	   data       : QueryString,
	   beforeSend : function(){
		 showDivLoading();
	   },
	   success    : function(resp){
		  
        try{
					
		  var data           = $.parseJSON(resp);
		  var guia         = data[0]['guia'];
		  var detalle_guia = data[0]['detalle_guia'];
		  var contacto_id    = guia[0]['contacto_id'];		  		
		  var cliente_id     = guia[0]['cliente_id'];	
		  var estado         = guia[0]['estado'];
		  		  		  						  
		  if(isNaN(parseInt(guia[0]['numero_guia_padre']))){
              alertJquery("<span style='font-weight:bold;font-size:14px'>No existe la GUIA : </span><span style='color:red;font-weight:bold;font-size:20px'>"+numero_guia+"</span>","Guiar Complementos");			  
			  Reset(formulario);
		  	  GuiaOnReset();
			  return false;
		  }
						
//		  setContactos(cliente_id,contacto_id);
		  
          setFormWithJSON(forma,guia);
		  
 		  document.getElementById('clase_guia').value = 'CP';
		  
		   if(estado == 'PD'){
		     if($('#actualizar')) document.getElementById('actualizar').disabled = false;			   
		   }else{
		       if($('#actualizar')) document.getElementById('actualizar').disabled = true;
			 }						
			
			if(estado == 'PD' || estado == 'PC' || estado == 'MF'){
              if(document.getElementById('anular')) document.getElementById('anular').disabled = false;				
			}else{
                  if(document.getElementById('anular')) document.getElementById('anular').disabled = true;				
			  }
			  
		   if(estado == 'AN'){
		     if($('#importSolcitud')) document.getElementById('importSolcitud').disabled = true;			   
		     if($('#guardar'))        document.getElementById('guardar').disabled        = true;			   			 			 
		   }else{
		       if($('#importSolcitud')) document.getElementById('importSolcitud').disabled = false;
		       if($('#guardar'))        document.getElementById('guardar').disabled        = false;			   			 			 			   
			 }			  
		  
		  $("#numero_guia_padre").val(numero_guia);
		  
		  var Tabla = document.getElementById('tableGuia');
		
		  $(Tabla.rows).each(function(){
									  
			if(this.rowIndex > 0){
			      $(this).remove();
			}
			
		  });	
			
						
		  for(var i = 0; i < detalle_guia.length; i++){
		  
			var newRow = insertaFilaAbajoClon(Tabla);
			var item   = parseInt(i);
		
            $(newRow).find("a[name=saveDetalleGuia]").html('<img name="remove" src="/velotax/framework/media/images/grid/close.png" />')		
		
			$(newRow).find("input[name=item]").val(item);    
			  
			$(newRow).find("a[name=saveDetalleGuia]").focus(function(){
			  $(this).parent().addClass("focusSaveRow");
			});
			
			$(newRow).find("a[name=saveDetalleGuia]").blur(function(){
			  $(this).parent().removeClass("focusSaveRow");
			});	
			
			$(newRow).find("a[name=saveDetalleGuia]").click(function(){
			  removeRowProduct(this);
			});		  
									
			for(var llave in detalle_guia[i]){				
			  $(newRow).find("input[name="+llave+"]").val(detalle_guia[i][llave]);
			}
			  
		  }		  
		  
		if(i < 7){
			  
			  var newRow = insertaFilaAbajoClon(Tabla);
			  var item   = parseInt(i) + 1;
		
			  $(newRow).find("input[name=item]").val(item);    
			  
			  $(newRow).find("a[name=saveDetalleGuia]").focus(function(){
			    $(this).parent().addClass("focusSaveRow");
			  });
			  
			  $(newRow).find("a[name=saveDetalleGuia]").blur(function(){
			    $(this).parent().removeClass("focusSaveRow");
			  });	
			  
			  $(newRow).find("a[name=saveDetalleGuia]").click(function(){
			    addRowProduct(this);
			  }); 			  
			  
			  
		  }
		  
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
					  
	 	  if($('#actualizar')) $('#actualizar').attr("disabled","true");
		  if($('#borrar'))     $('#borrar').attr("disabled","true");
		  if($('#limpiar'))    $('#limpiar').attr("disabled","");

			
		}catch(e){
			alertJquery(resp,"Error :"+e);
		  }	  
		  
		 removeDivLoading(); 

	   }			
	 });
	 
   }     								  
										  
  });

}

function setRangoDesdeHasta(){

   $("#rango_desde").change(function(){
									 
      document.getElementById('rango_hasta').value = this.value;									 
									 
   });
	
}

function onclickCancellation(formulario){
	
	if($("#divAnulacion").is(":visible")){
	 
	   var formularioPrincipal = document.getElementById('GuiaForm');
	   var causal_anulacion_id = $("#causal_anulacion_id").val();
	   var observaciones       = $("#observaciones_anulacion").val();
	   
       if(ValidaRequeridos(formulario)){
	
	     var QueryString = "ACTIONCONTROLER=onclickCancellation&"+FormSerialize(formulario)+"&guia_id="+$("#guia_id").val();
		
	     $.ajax({
           url  : "GuiaClass.php",
	       data : QueryString,
	       beforeSend: function(){
			   showDivLoading();
	       },
	       success : function(response){
			 
             Reset(formularioPrincipal);	
             GuiaOnReset();					  
						  
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
		
	 var guia_id = $("#guia_id").val();
	 var estado    = document.getElementById("estado").value;
	 
	 if(parseInt(guia_id) > 0){		

	    $("input[name=anular]").each(function(){ this.disabled = false; });
		
		$("#divAnulacion").dialog({
		  title: 'Anulacion Guia',
		  width: 450,
		  height: 280,
		  closeOnEscape:true
		 });
			
	 }else{
		alertJquery('Debe Seleccionar primero una guia','Anulacion');
	  }		
		
	}  
	  
	
}


function setObservaciones(id,text,obj){
	
   var origen = text.split("-");
	
   $("textarea[id=observaciones]").val($.trim(origen[0]));	
	
}


function reloadListProductos(){
  
   $("#reloadListProductos").click(function(){
			
	  var QueryString = "ACTIONCONTROLER=reloadListProductos";		
			
      $.ajax({
		url  : "GuiaClass.php?rand="+Math.random(),
		data : QueryString,
		beforeSend : function(){
			showDivLoading();
		},
		success : function(resp){

               var opciones = $.parseJSON(resp);
			   
			   $("#producto_id option").each(function(){
                   if(this.value != 'NULL'){
					   $(this).remove();
				   }
               });
			   
			   
			   for(var i = 0; i < opciones.length; i++){

			      $("#producto_id").append("<option value ='"+opciones[i]['value']+"'>"+opciones[i]['text']+"</option>");
			   
			   }
			   
			  removeDivLoading();
		}
		
	  });											
											
   });

}

function setOrdenCargue(){
		
  $("#orden_despacho").blur(function(){

     var orden_despacho = this.value;
	 
	 $("input[name=guia_cliente]").each(function(){
												 
         var guia_cliente = $.trim(this.value);												 
		 
		 if(!guia_cliente.length > 0){
			 this.value = orden_despacho;
		 }
												 
     });
									 
  });
	
}