// JavaScript Document
var CambioFechas;
$(document).ready(function(){
   	
    /**
    * cargamos el grid con las solicitudes de servicio
    */
   $("#iframeSolicitudGuia").attr("src","SolicServToGuiaPaqueteoClass.php");	    
    $("#importSolcitud").click(function(){		
        var formulario = document.getElementById('CambioFechasForm');		
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
	
    $("a[name=saveDetalleGuia]").click(function(){
      addRowProduct(this);
    });		
    /*$("#print_out").click(function(){
       printOut();								   
    });	
    $("#print_cancel").click(function(){
       printCancel();									  
    });	*/
   $("#actualizar").click(function(){
	  var formulario = this.form;	  
	  if(ValidaRequeridos(formulario)){ 	  
    
	    if(this.id == 'actualizar'){ 
			var QueryString = "ACTIONCONTROLER=onclickUpdate&"+FormSerialize(formulario); 
			$.ajax({
				  
			  url        : "CambioFechasClass.php?rand="+Math.random(),
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
		}/*else{
				var QueryString = "ACTIONCONTROLER=onclickUpdate&"+FormSerialize(formulario);
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
			    
		    }*/
	   }							
   });

});



function closeDialog(){
	$("#divSolicitudGuia").dialog('close');
}
//funcion para cargar los datos desde BUSCAR
function setDataFormWithResponse(guia_id){	
	var forma 		= document.forms[0];	
	var QueryString = "ACTIONCONTROLER=onclickFind&guia_id="+guia_id;	
	$.ajax({
	  url        : "CambioFechasClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
		  showDivLoading();
	  },
	  success    : function(resp){		  
        try{			
		  var data         = $.parseJSON(resp);
		  var guia         = data[0].guia;
		  var estado       = guia[0].estado_mensajeria_id;		  		

		  setFormWithJSON(forma,guia);
		  
			if(estado == 1 || estado == 4 || estado == 7){
				/*if($('#guardar'))    $('#guardar').attr("disabled","true");*/
				if($('#actualizar')) $('#actualizar').attr("disabled","");
				/*if($('#anular')) $('#anular').attr("disabled","");
				if($('#borrar'))     $('#borrar').attr("disabled","");
				if($('#limpiar'))    $('#limpiar').attr("disabled","");
				$("#tipo_envio_id").removeClass("obligatorio");*/
			}else{
				/*if($('#guardar'))    $('#guardar').attr("disabled","true");*/
				if($('#actualizar')) $('#actualizar').attr("disabled","");
				/*if($('#borrar'))     $('#borrar').attr("disabled","");
				if($('#limpiar'))    $('#limpiar').attr("disabled","");*/
			}
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
		  
       }	  
    });
}

/*function GuiaOnSave(formulario,resp){
  var guia_numero = parseInt(resp);
  if(guia_numero > 0){
	alertJquery("<span style='font-weight:bold;font-size:14px'>GUIA : </span><span style='color:red;font-weight:bold;font-size:20px'>"+guia_numero+"</span>","Guia");	
	Reset(formulario);
	GuiaOnReset();	
 }else{
	alertJquery(resp,"Error : ");
   }
}*/

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
	document.getElementById('estado_mensajeria_id').value= '1';
	document.getElementById('fecha_guia').value='';
		
    //if(document.getElementById('anular')) document.getElementById('anular').disabled = true;							  
	
	clearFind();
	
	
	//$("#fecha_guia").val($("#fecha_guia").val());
	$("#oficina_id").val($("#oficina_id_static").val());	
	
	/*$('#guardar').attr("disabled","");*/
	$('#actualizar').attr("disabled","true");
	/*$('#borrar').attr("disabled","true");
	$('#limpiar').attr("disabled","");*/	
	/* document.getElementById('estado_mensajeria_id').disabled = true;	
    recalculaValor();
	document.getElementById('fecha_guia').disabled = true;	
    recalculaValor();*/

	
	/* $("input[name=valor],input[name=peso_volumen]").each(function(){
																				   
	   if(this.id == 'valor'){																					   
		 setFormatCurrencyInput(this,2);																																	
	   }else{
			setFormatCurrencyInput(this,3);																																				
		  }		  
	 });
	 chequear();*/
}

/*function beforePrint(formulario,url,title,width,height){
	document.getElementById("rango_desde").style.width="120px";
	document.getElementById("rango_desde").style.height="16px";	
	document.getElementById("rango_hasta").style.width="120px";
	document.getElementById("rango_hasta").style.height="16px";
	document.getElementById("guias").style.width="120px";
	document.getElementById("guias").style.height="16px";	

	document.getElementById("orden_servicio").style.width="120px";
	document.getElementById("orden_servicio").style.height="16px";	
	document.getElementById("fecha_guia_crea").style.width="120px";
	document.getElementById("fecha_guia_crea").style.height="16px";	

	document.getElementById("rango_desde").style.fontSize="14px";
	document.getElementById("rango_hasta").style.fontSize="14px";
	document.getElementById("guias").style.fontSize="14px";

	document.getElementById("orden_servicio").style.fontSize="14px";
	document.getElementById("fecha_guia_crea").style.fontSize="14px";



  $("#rangoImp").dialog({
	  title: 'Impresion de Guias, Puede filtrar por Guias, Orden o Fecha',
	  width: 700,
	  height: 200,
		  closeOnEscape:true,
		  show: 'scale',
		  hide: 'scale'
  });			  
	
   return false;
}*/

/*function printOut(){		
	var rango_desde = document.getElementById("rango_desde").value;
	var rango_hasta = document.getElementById("rango_hasta").value;
	var guias = document.getElementById("guias").value;
	var formato     = document.getElementById("formato").value;
	var orden_servicio     = document.getElementById("orden_servicio").value;
	var fecha_guia_crea     = document.getElementById("fecha_guia_crea").value;
	var url = "GuiaClass.php?ACTIONCONTROLER=onclickPrint&guias="+guias+"&rango_desde="+rango_desde+"&rango_hasta="+rango_hasta+"&formato="+formato+"&orden_servicio="+orden_servicio+"&fecha_guia_crea="+fecha_guia_crea+"&random="+Math.random();	
	
	if( (parseInt(guias)!='' || (parseInt(orden_servicio)>0) || (parseInt(rango_hasta)>0 || parseInt(rango_desde)>0) || (fecha_guia_crea!='' && fecha_guia_crea!='null')) && formato!='NULL'  ){
		printCancel();
		onclickPrint(null,url,"Impresion Guia","950","600");		
	}else{
		alertJquery("Por favor indique algunos de los items: Guias(Separadas por coma ','), Orden o Fecha","Validacion Impresion");
	}
}

function printCancel(){
	$("#rangoImp").dialog('close');	
	document.getElementById("rango_desde").style.width="120px";
	document.getElementById("rango_desde").style.height="16px";	
	document.getElementById("rango_hasta").style.width="120px";
	document.getElementById("rango_hasta").style.height="16px";	
	document.getElementById("guias").style.width="120px";
	document.getElementById("guias").style.height="16px";
	removeDivLoading();
}*/



function cargaDatos(response){	
  var formulario = document.getElementById('CambioFechasForm');
  var solicitud          = response[0].solicitud;
  var detalles_solicitud = response[0].detalle_solicitud;
  var numDetalles        = detalles_solicitud.length - 1;  
  $("textarea[id=observaciones]").val($.trim(solicitud[0].origen));      	  
  setFormWithJSON(document.getElementById('CambioFechasForm'),solicitud,'true');  
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

}


/*function getOptionsTipoEnvio(){

	var TipoServicioId   = $("#tipo_servicio_mensajeria_id").val();
	var QueryString = "ACTIONCONTROLER=getOptionsTipoEnvio&tipo_servicio_mensajeria_id="+TipoServicioId;

	if(TipoServicioId != 'NULL'){
	
		$.ajax({
			url     : "CambioFechasClass.php",
			data    : QueryString,
			success : function(response){
				$("#tipo_envio_id").parent().html(response);
			}
		});
	}
}*/

function separaCodigoDescripcion(){}

function updateGridGuia(){
	$("#refresh_QUERYGRID_guia").click();
}

//function setDataSeguroPoliza(amparada_por){}

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

/*function onclickCancellation(){
	// if($('#anula')) $('#anula').attr("disabled","");	
	var causal_anulacion_id = $("#causal_anulacion_id").val();
	var observacion_anulacion = $("#observacion_anulacion").val();
	if (causal_anulacion_id > 0 && observacion_anulacion !== '') {
		var guia_id = document.getElementById('guia_id').value;
		var QueryString = "ACTIONCONTROLER=onclickCancellation&guia_id="+guia_id+"&causal_anulacion_id="+causal_anulacion_id+"&observacion_anulacion="+observacion_anulacion;
		$.ajax({
			url			: "GuiaClass.php?rand="+Math.random(),
			data		: QueryString,
			beforeSend	: function(){
				showDivLoading();
			},
			success    : function(resp){
				$("#divAnulacion").dialog('close');
				var formulario = document.getElementById('CambioFechasForm');
				Reset(formulario);
				GuiaOnReset();
				try{
					if (resp==='true') {
						alertJquery("La guia fue correctamente anulada","Anulacion");
					}else{
						alertJquery("Ocurrio una inconsistencia al intentar anular la guia","Error Anulacion");
					}
				}catch(e){
				alertJquery(resp,"Error :"+e);
				}
				removeDivLoading();
			}
		});
	}
}

$("#anular").click(function(){
});
function divAnular(){
	$("#divAnulacion").dialog({
		title: 'Anulacion de guias',
		width: 700,
		height: 300,
		closeOnEscape:true,
		show: 'scale',
		hide: 'scale'
	});
}*/