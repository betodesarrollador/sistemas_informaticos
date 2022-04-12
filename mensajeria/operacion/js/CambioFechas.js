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
		}
	   }							
   });

});



function closeDialog(){
	$("#divSolicitudGuia").dialog('close');
}
//funcion para cargar los datos desde BUSCAR
function setDataFormWithResponse(guia_id){	

	var guia_d =  guia_id.split('-');
	var forma 		= document.forms[0];	
	var QueryString = "ACTIONCONTROLER=onclickFind&guia_id="+guia_d[0]+"&tipo="+guia_d[1];	
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
		  	$("#guia_id").val(guia_d[0]);
			$("#tipo").val(guia_d[1]);
		  	$("#tipo_mostrar").val(guia_d[1]);			
			if(estado == 1 || estado == 4 || estado == 7){
				if($('#actualizar')) $('#actualizar').attr("disabled","");
			}else{
				if($('#actualizar')) $('#actualizar').attr("disabled","");
			}
		}catch(e){
			alertJquery(resp,"Error :");
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
		
	clearFind();
	$("#oficina_id").val($("#oficina_id_static").val());	
	
	$('#actualizar').attr("disabled","true");

}


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



function separaCodigoDescripcion(){}

function updateGridGuia(){
	$("#refresh_QUERYGRID_guia").click();
}
