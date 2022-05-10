// JavaScript Document

$(document).ready(function(){

  autocompleteProveedor();
  addRowCosto();
  removeRowCosto();
  setLiquidacionSobreDespa();

  setCalcularFlete();


});

function setCalcularFlete(){

  $("#calcularFlete").click(function(){
     calcularFlete(null,this.id,this.form);									 
  });
	
}

function calcularFlete(afterCalculation,objId,formulario){
						 
    var tenedor_id        = document.getElementById('tenedor_id').value;						 
    var valor_sobre_flete = document.getElementById('valor_sobre_flete').value;		
	
	if(!valor_sobre_flete > 0){
		alertJquery("Digite el valor pactado del Sobre flete por favor !!!","Validacion");
		return false;
	}
	
	var impuestos     = '';
	var descuentos    = '';
	var anticipos     = '';
	var contImpuesto  = 0;
	var contDescuento = 0;
	var contAnticipos = 0;
	var QueryString   = 'ACTIONCONTROLER=calcularFlete&valor_sobre_flete='+valor_sobre_flete+'&tenedor_id='+tenedor_id;
	
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
	
	
	
	$.ajax({
	  url        : "LiquidacionSobreDespaClass.php?rand="+Math.random(),
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
			 
			 
			 if(data['valor_neto_pagar']){
		           var valor_neto_pagar = data['valor_neto_pagar'];	   
				   $("#valor_neto_pagar").val(valor_neto_pagar);
             }
                        
			 
			  
		  }catch(e){
			   alertJquery(resp,"Error :");
			}
		 
		 
	   afterCalculation(objId,formulario);	 
	   } 
	  
    });
	      

}

function beforePrint(formulario,url,title,width,height){
	
	var liquidacion_despacho_sobre_id = parseInt($("#liquidacion_despacho_sobre_id").val());
	
	if(isNaN(liquidacion_despacho_sobre_id)){
	  
	  alertJquery('Debe seleccionar un Despacho a imprimir !!!','Impresion Liquidacion Sobre Flete');
	  return false;
	  
	}else{	  
	
	    var liquidacion_despacho_sobre_id = $("#liquidacion_despacho_sobre_id").val();
		
		if(liquidacion_despacho_sobre_id > 0){
			
		  return true;	
			
		}else{
			
			 alertJquery("No se puede mostrar impresion ya que esta liquidacion no se ha CAUSADO aun!!!","Impresion Liquidacion Sobre Flete");
			 return false;
			
		  }
		
	    return true;
	  }	
	
}


function Contabilizar(formulario){
	var liquidacion_despacho_sobre_id = $("#liquidacion_despacho_sobre_id").val();
	var fecha = $("#fecha").val();	
	
	if(parseInt(liquidacion_despacho_sobre_id)>0){
		var QueryString  = 'ACTIONCONTROLER=onclickContabilizar&liquidacion_despacho_sobre_id='+liquidacion_despacho_sobre_id+"&fecha="+fecha;
		
		$.ajax({
		 url        : "LiquidacionSobreDespaClass.php?rand="+Math.random(),
		 data       : QueryString,
		 beforeSend : function(){
			showDivLoading();
		 },
		 success  : function(resp){
			 //$("#refresh_QUERYGRID_LiquidacionDescuDespachos").click();
			 if($.trim(resp)=='true'){
				 alertJquery("Contabilizada exitosamente","Liquidacion Sobre Flete");
				 removeDivLoading();
				 setDataFormWithResponse(liquidacion_despacho_sobre_id);
			 }else{
 				 alertJquery(resp,"Liquidacion Sobre Flete");
 				 removeDivLoading();
			 }
		 }
		});		   
	}else{
		alertJquery("Por favor escoja primero un Registro","Validacion Contabilizacion");	
	}
	
}

function setDataFormWithResponse(liquidacion_despacho_sobre_id){
	
	var formulario  = document.forms[0];	
	var QueryString = "ACTIONCONTROLER=onclickFind&liquidacion_despacho_sobre_id="+liquidacion_despacho_sobre_id;
	
	$.ajax({
	  url        : "LiquidacionSobreDespaClass.php?rand="+Math.random(),
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

		
	
	    $("#concepto").val("LIQUIDACION SOBRE FLETE DU: ");
	    $("#fecha").val($("#fecha_static").val());			  
		  				
		try{
			
		 var data                   = $.parseJSON(resp); 		 
		 var encabezado_registro_id = $.trim(data[0]['encabezado_registro_id']);
		 var estado_liquidacion     = data[0]['estado_liquidacion'];
		 var impuestos              = data[0]['impuestos'];
		 var valor_sobre_flete      = data[0]['valor_sobre_flete'];						 		 
		 var valor_neto_pagar       = data[0]['valor_neto_pagar'];						 						 

		 var peso_total      		= data[0]['peso_total'];						 		 
		 var peso_vol_total      	= data[0]['peso_vol_total'];						 		 
		 var cantidad_total      	= data[0]['cantidad_total'];	
		  var valor_costos      	= data[0]['valor_costos'];	

		 var totalImpuestos         = 0;

		 var Tabla           = document.getElementById('tableLiquidacionSobreDespa');
		 var rowImpuestos    = document.getElementById('rowImpuestos');			  
		 var despachos_urbanos   = data[0]['despachos_urbanos'];
		 var numRow          = 2;		 
		 
         setFormWithJSON(formulario,resp,true);		 
				
		$("#valor_sobre_flete").val(valor_sobre_flete);		
		$("#valor_neto_pagar").val(valor_neto_pagar);
		
		$("#cantidad_peso").val(peso_total);		
		$("#cantidad_volu").val(peso_vol_total);
		$("#cantidad_galon").val(cantidad_total);
		$("#valor_galon").val(valor_costos);


				
		
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
				
        removeDivLoading();
		
		
		if($("#guardar"))        $("#guardar").attr("disabled","true");
		if($("#imprimir"))       $("#imprimir").attr("disabled","");			
		
		if(estado_liquidacion == 'L'){
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

function LiquidacionSobreDespaDespachoOnSaveOnUpdateonDelete(formulario,resp){

   LiquidacionSobreDespaDespachoOnReset(formulario);
   
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
	
}

function LiquidacionSobreDespaDespachoOnReset(formulario){
	
	Reset(formulario);
    clearFind();	
    setFocusFirstFieldForm(formulario);	
	clearDataForm(formulario);
	clearCostos();	
	
	$("#concepto").val("LIQUIDACION SOBRE FLETE DU: ");
	$("#fecha").val($("#fecha_static").val());	
	
	$("#refresh_QUERYGRID_LiquidacionSobreDespaDespachos").click();
			
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

function getDataDespacho(despachos_urbanos_id,despachos_urbanos,obj){
		   	   
	   if(despachos_urbanos_id > 0){
	
		   var formulario  = obj.form;	   		   
		   var despachos_urbanos  = despachos_urbanos.split("-");
		       despachos_urbanos  = despachos_urbanos[0];
		   var QueryString = "ACTIONCONTROLER=getDataDespacho&despachos_urbanos="+despachos_urbanos+"&despachos_urbanos_id="+despachos_urbanos_id;
				   
		   LiquidacionSobreDespaDespachoOnReset(formulario);	   
					  
          if(!isNaN(parseInt(despachos_urbanos_id))){	    
		   
		   $.ajax({
			 url        : "LiquidacionSobreDespaClass.php?rand="+Math.random(),
			 data       : QueryString,
			 beforeSend : function(){
				showDivLoading();
				clearCostos();

				
			 },
			 success    : function(resp){
									 
			   try{
						 
				 var data = $.parseJSON(resp); 
														 
				 setFormWithJSON(formulario,resp,true);
				 
				 var concepto = $("#concepto").val();
				 $("#concepto").val(concepto+' '+despachos_urbanos);
				 
				 removeDivLoading();
				  var Tabla_rem     = document.getElementById('remesas_reg');
				  var rowRemesa  = document.getElementById('rowRemesa');	

				 
				 
				  var Tabla         = document.getElementById('tableLiquidacionSobreDespa');
				  var rowImpuestos  = document.getElementById('rowImpuestos');			  
				  var despachos_urbanos = data[0]['despachos_urbanos'];
				  var numRow        = 2;
				  
				  QueryString  = "ACTIONCONTROLER=getLiquidacionSobreDespaDespacho&despachos_urbanos_id="+despachos_urbanos_id;
				  
				  $.ajax({
					url        : "LiquidacionSobreDespaClass.php?rand="+Math.random(),
					data       : QueryString,
					beforeSend : function(){
					  showDivLoading();
					},
					success    : function(resp){
											
					  try{
											  
						 if($.trim(resp).length == 0 || resp == 'null'){
													
							alertJquery("<p align='center'>Este despacho no tiene anticipos !! <br> No se puede legalizar</p>","Validacion LiquidacionSobreDespa"); 
							Reset(formulario);
							return true;
							 
						 }else{
										
							 var data            = $.parseJSON(resp); 
							 var impuestos       = data[0]['impuestos'];
							 var valor_sobre_flete = data[0]['valor_sobre_flete'];	
							 var saldo_por_pagar = data[0]['saldo_por_pagar'];

							 var peso_total      		= data[0]['peso_total'];						 		 
							 var peso_vol_total      	= data[0]['peso_vol_total'];						 		 
							 var cantidad_total      	= data[0]['cantidad_total'];	
							  var valor_costos      	= data[0]['valor_costos'];

							 var totalImpuestos  = 0;
									
							$("#valor_sobre_flete").val('');							
							$("#valor_neto_pagar").val('');

							$("#cantidad_peso").val(peso_total);		
							$("#cantidad_volu").val(peso_vol_total);
							$("#cantidad_galon").val(cantidad_total);
							$("#valor_galon").val(valor_costos);



							if(impuestos){
							
							 for(var i = 0; i < impuestos.length; i++){
								 
								 if(i == 0){
																		
									 $(rowImpuestos).find("input[name=impuestos]").each(function(){
											
										var input = this;
										
										for(var llave in impuestos[0]){
																			
										  if(input.id == llave){
											  if(llave != 'valor'){
												  input.value = impuestos[0][llave];
											  }
											  
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
											  if(llave != 'valor'){
												  input.value = impuestos[i][llave];
											  }
											  
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
						 
						}
						  
					  }catch(e){
						   alertJquery(resp,"Error :"+e);
						}                 
	
					  removeDivLoading();

					}
					
				  });		
				  
			   }catch(e){
				   
				   alertJquery(resp,"Despacho : "+despachos_urbanos);
				   LiquidacionSobreDespaDespachoOnReset(formulario);
				   
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
	  var impuestos         = '';
	  var contImpuestos     = 0;
	  var fletes            = '';
	  	  
	  var QueryString       = '';	
	  var tableLiquidacionSobreDespa  = document.getElementById('tableLiquidacionSobreDespa');
	  

	  var liquidacion_despacho_sobre_id 	=  $("#liquidacion_despacho_sobre_id").val();
	  var encabezado_registro_id 	=  $("#encabezado_registro_id").val();
	  var estado_liquidacion 	=  $("#estado_liquidacion").val();
	  var despachos_urbanos =  $("#despachos_urbanos").val();
	  var despachos_urbanos_id 	=  $("#despachos_urbanos_id").val();
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
	  var valor_flete 	=  $("#valor_flete").val();
	  var valor_sobre_flete	=  $("#valor_sobre_flete").val();
	  var observacion_sobre_flete	=  $("#observacion_sobre_flete").val();
	  var observaciones 	=  $("#observaciones").val();
	  var valor_neto_pagar	=  $("#valor_neto_pagar").val();
	  var saldo_por_pagar	=  $("#saldo_por_pagar").val();
	  var cantidad_galon	=  $("#cantidad_galon").val();
	  var cantidad_peso		=  $("#cantidad_peso").val();
	  var cantidad_volu		=  $("#cantidad_volu").val();
	  var valor_galon		=  $("#valor_galon").val();
	  var detalle_liquidacion_valor_flete_id	=  $("#detalle_liquidacion_valor_flete_id").val();	  
	  var detalle_liquidacion_valor_sobre_flete_id	=  $("#detalle_liquidacion_valor_sobre_flete_id").val();	
	   var detalle_liquidacion_saldo_por_pagar_id	=  $("#detalle_liquidacion_saldo_por_pagar_id").val();	  

	  QueryString = 'despachos_urbanos='+despachos_urbanos+'&despachos_urbanos_id='+despachos_urbanos_id+'&liquidacion_despacho_sobre_id='+liquidacion_despacho_sobre_id+'&encabezado_registro_id='+encabezado_registro_id
	  +'&estado_liquidacion='+estado_liquidacion+'&fecha_static='+fecha_static+'&fecha='+fecha+'&tenedor='+tenedor+'&tenedor_id='+tenedor_id+'&placa='+placa+'&placa_id='+placa_id
	  +'&origen='+origen+'&origen_id='+origen_id+'&destino='+destino+'&destino_id='+destino_id+'&total_anticipos='+total_anticipos+'&total_costos_viaje='+total_costos_viaje
	  +'&diferencia='+diferencia+'&usuario_id='+usuario_id+'&elaboro='+elaboro+'&concepto='+concepto+'&valor_flete='+valor_flete+'&valor_sobre_flete='+valor_sobre_flete
	  +'&observacion_sobre_flete='+observacion_sobre_flete+'&observaciones='+observaciones+'&valor_neto_pagar='+valor_neto_pagar+'&saldo_por_pagar='+saldo_por_pagar
	  +'&cantidad_galon='+cantidad_galon+'&cantidad_peso='+cantidad_peso+'&cantidad_volu='+cantidad_volu+'&valor_galon='+valor_galon+'&oficina_id='+oficina_id
	  +'&detalle_liquidacion_valor_flete_id='+detalle_liquidacion_valor_flete_id+'&detalle_liquidacion_valor_sobre_flete_id='+detalle_liquidacion_valor_sobre_flete_id
  	  +'&detalle_liquidacion_saldo_por_pagar_id='+detalle_liquidacion_saldo_por_pagar_id;	  


	  $(tableLiquidacionSobreDespa).find(".rowImpuestos").each(function(){			
			
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
	  



      if(ValidaRequeridos(formulario)){
		  		 		   
		   var QueryString  = 'ACTIONCONTROLER=onclickSave&'+QueryString;
		   
		   $.ajax({
		     url        : "LiquidacionSobreDespaClass.php?rand="+Math.random(),
			 data       : QueryString,
			 beforeSend : function(){
				showDivLoading();
			 },
			 success  : function(resp){				
			 			 
			     var liquidacion_despacho_sobre_id = parseInt(resp);
				 
				 if(!isNaN(liquidacion_despacho_sobre_id)){
					 
				 	 $("#refresh_QUERYGRID_LiquidacionSobreDespaDespachos").click();	
					 
					 var url = "LiquidacionSobreDespaClass.php?ACTIONCONTROLER=onclickPrint&liquidacion_despacho_sobre_id="+liquidacion_despacho_sobre_id+"&rand="+Math.random();
					 
					 popPup(url,10,900,600);
					 
//					 document.location.href = "LiquidacionSobreDespaDespachosClass.php?"+QueryString;
					 
				 }else{
					 alertJquery(resp,"Validacion");
				  }		 
			 
			 
				// alertJquery(resp,"LiquidacionSobreDespa");				 
				 removeDivLoading();	
                 LiquidacionSobreDespaDespachoOnSaveOnUpdateonDelete(formulario);				 
		     }
			 
		   });
		   
       }											     

}

var formSubmitted = false;

function onclickUpdate(objId,formulario){

      var obj               = document.getElementById(objId);
	  var formulario        = obj.form;	   
	  var impuestos         = '';
	  var contImpuestos     = 0;
	  var fletes            = '';
	  	  
	  var QueryString       = '';	
	  var tableLiquidacionSobreDespa  = document.getElementById('tableLiquidacionSobreDespa');

	  var liquidacion_despacho_sobre_id 	=  $("#liquidacion_despacho_sobre_id").val();
	  var encabezado_registro_id 	=  $("#encabezado_registro_id").val();
	  var estado_liquidacion 	=  $("#estado_liquidacion").val();
	  var despachos_urbanos =  $("#despachos_urbanos").val();
	  var despachos_urbanos_id 	=  $("#despachos_urbanos_id").val();
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
	  var total_costos_viaje	=  $("#total_costos_viaje").val();
	  var diferencia 	=  $("#diferencia").val();
	  var usuario_id	=  $("#usuario_id").val();
	  var oficina_id	=  $("#oficina_id").val();
	  var elaboro 		=  $("#elaboro").val();
	  var concepto		=  $("#concepto").val();
	  var valor_flete 	=  $("#valor_flete").val();
	  var valor_sobre_flete	=  $("#valor_sobre_flete").val();
	  var observacion_sobre_flete	=  $("#observacion_sobre_flete").val();
	  var observaciones 	=  $("#observaciones").val();
	  var valor_neto_pagar	=  $("#valor_neto_pagar").val();
	  var saldo_por_pagar	=  $("#saldo_por_pagar").val();
	  var cantidad_galon	=  $("#cantidad_galon").val();
	  var cantidad_peso		=  $("#cantidad_peso").val();
	  var cantidad_volu		=  $("#cantidad_volu").val();
	  var valor_galon		=  $("#valor_galon").val();
	  var detalle_liquidacion_valor_flete_id	=  $("#detalle_liquidacion_valor_flete_id").val();	   
	  var detalle_liquidacion_valor_sobre_flete_id	=  $("#detalle_liquidacion_valor_sobre_flete_id").val();
	  var detalle_liquidacion_saldo_por_pagar_id	=  $("#detalle_liquidacion_saldo_por_pagar_id").val();	  
	  

	  QueryString = 'despachos_urbanos='+despachos_urbanos+'&despachos_urbanos_id='+despachos_urbanos_id+'&liquidacion_despacho_sobre_id='+liquidacion_despacho_sobre_id+'&encabezado_registro_id='+encabezado_registro_id
	  +'&estado_liquidacion='+estado_liquidacion+'&fecha_static='+fecha_static+'&fecha='+fecha+'&tenedor='+tenedor+'&tenedor_id='+tenedor_id+'&placa='+placa+'&placa_id='+placa_id
	  +'&origen='+origen+'&origen_id='+origen_id+'&destino='+destino+'&destino_id='+destino_id+'&total_anticipos='+total_anticipos+'&total_costos_viaje='+total_costos_viaje
	  +'&diferencia='+diferencia+'&usuario_id='+usuario_id+'&elaboro='+elaboro+'&concepto='+concepto+'&valor_flete='+valor_flete+'&valor_sobre_flete='+valor_sobre_flete
	  +'&observacion_sobre_flete='+observacion_sobre_flete+'&observaciones='+observaciones+'&valor_neto_pagar='+valor_neto_pagar+'&saldo_por_pagar='+saldo_por_pagar
	  +'&cantidad_galon='+cantidad_galon+'&cantidad_peso='+cantidad_peso+'&cantidad_volu='+cantidad_volu+'&valor_galon='+valor_galon+'&oficina_id='+oficina_id
  	  +'&detalle_liquidacion_valor_flete_id='+detalle_liquidacion_valor_flete_id+'&detalle_liquidacion_valor_sobre_flete_id='+detalle_liquidacion_valor_sobre_flete_id
	  +'&detalle_liquidacion_saldo_por_pagar_id='+detalle_liquidacion_saldo_por_pagar_id;	  

	  $(tableLiquidacionSobreDespa).find(".rowImpuestos").each(function(){			
			
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
			  }else if(this.id == 'detalle_liquidacion_despacho_sobre_id'){
					 impuestos += '&impuestos['+contImpuestos+'][detalle_liquidacion_despacho_sobre_id]='+this.value;	
			  }
			
															 
		});
		
		contImpuestos++;
								 
	  });		  
	  
	  QueryString += impuestos;		  	  
	  



      if(ValidaRequeridos(formulario)){
		   
   		   var QueryString  = 'ACTIONCONTROLER=onclickUpdate&'+QueryString;
		   
		   $.ajax({
		     url        : "LiquidacionSobreDespaClass.php?rand="+Math.random(),
			 data       : QueryString,
			 beforeSend : function(){
				showDivLoading();
			 },
			 success  : function(resp){
			 	 $("#refresh_QUERYGRID_LiquidacionSobreDespaDespachos").click();					 
				 alertJquery(resp,"LiquidacionSobreDespa");
				 removeDivLoading();
				 LiquidacionSobreDespaDespachoOnSaveOnUpdateonDelete(formulario);
		     }
		   });		   
		 
       }
											     
}

function setLiquidacionSobreDespa(){
		
	$("#guardar,#actualizar").click(function(){
											 
      if(this.id == 'guardar'){		  
        calcularFlete(onclickSave,this.id,this.form);		  		  
	  }else{
          calcularFlete(onclickUpdate,this.id,this.form);		  
		}											 
											 
    });
	
}


function clearDataForm(){
	
	$(".rowImpuestos").each(function() { if(this.id != 'rowImpuestos') { $(this).remove(); } });

}