// JavaScript Document
$(document).ready(function(){
	linkDetallesSolicitud();	
	setValorLiquidacion();
	 autocompleteCliente();		
});

function autocompleteCliente(){
	
	$("input[name=cliente]").autocomplete("../../../framework/clases/ListaInteligente.php?consulta=cliente1", {
		width: 260,
		selectFirst: true
	});
	
	$("input[name=cliente]").result(function(event, data, formatted) {				   
		if (data){
			var numero_identificacion = data[0].split("_");
			$(this).val($.trim(numero_identificacion[1]));
			$(this).next().val(data[1]);
			
   		    var txtNext = false;			
		}
	});
	
}

function setValorLiquidacion(){

  $("select[name=tipo_liquidacion]").change(function(){

     var Row = this.parentNode.parentNode;
	 	 
     if(this.value == 'P'){
		 
		var peso           =  $(Row).find("input[name=peso]").val();
		var peso_neto      = ((peso * 1) * 0.001);
		var valor_unidad   = removeFormatCurrency($(Row).find("input[name=valor_unidad_facturar]").val());
		var valor_facturar = (peso_neto * valor_unidad);
				
		if(!isNaN(valor_facturar)){
			
			$(Row).find("input[name=valor_facturar]").val(setFormatCurrency(valor_facturar));		
//		    $(Row).find("input[name=valor_unidad_facturar]").removeAttr("readOnly");
//		    $(Row).find("input[name=valor_facturar]").attr("readOnly","true");
			
		}	
		

	 }else if(this.value == 'G'){
		 
		 
			var cantidad   = ($(Row).find("input[name=cantidad]").val() * 1);
			var valor_unidad   = removeFormatCurrency($(Row).find("input[name=valor_unidad_facturar]").val());
			var valor_facturar = (cantidad * valor_unidad);
			
			if(!isNaN(valor_facturar)){ 			 			  
			  
			 $(Row).find("input[name=valor_facturar]").val(setFormatCurrency(valor_facturar));		
//		     $(Row).find("input[name=valor_facturar]").removeAttr("readOnly","false");			  			 			 
//		     $(Row).find("input[name=valor_unidad_facturar]").removeAttr("readOnly");
//		     $(Row).find("input[name=valor_facturar]").attr("readOnly","true");			  
			}
	 }else if(this.value == 'V'){
		 
			var peso_volumen   = ($(Row).find("input[name=peso_volumen]").val() * 1);
			var valor_unidad   = removeFormatCurrency($(Row).find("input[name=valor_unidad_facturar]").val());
			var valor_facturar = (peso_volumen * valor_unidad);
			
			if(!isNaN(valor_facturar)){ 			 			  
			  
			 $(Row).find("input[name=valor_facturar]").val(setFormatCurrency(valor_facturar));		
//		     $(Row).find("input[name=valor_facturar]").removeAttr("readOnly","false");			  			 			 
//		     $(Row).find("input[name=valor_unidad_facturar]").removeAttr("readOnly");
//		     $(Row).find("input[name=valor_facturar]").attr("readOnly","true");			  
			  
			}	 
		 
	  }else if(this.value == 'C'){

//		     $(Row).find("input[name=valor_unidad_facturar]").attr("readOnly","true");
//		     $(Row).find("input[name=valor_facturar]").removeAttr("readOnly","false");			  			 
//		     $(Row).find("input[name=valor_facturar]").removeAttr("readOnly");			  
             $(Row).find("input[name=valor_unidad_facturar]").val("0");		  
  			 $(Row).find("input[name=valor_facturar]").val("");
		  
		}										 
										 
  });
  
  $("input[name=valor_unidad_facturar]").keyup(function(){
														
      var Row              = this.parentNode.parentNode;
      var tipo_liquidacion = $(Row).find('select[name=tipo_liquidacion]').val();
					
     if(tipo_liquidacion == 'P'){
		 
		var peso_neto      = (($(Row).find("input[name=peso]").val() * 1) * 0.001);
		var valor_unidad   = removeFormatCurrency(this.value);
		var valor_facturar = Math.round(peso_neto * valor_unidad);
		if(!isNaN(valor_facturar)){
			
			$(Row).find("input[name=valor_facturar]").val(setFormatCurrency(valor_facturar));		
		    $(Row).find('input[name=valor_unidad_facturar]').removeAttr("readOnly");
		    $(Row).find('input[name=valor_facturar').attr("readOnly","true");			  			  			
			
		}

	 }else if(tipo_liquidacion == 'G'){
		 
			var cantidad   = ($(Row).find("input[name=cantidad]").val() * 1);
			var valor_unidad   = removeFormatCurrency(this.value);
			var valor_facturar = Math.round(cantidad * valor_unidad);
			
			if(!isNaN(valor_facturar)){ 
			
			  $(Row).find("input[name=valor_facturar]").val(setFormatCurrency(valor_facturar));		 
		      $(Row).find("input[name=valor_unidad_facturar]").removeAttr("readOnly");
		      $(Row).find("input[name=valor_facturar").attr("readOnly","true");			  			  
			  
			}

		 
	 }else if(tipo_liquidacion == 'V'){
		 
			var peso_volumen   = ($(Row).find("input[name=peso_volumen]").val() * 1);
			var valor_unidad   = removeFormatCurrency(this.value);
			var valor_facturar = Math.round(peso_volumen * valor_unidad);
			
			if(!isNaN(valor_facturar)){ 
			
			  $(Row).find("input[name=valor_facturar]").val(setFormatCurrency(valor_facturar));		 
		      $(Row).find("input[name=valor_unidad_facturar]").removeAttr("readOnly");
		      $(Row).find("input[name=valor_facturar").attr("readOnly","true");			  			  
			  
			}
		 
	  }else if(tipo_liquidacion == 'C'){
		  
		      $(Row).find("input[name=valor_unidad_facturar]").attr("readOnly","true");
		      $(Row).find("input[name=valor_facturar]").removeAttr("readOnly");			  
              $(Row).find("input[name=valor_unidad_facturar]").val("0");		  
  			  $(Row).find("input[name=valor_facturar]").val("");		  
		  
		}						
									
  });
	
}

function saveDetalleSolicitud(obj){
	
	var row = obj.parentNode.parentNode;

    if(validaRequeridosDetalle(obj,row)){
			  
	  var Celda                 = obj.parentNode;
	  var Fila                  = Celda.parentNode;
	  var Tabla                 = Fila.parentNode;
	  var remesa_id             = $(Fila).find("input[name=remesa_id]").val();
	  var tipo_liquidacion      = $(Fila).find("select[name=tipo_liquidacion]").val();	  	  
	  var valor_unidad_facturar = $(Fila).find("input[name=valor_unidad_facturar]").val();	  
	  var valor_facturar        = $(Fila).find("input[name=valor_facturar]").val();	  	
	  var orden_despacho        = $(Fila).find("input[name=documento_cliente]").val();	 
	  var cliente        = $(Fila).find("input[name=cliente]").val();		  
	  var cliente_id        = $(Fila).find("input[name=cliente_id]").val();		  	  
	  

	  var peso        			= $(Fila).find("input[name=peso]").val();	  	
	  var peso_volumen          = $(Fila).find("input[name=peso_volumen]").val();	  
	  var cantidad              = $(Fila).find("input[name=cantidad]").val();	  

	  var checkProcesar         = $(Fila).find("input[name=procesar]");    	            
	  
      var QueryString   = "ACTIONCONTROLER=onclickUpdate&remesa_id="+remesa_id+"&valor_facturar="+valor_facturar+"&tipo_liquidacion="+tipo_liquidacion+"&valor_unidad_facturar="
	                       +valor_unidad_facturar+"&valor_facturar="+valor_facturar+"&orden_despacho="+orden_despacho+"&peso="+peso+"&peso_volumen="+peso_volumen+"&cantidad="+cantidad+"&cliente="+cliente+"&cliente_id="+cliente_id;
	      
				      
	      $.ajax({
		      url        : "DetalleLiquidacionRemesasClass.php",
		      data       : QueryString,
		      beforeSend : function(){
			     setMessageWaiting();
		      },
		      success    : function(response){
		      			  
				 checkProcesar.attr("checked","");
				 
				 $(Celda).removeClass("focusSaveRow");
				 
				 if($.trim(response) == 'true'){
                   setMessage("Se guardo exitosamente!!");					 
				 }else{
					  setMessage(response);
				   }
				 			      
		      }
		      
	      });

     
  }//fin de validaRequeridosDetalle	
  
}

/***************************************************************
  Funciones para el objeto de guardado en los edtalles de ruta
***************************************************************/
function linkDetallesSolicitud(){

	$("a[name=saveDetalleSoliServi]").attr("href","javascript:void(0)");
	
	$("a[name=saveDetalleSoliServi]").focus(function(){
		var celda = this.parentNode;
		$(celda).addClass("focusSaveRow");
    });
	
	$("a[name=saveDetalleSoliServi]").blur(function(){
		var celda = this.parentNode;
		$(celda).removeClass("focusSaveRow");
    });
	
	$("a[name=saveDetalleSoliServi]").click(function(){
		saveDetalleSolicitud(this);
    });
	
}