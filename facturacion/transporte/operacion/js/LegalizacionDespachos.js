// JavaScript Document
var formSubmitted = false;
$(document).ready(function(){

  autocompleteProveedor();
  addRowCosto();
  removeRowCosto();
  setLiquidacion();
  validaTipoDatoLegalizacion();  
  
});

function OnclickContabilizar(formu){ 
	var legalizacion_despacho_id 			 = $("#legalizacion_despacho_id").val();
	var fecha 			 					 = $("#fecha").val();
	var conductor_id 			 			 = $("#conductor_id").val();
	var despachos_urbanos_id	 			 = $("#despachos_urbanos_id").val();
	var despacho 			 			 	 = $("#despacho").val();
	var placa_id 			 			 	 = $("#placa_id").val();
	var contAnticipos     = 0;
	var contCostos     = 0;	
	var anticipos     = '';	
	var costos     = '';		
	
	var tableLegalizacion  = document.getElementById('tableLegalizacion');	
	
	var QueryString 		 = "ACTIONCONTROLER=getTotalDebitoCredito&legalizacion_despacho_id="+legalizacion_despacho_id;	
	if(parseInt(legalizacion_despacho_id)>0){
		if(!formSubmitted){	
			formSubmitted = true;			
			$.ajax({
			  url     : "LegalizacionDespachosClass.php",
			  data    : QueryString,
			  success : function(response){
						  
				  try{
					 var totalDebitoCredito = $.parseJSON(response); 
					 var totalDebito        = parseFloat(totalDebitoCredito[0]['debito']) > 0 ? totalDebitoCredito[0]['debito'] : 0;
					 var totalCredito       = parseFloat(totalDebitoCredito[0]['credito']) > 0 ? totalDebitoCredito[0]['credito'] : 0;
					 
					 $("#totalDebito").html(totalDebito);
					 $("#totalCredito").html(totalCredito);	
					 
					 if(parseFloat(totalDebito)==parseFloat(totalCredito) ){ 

						var QueryString = "ACTIONCONTROLER=OnclickContabilizar&legalizacion_despacho_id="+legalizacion_despacho_id+"&fecha="+fecha+"&conductor_id="+conductor_id+"&despachos_urbanos_id="+despachos_urbanos_id+"&despacho="+despacho+"&placa_id="+placa_id;	

						  $(tableLegalizacion).find(".rowCostos").each(function(){
																								
							var detalle_parametros_legalizacion_id = '';
							var tercero       = '';
							var tercero_id       = '';							
							var valor        = '';
									
							$(this).find("input[name=costos_viaje],select[name=costos_viaje]").each(function(){   
								if(this.id == 'detalle_parametros_legalizacion_id'){ 
 								  	costos += '&costos_viaje['+contCostos+'][detalle_parametros_legalizacion_id]='+this.value;													
								}else if(this.id == 'tercero'){
									 costos += '&costos_viaje['+contCostos+'][tercero]='+this.value;							
								}else if(this.id == 'tercero_id'){
									   costos += '&costos_viaje['+contCostos+'][tercero_id]='+this.value;	
								 }else if(this.id == 'valor'){
										 costos += '&costos_viaje['+contCostos+'][valor]='+this.value;	
								  }
								
																				 
							});
							contCostos++;

						  });		  
						  
						  QueryString += costos;				  

						  $(tableLegalizacion).find(".rowAnticipos").each(function(){

							var anticipos_despacho_id = '';
							var conductor               = '';
							var conductor_id            = '';
							var valor                   = '';
							var numero           = '';			
								
							$(this).find("input[name=anticipos]").each(function(){   
								if(this.id == 'anticipos_despacho_id'){
								   anticipos += '&anticipos['+contAnticipos+'][anticipos_despacho_id]='+this.value;							
								}else if(this.id == 'conductor'){
									 anticipos += '&anticipos['+contAnticipos+'][conductor]='+this.value;	
								}else if(this.id == 'conductor_id'){
									   anticipos += '&anticipos['+contAnticipos+'][conductor_id]='+this.value;	
								 }else if(this.id == 'valor'){
										 anticipos += '&anticipos['+contAnticipos+'][valor]='+this.value;	
								  }else if(this.id == 'numero'){
										 anticipos += '&anticipos['+contAnticipos+'][numero]='+this.value;	
								  }
								
																				 
							});
								
							contAnticipos++;
																				 
						  });		  
						  
						  QueryString += anticipos;



	
						$.ajax({
							url     : "LegalizacionDespachosClass.php",
							data    : QueryString,
							success : function(response){
						  
								try{
									 if($.trim(response) == 'true'){
										 alertJquery('Legalizacion Contabilizada','Contabilizacion Exitosa');
										 setDataFormWithResponse(legalizacion_despacho_id);
										 formSubmitted = false;	
									 }else{
										   alertJquery(response,'Inconsistencia Contabilizando');
									 }
									
		
								}catch(e){
								  
								}
							}
						});
					 }else{
						alertJquery('No existen sumas iguales :<b>NO SE CONTABILIZARA</b>','Contabilizacion'); 
					 }
				  }catch(e){
					  
				  }
			  }
			  
			}); 
			
		}
	}else{
		alertJquery('Debe Seleccionar primero una Legalizacion','Contabilizacion'); 
	}
}

function beforePrint(formulario,url,title,width,height){
	
	var encabezado_registro_id = parseInt($("#encabezado_registro_id").val());
	
	if(isNaN(encabezado_registro_id)){
	  
	  alertJquery('Debe seleccionar una legalizacion a imprimir !!!','Impresion despacho');
	  return false;
	  
	}else{	  
	    return true;
	  }	
	
}

function setDataFormWithResponse(legalizacion_despacho_id){
	
	var formulario  = document.forms[0];	
	var QueryString = "ACTIONCONTROLER=onclickFind&legalizacion_despacho_id="+legalizacion_despacho_id;
	
	$.ajax({
	  url        : "LegalizacionDespachosClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
          clearRowAnticipos();
          clearCostos();		  
		  showDivLoading();
	  },
	  success    : function(resp){
		  
        try{
			
		  var data         = $.parseJSON(resp);
		  var anticipos    = data[0]['anticipos_despacho'];
		  var costos_viaje = data[0]['costos_viaje_despacho'];
		
		  setFormWithJSON(formulario,data[0]['legalizacion_despacho'],true);	
		  
		  var Tabla         = document.getElementById('tableLegalizacion');
		  var rowAnticipos  = document.getElementById('rowAnticipos');	
		  var rowCostos     = document.getElementById('rowCostos');	
		  var numRow        = 2;
		  		  
				  
         if(anticipos){				  
				  
		 for(var i = 0; i < anticipos.length; i++){
			 
			 if(i == 0){
													
				 $(rowAnticipos).find("input[name=anticipos]").each(function(){
						
					var input = this;
					
					for(var llave in anticipos[0]){
														
					  if(input.id == llave){
						  input.value = anticipos[0][llave];						  
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
					  }
					
					}
																			 
				 });

			 numRow++;                              
			 }
			 
			 
		 }	
		 
		 
		}
		 
		 numRow = (numRow * 1) + 2;
		 
        if(costos_viaje){		 
		 
		 for(var i = 0; i < costos_viaje.length; i++){
			 
			 if(i == 0){
													
				 $(rowCostos).find("input[name=costos_viaje],select[name=costos_viaje]").each(function(){
						
					var input = this;
					
					for(var llave in costos_viaje[0]){
														
					  if(input.id == llave){
						  input.value = costos_viaje[0][llave];		 autocompleteProveedor();				  
					  }
					
					}
																			 
				 });							 
				 
			 }else{

				  var newRow       = Tabla.insertRow(numRow);
				  newRow.className = 'rowCostos';
				  newRow.innerHTML = rowCostos.innerHTML;
				  
				 $(newRow).find("input[name=costos_viaje],select[name=costos_viaje]").each(function(){
						
					var input = this;
					
					for(var llave in costos_viaje[i]){
					
					  if(input.id == llave){
						  input.value = costos_viaje[i][llave];  autocompleteProveedor();
					  }
					
					}
																			 
				 });

			 numRow++;                              
			 }
			 
			 
		 }			 
		 
		}
		  
		removeDivLoading();	 
		if($("#guardar"))  $("#guardar").attr("disabled","true");
		if(parseInt($("#encabezado_registro_id").val())>0){
			if($("#contabilizar"))  $("#contabilizar").attr("disabled","true");
			if($("#actualizar"))  $("#actualizar").attr("disabled","true");
		}else{
			if($("#contabilizar"))  $("#contabilizar").attr("disabled","");
			if($("#actualizar"))  $("#actualizar").attr("disabled","");
		
		}
		
		if($("#imprimir")) $("#imprimir").attr("disabled","");			
			
	    }catch(e){
			  alertJquery(resp,"Error: "+e);
			  removeDivLoading();
		  }
		
	  }
		
    });

}

function legalizacionManifiestoOnSaveOnUpdateonDelete(formulario,resp){

   legalizacionManifiestoOnReset(formulario);
   
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
	
   alertJquery(resp,"parametros Legalizacion");
   
}
function legalizacionManifiestoOnReset(formulario){

	Reset(formulario);
    clearFind();	
    setFocusFirstFieldForm(formulario);	
	
	$("#concepto").val("LEGALIZACION ANTICIPOS DU: ");
	$("#fecha").val($("#fecha_static").val());
	
    clearRowAnticipos();
    clearCostos();
		
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#imprimir'))   $('#imprimir').attr("disabled","true");	
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($("#contabilizar"))  $("#contabilizar").attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
}

function addRowCosto(obj){  	
       
  $("input[name=add]").click(function(){

      var despachos_urbanos_id                       = $("#despachos_urbanos_id").val();
	  
	  if($.trim(despachos_urbanos_id).length > 0){
		  
      var row                                 = this.parentNode.parentNode;							  
	  var detalle_parametros_legalizacion_id  = $(row).find("select[id=detalle_parametros_legalizacion_id] option:selected").val();
	  var tercero_id                          = $(row).find("input[name=costos_viaje]&&input[id=tercero_id]").val();
	  var valor                               = $(row).find("input[name=costos_viaje]&&input[id=valor]").val();
	  
	  if(detalle_parametros_legalizacion_id == 'NULL'){ 
	    alertJquery("Debe seleccionar un concepto de legalizacion!!!","Validacion Costos Viaje");		  
		return false;
	  }
	  
	  if(!parseInt(tercero_id) > 0){ 
	    alertJquery("Debe seleccionar un proveedor!!!","Validacion Costos Viaje");		  
		return false;
	  }	  
	  
	  if(!$.trim(valor).length > 0){ 
	    alertJquery("Debe digitar un valor!!!","Validacion Costos Viaje");		  
		return false;
	  }	 	  
	  
	  
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
          validaTipoDatoLegalizacion();		  
		  
	  }else{		  
		   alertJquery("Debe seleccionar un despacho!!","Validacion Legalizacion despacho");
		   return false;		  
		}
							  
  });

}

function removeRowCosto(){
  
    
	$("input[name=remove]").click(function(){
										   
        var row = this.parentNode.parentNode;
		
		$(row).remove();		
		  calculaTotalCosto();
		  calculaDiferencia();	
          validaTipoDatoLegalizacion();	
										   
    });
  
  
}

function getDataManifiesto(despachos_urbanos_id,text,obj){
	
	//$("#despacho").blur(function(){
								 
       var legalizacion_despacho_id = $("#legalizacion_despacho_id").val();								   
	   	   
	   if(!legalizacion_despacho_id > 0){	 
	
		   var despacho    = $.trim(text).split("-");
		       despacho    = despacho[0];
		   var formulario  = obj.form;
		   var QueryString = "ACTIONCONTROLER=getDataManifiesto&despacho="+despacho+"&despachos_urbanos_id="+despachos_urbanos_id;
					  
		   if(parseInt(despachos_urbanos_id) > 0){	    
		   
		   $.ajax({
			 url        : "LegalizacionDespachosClass.php?rand="+Math.random(),
			 data       : QueryString,
			 beforeSend : function(){
				showDivLoading();
				legalizacionManifiestoOnReset(formulario);
			 },
			 success    : function(resp){
				 
			   try{
						 
				 var data = $.parseJSON(resp); 
				 
				 setFormWithJSON(formulario,resp,true);
				 
				 var concepto = $("#concepto").val();
				 $("#concepto").val(concepto+' '+despacho);
				 
				 removeDivLoading();
				 
				  var Tabla         = document.getElementById('tableLegalizacion');
				  var rowAnticipos  = document.getElementById('rowAnticipos');
				  var despachos_urbanos_id = data[0]['despachos_urbanos_id'];
				  var numRow        = 2;
				  
				  QueryString  = "ACTIONCONTROLER=getAnticiposManifiesto&despachos_urbanos_id="+despachos_urbanos_id;
				  
				  $.ajax({
					url        : "LegalizacionDespachosClass.php?rand="+Math.random(),
					data       : QueryString,
					beforeSend : function(){
					  showDivLoading();
					},
					success    : function(resp){
						
					  try{
											  
						 if($.trim(resp).length == 0 || resp == 'null'){
													
							alertJquery("<p align='center'>Este despacho no tiene anticipos !! <br> No se puede legalizar</p>","Validacion Legalizacion"); 
							Reset(formulario);
							return true;
							 
						 }else{
																					  
							 var data           = $.parseJSON(resp); 
							 var totalAnticipos = 0; 
							 
							 for(var i = 0; i < data.length; i++){
								 
								 if(i == 0){
																		
									 $(rowAnticipos).find("input[name=anticipos]").each(function(){
											
										var input = this;
										
										for(var llave in data[0]){
																			
										  if(input.id == llave){
											  input.value = data[0][llave];
											  
											  if(llave == 'valor'){
												  totalAnticipos += (removeFormatCurrency(data[0][llave]) * 1);										  
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
										
										for(var llave in data[i]){
										
										  if(input.id == llave){
											  input.value = data[i][llave];
											  
											  if(llave == 'valor'){
												  totalAnticipos += (removeFormatCurrency(data[i][llave]) * 1);
											  }									  
											  
										  }
										
										}
																								 
									 });
		
								 numRow++;                              
								 }
								 
								 
							 }
							 
							 $("#total_anticipos").val(setFormatCurrency(totalAnticipos,0));
							 $("#total_costos_viaje").val("0");
						 
						}
						  
					  }catch(e){
						   alertJquery(resp,"Error :"+e);
						}                 
	
					  removeDivLoading();
					}
					
				  });		
				  
			   }catch(e){
				   
				   alertJquery(resp,"despacho : "+despacho);
				   legalizacionManifiestoOnReset(formulario);
				   
				 }
				 
										 
			 }
			 
		   });	
		   
		  }
		  
	  }
										 
   // });
	
}


function setProveedor(id,text,obj){
	
 var row = obj.parentNode.parentNode;
 
 $(row).find("#tercero_id").val(id);

}

function clearRowAnticipos(){
	
   $(".rowAnticipos").each(function(){
									
       if(this.id != 'rowAnticipos'){
		 $(this).remove();
	   }else{		   
	       $(this).find("input[name=remove]").replaceWith('<input type="button" name="add" id="add" value=" + " />');													
           addRowCosto();			   		   
		 }									
									
   });
     
	
}


function clearCostos(){

  $(".rowCostos").each(function(){	
	   if(this.id != 'rowCostos'){
		 $(this).remove();
	   }else{		   
		   //$(this).find("input[name=remove]").replaceWith('<input type="button" name="add" id="add" value=" + " />');													
		   addRowCosto();			   		   
		 }									
								
  });

  /*
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
		
  });*/
  

}

function autocompleteProveedor(){
	
  $("input[id=tercero]").keypress(function(event){

      ajax_suggest(this,event,"tercero","null",setProveedor,null,document.forms[0]);  
  
  });
  
}


function calculaTotalCosto(){	
	
	var total_costos_viaje = 0;
	
    $("input[name=costos_viaje]&&input[id=valor]").each(function(){
        total_costos_viaje += (removeFormatCurrency(this.value) * 1);
    });
	
	$("#total_costos_viaje").val(setFormatCurrency(total_costos_viaje,0));
	
}

function calculaDiferencia(){
	
	var diferencia         = 0;
	var total_anticipos    = (removeFormatCurrency($("#total_anticipos").val()) * 1);
	var total_costos_viaje = (removeFormatCurrency($("#total_costos_viaje").val()) * 1);
	
	if(total_costos_viaje > 0){
       diferencia = (total_anticipos - total_costos_viaje);
    }else{
         diferencia = 0;			     		
	  }	  
	
	$("#diferencia").val(setFormatCurrency(Math.abs(diferencia)));

}

function setLiquidacion(){
		
	$("#guardar,#actualizar").click(function(){

	   var formulario   = this.form;	   
	   var anticipos    = '';
	   var numAnticipo  = 1;
	   var costos_viaje = '';
	   var numCosto     = 0;
	   var tableLegalizacion  = document.getElementById('tableLegalizacion');	

	  $(tableLegalizacion).find(".rowCostos").each(function(){
																			
		var detalle_parametros_legalizacion_id = '';
		var tercero       = '';
		var tercero_id       = '';							
		var valor        = '';
				
		$(this).find("input[name=costos_viaje],select[name=costos_viaje]").each(function(){   
			if(this.id == 'detalle_parametros_legalizacion_id'){ 
				costos_viaje += '&costos_viaje['+numCosto+'][detalle_parametros_legalizacion_id]='+this.value;													
			}else if(this.id == 'tercero_id'){
				   costos_viaje += '&costos_viaje['+numCosto+'][tercero_id]='+this.value;	
			 }else if(this.id == 'valor'){
					 costos_viaje += '&costos_viaje['+numCosto+'][valor]='+this.value;	
			  }
			
															 
		});
		numCosto++;

	  });		  
	  
			  

	  $(tableLegalizacion).find(".rowAnticipos").each(function(){

		var anticipos_despacho_id = '';
		var conductor               = '';
		var conductor_id            = '';
		var valor                   = '';
		var numero           = '';			
			
		$(this).find("input[name=anticipos]").each(function(){   
			if(this.id == 'anticipos_despacho_id'){
			   anticipos += '&anticipos['+numAnticipo+'][anticipos_despacho_id]='+this.value;							
			}
			
															 
		});
			
		numAnticipo++;
															 
	  });		  
	  
	  

	 /*  $("#rowAnticipos").each(function(){
										
		  $(this).find("input[name=anticipos]").each(function(){
			   anticipos += '&anticipos[0]['+this.id+']='+this.value;																  
		  });
										
	   });
	   
	   $(".rowAnticipos").each(function(){
										
		  $(this).find("input[name=anticipos]").each(function(){
			   anticipos += '&anticipos['+numAnticipo+']['+this.id+']='+this.value;																  
		  });
		  
		  numAnticipo++;
										
	   });	
	   
	   $("#rowCostos").each(function(){

	      var adiciono = false;
			   
		  $(this).find("input[name=remove]").each(function(){  adiciono = true; return true; });

	      if(adiciono){
			  
			$(this).find("select,input[name=costos_viaje]").each(function(){																	 
			  costos_viaje += '&costos_viaje['+numCosto+']['+this.id+']='+this.value;	
			});
		  
		    numCosto++;
		    return true;
		  }
										
	   });
	   
	   $(".rowCostos").each(function(){
			
		  var adiciono = false;
		  var rowCosto = this;
		  
		  $(rowCosto).find("input[name=remove]").each(function(){  adiciono = true; return true  });		  
			
		  if(adiciono){
			  			  
			  $(rowCosto).find("select,input[name=costos_viaje]").each(function(){
				 costos_viaje += '&costos_viaje['+numCosto+']['+this.id+']='+this.value;																
			  });
			  
			  numCosto++;
		  
		  }
										
	   });		*/
	   
      if(ValidaRequeridos(formulario)){
	   var legalizacion_despacho_id = $("#legalizacion_despacho_id").val();			
	   var encabezado_registro_id = parseInt($("#encabezado_registro_id").val())>0?$("#encabezado_registro_id").val():'NULL';	
	   var despacho = $("#despacho").val();	
	    var despachos_urbanos_id = $("#despachos_urbanos_id").val();	
		var concepto = $("#concepto").val();
		var fecha = $("#fecha").val();
		var conductor = $("#conductor").val();
		var conductor_id = $("#conductor_id").val();
		var placa = $("#placa").val();
		var placa_id = $("#placa_id").val();
		var origen = $("#origen").val();
		var origen_id = $("#origen_id").val();
		var destino = $("#destino").val();
		var destino_id = $("#destino_id").val();
		var valor = $("#valor").val();
		var total_anticipos = $("#total_anticipos").val();
		var total_costos_viaje = $("#total_costos_viaje").val();
		var diferencia = $("#diferencia").val();
		var elaboro = $("#elaboro").val();
		var usuario_id = $("#usuario_id").val();		
		
	   
	   	   
       if(this.id == 'guardar'){
		   
		   var valorLegalizar = removeFormatCurrency($("#rowCostos").find("input[name=costos_viaje]&&input[id=valor]").val());
		   		   
		  if(valorLegalizar > 0){
		   
			   var QueryString  = 'ACTIONCONTROLER=onclickSave&legalizacion_despacho_id='+legalizacion_despacho_id+'&encabezado_registro_id='+encabezado_registro_id
			   +'&despacho='+despacho+'&despachos_urbanos_id='+despachos_urbanos_id+'&concepto='+concepto+'&fecha='+fecha+'&conductor='+conductor+'&conductor_id='+conductor_id
			   +'&placa='+placa+'&placa_id='+placa_id+'&origen='+origen+'&origen_id='+origen_id+'&destino='+destino+'&destino_id='+destino_id+'&valor='+valor
			   +'&total_anticipos='+total_anticipos+'&total_costos_viaje='+total_costos_viaje+'&diferencia='+diferencia+'&elaboro='+elaboro+'&usuario_id='+usuario_id+anticipos+costos_viaje;
			   
			   $.ajax({
				 url        : "LegalizacionDespachosClass.php?rand="+Math.random(),
				 data       : QueryString,
				 beforeSend : function(){
					showDivLoading();
				 },
				 success  : function(resp){
					 					 
					 removeDivLoading();
	
					 try{
						 
					 var data = $.parseJSON(resp);
					 
					 if(data['error']){
						 alertJquery(data['error'],"Validacion");
					 }else{					 
					 
					 jConfirm("<p align='center'>Se genero exitosamente el documento [ "+data['tipo_documento']+" : "+data['consecutivo']+"]<br>Desea Imprimir el documento contable</p>", "Legalizacion", 
					 function(r) {  
																						   
					   if(r) {  
						
						 $("#legalizacion_despacho_id").val(data['legalizacion_despacho_id']);
						 $("#encabezado_registro_id").val(data['encabezado_registro_id']);
					   
						 onclickPrint(formulario,'LegalizacionDespachosClass.php?encabezado_registro_id='+encabezado_registro_id,'Impresion Legalizacion','900',
									  '600',null);
						 Reset();			     
					   } else { 
							  legalizacionManifiestoOnReset(formulario);
						   }
						   
					   }); 
					 
					   legalizacionManifiestoOnReset(formulario);
					   
					   }
					 
					 }catch(e){
						  alertJquery(resp,"Error :"+e);
					   }
					 
				 }
				 
			   });
		   
	     }else{
			   alertJquery("Debe adicionar al menos un concepto de legalizacion!!!","Validacion Costos Viaje");
			   return false;
		   }

		   
       }else{
		   
   		   //var QueryString  = 'ACTIONCONTROLER=onclickUpdate&'+FormSerialize(formulario)+anticipos+costos_viaje;

		   var QueryString  = 'ACTIONCONTROLER=onclickUpdate&legalizacion_despacho_id='+legalizacion_despacho_id+'&encabezado_registro_id='+encabezado_registro_id
		   +'&despacho='+despacho+'&despachos_urbanos_id='+despachos_urbanos_id+'&concepto='+concepto+'&fecha='+fecha+'&conductor='+conductor+'&conductor_id='+conductor_id
		   +'&placa='+placa+'&placa_id='+placa_id+'&origen='+origen+'&origen_id='+origen_id+'&destino='+destino+'&destino_id='+destino_id+'&valor='+valor
		   +'&total_anticipos='+total_anticipos+'&total_costos_viaje='+total_costos_viaje+'&diferencia='+diferencia+'&elaboro='+elaboro+'&usuario_id='+usuario_id+anticipos+costos_viaje;

		   
		   $.ajax({
		     url        : "LegalizacionDespachosClass.php?rand="+Math.random(),
			 data       : QueryString,
			 beforeSend : function(){
				showDivLoading();
			 },
			 success  : function(resp){
				 alertJquery(resp);
				 removeDivLoading();
 				 legalizacionManifiestoOnSaveOnUpdateonDelete(formulario,resp);
		     }
		   });	
		   
		   
		 }	
		 
       }
											 
    });
	
}

function validaTipoDatoLegalizacion(){
	
  $("input[name=costos_viaje]&&input[id=valor]").keypress(function(event){																   
     var params = new Array({"campo":"valor","type":"numeric","length":null,"presicion":null,"patron":null,"mensaje":null,"value":null});
	 return SetValidacion(event,this,params);																	   												
  });	
  
  $("input[name=costos_viaje]&&input[id=valor]").keyup(function(event){
     setFormatCurrencyInput(this,0);
  });
  
	
}