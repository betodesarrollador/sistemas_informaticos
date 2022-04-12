// JavaScript Document

$(document).ready(function(){

  autocompleteProveedor();
  addRowCosto();
  removeRowCosto();
  setLiquidacionDescu();
  validaTipoDescuento();
  setValorLiquidacionDescu();

});


function calcularFlete(){
	$("input[id=valor]").keyup(function(event){
						 
		var valor_descu    = 0;
		$(".rowDescuentos").each(function(){
		   $(this).find("input[name=descuentos]").each(function(){
												   
			  if(this.id == 'valor'){
					if(!isNaN(removeFormatCurrency(this.value))){
						 valor_descu= parseFloat(valor_descu)+parseFloat(removeFormatCurrency(this.value));			  
					}else{
						 valor_descu= parseFloat(valor_descu)+parseFloat(0);			  
						
					}
			  }
		   });
		});	
		if(!isNaN(valor_descu)){
			$("#valor_descuentos").val(setFormatCurrency(valor_descu));
		}
	});

}

function beforePrint(formulario,url,title,width,height){
	
	var liquidacion_despacho_descu_id = parseInt($("#liquidacion_despacho_descu_id").val());
	
	if(isNaN(liquidacion_despacho_descu_id)){
	  
	  alertJquery('Debe seleccionar un Despacho a imprimir !!!','Impresion LiquidacionDescu');
	  return false;
	  
	}else{	  
	
	    var liquidacion_despacho_descu_id = $("#liquidacion_despacho_descu_id").val();
		
		if(liquidacion_despacho_descu_id > 0){
			
		  return true;	
			
		}else{
			
			 alertJquery("No se puede mostrar impresion ya que esta liquidacion no se ha CAUSADO aun!!!","Impresion Liquidacion");
			 return false;
			
		  }
		
	    return true;
	  }	
	
}

function setValorLiquidacionDescu(){

  $("select[id=tipo_liquidacion]").change(function(){

     var Row = this.parentNode.parentNode;
	 	 
     if(this.value == 'P'){
		 
		var peso           =  $(Row).find("input[id=peso]").val();
		var peso_neto      = ((peso * 1) * 0.001);
		var valor_unidad   = removeFormatCurrency($(Row).find("input[id=valor_unidad_costo]").val());
		var valor_costo = (peso_neto * valor_unidad);
				
		if(!isNaN(valor_costo)){
			if(parseFloat($(Row).find("input[id=valor_facturar]").val())>=parseFloat(valor_costo)){
				$(Row).find("input[id=valor_costo]").val(setFormatCurrency(valor_costo));		
				//$(Row).find("input[name=valor_unidad_facturar]").removeAttr("readOnly");
				//$(Row).find("input[name=valor_facturar]").attr("readOnly","true");
			
			}else{
				$(Row).find("input[id=valor_costo]").val("");	
				$(Row).find("input[id=valor_unidad_costo]").val("");	
				 alertJquery("El costo ($"+setFormatCurrency(valor_costo)+") es mayor al valor a Facturar ($"+setFormatCurrency($(Row).find("input[id=valor_facturar]").val())+")!!!","LiquidacionDescu");
			}
			
		}	
		
		 
	 }else if(this.value == 'V'){
		 
			var peso_volumen   = ($(Row).find("input[id=peso_volumen]").val() * 1);
			var valor_unidad   = removeFormatCurrency($(Row).find("input[id=valor_unidad_costo]").val());
			var valor_costo = (peso_volumen * valor_unidad);
			
			if(!isNaN(valor_costo)){ 			 			  

				if(parseFloat($(Row).find("input[id=valor_facturar]").val())>=parseFloat(valor_costo)){
					$(Row).find("input[id=valor_costo]").val(setFormatCurrency(valor_costo));		
					//$(Row).find("input[name=valor_unidad_facturar]").removeAttr("readOnly");
					//$(Row).find("input[name=valor_facturar]").attr("readOnly","true");
				
				}else{
					$(Row).find("input[id=valor_costo]").val("");	
					$(Row).find("input[id=valor_unidad_costo]").val("");	
					 alertJquery("El costo ($"+setFormatCurrency(valor_costo)+") es mayor al valor a Facturar ($"+setFormatCurrency($(Row).find("input[id=valor_facturar]").val())+")!!!","LiquidacionDescu");
				}
			  
			}	 
	 }else if(this.value == 'G'){
		 
			var cantidad   = ($(Row).find("input[id=cantidad]").val() * 1);
			var valor_unidad   = removeFormatCurrency($(Row).find("input[id=valor_unidad_costo]").val());
			var valor_costo = (cantidad * valor_unidad);
			
			if(!isNaN(valor_costo)){ 			 			  

				if(parseFloat($(Row).find("input[id=valor_facturar]").val())>=parseFloat(valor_costo)){
					$(Row).find("input[id=valor_costo]").val(setFormatCurrency(valor_costo));		
					//$(Row).find("input[name=valor_unidad_facturar]").removeAttr("readOnly");
					//$(Row).find("input[name=valor_facturar]").attr("readOnly","true");
				
				}else{
					$(Row).find("input[id=valor_costo]").val("");	
					$(Row).find("input[id=valor_unidad_costo]").val("");	
					 alertJquery("El costo ($"+setFormatCurrency(valor_costo)+") es mayor al valor a Facturar ($"+setFormatCurrency($(Row).find("input[id=valor_facturar]").val())+")!!!","LiquidacionDescu");
				}

			}	 
		 
	  }else if(this.value == 'C'){

//		     $(Row).find("input[name=valor_unidad_facturar]").attr("readOnly","true");
//		     $(Row).find("input[name=valor_facturar]").removeAttr("readOnly","false");			  			 
//		     $(Row).find("input[name=valor_facturar]").removeAttr("readOnly");			  
             $(Row).find("input[id=valor_unidad_costo]").val("0");		  
  			 $(Row).find("input[id=valor_costo]").val("");
		  
		}		

		var total_cost=0;
		$(".rowRemesa").each(function(){ 
		   
		   $(this).find("input[name=remesa]").each(function(){
												   
			 if(this.id == 'valor_costo' && this.value!='' ){
				 total_cost = parseFloat(parseFloat(total_cost) + parseFloat(removeFormatCurrency(this.value)));
			 }
																							   
		   });
		   
		  $("#valor_galon").val(setFormatCurrency(total_cost));
		  $("#valor_flete").val(setFormatCurrency(total_cost));
		   
		});

										 
  });
  
  $("input[id=valor_unidad_costo]").keyup(function(){
														
      var Row              = this.parentNode.parentNode;
      var tipo_liquidacion = $(Row).find('select[id=tipo_liquidacion]').val();
					
     if(tipo_liquidacion == 'P'){
		 
		var peso_neto      = (($(Row).find("input[id=peso]").val() * 1) * 0.001);
		var valor_unidad   = removeFormatCurrency(this.value);
		var valor_costo = Math.round(peso_neto * valor_unidad);
		if(!isNaN(valor_costo)){

			if(parseFloat($(Row).find("input[id=valor_facturar]").val())>=parseFloat(valor_costo)){
				$(Row).find("input[id=valor_costo]").val(setFormatCurrency(valor_costo));		
				$(Row).find("input[name=valor_unidad_costo]").removeAttr("readOnly");
				$(Row).find("input[name=valor_costo]").attr("readOnly","true");
			
			}else{
				$(Row).find("input[id=valor_costo]").val("");	
				$(Row).find("input[id=valor_unidad_costo]").val("");	
				 alertJquery("El costo ($"+setFormatCurrency(valor_costo)+") es mayor al valor a Facturar ($"+setFormatCurrency($(Row).find("input[id=valor_facturar]").val())+")!!!","LiquidacionDescu");
			}

		}
		
		 
	 }else if(tipo_liquidacion == 'V'){
		 
			var peso_volumen   = ($(Row).find("input[id=peso_volumen]").val() * 1);
			var valor_unidad   = removeFormatCurrency(this.value);
			var valor_costo = Math.round(peso_volumen * valor_unidad);
			
			if(!isNaN(valor_costo)){ 

				if(parseFloat($(Row).find("input[id=valor_facturar]").val())>=parseFloat(valor_costo)){
					$(Row).find("input[id=valor_costo]").val(setFormatCurrency(valor_costo));		
					$(Row).find("input[name=valor_unidad_costo]").removeAttr("readOnly");
					$(Row).find("input[name=valor_costo]").attr("readOnly","true");
				
				}else{
					$(Row).find("input[id=valor_costo]").val("");	
					$(Row).find("input[id=valor_unidad_costo]").val("");	
					 alertJquery("El costo ($"+setFormatCurrency(valor_costo)+") es mayor al valor a Facturar ($"+setFormatCurrency($(Row).find("input[id=valor_facturar]").val())+")!!!","LiquidacionDescu");
				}

			}
	 }else if(tipo_liquidacion == 'G'){
		 
			var cantidad   = ($(Row).find("input[id=cantidad]").val() * 1);
			var valor_unidad   = removeFormatCurrency(this.value);
			var valor_costo = (cantidad * valor_unidad);
			
			if(!isNaN(valor_costo)){ 			 			  

				if(parseFloat($(Row).find("input[id=valor_facturar]").val())>=parseFloat(valor_costo)){
					$(Row).find("input[id=valor_costo]").val(setFormatCurrency(valor_costo));		
					$(Row).find("input[name=valor_unidad_costo]").removeAttr("readOnly");
					$(Row).find("input[name=valor_costo]").attr("readOnly","true");
				
				}else{
					$(Row).find("input[id=valor_costo]").val("");	
					$(Row).find("input[id=valor_unidad_costo]").val("");	
					 alertJquery("El costo ($"+setFormatCurrency(valor_costo)+") es mayor al valor a Facturar ($"+setFormatCurrency($(Row).find("input[id=valor_facturar]").val())+")!!!","LiquidacionDescu");
				}
			}	 
		 
		 
	  }else if(tipo_liquidacion == 'C'){
		  
		      $(Row).find("input[id=valor_unidad_costo]").attr("readOnly","true");
		      $(Row).find("input[id=valor_costo]").removeAttr("readOnly");			  
              $(Row).find("input[id=valor_unidad_costo]").val("0");		  
  			  $(Row).find("input[id=valor_costo]").val("");		  
		  
		}						

		var total_cost=0;
		$(".rowRemesa").each(function(){ 
		   
		   $(this).find("input[name=remesa]").each(function(){
												   
			 if(this.id == 'valor_costo' && this.value!='' ){
				 total_cost = parseFloat(parseFloat(total_cost) + parseFloat(removeFormatCurrency(this.value)));
			 }
																							   
		   });
		   
		  $("#valor_galon").val(setFormatCurrency(total_cost));
		  $("#valor_flete").val(setFormatCurrency(total_cost));
		   
		});

  });

  $("input[id=cantidad]").keyup(function(){
														
      var Row              = this.parentNode.parentNode;
      var tipo_liquidacion = $(Row).find('select[id=tipo_liquidacion]').val();
					
     if(tipo_liquidacion == 'P'){
		 
		var peso_neto      = (($(Row).find("input[id=peso]").val() * 1) * 0.001);
		var valor_unidad   = removeFormatCurrency($(Row).find("input[id=valor_unidad_costo]").val());
		var valor_costo = Math.round(peso_neto * valor_unidad);
		if(!isNaN(valor_costo)){

			if(parseFloat($(Row).find("input[id=valor_facturar]").val())>=parseFloat(valor_costo)){
				$(Row).find("input[id=valor_costo]").val(setFormatCurrency(valor_costo));		
				$(Row).find("input[name=valor_unidad_costo]").removeAttr("readOnly");
				$(Row).find("input[name=valor_costo]").attr("readOnly","true");
			
			}else{
				$(Row).find("input[id=valor_costo]").val("");	
				$(Row).find("input[id=valor_unidad_costo]").val("");	
				 alertJquery("El costo ($"+setFormatCurrency(valor_costo)+") es mayor al valor a Facturar ($"+setFormatCurrency($(Row).find("input[id=valor_facturar]").val())+")!!!","LiquidacionDescu");
			}
		}
		
		 
	 }else if(tipo_liquidacion == 'V'){
		 
			var peso_volumen   = ($(Row).find("input[id=peso_volumen]").val() * 1);
			var valor_unidad   = removeFormatCurrency($(Row).find("input[id=valor_unidad_costo]").val());
			var valor_costo = Math.round(peso_volumen * valor_unidad);
			
			if(!isNaN(valor_costo)){ 
			
				if(parseFloat($(Row).find("input[id=valor_facturar]").val())>=parseFloat(valor_costo)){
					$(Row).find("input[id=valor_costo]").val(setFormatCurrency(valor_costo));		
					$(Row).find("input[name=valor_unidad_costo]").removeAttr("readOnly");
					$(Row).find("input[name=valor_costo]").attr("readOnly","true");
				
				}else{
					$(Row).find("input[id=valor_costo]").val("");	
					$(Row).find("input[id=valor_unidad_costo]").val("");	
					 alertJquery("El costo ($"+setFormatCurrency(valor_costo)+") es mayor al valor a Facturar ($"+setFormatCurrency($(Row).find("input[id=valor_facturar]").val())+")!!!","LiquidacionDescu");
				}
			  
			}
	 }else if(tipo_liquidacion == 'G'){
		 
			var cantidad   = ($(Row).find("input[id=cantidad]").val() * 1);
			var valor_unidad   = removeFormatCurrency($(Row).find("input[id=valor_unidad_costo]").val());
			var valor_costo = (cantidad * valor_unidad);
			
			if(!isNaN(valor_costo)){ 			 			  
			  
				if(parseFloat($(Row).find("input[id=valor_facturar]").val())>=parseFloat(valor_costo)){
					$(Row).find("input[id=valor_costo]").val(setFormatCurrency(valor_costo));		
					$(Row).find("input[name=valor_unidad_costo]").removeAttr("readOnly");
					$(Row).find("input[name=valor_costo]").attr("readOnly","true");
				
				}else{
					$(Row).find("input[id=valor_costo]").val("");	
					$(Row).find("input[id=valor_unidad_costo]").val("");	
					 alertJquery("El costo ($"+setFormatCurrency(valor_costo)+") es mayor al valor a Facturar ($"+setFormatCurrency($(Row).find("input[id=valor_facturar]").val())+")!!!","LiquidacionDescu");
				}
			  
			}	 
		 
		 
	  }else if(tipo_liquidacion == 'C'){
		  
		      $(Row).find("input[id=valor_unidad_costo]").attr("readOnly","true");
		      $(Row).find("input[id=valor_costo]").removeAttr("readOnly");			  
              $(Row).find("input[id=valor_unidad_costo]").val("0");		  
  			  $(Row).find("input[id=valor_costo]").val("");		  
		  
		}						

		var total_cost=0;
		var total_cantidad=0;		
		$(".rowRemesa").each(function(){ 
		   
		   $(this).find("input[name=remesa]").each(function(){
												   
			 if(this.id == 'valor_costo' && this.value!='' ){
				 total_cost = parseFloat(parseFloat(total_cost) + parseFloat(removeFormatCurrency(this.value)));
			 }

			 if(this.id == 'cantidad' && this.value!='' ){
				 total_cantidad = parseFloat(parseFloat(total_cantidad) + parseFloat(removeFormatCurrency(this.value)));
			 }

		   });
		   
		  $("#valor_galon").val(setFormatCurrency(total_cost));
		  $("#valor_flete").val(setFormatCurrency(total_cost));
		  $("#cantidad_galon").val(setFormatCurrency(total_cantidad));
		   
		});

  });


  $("input[id=peso]").keyup(function(){
														
      var Row              = this.parentNode.parentNode;
      var tipo_liquidacion = $(Row).find('select[id=tipo_liquidacion]').val();
					
     if(tipo_liquidacion == 'P'){
		 
		var peso_neto      = (($(Row).find("input[id=peso]").val() * 1) * 0.001);
		var valor_unidad   = removeFormatCurrency($(Row).find("input[id=valor_unidad_costo]").val());
		var valor_costo = Math.round(peso_neto * valor_unidad);
		if(!isNaN(valor_costo)){
			
			if(parseFloat($(Row).find("input[id=valor_facturar]").val())>=parseFloat(valor_costo)){
				$(Row).find("input[id=valor_costo]").val(setFormatCurrency(valor_costo));		
				$(Row).find("input[name=valor_unidad_costo]").removeAttr("readOnly");
				$(Row).find("input[name=valor_costo]").attr("readOnly","true");
			
			}else{
				$(Row).find("input[id=valor_costo]").val("");	
				$(Row).find("input[id=valor_unidad_costo]").val("");	
				 alertJquery("El costo ($"+setFormatCurrency(valor_costo)+") es mayor al valor a Facturar ($"+setFormatCurrency($(Row).find("input[id=valor_facturar]").val())+")!!!","LiquidacionDescu");
			}
			
		}
		
		 
	 }else if(tipo_liquidacion == 'V'){
		 
			var peso_volumen   = ($(Row).find("input[id=peso_volumen]").val() * 1);
			var valor_unidad   = removeFormatCurrency($(Row).find("input[id=valor_unidad_costo]").val());
			var valor_costo = Math.round(peso_volumen * valor_unidad);
			
			if(!isNaN(valor_costo)){ 
			
				if(parseFloat($(Row).find("input[id=valor_facturar]").val())>=parseFloat(valor_costo)){
					$(Row).find("input[id=valor_costo]").val(setFormatCurrency(valor_costo));		
					$(Row).find("input[name=valor_unidad_costo]").removeAttr("readOnly");
					$(Row).find("input[name=valor_costo]").attr("readOnly","true");
				
				}else{
					$(Row).find("input[id=valor_costo]").val("");	
					$(Row).find("input[id=valor_unidad_costo]").val("");	
					 alertJquery("El costo ($"+setFormatCurrency(valor_costo)+") es mayor al valor a Facturar ($"+setFormatCurrency($(Row).find("input[id=valor_facturar]").val())+")!!!","LiquidacionDescu");
				}
			  
			}
	 }else if(tipo_liquidacion == 'G'){
		 
			var cantidad   = ($(Row).find("input[id=cantidad]").val() * 1);
			var valor_unidad   = removeFormatCurrency($(Row).find("input[id=valor_unidad_costo]").val());
			var valor_costo = (cantidad * valor_unidad);
			
			if(!isNaN(valor_costo)){ 			 			  
			  
				if(parseFloat($(Row).find("input[id=valor_facturar]").val())>=parseFloat(valor_costo)){
					$(Row).find("input[id=valor_costo]").val(setFormatCurrency(valor_costo));		
					$(Row).find("input[name=valor_unidad_costo]").removeAttr("readOnly");
					$(Row).find("input[name=valor_costo]").attr("readOnly","true");
				
				}else{
					$(Row).find("input[id=valor_costo]").val("");	
					$(Row).find("input[id=valor_unidad_costo]").val("");	
					 alertJquery("El costo ($"+setFormatCurrency(valor_costo)+") es mayor al valor a Facturar ($"+setFormatCurrency($(Row).find("input[id=valor_facturar]").val())+")!!!","LiquidacionDescu");
				}
			  
			}	 
		 
		 
	  }else if(tipo_liquidacion == 'C'){
		  
		      $(Row).find("input[id=valor_unidad_costo]").attr("readOnly","true");
		      $(Row).find("input[id=valor_costo]").removeAttr("readOnly");			  
              $(Row).find("input[id=valor_unidad_costo]").val("0");		  
  			  $(Row).find("input[id=valor_costo]").val("");		  
		  
		}						

		var total_cost=0;
		var total_peso=0;		
		$(".rowRemesa").each(function(){ 
		   
		   $(this).find("input[name=remesa]").each(function(){
												   
			 if(this.id == 'valor_costo' && this.value!='' ){
				 total_cost = parseFloat(total_cost + removeFormatCurrency(this.value));
			 }

			 if(this.id == 'peso' && this.value!='' ){
				 total_peso = parseFloat(parseFloat(total_peso) + parseFloat(removeFormatCurrency(this.value)));
			 }

		   });
		   
		  $("#valor_galon").val(setFormatCurrency(total_cost));
		  $("#valor_flete").val(setFormatCurrency(total_cost));
		  $("#cantidad_peso").val(setFormatCurrency(total_peso));
		   
		});

  });

  $("input[id=peso_volumen]").keyup(function(){
														
      var Row              = this.parentNode.parentNode;
      var tipo_liquidacion = $(Row).find('select[id=tipo_liquidacion]').val();
					
     if(tipo_liquidacion == 'P'){
		 
		var peso_neto      = (($(Row).find("input[id=peso]").val() * 1) * 0.001);
		var valor_unidad   = removeFormatCurrency($(Row).find("input[id=valor_unidad_costo]").val());
		var valor_costo = Math.round(peso_neto * valor_unidad);
		if(!isNaN(valor_costo)){
			
			if(parseFloat($(Row).find("input[id=valor_facturar]").val())>=parseFloat(valor_costo)){
				$(Row).find("input[id=valor_costo]").val(setFormatCurrency(valor_costo));		
				$(Row).find("input[name=valor_unidad_costo]").removeAttr("readOnly");
				$(Row).find("input[name=valor_costo]").attr("readOnly","true");
			
			}else{
				$(Row).find("input[id=valor_costo]").val("");	
				$(Row).find("input[id=valor_unidad_costo]").val("");	
				 alertJquery("El costo ($"+setFormatCurrency(valor_costo)+") es mayor al valor a Facturar ($"+setFormatCurrency($(Row).find("input[id=valor_facturar]").val())+")!!!","LiquidacionDescu");
			}
			
		}
		
		 
	 }else if(tipo_liquidacion == 'V'){
		 
			var peso_volumen   = ($(Row).find("input[id=peso_volumen]").val() * 1);
			var valor_unidad   = removeFormatCurrency($(Row).find("input[id=valor_unidad_costo]").val());
			var valor_costo = Math.round(peso_volumen * valor_unidad);
			
			if(!isNaN(valor_costo)){ 
			
				if(parseFloat($(Row).find("input[id=valor_facturar]").val())>=parseFloat(valor_costo)){
					$(Row).find("input[id=valor_costo]").val(setFormatCurrency(valor_costo));		
					$(Row).find("input[name=valor_unidad_costo]").removeAttr("readOnly");
					$(Row).find("input[name=valor_costo]").attr("readOnly","true");
				
				}else{
					$(Row).find("input[id=valor_costo]").val("");	
					$(Row).find("input[id=valor_unidad_costo]").val("");	
					 alertJquery("El costo ($"+setFormatCurrency(valor_costo)+") es mayor al valor a Facturar ($"+setFormatCurrency($(Row).find("input[id=valor_facturar]").val())+")!!!","LiquidacionDescu");
				}
			  
			}
	 }else if(tipo_liquidacion == 'G'){
		 
			var cantidad   = ($(Row).find("input[id=cantidad]").val() * 1);
			var valor_unidad   = removeFormatCurrency($(Row).find("input[id=valor_unidad_costo]").val());
			var valor_costo = (cantidad * valor_unidad);
			
			if(!isNaN(valor_costo)){ 			 			  
			  
				if(parseFloat($(Row).find("input[id=valor_facturar]").val())>=parseFloat(valor_costo)){
					$(Row).find("input[id=valor_costo]").val(setFormatCurrency(valor_costo));		
					$(Row).find("input[name=valor_unidad_costo]").removeAttr("readOnly");
					$(Row).find("input[name=valor_costo]").attr("readOnly","true");
				
				}else{
					$(Row).find("input[id=valor_costo]").val("");	
					$(Row).find("input[id=valor_unidad_costo]").val("");	
					 alertJquery("El costo ($"+setFormatCurrency(valor_costo)+") es mayor al valor a Facturar ($"+setFormatCurrency($(Row).find("input[id=valor_facturar]").val())+")!!!","LiquidacionDescu");
				}
			}	 
		 
		 
	  }else if(tipo_liquidacion == 'C'){
		  
		      $(Row).find("input[id=valor_unidad_costo]").attr("readOnly","true");
		      $(Row).find("input[id=valor_costo]").removeAttr("readOnly");			  
              $(Row).find("input[id=valor_unidad_costo]").val("0");		  
  			  $(Row).find("input[id=valor_costo]").val("");		  
		  
		}						

		var total_cost=0;
		var total_peso_volumen=0;		
		$(".rowRemesa").each(function(){ 
		   
		   $(this).find("input[name=remesa]").each(function(){
												   
			 if(this.id == 'valor_costo' && this.value!='' ){
				 total_cost = parseFloat(parseFloat(total_cost) + parseFloat(removeFormatCurrency(this.value)));
			 }

			 if(this.id == 'peso_volumen' && this.value!='' ){
				 total_peso_volumen = parseFloat(parseFloat(total_peso_volumen) + parseFloat(removeFormatCurrency(this.value)));
			 }

		   });
		   
		  $("#valor_galon").val(setFormatCurrency(total_cost));
		  $("#valor_flete").val(setFormatCurrency(total_cost));
		  $("#cantidad_volu").val(setFormatCurrency(total_peso_volumen));
		   
		});

  });

 $("input[id=valor_costo]").keyup(function(){
														
      var Row              = this.parentNode.parentNode;
      var tipo_liquidacion = $(Row).find('select[id=tipo_liquidacion]').val();
					
     if(tipo_liquidacion == 'C'){
		 
		var valor_costo   = removeFormatCurrency($(Row).find("input[id=valor_costo]").val());
		var valor_costo = parseFloat(valor_costo);
		if(!isNaN(valor_costo)){
			
			if(parseFloat($(Row).find("input[id=valor_facturar]").val())>=parseFloat(valor_costo)){
				$(Row).find("input[id=valor_costo]").val(setFormatCurrency(valor_costo));		
				$(Row).find("input[name=valor_unidad_costo]").attr("readOnly","true");
			
			}else{
				$(Row).find("input[id=valor_costo]").val("");	
				$(Row).find("input[id=valor_unidad_costo]").val("0");	
				 alertJquery("El costo ($"+setFormatCurrency(valor_costo)+") es mayor al valor a Facturar ($"+setFormatCurrency($(Row).find("input[id=valor_facturar]").val())+")!!!","LiquidacionDescu");
			}
			
		}
		
		 
	 }

		var total_cost=0;
		var total_peso_volumen=0;		
		$(".rowRemesa").each(function(){ 
		   
		   $(this).find("input[name=remesa]").each(function(){
												   
			 if(this.id == 'valor_costo' && this.value!='' ){
				 total_cost = parseFloat(parseFloat(total_cost) + parseFloat(removeFormatCurrency(this.value)));
			 }

			 if(this.id == 'peso_volumen' && this.value!='' ){
				 total_peso_volumen = parseFloat(parseFloat(total_peso_volumen) + parseFloat(removeFormatCurrency(this.value)));
			 }

		   });
		   
		  $("#valor_galon").val(setFormatCurrency(total_cost));
		  $("#valor_flete").val(setFormatCurrency(total_cost));
		  $("#cantidad_volu").val(setFormatCurrency(total_peso_volumen));
		   
		});

  });

}


function setDataFormWithResponse(liquidacion_despacho_descu_id){
	
	var formulario  = document.forms[0];	
	var QueryString = "ACTIONCONTROLER=onclickFind&liquidacion_despacho_descu_id="+liquidacion_despacho_descu_id;
	
	$.ajax({
	  url        : "LiquidacionDescuDespaClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
		  showDivLoading();
	  },
      success    : function(resp){
		  
	    Reset(formulario);
        clearFind();	
        setFocusFirstFieldForm(formulario);	
	    clearDataForm(formulario);
	    clearCostos();	
		clearRowRemesa();
	
	    $("#concepto").val("LIQUIDACION DU: ");
	    $("#fecha").val($("#fecha_static").val());			  
		  				
		try{
			
		 var data                   = $.parseJSON(resp); 		 
		 var encabezado_registro_id = $.trim(data[0]['encabezado_registro_id']);
		 var estado_liquidacion     = data[0]['estado_liquidacion'];
		 var remesa_dat             = data[0]['remesa_dat'];
		 var descuentos             = data[0]['descuentos'];				 
		 var valor_descuentos      	= data[0]['valor_descuentos'];						 		 
		 var peso_total      		= data[0]['peso_total'];						 		 
		 var peso_vol_total      	= data[0]['peso_vol_total'];						 		 
		 var cantidad_total      	= data[0]['cantidad_total'];	
		 var valor_costos      		= data[0]['valor_costos'];	

		 var totalDescuentos        = 0;

		 var Tabla_rem      		= document.getElementById('remesas_reg');
		 var rowRemesa      		= document.getElementById('rowRemesa');	

		 var Tabla           		= document.getElementById('tableLiquidacionDescuDespa');
		 var rowDescuentos   		= document.getElementById('rowDescuentos');			  
		 var despachos_urbanos_id   = data[0]['despachos_urbanos_id'];
		 var numRow          		= 1;		 
		 
         setFormWithJSON(formulario,resp,true);		 
				
		
		$("#cantidad_peso").val(peso_total);		
		$("#cantidad_volu").val(peso_vol_total);
		$("#cantidad_galon").val(cantidad_total);
		$("#valor_galon").val(valor_costos);
				
		if(remesa_dat){
		
		 for(var i = 0; i < remesa_dat.length; i++){
			 
			 if(i == 0){
													
				 $(rowRemesa).find("input[name=remesa]").each(function(){
						
					var input = this;

					
					for(var llave in remesa_dat[0]){
													
					  if(input.id == llave){
						  input.value = remesa_dat[0][llave];
						  
					  }
					  if(llave == 'tipo_liquidacion'){ 
						  $('#tipo_liquidacion option[value='+remesa_dat[0][llave]+']').attr('selected', true);
						  //input.selected = (input.value == (remesa_dat[0][llave]));
						  
					  }
					  
					
					}
																			 
				 });							 
				 
			 }else{

				  var newRow       = Tabla_rem.insertRow(numRow);
				  newRow.className = 'rowRemesa';
				  newRow.innerHTML = rowRemesa.innerHTML;
				  
				 $(newRow).find("input[name=remesa]").each(function(){
						
					var input = this;
					
					for(var llave in remesa_dat[i]){
					
					  if(input.id == llave){
						  input.value = remesa_dat[i][llave];
					  }
					  if(llave == 'tipo_liquidacion'){ 
						  $('#tipo_liquidacion option[value='+remesa_dat[0][llave]+']').attr('selected', true);
						  //input.selected = (input.value == (remesa_dat[0][llave]));
						  
					  }
					  
					
					}
																			 
				 });
		     setValorLiquidacionDescu();
			 numRow++;                              
			 }
			 
			 
		 }
		 
	 }
				
		 numRow=1;	
		
		 
	  if(descuentos){	 
				
		 for(var i = 0; i < descuentos.length; i++){
			 
			 if(i == 0){
													
				 $(rowDescuentos).find("input[name=descuentos]").each(function(){
						
					var input = this;
					
					for(var llave in descuentos[0]){
														
					  if(input.id == llave){
						  input.value = descuentos[0][llave];
						  
						  if(llave == 'valor'){
							  totalDescuentos += (descuentos[0][llave] * 1);										  
						  }
						  
					  }
					
					}
																			 
				 });							 
				 
			 }else{

				  var newRow       = Tabla.insertRow(numRow);
				  newRow.className = 'rowDescuentos';
				  newRow.innerHTML = rowDescuentos.innerHTML;
												  
				 $(newRow).find("input[name=descuentos]").each(function(){
						
					var input = this;
					
					for(var llave in descuentos[i]){
					
					  if(input.id == llave){
						  input.value = descuentos[i][llave];
						  
						  if(llave == 'valor'){
							  totalDescuentos += (descuentos[i][llave] * 1);
						  }									  
						  
					  }
					
					}
													 
				 });

			 numRow++;                              
			 }
			 
			 
		 }	
		 
	   }
				
				
		 
		
        removeDivLoading();
		validaTipoDescuento();			
		
		if($("#guardar"))        $("#guardar").attr("disabled","true");
		if($("#imprimir"))       $("#imprimir").attr("disabled","");			
		
		if(estado_liquidacion == 'L'){
		  if($("#actualizar"))     $("#actualizar").attr("disabled","");				
		}else{
		    if($("#actualizar"))     $("#actualizar").attr("disabled","true");				
		  }
		
		
		}catch(e){
			 alertJquery(resp,"Error : "+e);
		  }
		
	  }
		
    });

}

function LiquidacionDescuDespachoOnSaveOnUpdateonDelete(formulario,resp){

   LiquidacionDescuDespachoOnReset(formulario);
   
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
	
}

function LiquidacionDescuDespachoOnReset(formulario){
	
	Reset(formulario);
    clearFind();	
    setFocusFirstFieldForm(formulario);	
	clearDataForm(formulario);
	clearCostos();	
	clearRowRemesa();
	
	$("#concepto").val("LIQUIDACION DU: ");
	$("#fecha").val($("#fecha_static").val());	
	
	$("#refresh_QUERYGRID_LiquidacionDescuDespachos").click();
			
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
	if($("#imprimir"))       $("#imprimir").attr("disabled","true");	
}

function addRowCosto(obj){  	
       
  $("input[name=add]").click(function(){
						
      var row      = this.parentNode.parentNode;						
	  var table    = row.parentNode;
	  var indexRow = row.rowIndex;
						
      var newRow           = table.insertRow(indexRow);
          newRow.className = 'rowCostos';
          newRow.innerHTML = row.innerHTML;									  
		  
		  autocompleteProveedor();
		  addRowCosto();
		  
          $(row).find("input[name=add]").replaceWith("<input type='button' name='remove' id='remove' value=' - ' />");	
		  removeRowCosto();
		  calculaTotalCosto();
		  calculaDiferencia();
									  
  });

}

function removeRowCosto(){
  
    
	$("input[name=remove]").click(function(){
										   
        var row = this.parentNode.parentNode;
		
		$(row).remove();		
	    calculaTotalCosto();
		calculaDiferencia();
										   
    });
  
  
}

function getDataDespacho(despachos_urbanos_id,despacho,obj){
		   	   
	   if(despachos_urbanos_id > 0){
	
		   var formulario  	= obj.form;	   		   
		   var despacho  	= despacho.split("-");
		       despacho 	= despacho[0];
		   var QueryString 	= "ACTIONCONTROLER=getDataDespacho&despacho="+despacho+"&despachos_urbanos_id="+despachos_urbanos_id;
				   
		   LiquidacionDescuDespachoOnReset(formulario);	   
					  
          if(!isNaN(parseInt(despachos_urbanos_id))){	    
		   
		   $.ajax({
			 url        : "LiquidacionDescuDespaClass.php?rand="+Math.random(),
			 data       : QueryString,
			 beforeSend : function(){
				showDivLoading();
				clearCostos();
				clearRowRemesa();
				
			 },
			 success    : function(resp){
									 
			   try{
						 
				 var data = $.parseJSON(resp); 
														 
				 setFormWithJSON(formulario,resp,true);
				 
				 var concepto = $("#concepto").val();
				 $("#concepto").val(concepto+' '+despacho);
				 
				 removeDivLoading();
				  var Tabla_rem     		= document.getElementById('remesas_reg');
				  var rowRemesa  			= document.getElementById('rowRemesa');	
				  var Tabla         		= document.getElementById('tableLiquidacionDescuDespa');
				  var rowDescuentos 		= document.getElementById('rowDescuentos');			  
				  var despachos_urbanos_id 	= data[0]['despachos_urbanos_id'];
				  var numRow        		= 1;
				  
				  QueryString  = "ACTIONCONTROLER=getLiquidacionDescuDespacho&despachos_urbanos_id="+despachos_urbanos_id;
				  
				  $.ajax({
					url        : "LiquidacionDescuDespaClass.php?rand="+Math.random(),
					data       : QueryString,
					beforeSend : function(){
					  showDivLoading();
					},
					success    : function(resp){
											
					  try{
											  
						 if($.trim(resp).length == 0 || resp == 'null'){
													
							alertJquery("<p align='center'>Este despacho no tiene anticipos !! <br> No se puede legalizar</p>","Validacion LiquidacionDescu"); 
							Reset(formulario);
							return true;
							 
						 }else{
										
							 var data            	= $.parseJSON(resp); 
							 var remesa_dat       	= data[0]['remesa_dat'];
							 var descuentos      	= data[0]['descuentos'];
							 var valor_flete     	= data[0]['valor_flete'];	
							 var valor_neto_pagar	= data[0]['valor_neto_pagar'];						 						 
							 var saldo_por_pagar 	= data[0]['saldo_por_pagar'];
							 var peso_total      	= data[0]['peso_total'];						 		 
							 var peso_vol_total     = data[0]['peso_vol_total'];						 		 
							 var cantidad_total     = data[0]['cantidad_total'];	

							 var totalDescuentos = 0;
									
							$("#valor_flete").val(valor_flete);
							$("#valor_neto_pagar").val(valor_neto_pagar);
							$("#saldo_por_pagar").val(saldo_por_pagar);		

							$("#cantidad_peso").val(peso_total);		
							$("#cantidad_volu").val(peso_vol_total);
							$("#cantidad_galon").val(cantidad_total);

							if(remesa_dat){
							
							 for(var i = 0; i < remesa_dat.length; i++){
								 
								 if(i == 0){
																		
									 $(rowRemesa).find("input[name=remesa]").each(function(){
											
										var input = this;
										
										for(var llave in remesa_dat[0]){
																		
										  if(input.id == llave){
											  input.value = remesa_dat[0][llave];
											  
										  }
										  if(llave == 'tipo_liquidacion'){
											  $('#tipo_liquidacion option[value='+remesa_dat[0][llave]+']').attr('selected', true);
											  
										  }
										
										}
																								 
									 });							 
									 
								 }else{
		
									  var newRow       = Tabla_rem.insertRow(numRow);
									  newRow.className = 'rowRemesa';
									  newRow.innerHTML = rowRemesa.innerHTML;
									  
									 $(newRow).find("input[name=remesa]").each(function(){
											
										var input = this;
										
										for(var llave in remesa_dat[i]){
										
										  if(input.id == llave){
											  input.value = remesa_dat[i][llave];
										  }
										  if(llave == 'tipo_liquidacion'){
											  $('#tipo_liquidacion option[value='+remesa_dat[0][llave]+']').attr('selected', true);
											  
										  }
										
										}
																								 
									 });
								 setValorLiquidacionDescu();
								 numRow++;                              
								 }
								 
								 
							 }
							 
						 }
							numRow        = 1;
							 
						if(descuentos)	{									 

									
							 for(var i = 0; i < descuentos.length; i++){
								 
								 if(i == 0){
																		
									 $(rowDescuentos).find("input[name=descuentos]").each(function(){
											
										var input = this;
										
										for(var llave in descuentos[0]){
																			
										  if(input.id == llave){
											  input.value = descuentos[0][llave];
											  
											  if(llave == 'valor'){
												  totalDescuentos += (descuentos[0][llave] * 1);										  
											  }
											  
										  }
										
										}
																								 
									 });							 
									 
								 }else{
		
									  var newRow       = Tabla.insertRow(numRow);
									  newRow.className = 'rowDescuentos';
									  newRow.innerHTML = rowDescuentos.innerHTML;
																	  
									 $(newRow).find("input[name=descuentos]").each(function(){
											
										var input = this;
										
										for(var llave in descuentos[i]){
										
										  if(input.id == llave){
											  input.value = descuentos[i][llave];
											  
											  if(llave == 'valor'){
												  totalDescuentos += (descuentos[i][llave] * 1);
											  }									  
											  
										  }
										
										}
																								 
									 });
		
								 numRow++;                              
								 }
								 
								 
							 }
							 
							 
						 }
									
						}
						  
					  }catch(e){
						   alertJquery(resp,"Error :"+e);
						}                 
	
					  removeDivLoading();
					  validaTipoDescuento();	
					}
					
				  });		
				  
			   }catch(e){
				   
				   alertJquery(resp,"Despacho : "+despacho);
				   LiquidacionDescuDespachoOnReset(formulario);
				   
				 }
				 
		 
			 }
			 
		   });	
				 
	     }
		 
	  }
		
}


function setProveedor(id,text,obj){
	
 var row = obj.parentNode.parentNode;
 
 $(row).find("#tercero_id").val(id);

}

function clearRowRemesa(){
	
   $(".rowRemesa").each(function(){
       if(this.id != 'rowRemesa'){
		   $(this).remove();
	   }									
   });
}


function clearCostos(){

  $(".rowCostos").each(function(){									 
	 $(this).remove();	 
  });
  
  $("#rowCostos").find("select,input").each(function(){														   
													 
      if(this.type == 'select-one'){
		 this.value = 'NULL';
	  }else{
		  
		  if(this.name == 'remove'){
			  
	         $(this).replaceWith('<input type="button" name="add" id="add" value=" + " />');													   
             addRowCosto();														   			  
			  
		  }else if(this.name != 'add'){
			  
			   this.value = '';
			  
			}
		  
		}													 
		
  });
  

}

function autocompleteProveedor(){
	
  $("input[id=tercero]").keypress(function(event){
      ajax_suggest(this,event,"tercero","null",setProveedor,null,document.forms[0]);    
  });
  
}


function calculaTotalCosto(){	
	
	var total_costos_viaje = 0;
	
    $("input[name=costos_viaje]&&input[id=valor]").each(function(){
        total_costos_viaje += (this.value * 1);
    });
	
	$("#total_costos_viaje").val(total_costos_viaje);
	
}

function calculaDiferencia(){
	
	var diferencia         = 0;
	var total_anticipos    = ($("#total_anticipos").val() * 1);
	var total_costos_viaje = ($("#total_costos_viaje").val() * 1);
	    diferencia         = (total_anticipos - total_costos_viaje);
	
	$("#diferencia").val(Math.abs(diferencia));

}


function onclickSave(objId,formulario){

      var obj               = document.getElementById(objId);
	  var formulario        = obj.form;	   
	  var descuentos        = '';
	  var remesa        	= '';
	  var contDescuentos    = 0;
  	  var contRemesa 		=0;
	  var fletes            = '';
	  	  
	  var QueryString       = '';	
	  var tableLiquidacionDescu  = document.getElementById('tableLiquidacionDescuDespa');
	  var remesas_reg  = document.getElementById('remesas_reg');
	  

	  var liquidacion_despacho_id 	=  $("#liquidacion_despacho_id").val();
	  var encabezado_registro_id 	=  $("#encabezado_registro_id").val();
	  var estado_liquidacion 	=  $("#estado_liquidacion").val();
	  var despachos_urbanos_id =  $("#despachos_urbanos_id").val();
	  var despacho 	=  $("#despacho").val();
	  var fecha_static 	=  $("#fecha_static").val();
	  var fecha 	=  $("#fecha").val();
	  var tenedor 	=  $("#tenedor").val();
	  var tenedor_id=  $("#tenedor_id").val();
	  var placa 	=  $("#placa").val();
	  var placa_id 	=  $("#placa_id").val();
	  var origen 	=  $("#origen").val();
	  var origen_id	=  $("#origen_id").val();
	  var destino 	=  $("#destino").val();
	  var destino_id	=  $("#destino_id").val();
	  var usuario_id	=  $("#usuario_id").val();
	  var oficina_id	=  $("#oficina_id").val();
	  var elaboro 		=  $("#elaboro").val();
	  var concepto		=  $("#concepto").val();
	  var valor_descuentos 	=  $("#valor_descuentos").val();
	  var observaciones 	=  $("#observaciones").val();
	  var cantidad_galon	=  $("#cantidad_galon").val();
	  var cantidad_peso		=  $("#cantidad_peso").val();
	  var cantidad_volu		=  $("#cantidad_volu").val();
	  var valor_galon		=  $("#valor_galon").val();
	  var detalle_liquidacion_valor_flete_id	=  $("#detalle_liquidacion_valor_flete_id").val();	  
	  var detalle_liquidacion_valor_sobre_flete_id	=  $("#detalle_liquidacion_valor_sobre_flete_id").val();	
	  var detalle_liquidacion_saldo_por_pagar_id	=  $("#detalle_liquidacion_saldo_por_pagar_id").val();	  

	  QueryString = 'despachos_urbanos_id='+despachos_urbanos_id+'&despacho='+despacho+'&liquidacion_despacho_id='+liquidacion_despacho_id+'&encabezado_registro_id='+encabezado_registro_id
	  +'&estado_liquidacion='+estado_liquidacion+'&fecha_static='+fecha_static+'&fecha='+fecha+'&tenedor='+tenedor+'&tenedor_id='+tenedor_id+'&placa='+placa+'&placa_id='+placa_id
	  +'&origen='+origen+'&origen_id='+origen_id+'&destino='+destino+'&destino_id='+destino_id+'&usuario_id='+usuario_id+'&elaboro='+elaboro+'&concepto='+concepto+'&valor_descuentos='+valor_descuentos+'&observaciones='+observaciones
	  +'&cantidad_galon='+cantidad_galon+'&cantidad_peso='+cantidad_peso+'&cantidad_volu='+cantidad_volu+'&valor_galon='+valor_galon+'&oficina_id='+oficina_id
	  +'&detalle_liquidacion_valor_flete_id='+detalle_liquidacion_valor_flete_id+'&detalle_liquidacion_valor_sobre_flete_id='+detalle_liquidacion_valor_sobre_flete_id
  	  +'&detalle_liquidacion_saldo_por_pagar_id='+detalle_liquidacion_saldo_por_pagar_id;	  


	  
	  $(tableLiquidacionDescu).find(".rowDescuentos").each(function(){
															   				
		var descuento_id = '';
		var nombre       = '';
		var valor        = '';
				
		$(this).find("input[name=descuentos]").each(function(){   
				
			if(this.id == 'descuentos_despacho_id'){
			   descuentos += '&descuentos['+contDescuentos+'][descuentos_despacho_id]='+this.value;													
			}else if(this.id == 'descuento_id'){
				 descuentos += '&descuentos['+contDescuentos+'][descuento_id]='+this.value;							
			}else if(this.id == 'nombre'){
				   descuentos += '&descuentos['+contDescuentos+'][nombre]='+this.value;	
			 }else if(this.id == 'valor'){
					 descuentos += '&descuentos['+contDescuentos+'][valor]='+this.value;	
			  }
			
															 
		});
		
		contDescuentos++;
																 
	  });		  
	  
	  QueryString += descuentos;				  
	  	  
	  $(remesas_reg).find(".rowRemesa").each(function(){
		
		var remesa_id = '';
		var cantidad     = '';
		var peso      = '';
		var peso_volumen     = '';
		var tipo_liquidacion      = '';		
		var valor_unidad_costo      = '';		
		var valor_costo       = '';	
		var estado       = '';	
		var numero_remesa       = '';			
			
		$(this).find("input[name=remesa]").each(function(){   
									
			if(this.id == 'remesa_id'){
			    remesa += '&remesa['+contRemesa+'][remesa_id]='+this.value;							
			}else if(this.id == 'cantidad'){
				remesa += '&remesa['+contRemesa+'][cantidad]='+this.value;	
			//}else if(this.id == 'peso'){
				//remesa += '&remesa['+contRemesa+'][peso]='+this.value;	
			//}else if(this.id == 'peso_volumen'){
				//remesa += '&remesa['+contRemesa+'][peso_volumen]='+this.value;	
			//}else if(this.id == 'tipo_liquidacion'){
				//remesa += '&remesa['+contRemesa+'][tipo_liquidacion]='+this.value;	
			//}else if(this.id == 'valor_unidad_costo'){
				//remesa += '&remesa['+contRemesa+'][valor_unidad_costo]='+this.value;
			//}else if(this.id == 'estado'){
				//remesa += '&remesa['+contRemesa+'][estado]='+this.value;
			//}else if(this.id == 'numero_remesa'){
				//remesa += '&remesa['+contRemesa+'][numero_remesa]='+this.value;	
			//}else if(this.id == 'valor_costo'){
				//remesa += '&remesa['+contRemesa+'][valor_costo]='+this.value;	
				
			}
			
															 
		});
			
		contRemesa++;
															 
	  });		  
	  
	  QueryString += remesa;

      if(ValidaRequeridos(formulario)){
		  		 		   
		   var QueryString  = 'ACTIONCONTROLER=onclickSave&'+QueryString;
		   
		   $.ajax({
		     url        : "LiquidacionDescuDespaClass.php?rand="+Math.random(),
			 data       : QueryString,
			 beforeSend : function(){
				showDivLoading();
			 },
			 success  : function(resp){				
			 			 
			     var liquidacion_despacho_descu_id = parseInt(resp);
				 
				 if(!isNaN(liquidacion_despacho_descu_id)){
					 
				 	 $("#refresh_QUERYGRID_LiquidacionDescuDespachos").click();	
					 
					 var url = "LiquidacionDescuDespaClass.php?ACTIONCONTROLER=onclickPrint&liquidacion_despacho_descu_id="+liquidacion_despacho_descu_id+"&rand="+Math.random();
					 
					 popPup(url,10,900,600);
					 
//					 document.location.href = "LiquidacionDescuDespachosClass.php?"+QueryString;
					 
				 }else{
					 alertJquery(resp);
				  }		 
			 
			 
				// alertJquery(resp,"LiquidacionDescu");				 
				 removeDivLoading();	
                 LiquidacionDescuDespachoOnSaveOnUpdateonDelete(formulario);				 
		     }
			 
		   });
		   
       }											     

}

var formSubmitted = false;

function onclickUpdate(objId,formulario){

      var obj               = document.getElementById(objId);
	  var formulario        = obj.form;	   
	  var anticipos         = '';
	  var impuestos         = '';
	  var descuentos        = '';
	  var remesa        	= '';
	  var contAnticipos     = 0;
	  var contImpuestos     = 0;
	  var contDescuentos    = 0;
  	  var contRemesa 		=0;
	  var fletes            = '';
	  	  
	  var QueryString       = '';	
	  var tableLiquidacionDescu  = document.getElementById('tableLiquidacionDescuDespa');
	  var remesas_reg  = document.getElementById('remesas_reg');

	  var liquidacion_despacho_descu_id 	=  $("#liquidacion_despacho_descu_id").val();
	  var encabezado_registro_id 	=  $("#encabezado_registro_id").val();
	  var estado_liquidacion 	=  $("#estado_liquidacion").val();
	  var despachos_urbanos_id =  $("#despachos_urbanos_id").val();
	  var despacho 	=  $("#despacho").val();
	  var fecha_static 	=  $("#fecha_static").val();
	  var fecha 	=  $("#fecha").val();
	  var tenedor 	=  $("#tenedor").val();
	  var tenedor_id=  $("#tenedor_id").val();
	  var placa 	=  $("#placa").val();
	  var placa_id 	=  $("#placa_id").val();
	  var origen 	=  $("#origen").val();
	  var origen_id	=  $("#origen_id").val();
	  var destino 	=  $("#destino").val();
	  var destino_id	=  $("#destino_id").val();
	  var total_anticipos 	=  $("#total_anticipos").val();
	  var total_costos_viaje	=  $("#total_costos_viaje").val();
	  var diferencia 	=  $("#diferencia").val();
	  var usuario_id	=  $("#usuario_id").val();
	  var oficina_id	=  $("#oficina_id").val();
	  var elaboro 		=  $("#elaboro").val();
	  var concepto		=  $("#concepto").val();
	  var valor_descuentos 	=  $("#valor_descuentos").val();
	  var observaciones 	=  $("#observaciones").val();
	  var cantidad_galon	=  $("#cantidad_galon").val();
	  var cantidad_peso		=  $("#cantidad_peso").val();
	  var cantidad_volu		=  $("#cantidad_volu").val();
	  var valor_galon		=  $("#valor_galon").val();
	  var detalle_liquidacion_valor_flete_id	=  $("#detalle_liquidacion_valor_flete_id").val();	   
	  var detalle_liquidacion_valor_sobre_flete_id	=  $("#detalle_liquidacion_valor_sobre_flete_id").val();
	  var detalle_liquidacion_saldo_por_pagar_id	=  $("#detalle_liquidacion_saldo_por_pagar_id").val();	  
	  

	  QueryString = 'despachos_urbanos_id='+despachos_urbanos_id+'&despacho='+despacho+'&liquidacion_despacho_descu_id='+liquidacion_despacho_descu_id+'&encabezado_registro_id='+encabezado_registro_id
	  +'&estado_liquidacion='+estado_liquidacion+'&fecha_static='+fecha_static+'&fecha='+fecha+'&tenedor='+tenedor+'&tenedor_id='+tenedor_id+'&placa='+placa+'&placa_id='+placa_id
	  +'&origen='+origen+'&origen_id='+origen_id+'&destino='+destino+'&destino_id='+destino_id+'&total_anticipos='+total_anticipos+'&total_costos_viaje='+total_costos_viaje
	  +'&diferencia='+diferencia+'&usuario_id='+usuario_id+'&elaboro='+elaboro+'&concepto='+concepto+'&valor_descuentos='+valor_descuentos
	  +'&observaciones='+observaciones+'&cantidad_galon='+cantidad_galon+'&cantidad_peso='+cantidad_peso+'&cantidad_volu='+cantidad_volu+'&valor_galon='+valor_galon+'&oficina_id='+oficina_id
  	  +'&detalle_liquidacion_valor_flete_id='+detalle_liquidacion_valor_flete_id+'&detalle_liquidacion_valor_sobre_flete_id='+detalle_liquidacion_valor_sobre_flete_id
	  +'&detalle_liquidacion_saldo_por_pagar_id='+detalle_liquidacion_saldo_por_pagar_id;	  

	  
	  $(tableLiquidacionDescu).find(".rowDescuentos").each(function(){
															   				
		var descuento_id = '';
		var nombre       = '';
		var valor        = '';
				
		$(this).find("input[name=descuentos]").each(function(){   
				
			if(this.id == 'descuentos_despacho_id'){
			   descuentos += '&descuentos['+contDescuentos+'][descuentos_despacho_id]='+this.value;													
			}else if(this.id == 'descuento_id'){
				 descuentos += '&descuentos['+contDescuentos+'][descuento_id]='+this.value;							
			}else if(this.id == 'nombre'){
				   descuentos += '&descuentos['+contDescuentos+'][nombre]='+this.value;	
			 }else if(this.id == 'valor'){
					 descuentos += '&descuentos['+contDescuentos+'][valor]='+this.value;	
			  }else if(this.id == 'detalle_liquidacion_despacho_descu_id'){
					 descuentos += '&descuentos['+contDescuentos+'][detalle_liquidacion_despacho_descu_id]='+this.value;	
			  }
			
															 
		});
		
		contDescuentos++;
																 
	  });		  
	  
	  QueryString += descuentos;				  
	  	  

	  $(remesas_reg).find(".rowRemesa").each(function(){
		
		var remesa_id = '';
		var cantidad     = '';
		var peso      = '';
		var peso_volumen     = '';
		var tipo_liquidacion      = '';		
		var valor_unidad_costo      = '';		
		var valor_costo       = '';		
		var estado       = '';	
		var numero_remesa       = '';					
			
		$(this).find("input[name=remesa]").each(function(){   
									
			if(this.id == 'remesa_id'){
			    remesa += '&remesa['+contRemesa+'][remesa_id]='+this.value;							
			}else if(this.id == 'cantidad'){
				remesa += '&remesa['+contRemesa+'][cantidad]='+this.value;	
			/*}else if(this.id == 'peso'){
				remesa += '&remesa['+contRemesa+'][peso]='+this.value;	
			}else if(this.id == 'peso_volumen'){
				remesa += '&remesa['+contRemesa+'][peso_volumen]='+this.value;	
			}else if(this.id == 'tipo_liquidacion'){
				remesa += '&remesa['+contRemesa+'][tipo_liquidacion]='+this.value;	
			}else if(this.id == 'valor_unidad_costo'){
				remesa += '&remesa['+contRemesa+'][valor_unidad_costo]='+this.value;	
			}else if(this.id == 'estado'){
				remesa += '&remesa['+contRemesa+'][estado]='+this.value;	
			}else if(this.id == 'numero_remesa'){
				remesa += '&remesa['+contRemesa+'][numero_remesa]='+this.value;	
			}else if(this.id == 'valor_costo'){
				remesa += '&remesa['+contRemesa+'][valor_costo]='+this.value;	
				*/
			}
			
															 
		});
			
		contRemesa++;
															 
	  });		  
	  
	  QueryString += remesa;

      if(ValidaRequeridos(formulario)){
		   
   		   var QueryString  = 'ACTIONCONTROLER=onclickUpdate&'+QueryString;
		   
		   $.ajax({
		     url        : "LiquidacionDescuDespaClass.php?rand="+Math.random(),
			 data       : QueryString,
			 beforeSend : function(){
				showDivLoading();
			 },
			 success  : function(resp){
			 	 $("#refresh_QUERYGRID_LiquidacionDescuDespachos").click();					 
				 alertJquery(resp,"Liquidacion Descuentos");
				 removeDivLoading();
				 LiquidacionDescuDespachoOnSaveOnUpdateonDelete(formulario);
		     }
		   });		   
		 
       }
											     
}

function Contabilizar(formulario){
	var liquidacion_despacho_descu_id = $("#liquidacion_despacho_descu_id").val();
	var fecha = $("#fecha").val();	
	
	if(parseInt(liquidacion_despacho_descu_id)>0){
		var QueryString  = 'ACTIONCONTROLER=onclickContabilizar&liquidacion_despacho_descu_id='+liquidacion_despacho_descu_id+"&fecha="+fecha;
		
		$.ajax({
		 url        : "LiquidacionDescuDespaClass.php?rand="+Math.random(),
		 data       : QueryString,
		 beforeSend : function(){
			showDivLoading();
		 },
		 success  : function(resp){
			 //$("#refresh_QUERYGRID_LiquidacionDescuDespachos").click();
			 if($.trim(resp)=='true'){
				 alertJquery("Contabilizada exitosamente","Liquidacion Descuentos");
				 removeDivLoading();
				 setDataFormWithResponse(liquidacion_despacho_descu_id);
			 }else{
 				 alertJquery(resp,"Liquidacion Descuentos");
 				 removeDivLoading();
			 }
		 }
		});		   
	}else{
		alertJquery("Por favor escoja primero un Registro","Validacion Contabilizacion");	
	}
	
}
function setLiquidacionDescu(){
		
	$("#guardar,#actualizar").click(function(){
											 
      if(this.id == 'guardar'){		  
        onclickSave(this.id,this.form);		  		  
	  }else{
          onclickUpdate(this.id,this.form);		  
		}											 
											 
    });
	
}

function validaTipoDescuento(){

  $("input[name=descuentos]").keypress(function(event){
											 
      var row     = this.parentNode.parentNode;									 
	  var calculo = $(row).find("input[id=calculo]").val();
	  
	  if(calculo == 'P'){
	    return false;
	  }else{
		  
         var params = new Array({"campo":"valor_flete","type":"numeric","length":null,"presicion":null,"patron":null,"mensaje":null,"value":null});
		 return SetValidacion(event,this,params);		   

		}
											 
  });
  
  
   $("input[name=descuentos]&&input[id=valor]").keyup(function(){ format(this,0); });

}

function clearDataForm(){
	
	$(".rowImpuestos").each(function() { if(this.id != 'rowImpuestos') { $(this).remove(); } });
	$(".rowDescuentos").each(function(){ if(this.id != 'rowDescuentos'){ $(this).remove(); } });
	$(".rowAnticipos").each(function() { if(this.id != 'rowAnticipos') { $(this).remove(); } });

}