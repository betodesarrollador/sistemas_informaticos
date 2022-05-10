// JavaScript Document

$(document).ready(function(){

  autocompleteProveedor();
  addRowCosto();
  removeRowCosto();
  setLiquidacion();
  validaTipoDescuento();
  setCalcularFlete();
  
  $("#divAnulacion").css("display","none");

});

function setCalcularFlete(){

  $("#calcularFlete").click(function(){
     calcularFlete(null,this.id,this.form);									 
  });
	
}

 var formSubmitted = false;
function onclickCancellation(formulario){
	var despachos_urbanos_id = $("#despachos_urbanos_id").val();
	var despachos_urbanos= $("#despachos_urbanos_id").val();
	var liquidacion_despacho_id = $("#liquidacion_despacho_id").val();
	var liquidacion_despacho   = $("#liquidacion_despacho").val();	
	
	if($("#divAnulacion").is(":visible")){
	 
	   var formularioPrincipal = document.forms[0];
	   var causal_anulacion_id = $("#causal_anulacion_id").val();
	   var observacion_anulacion       = $("#observacion_anulacion").val();
	   
       if(ValidaRequeridos(formulario)){
		   
		 if(!formSubmitted){  		   
	
	     var QueryString = "ACTIONCONTROLER=onclickCancellation&liquidacion_despacho_id="+liquidacion_despacho_id+'&causal_anulacion_id='+causal_anulacion_id+'&observacion_anulacion='+observacion_anulacion+'&despachos_urbanos='+despachos_urbanos;
		
	     $.ajax({
           url  : "LiquidacionDespachosClass.php",
	       data : QueryString,
	       beforeSend: function(){
			   showDivLoading();
			   formSubmitted = true;
	       },
	       success : function(response){
			 
			 formSubmitted = false;
			 Reset(formularioPrincipal);
             LiquidacionDespachosOnReset(formulario);						  
						  
		     if($.trim(response) == 'true'){
				 
			   alertJquery('Liquidacion despacho urbano  Anulado','Anulado Exitosamente');		 
				 				 
			 }else{
				   alertJquery(response,'Inconsistencia Anulando');
			   }
			   
			 removeDivLoading();
             $("#divAnulacion").dialog('close');
			 
	       }
	   
	     });
		 
	    }
	   
	   }
	
    }else{
		
	 var liquidacion_despacho_id = $("#liquidacion_despacho_id").val();
	 var estado_liquidacion        = document.getElementById("estado_liquidacion").value;
	 
	 if(parseInt(liquidacion_despacho_id) > 0){		

		$("#divAnulacion").dialog({
		  title: 'Anulacion Liquidacion Despacho Urbano',
		  width: 450,
		  height: 280,
		  closeOnEscape:true
		 });
			
	 }else{
		alertJquery('Debe Seleccionar primero un  Despacho Urbano','Anulacion');
	  }		
		
	}  
	  
	
}


function calcularFlete(afterCalculation,objId,formulario){
					
    var tenedor_id        = document.getElementById('tenedor_id').value;					
    var valor_flete       = document.getElementById('valor_flete').value;		
    var valor_sobre_flete = document.getElementById('valor_sobre_flete').value;			
	
	if(!valor_flete > 0){
		alertJquery("Digite el valor pactado del flete por favor !!!","Validacion");
		return false;
	}
	
	var impuestos     = '';
	var descuentos    = '';
	var anticipos     = '';
	var contImpuesto  = 0;
	var contDescuento = 0;
	var contAnticipos = 0;
	var QueryString   = 'ACTIONCONTROLER=calcularFlete&valor_flete='+valor_flete+'&valor_sobre_flete='+valor_sobre_flete+'&tenedor_id='+tenedor_id;
	
	$(".rowImpuestos").each(function(){
	   
	   $(this).find("input[name=impuestos]").each(function(){
											   
         if(this.id == 'impuestos_despacho_id'){
			 impuestos += '&impuestos['+contImpuesto+'][impuestos_despacho_id]='+this.value;
		 }else if(this.id == 'impuesto_id'){
			   impuestos += '&impuestos['+contImpuesto+'][impuesto_id]='+this.value;			 
		  }else if(this.id == 'nombre'){
			      impuestos += '&impuestos['+contImpuesto+'][nombre]='+this.value;			  
			}else if(this.id == 'base'){
			        impuestos += '&impuestos['+contImpuesto+'][base]='+this.value;				
			  }else if(this.id == 'valor'){
			        impuestos += '&impuestos['+contImpuesto+'][valor]='+this.value;				
			  }
											   											   
       });
	   
	   contImpuesto++;
	   
    });
	
    QueryString += impuestos;
	
	$(".rowDescuentos").each(function(){
	   
	   $(this).find("input[name=descuentos]").each(function(){
											   
         if(this.id == 'descuento_id'){
			 descuentos += '&descuentos['+contDescuento+'][descuento_id]='+this.value;
		 }else if(this.id == 'nombre'){
			   descuentos += '&descuentos['+contDescuento+'][nombre]='+this.value;			 
		  }else if(this.id == 'valor'){
			      descuentos += '&descuentos['+contDescuento+'][valor]='+this.value;			  
			}
											   											   
       });
	   
	   contDescuento++;
	   
    });	
	
    QueryString += descuentos;	
	
	$(".rowAnticipos").each(function(){
	   	   
	   var adiciono = false;
	   	   
		   
	   $(this).find("input[name=anticipos]").each(function(){
											   
		 if(this.id == 'anticipos_despacho_id'){
			 anticipos += '&anticipo['+contAnticipos+'][anticipos_despacho_id]='+this.value;
		 }else if(this.id == 'numero'){
			   anticipos += '&anticipo['+contAnticipos+'][numero]='+this.value;			 
		  }else if(this.id == 'valor'){
				  anticipos += '&anticipo['+contAnticipos+'][valor]='+this.value;			  
			}else if(this.id == 'tenedor'){
					anticipos += '&anticipo['+contAnticipos+'][tenedor]='+this.value;			  
			  }else if(this.id == 'tenedor_id'){
					  anticipos += '&anticipo['+contAnticipos+'][tenedor_id]='+this.value;			  
			   }else if(this.id == 'observaciones'){
					   anticipos += '&anticipo['+contAnticipos+'][observaciones]='+this.value;			  
				}
																						   
	   });
		   
	   contAnticipos++;	   
	   
    });		
	
    QueryString += anticipos;	
	
	$.ajax({
	  url        : "LiquidacionDespachosClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
		  showDivLoading();
	  },
	  success    : function(resp){

		  removeDivLoading();

		  try{
			  
			 var data      = $.parseJSON(resp);			 
			 var impuestos = data['impuestos'];
			 
			 if(data['impuestos']){
			 
			  for(var i = 0; i < impuestos.length; i++){
			  
			      var impuesto_id = impuestos[i]['impuesto_id'];
			      var valor       = impuestos[i]['valor'];
			      var base        = impuestos[i]['base'];				  
				  
			      $(".rowImpuestos").find("input[name=impuestos]&&input[id=impuesto_id]").each(function(){
																									  
				  if(this.value == impuesto_id){
					    
				    var row = this.parentNode.parentNode;
					    
				    $(row).find("input[name=impuestos]&&input[id=valor]").val(valor);
				    $(row).find("input[name=impuestos]&&input[id=base]").val(base);					
				    return true;
					    
				  }
																										  
			      });
			  
			  }			 
			
			 }
			 
			 
			 if(data['descuentos']){
			   
			    var descuentos = data['descuentos'];
			    
			    for(i = 0; i < descuentos.length; i++){
			    
				var descuento_id = descuentos[i]['descuento_id'];
				    var valor        = descuentos[i]['valor'];
				    
				$(".rowDescuentos").find("input[name=descuentos]&&input[id=descuento_id]").each(function(){
																									    
				if(this.value == descuento_id){
					      
				  var row = this.parentNode.parentNode;
					      
				  $(row).find("input[name=descuentos]&&input[id=valor]").val(valor);
				  return true;
					      
				}
																										    
			      });
			    
			    }
			 
			 }
			 
			 
			 if(data['valor_neto_pagar']){
		           var valor_neto_pagar = data['valor_neto_pagar'];	   
			   $("#valor_neto_pagar").val(valor_neto_pagar);
                        }
                        
                        if(data['saldo_por_pagar']){
			    var saldo_por_pagar  = data['saldo_por_pagar'];			 
			    $("#saldo_por_pagar").val(saldo_por_pagar);	
			 }
			 
			  
		  }catch(e){
			   alertJquery(resp,"Error :");
			}
		 
		 
	   afterCalculation(objId,formulario);	 
	   } 
	  
    });
	      

}

function beforePrint(formulario,url,title,width,height){
	
	var liquidacion_despacho_id = parseInt($("#liquidacion_despacho_id").val());
	
	if(isNaN(liquidacion_despacho_id)){
	  
	  alertJquery('Debe seleccionar un Despacho a imprimir !!!','Impresion Liquidacion');
	  return false;
	  
	}else{	  
	
	    var liquidacion_despacho_id = $("#liquidacion_despacho_id").val();
		
		if(liquidacion_despacho_id > 0){
			
		  return true;	
			
		}else{
			
			 alertJquery("No se puede mostrar impresion ya que esta liquidacion no se ha CAUSADO aun!!!","Impresion Liquidacion");
			 return false;
			
		  }
		
	    return true;
	  }	
	
}

function setDataFormWithResponse(liquidacion_despacho_id){
	
	var formulario  = document.forms[0];	
	var QueryString = "ACTIONCONTROLER=onclickFind&liquidacion_despacho_id="+liquidacion_despacho_id;
	
	$.ajax({
	  url        : "LiquidacionDespachosClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
		  showDivLoading();
	  },
      success    : function(resp){
		  				
	    Reset(formulario);
        clearFind();	
        setFocusFirstFieldForm(formulario);	
	    clearDataForm(formulario);
	    clearRowAnticipos();
	    clearCostos();							
						
		try{
			
		 var data                   = $.parseJSON(resp); 		 
		 var encabezado_registro_id = $.trim(data[0]['encabezado_registro_id']);
		 var estado_liquidacion     = data[0]['estado_liquidacion'];
		 var impuestos              = data[0]['impuestos'];
		 var descuentos             = data[0]['descuentos'];
		 var anticipos              = data[0]['anticipos'];						 
		 var valor_flete            = data[0]['valor_flete'];		
		 var valor_sobre_flete      = data[0]['valor_sobre_flete'];			 
		 var valor_neto_pagar       = data[0]['valor_neto_pagar'];						 						 
		 var saldo_por_pagar        = data[0]['saldo_por_pagar'];						 						  
		 var totalImpuestos         = 0;
		 var totalDescuentos        = 0;
		 var totalAnticipos         = 0; 
		 
		 var Tabla           = document.getElementById('tableLiquidacion');
		 var rowImpuestos    = document.getElementById('rowImpuestos');			  
		 var rowDescuentos   = document.getElementById('rowDescuentos');			  
		 var rowAnticipos    = document.getElementById('rowAnticipos');
		 var despachos_urbanos_id   = data[0]['despachos_urbanos_id'];
		 var numRow          = 2;		 
		 
         setFormWithJSON(formulario,resp,true);		 
				
		$("#valor_flete").val(valor_flete);
		$("#valor_sobre_flete").val(valor_sobre_flete);			
		$("#valor_neto_pagar").val(valor_neto_pagar);
		$("#saldo_por_pagar").val(saldo_por_pagar);						
				
				
		if(impuestos){		
				
		 for(var i = 0; i < impuestos.length; i++){
			 
			 if(i == 0){
													
				 $(rowImpuestos).find("input[name=impuestos]").each(function(){
						
					var input = this;
					
					for(var llave in impuestos[0]){
														
					  if(input.id == llave){
						  input.value = impuestos[0][llave];
						  
						  if(llave == 'valor'){
							  totalImpuestos += (impuestos[0][llave] * 1);										  
						  }
						  
					  }
					
					}
																			 
				 });							 
				 
			 }else{

				  var newRow       = Tabla.insertRow(numRow);
				  newRow.className = 'rowImpuestos';
				  newRow.innerHTML = rowImpuestos.innerHTML;
				  
				 $(newRow).find("input[name=impuestos]").each(function(){
						
					var input = this;
					
					for(var llave in impuestos[i]){
					
					  if(input.id == llave){
						  input.value = impuestos[i][llave];
						  
						  if(llave == 'valor'){
							  totalImpuestos += (impuestos[i][llave] * 1);
						  }									  
						  
					  }
					
					}
																			 
				 });

			 numRow++;                              
			 }
			 
			 
		 }	
		 
		 
		}
				
		 numRow++;	
		 
		
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
				
	
	 if(anticipos){
		
		 for(var i = 0; i < anticipos.length; i++){
			 
			 if(i == 0){
													
				 $(rowAnticipos).find("input[name=anticipos]").each(function(){
						
					var input = this;
					
					for(var llave in anticipos[0]){
														
					  if(input.id == llave){
						  input.value = anticipos[0][llave];
						  
						  if(llave == 'valor'){
							  totalAnticipos += (anticipos[0][llave] * 1);										  
						  }
						  
					  }
					
					}
																			 
				 });							 
				 
			 }else{

				  var newRow       = Tabla.insertRow(numRow);
				  newRow.className = 'rowAnticipos';
				  newRow.innerHTML = rowAnticipos.innerHTML;
				  
				 $(newRow).find("input[name=anticipos]").each(function(){
						
					var input = this;
					
					for(var llave in anticipos[i]){
					
					  if(input.id == llave){
						  input.value = anticipos[i][llave];
						  
						  if(llave == 'valor'){
							  totalAnticipos += (anticipos[i][llave] * 1);
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
	     if(estado_liquidacion == 'A' || estado_liquidacion == 'C'){
			$("#anular").attr("disabled","true");
		}else{
			$("#anular").attr("disabled","");
		} 		
		if(estado_liquidacion == 'L' || estado_liquidacion == 'C'){
		  if($("#actualizar"))     $("#actualizar").attr("disabled","");				
		  if($("#calcularFlete"))  $("#calcularFlete").attr("disabled","");						  
		}else{
		    if($("#actualizar"))     $("#actualizar").attr("disabled","true");				
		    if($("#calcularFlete"))  $("#calcularFlete").attr("disabled","true");							
		  }
		
		
		}catch(e){
			 alertJquery(resp,"Error : "+e);
		  }
		
	  }
		
    });

}

function LiquidacionDespachoOnSaveOnUpdateonDelete(formulario,resp){

   LiquidacionDespachosOnReset(formulario);
   
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
   if($('#anular'))    $('#anular').attr("disabled","true");
	
}

function LiquidacionDespachosOnReset(formulario){
	
	Reset(formulario);
    clearFind();	
    setFocusFirstFieldForm(formulario);	
	clearDataForm(formulario);
	clearRowAnticipos();
	clearCostos();	
	
	$("#concepto").val("LIQUIDACION MC: ");
	$("#fecha").val($("#fecha_static").val());	
	
	$("#refresh_QUERYGRID_LiquidacionDespachos").click();	
			
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
	
		   var formulario  = obj.form;	   			   
		   var despacho    = despacho.split("-");
		       despacho    = $.trim(despacho[0]);
		   var QueryString = "ACTIONCONTROLER=getDataDespacho&despacho="+despacho+"&despachos_urbanos_id="+despachos_urbanos_id;
		   
		   LiquidacionDespachosOnReset(formulario);	   
			  
		   if(!isNaN(parseInt(despachos_urbanos_id))){	    
		   
		   $.ajax({
			 url        : "LiquidacionDespachosClass.php?rand="+Math.random(),
			 data       : QueryString,
			 beforeSend : function(){
				showDivLoading();
				clearRowAnticipos();
				clearCostos();
			 },
			 success    : function(resp){
				 															 
			   try{
						 
				 var data = $.parseJSON(resp); 
														 
				 setFormWithJSON(formulario,resp,true);
				 
				 var concepto = $("#concepto").val();
				 $("#concepto").val(concepto+' '+despacho);
				 
				 removeDivLoading();
				 
				  var Tabla         = document.getElementById('tableLiquidacion');
				  var rowImpuestos  = document.getElementById('rowImpuestos');			  
				  var rowDescuentos = document.getElementById('rowDescuentos');			  
				  var rowAnticipos  = document.getElementById('rowAnticipos');
				  var despachos_urbanos_id = data[0]['despachos_urbanos_id'];
				  var numRow        = 2;
				  
				  QueryString  = "ACTIONCONTROLER=getLiquidacionDespachos&despachos_urbanos_id="+despachos_urbanos_id;
				  
				  $.ajax({
					url        : "LiquidacionDespachosClass.php?rand="+Math.random(),
					data       : QueryString,
					beforeSend : function(){
					  showDivLoading();
					},
					success    : function(resp){
																			
					  try{
											  
						 if($.trim(resp).length == 0 || resp == 'null'){
													
							alertJquery("<p align='center'>Este despacho no tiene anticipos !! <br> No se puede legalizar</p>","Validacion Liquidacion"); 
							Reset(formulario);
							return true;
							 
						 }else{
										
							 var data            = $.parseJSON(resp); 
							 var impuestos       = data[0]['impuestos'];
							 var descuentos      = data[0]['descuentos'];
							 var anticipos       = data[0]['anticipos'];						 
							 var valor_flete     = data[0]['valor_flete'];		
							 var valor_sobre_flete = data[0]['valor_sobre_flete'];								 
							 var valor_neto_pagar= data[0]['valor_neto_pagar'];						 						 
							 var saldo_por_pagar = data[0]['saldo_por_pagar'];						 						  
							 var totalImpuestos  = 0;
							 var totalDescuentos = 0;
							 var totalAnticipos  = 0; 
									
							$("#valor_flete").val(valor_flete);
							$("#valor_neto_pagar").val(valor_neto_pagar);
					$("#valor_sobre_flete").val(valor_sobre_flete);														
							$("#saldo_por_pagar").val(saldo_por_pagar);						
									
						   if(impuestos){											
									
							 for(var i = 0; i < impuestos.length; i++){
								 
								 if(i == 0){
																		
									 $(rowImpuestos).find("input[name=impuestos]").each(function(){
											
										var input = this;
										
										for(var llave in impuestos[0]){
																			
										  if(input.id == llave){
											  input.value = impuestos[0][llave];
											  
											  if(llave == 'valor'){
												  totalImpuestos += (impuestos[0][llave] * 1);										  
											  }
											  
										  }
										
										}
																								 
									 });							 
									 
								 }else{
		
									  var newRow       = Tabla.insertRow(numRow);
									  newRow.className = 'rowImpuestos';
									  newRow.innerHTML = rowImpuestos.innerHTML;
									  
									 $(newRow).find("input[name=impuestos]").each(function(){
											
										var input = this;
										
										for(var llave in impuestos[i]){
										
										  if(input.id == llave){
											  input.value = impuestos[i][llave];
											  
											  if(llave == 'valor'){
												  totalImpuestos += (impuestos[i][llave] * 1);
											  }									  
											  
										  }
										
										}
																								 
									 });
		
								 numRow++;                              
								 }
								 
								 
							 }	
							 
							 
						  }
									
							 numRow++;		
									
									
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
						 
						 if(anticipos){
							
							 for(var i = 0; i < anticipos.length; i++){
								 
								 if(i == 0){
																		
									 $(rowAnticipos).find("input[name=anticipos]").each(function(){
											
										var input = this;
										
										for(var llave in anticipos[0]){
																			
										  if(input.id == llave){
											  input.value = anticipos[0][llave];
											  
											  if(llave == 'valor'){
												  totalAnticipos += (anticipos[0][llave] * 1);										  
											  }
											  
										  }
										
										}
																								 
									 });							 
									 
								 }else{
		
									  var newRow       = Tabla.insertRow(numRow);
									  newRow.className = 'rowAnticipos';
									  newRow.innerHTML = rowAnticipos.innerHTML;
									  
									 $(newRow).find("input[name=anticipos]").each(function(){
											
										var input = this;
										
										for(var llave in anticipos[i]){
										
										  if(input.id == llave){
											  input.value = anticipos[i][llave];
											  
											  if(llave == 'valor'){
												  totalAnticipos += (anticipos[i][llave] * 1);
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
				   LiquidacionDespachosOnReset(formulario);
				   
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

function clearRowAnticipos(){
	
   $(".rowAnticipos").each(function(){
									
       if(this.id != 'rowAnticipos'){
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
	  var anticipos         = '';
	  var impuestos         = '';
	  var descuentos        = '';
	  var contAnticipos     = 0;
	  var contImpuestos     = 0;
	  var contDescuentos    = 0;
	  var fletes            = '';
	  	  
	  var QueryString       = '';	
	  var tableLiquidacion  = document.getElementById('tableLiquidacion');
						  
	  $(tableLiquidacion).find(".rowImpuestos").each(function(){			
			
		var rowImpuesto             = this;	
		var impuestos_despacho_id = '';
		var impuesto_id             = '';
		var nombre                  = '';
		var valor                   = '';
				
		$(rowImpuesto).find("input[name=impuestos]").each(function(){   
									
			if(this.id == 'impuestos_despacho_id'){
			   impuestos += '&impuestos['+contImpuestos+'][impuestos_despacho_id]='+this.value;							
			}else if(this.id == 'impuesto_id'){
				 impuestos += '&impuestos['+contImpuestos+'][impuesto_id]='+this.value;	
			}else if(this.id == 'nombre'){
				   impuestos += '&impuestos['+contImpuestos+'][nombre]='+this.value;	
			 }else if(this.id == 'base'){
					 impuestos += '&impuestos['+contImpuestos+'][base]='+this.value;	
			  }else if(this.id == 'valor'){
					 impuestos += '&impuestos['+contImpuestos+'][valor]='+this.value;	
			  }
			
															 
		});
		
		contImpuestos++;
								 
	  });		  
	  
	  QueryString += impuestos;		  	  
	  
	  $(tableLiquidacion).find(".rowDescuentos").each(function(){
															   				
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
	  	  
	  $(tableLiquidacion).find(".rowAnticipos").each(function(){
		
		var anticipos_despacho_id = '';
		var conductor               = '';
		var conductor_id            = '';
		var valor                   = '';
		var observaciones           = '';			
			
		$(this).find("input[name=anticipos]").each(function(){   
									
			if(this.id == 'anticipos_despacho_id'){
			   anticipos += '&anticipos['+contAnticipos+'][anticipos_despacho_id]='+this.value;							
			}else if(this.id == 'tenedor'){
				 anticipos += '&anticipos['+contAnticipos+'][tenedor]='+this.value;	
			}else if(this.id == 'tenedor_id'){
				   anticipos += '&anticipos['+contAnticipos+'][tenedor_id]='+this.value;	
			 }else if(this.id == 'valor'){
					 anticipos += '&anticipos['+contAnticipos+'][valor]='+this.value;	
			  }else if(this.id == 'numero'){
					 anticipos += '&anticipos['+contAnticipos+'][numero]='+this.value;	
			  }
			
															 
		});
			
		contAnticipos++;
															 
	  });		  
	  
	  QueryString += anticipos;
	  	 		 		  
      if(ValidaRequeridos(formulario)){
		   
		   var QueryString  = 'ACTIONCONTROLER=onclickSave&'+FormSerialize(formulario)+QueryString;
		   
		   $.ajax({
		     url        : "LiquidacionDespachosClass.php?rand="+Math.random(),
			 data       : QueryString,
			 beforeSend : function(){
				showDivLoading();
			 },
			 success  : function(resp){	
			 
			     var liquidacion_despacho_id = parseInt(resp);
				 
				 if(!isNaN(liquidacion_despacho_id)){
					 
				 	 $("#refresh_QUERYGRID_LiquidacionDespachos").click();	
					 
					 var url = "LiquidacionDespachosClass.php?ACTIONCONTROLER=onclickPrint&liquidacion_despacho_id="+liquidacion_despacho_id+"&rand="+Math.random();
					 
					 popPup(url,10,900,600);
					 
//					 document.location.href = "LiquidacionDespachosClass.php?"+QueryString;
					 
				 }else{
					 alertJquery(resp,"Validacion Liquidacion");
				  }
			 
			 
				// alertJquery(resp);				 
				 removeDivLoading();	
                 LiquidacionDespachoOnSaveOnUpdateonDelete(formulario);				 
		     }
			 
		   });
		   
       }											     

}

function onclickUpdate(objId,formulario){

      var obj               = document.getElementById(objId);
	  var formulario        = obj.form;	   
	  var anticipos         = '';
	  var impuestos         = '';
	  var descuentos        = '';
	  var contAnticipos     = 0;
	  var contImpuestos     = 0;
	  var contDescuentos    = 0;
	  var fletes            = '';
	  	  
	  var QueryString       = '';	
	  var tableLiquidacion  = document.getElementById('tableLiquidacion');
						  
	  $(tableLiquidacion).find(".rowImpuestos").each(function(){			
			
		var rowImpuesto             = this;	
		var impuestos_despacho_id = '';
		var impuesto_id             = '';
		var nombre                  = '';
		var valor                   = '';
				
		$(rowImpuesto).find("input[name=impuestos]").each(function(){   
									
			if(this.id == 'impuestos_despacho_id'){
			   impuestos += '&impuestos['+contImpuestos+'][impuestos_despacho_id]='+this.value;							
			}else if(this.id == 'impuesto_id'){
				 impuestos += '&impuestos['+contImpuestos+'][impuesto_id]='+this.value;	
			}else if(this.id == 'nombre'){
				   impuestos += '&impuestos['+contImpuestos+'][nombre]='+this.value;	
			 }else if(this.id == 'base'){
					 impuestos += '&impuestos['+contImpuestos+'][base]='+this.value;	
			  }else if(this.id == 'valor'){
					 impuestos += '&impuestos['+contImpuestos+'][valor]='+this.value;	
			  }else if(this.id == 'detalle_liquidacion_despacho_id'){
					 impuestos += '&impuestos['+contImpuestos+'][detalle_liquidacion_despacho_id]='+this.value;	
			  }
			
															 
		});
		
		contImpuestos++;
								 
	  });		  
	  
	  QueryString += impuestos;		  	  
	  
	  $(tableLiquidacion).find(".rowDescuentos").each(function(){
															   				
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
			  }else if(this.id == 'detalle_liquidacion_despacho_id'){
					 descuentos += '&descuentos['+contDescuentos+'][detalle_liquidacion_despacho_id]='+this.value;	
			  }
			
															 
		});
		
		contDescuentos++;
																 
	  });		  
	  
	  QueryString += descuentos;				  
	  	  
	  $(tableLiquidacion).find(".rowAnticipos").each(function(){
		
		var anticipos_despacho_id = '';
		var conductor               = '';
		var conductor_id            = '';
		var valor                   = '';
		var observaciones           = '';			
			
		$(this).find("input[name=anticipos]").each(function(){   
									
			if(this.id == 'anticipos_despacho_id'){
			   anticipos += '&anticipos['+contAnticipos+'][anticipos_despacho_id]='+this.value;							
			}else if(this.id == 'tenedor'){
				 anticipos += '&anticipos['+contAnticipos+'][tenedor]='+this.value;	
			}else if(this.id == 'tenedor_id'){
				   anticipos += '&anticipos['+contAnticipos+'][tenedor_id]='+this.value;	
			 }else if(this.id == 'valor'){
					 anticipos += '&anticipos['+contAnticipos+'][valor]='+this.value;	
			  }else if(this.id == 'numero'){
					 anticipos += '&anticipos['+contAnticipos+'][numero]='+this.value;	
			  }
			
															 
		});
			
		contAnticipos++;
															 
	  });		  
	  
	  QueryString += anticipos;
	  	 		 		  
      if(ValidaRequeridos(formulario)){
		   
   		   var QueryString  = 'ACTIONCONTROLER=onclickUpdate&'+FormSerialize(formulario)+QueryString;
		   
		   $.ajax({
		     url        : "LiquidacionDespachosClass.php?rand="+Math.random(),
			 data       : QueryString,
			 beforeSend : function(){
				showDivLoading();
			 },
			 success  : function(resp){
			 	 $("#refresh_QUERYGRID_LiquidacionDespachos").click();	
				 alertJquery(resp);
				 removeDivLoading();
				 LiquidacionDespachoOnSaveOnUpdateonDelete(formulario);
		     }
		   });		   
		 
       }
											     
}

function setLiquidacion(){
		
	$("#guardar,#actualizar").click(function(){
											 
      if(this.id == 'guardar'){		  
        calcularFlete(onclickSave,this.id,this.form);		  		  
	  }else{
          calcularFlete(onclickUpdate,this.id,this.form);		  
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