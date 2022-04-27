// JavaScript Document
var SolicitudId;
$(document).ready(function(){	
   	
	$("#divAnulacion").css("display","none");	
    /**
    * cargamos el grid con las solicitudes de servicio
    */
    $("#iframeSolicitudGuia").attr("src","SolicServToGuiaPaqueteoClass.php");	    
    $("#importSolcitud").click(function(){		
        var formulario = document.getElementById('GuiaInterconForm');		
        Reset(formulario);	
        GuiaInterconOnReset();				
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
	
    $("a[name=saveDetalleGuiaIntercon]").click(function(){
      addRowProduct(this);
    });		
    $("#saveDetallesGuiaIntercon").click(function(){
      window.frames[1].saveDetallesGuiaIntercon();
    });    
    $("#deleteDetallesGuiaIntercon").click(function(){
	window.frames[1].deleteDetallesGuiaIntercon();
    });	
   $("a[name=saveDetalleGuiaIntercon]").focus(function(){    
       $(this).parent().addClass("focusSaveRow");
    });	
   $("a[name=saveDetalleGuiaIntercon]").blur(function(){
       $(this).parent().removeClass("focusSaveRow");
   });	   
   $("#guardar,#actualizar").click(function(){
	  var formulario = this.form;	  
	  if(ValidaRequeridos(formulario)){ 	  
    
	    if(this.id == 'guardar'){ 
			var QueryString = "ACTIONCONTROLER=onclickSave&"+FormSerialize(formulario);
			$.ajax({
			  url        : "GuiaInterconClass.php?rand="+Math.random(),
			  data       : QueryString,
			  beforeSend : function(){
				showDivLoading();
			  },
			  success    : function(resp){				   
				  updateGridGuiaIntercon();
				  removeDivLoading();
				  GuiaInterconOnSave(formulario,resp);					  
			  }
			});				
		}else{
				var QueryString = "ACTIONCONTROLER=onclickUpdate&"+FormSerialize(formulario);
				$.ajax({
				  url        : "GuiaInterconClass.php?rand="+Math.random(),
				  data       : QueryString,
				  beforeSend : function(){
					showDivLoading();
				  },
				  success    : function(resp){
					  updateGridGuiaIntercon();
					  removeDivLoading();
					  GuiaInterconOnUpdate(formulario,resp);						  
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

	//para chequear si es una oficina de cliente
	var QueryString = "ACTIONCONTROLER=chequear";

	$.ajax({
	  url        : "GuiaInterconClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
		showDivLoading();
	  },
	  success    : function(resp){
		  if(resp=='false'){

			if($('#origen'))    $('#origen').attr("disabled","");			  			
			if($('#tipo_identificacion_remitente_id'))    $('#tipo_identificacion_remitente_id').attr("disabled","");					  						
			if($('#remitente'))    $('#remitente').attr("disabled","");				  									
			if($('#doc_remitente'))    $('#doc_remitente').attr("disabled","");				
			if($('#direccion_remitente'))    $('#direccion_remitente').attr("disabled","");		
			if($('#telefono_remitente'))    $('#telefono_remitente').attr("disabled","");					

		  }else{
		  	var data         = $.parseJSON(resp);  
			if(parseInt(data[0].cliente_id)>0){			
				if($('#origen_hidden'))    $('#origen_hidden').val(data[0].origen_id);
				//if($('#cliente_id'))    $('#cliente_id').val(data[0].cliente_id);
				if($('#origen'))    $('#origen').val(data[0].origen);			  			
				if($('#tipo_identificacion_remitente_id'))    $('#tipo_identificacion_remitente_id').val(data[0].tipo_identificacion_remitente_id);			  						
				if($('#remitente'))    $('#remitente').val(data[0].remitente);			  									
				if($('#doc_remitente'))    $('#doc_remitente').val(data[0].doc_remitente);		
				if($('#direccion_remitente'))    $('#direccion_remitente').val(data[0].direccion_remitente);	
				if($('#telefono_remitente'))    $('#telefono_remitente').val(data[0].telefono_remitente);	
				
	
				if($('#origen'))    $('#origen').attr("disabled","true");			  			
				if($('#tipo_identificacion_remitente_id'))    $('#tipo_identificacion_remitente_id').attr("disabled","true");					  						
				if($('#remitente'))    $('#remitente').attr("disabled","true");				  									
				if($('#doc_remitente'))    $('#doc_remitente').attr("disabled","true");				
				if($('#direccion_remitente'))    $('#direccion_remitente').attr("disabled","true");		
				if($('#telefono_remitente'))    $('#telefono_remitente').attr("disabled","true");					
			}else{
				if($('#origen'))    $('#origen').attr("disabled","");			  			
				if($('#tipo_identificacion_remitente_id'))    $('#tipo_identificacion_remitente_id').attr("disabled","");					  						
				if($('#remitente'))    $('#remitente').attr("disabled","");				  									
				if($('#doc_remitente'))    $('#doc_remitente').attr("disabled","");				
				if($('#direccion_remitente'))    $('#direccion_remitente').attr("disabled","");		
				if($('#telefono_remitente'))    $('#telefono_remitente').attr("disabled","");					
				
			}
			
		  }
		   removeDivLoading(); 
		  
	  }
   });
	//para chequear si es una oficina de cliente fin

});

function chequear(){

	//para chequear si es una oficina de cliente
	var QueryString = "ACTIONCONTROLER=chequear";

	$.ajax({
	  url        : "GuiaInterconClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
		showDivLoading();
	  },
	  success    : function(resp){
		  if(resp=='false'){

			if($('#origen'))    $('#origen').attr("disabled","");			  			
			if($('#tipo_identificacion_remitente_id'))    $('#tipo_identificacion_remitente_id').attr("disabled","");					  						
			if($('#remitente'))    $('#remitente').attr("disabled","");				  									
			if($('#doc_remitente'))    $('#doc_remitente').attr("disabled","");				
			if($('#direccion_remitente'))    $('#direccion_remitente').attr("disabled","");		
			if($('#telefono_remitente'))    $('#telefono_remitente').attr("disabled","");					

		  }else{
		  	var data         = $.parseJSON(resp);  
			if(parseInt(data[0].cliente_id)>0){			
				if($('#origen_hidden'))    $('#origen_hidden').val(data[0].origen_id);
				if($('#cliente_id'))    $('#cliente_id').val(data[0].cliente_id);
				if($('#origen'))    $('#origen').val(data[0].origen);			  			
				if($('#tipo_identificacion_remitente_id'))    $('#tipo_identificacion_remitente_id').val(data[0].tipo_identificacion_remitente_id);			  						
				if($('#remitente'))    $('#remitente').val(data[0].remitente);			  									
				if($('#doc_remitente'))    $('#doc_remitente').val(data[0].doc_remitente);		
				if($('#direccion_remitente'))    $('#direccion_remitente').val(data[0].direccion_remitente);	
				if($('#telefono_remitente'))    $('#telefono_remitente').val(data[0].telefono_remitente);	
				
	
				if($('#origen'))    $('#origen').attr("disabled","true");			  			
				if($('#tipo_identificacion_remitente_id'))    $('#tipo_identificacion_remitente_id').attr("disabled","true");					  						
				if($('#remitente'))    $('#remitente').attr("disabled","true");				  									
				if($('#doc_remitente'))    $('#doc_remitente').attr("disabled","true");				
				if($('#direccion_remitente'))    $('#direccion_remitente').attr("disabled","true");		
				if($('#telefono_remitente'))    $('#telefono_remitente').attr("disabled","true");					
			}else{
				if($('#origen'))    $('#origen').attr("disabled","");			  			
				if($('#tipo_identificacion_remitente_id'))    $('#tipo_identificacion_remitente_id').attr("disabled","");					  						
				if($('#remitente'))    $('#remitente').attr("disabled","");				  									
				if($('#doc_remitente'))    $('#doc_remitente').attr("disabled","");				
				if($('#direccion_remitente'))    $('#direccion_remitente').attr("disabled","");		
				if($('#telefono_remitente'))    $('#telefono_remitente').attr("disabled","");					
				
			}
			
		  }
		   removeDivLoading(); 
		  
	  }
   });
	//para chequear si es una oficina de cliente fin
}

function closeDialog(){
	$("#divSolicitudGuiaIntercon").dialog('close');
}
//funcion para cargar los datos desde BUSCAR
function setDataFormWithResponse(guia_interconexion_id){	
	var forma 		= document.forms[0];	
	var QueryString = "ACTIONCONTROLER=onclickFind&guia_interconexion_id="+guia_interconexion_id;	
	$.ajax({
	  url        : "GuiaInterconClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
		  showDivLoading();
	  },
	  success    : function(resp){		  
        try{			
		  var data         = $.parseJSON(resp);
		  var guia_interconexion         = data[0].guia_interconexion;
		  var clase_guia   = guia_interconexion[0].clase_guia;		  
		  var estado       = guia_interconexion[0].estado_mensajeria_id;		  		

		  setFormWithJSON(forma,guia_interconexion);
		  

			if(estado == 1 || estado == 4 || estado == 7){
				if($('#guardar'))    $('#guardar').attr("disabled","true");
				if($('#actualizar')) $('#actualizar').attr("disabled","");
				if($('#anular')) $('#anular').attr("disabled","");
				if($('#borrar'))     $('#borrar').attr("disabled","");
				if($('#limpiar'))    $('#limpiar').attr("disabled","");
				$("#tipo_envio_id").removeClass("obligatorio");
			}else{
				if($('#guardar'))    $('#guardar').attr("disabled","true");
				if($('#actualizar')) $('#actualizar').attr("disabled","true");
				if($('#borrar'))     $('#borrar').attr("disabled","");
				if($('#limpiar'))    $('#limpiar').attr("disabled","");
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
         	 
		 var guia_interconexion_id = $("#guia_interconexion_id").val();
		  
       }	  
    });
}

function GuiaInterconOnSave(formulario,resp){
  var guia_numero = parseInt(resp);
  if(guia_numero > 0){
	alertJquery("<span style='font-weight:bold;font-size:14px'>GUIA : </span><span style='color:red;font-weight:bold;font-size:20px'>"+guia_numero+"</span>","GuiaIntercon");	
	Reset(formulario);
	GuiaInterconOnReset();	
 }else{
	alertJquery(resp,"Error : ");
   }
}

function GuiaInterconOnUpdate(formulario,resp){	
	if($.trim(resp) == 'true'){		
		alertJquery("Se Actualizo de Forma Exitosa");
		Reset(formulario);
		GuiaInterconOnReset();
		updateGridGuiaIntercon();
	}else{
		alertJquery(resp);
	}
}

function GuiaInterconOnDelete(formulario,resp){
	Reset(formulario);
	GuiaInterconOnReset();
	updateGridGuiaIntercon();
	alertJquery(resp);
}

function GuiaInterconOnReset(){	
    var Tabla = document.getElementById('tableGuiaIntercon');
	document.getElementById('estado_mensajeria_id').value= '1';
	document.getElementById('forma_pago_mensajeria_id').value='2';
		
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

function cargaDatos(response){	
  var formulario = document.getElementById('GuiaInterconForm');
  var solicitud          = response[0].solicitud;
  var detalles_solicitud = response[0].detalle_solicitud;
  var numDetalles        = detalles_solicitud.length - 1;  
  $("textarea[id=observaciones]").val($.trim(solicitud[0].origen));      	  
  setFormWithJSON(document.getElementById('GuiaInterconForm'),solicitud,'true');  
  var Tabla = document.getElementById('tableGuiaIntercon');  
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
    $(newRow).find("a[name=saveDetalleGuiaIntercon]").html('<img name="remove" src="/velotax/framework/media/images/grid/close.png" />')
    $(newRow).find("input[name=item]").val(i);                

    $(newRow).find("a[name=saveDetalleGuiaIntercon]").focus(function(){
      $(this).parent().addClass("focusSaveRow");
    });
      
    $(newRow).find("a[name=saveDetalleGuiaIntercon]").blur(function(){
      $(this).parent().removeClass("focusSaveRow");
    });	
      
    $(newRow).find("a[name=saveDetalleGuiaIntercon]").click(function(){	
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
    
  if(i < maxProductosGuiaIntercon){    
    var newRow = insertaFilaAbajoClon(Tabla);
    var item   = parseInt(i) + parseInt(1);
    $(newRow).find("input[name=item]").val(item);  	  
    
	$(newRow).find("a[name=saveDetalleGuiaIntercon]").focus(function(){
      $(this).parent().addClass("focusSaveRow");
    });
    
    $(newRow).find("a[name=saveDetalleGuiaIntercon]").blur(function(){
      $(this).parent().removeClass("focusSaveRow");
    });	
    
    $(newRow).find("a[name=saveDetalleGuiaIntercon]").click(function(){
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


function getOptionsTipoEnvio(){

	var TipoServicioId   = $("#tipo_servicio_mensajeria_id").val();
	var QueryString = "ACTIONCONTROLER=getOptionsTipoEnvio&tipo_servicio_mensajeria_id="+TipoServicioId;

	if(TipoServicioId != 'NULL'){
	
		$.ajax({
			url     : "GuiaInterconClass.php",
			data    : QueryString,
			success : function(response){
				$("#tipo_envio_id").parent().html(response);
			}
		});
	}
}

function separaCodigoDescripcion(){}

function updateGridGuiaIntercon(){
	$("#refresh_QUERYGRID_guia").click();
}

//function setDataSeguroPoliza(amparada_por){}

var maxProductosGuiaIntercon = 7;

function addRowProduct(obj){         
      var Tabla    = obj.parentNode.parentNode.parentNode;	                  
      var Fila     = obj.parentNode.parentNode;
      var item     = 1;
      var tam      = Tabla.rows.length - 1;
      var actmayor = 0;
      var cont     = 0;      
      if(validaRequeridosDetalle(obj,Fila)){        
	  if(tam == maxProductosGuiaIntercon){
		$(Fila).find("a[name=saveDetalleGuiaIntercon]").each(function(){		  
		  var newLink2           = document.createElement("a");
		      newLink2.href      = "javascript:void(0)";
		      newLink2.name      = "saveDetalleGuiaIntercon";
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
		
	  $(newRow).find("a[name=saveDetalleGuiaIntercon]").focus(function(){
	    $(this).parent().addClass("focusSaveRow");
	  });
	  
	  $(newRow).find("a[name=saveDetalleGuiaIntercon]").blur(function(){
	    $(this).parent().removeClass("focusSaveRow");
	  });	
	  
	  $(newRow).find("a[name=saveDetalleGuiaIntercon]").click(function(){
	    addRowProduct(this);
	  });    
	  
	  var newLink           = document.createElement("a");
	      newLink.href      = "javascript:void(0)";
	      newLink.name      = "saveDetalleGuiaIntercon";
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
	      if(rowsNow == maxProductosGuiaIntercon){
		
		$(newRow).find("a[name=saveDetalleGuiaIntercon]").each(function(){		  
		  var newLink2           = document.createElement("a");
		      newLink2.href      = "javascript:void(0)";
		      newLink2.name      = "saveDetalleGuiaIntercon";
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
  
  if(rowsNow == maxProductosGuiaIntercon && numAdd == 0){     
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
      
      $(newRow).find("a[name=saveDetalleGuiaIntercon]").focus(function(){
	  $(this).parent().addClass("focusSaveRow");
      });
      
      $(newRow).find("a[name=saveDetalleGuiaIntercon]").blur(function(){
	  $(this).parent().removeClass("focusSaveRow");
      });	
      
      $(newRow).find("a[name=saveDetalleGuiaIntercon]").click(function(){
	  addRowProduct(this);
      }); 
  }
  
  $(obj.parentNode.parentNode).remove();    
  
  var valorTotal = 0;  
  var Tabla      = document.getElementById('tableGuiaIntercon');

  $(Tabla).find("input[name=cantidad]").each(function(){ 															  
    var valor = removeFormatCurrency(this.value);															  
    valorTotal += (valor * 1); 	
  });	   
  
  $("#cantidad").val(valorTotal);
     
  var pesoTotal = 0;
  var Tabla     = document.getElementById('tableGuiaIntercon');

  $(Tabla).find("input[name=peso]").each(function(){ 
        var valor = removeFormatCurrency(this.value);															  
        pesoTotal += (valor * 1) 
  });	   
  
  $("#peso").val(pesoTotal);
    
  var valorTotal = 0;
  var Tabla      = document.getElementById('tableGuiaIntercon');

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


function setDataRemitente(remitente_id,remitente,input){		   		   		   
	var QueryString = "ACTIONCONTROLER=getDataRemitenteDestinatario&remitente_destinatario_id="+remitente_id;	
   $.ajax({
	 url        : "GuiaInterconClass.php?rand="+Math.random(),
	 data       : QueryString,
	 beforeSend : function(){
		 showDivLoading();
	 },
	 success    : function(resp){	 		 
		 try{			 
			 var dataResp = $.parseJSON(resp);				 
			 $("#remitente").val(dataResp[0].remitente_destinatario);
			 $("#remitente_id").val(dataResp[0].remitente_destinatario_id);				 
			 $("#doc_remitente").val(dataResp[0].numero_identificacion);				 				 
			 $("#tipo_identificacion_remitente_id").val(dataResp[0].tipo_identificacion_id);
			 $("#direccion_remitente").val(dataResp[0].direccion);				 				 				 
			 $("#telefono_remitente").val(dataResp[0].telefono);	 
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
					url     : "GuiaInterconClass.php?rand="+Math.random(),
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
	 url        : "GuiaInterconClass.php?rand="+Math.random(),
	 data       : QueryString,
	 beforeSend : function(){
		 showDivLoading();
	 },
	 success    : function(resp){		 
		 try{			 
			 var dataResp = $.parseJSON(resp);				 
			 $("#destinatario").val(dataResp[0].remitente_destinatario);
			 $("#destinatario_id").val(dataResp[0].remitente_destinatario_id);				 
			 $("#doc_destinatario").val(dataResp[0].numero_identificacion);				 				 
			 $("#tipo_identificacion_destinatario_id").val(dataResp[0].tipo_identificacion_id);				 				 				 				             
			 $("#direccion_destinatario").val(dataResp[0].direccion);				 				 				 
			 $("#telefono_destinatario").val(dataResp[0].telefono);
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
		var pesovol=(parseInt(largo) * parseInt(ancho) * parseInt(alto)/100)*0.04;
		$("#peso_volumen").val(Math.ceil(pesovol)); 
	}
	
}
function recalculaValor(){

	var tipo_envio_id= document.getElementById('tipo_envio_id').value;
	var tipo_servicio_mensajeria_id = $("#tipo_servicio_mensajeria_id").val();
	var cliente_id = $("#cliente_id").val();
	var origen_id = $("#origen_hidden").val();
	var destino_id = $("#destino_hidden").val();
	var peso = $("#peso").val();
	var peso_volumen = $("#peso_volumen").val();
	var valor = removeFormatCurrency($("#valor").val());
	var valor_otros = removeFormatCurrency($("#valor_otros").val());
	
	if(/*parseInt(tipo_envio_id)>0 && */parseInt(tipo_servicio_mensajeria_id)>0 && origen_id!='NULL' && origen_id!='' && destino_id!='NULL' && destino_id!='' && parseFloat(peso)>0 && parseFloat(valor)>0   ){
		
		var QueryString = "ACTIONCONTROLER=CalcularTarifa&tipo_envio_id="+tipo_envio_id+"&tipo_servicio_mensajeria_id="+tipo_servicio_mensajeria_id
		+"&origen_id="+origen_id+"&destino_id="+destino_id+"&peso="+peso+"&valor="+valor+"&valor_otros="+valor_otros+"&cliente_id="+cliente_id+"&peso_volumen="+peso_volumen;	
	   $.ajax({
		 url        : "GuiaInterconClass.php?rand="+Math.random(),
		 data       : QueryString,
		 beforeSend : function(){
			 showDivLoading();
		 },
		 success    : function(resp){		 
			 try{			 
				 var dataResp = $.parseJSON(resp);	
				 
				 $("#valor_flete").val(dataResp.valor_flete);
				 $("#valor_seguro").val(dataResp.valor_declarado);				 
				 $("#valor_total").val(dataResp.total);		
				 $("#valor_manejo").val(dataResp.valor_manejo);		
				 $("#tipo_envio_id").val(dataResp.tipo_envio_id);		
			 }catch(e){
				   alertJquery(resp,"Error :"+e);
				}		 
			 removeDivLoading();
		 }	
	   });
		
	}


}



function setRangoDesdeHasta(){
   $("#rango_desde").change(function(){									 
      document.getElementById('rango_hasta').value = this.value;
   });	
}

function onclickCancellation(){
	// if($('#anula')) $('#anula').attr("disabled","");	
	var causal_anulacion_id = $("#causal_anulacion_id").val();
	var observacion_anulacion = $("#observacion_anulacion").val();
	if (causal_anulacion_id > 0 && observacion_anulacion !== '') {
		var guia_interconexion_id = document.getElementById('guia_interconexion_id').value;
		var QueryString = "ACTIONCONTROLER=onclickCancellation&guia_interconexion_id="+guia_interconexion_id+"&causal_anulacion_id="+causal_anulacion_id+"&observacion_anulacion="+observacion_anulacion;
		$.ajax({
			url			: "GuiaInterconClass.php?rand="+Math.random(),
			data		: QueryString,
			beforeSend	: function(){
				showDivLoading();
			},
			success    : function(resp){
				$("#divAnulacion").dialog('close');
				var formulario = document.getElementById('GuiaInterconForm');
				Reset(formulario);
				GuiaInterconOnReset();
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
}
function setObservaciones(id,text,obj){}
function setValorLiquidacion(){}