// JavaScript Document
var formSubmitted = false;
$(document).ready(function(){

  autocompleteProveedor();
  addRowCosto();
  removeRowCosto();
  setLiquidacion();
  validaTipoDatoLegalizacion();  
  
 //inicio bloque reportar cumplido
   $("#reportar").click(function(){
		if(parseInt($("#manifiesto_id").val())>0){
			cumplirManifiestoCargaMinisterio();
		}else{
			alertJquery("Por favor escoja un manifiesto Legalizado.","Validacion");		
		}
  });

  //fin bloque reportar cumplido

  
});
function OnclickContabilizar(formu){ 
	var legalizacion_manifiesto_id 			 = $("#legalizacion_manifiesto_id").val();
	var fecha 			 					 = $("#fecha").val();
	var conductor_id 			 			 = $("#conductor_id").val();
	var manifiesto_id 			 			 = $("#manifiesto_id").val();
	var manifiesto 			 			 	 = $("#manifiesto").val();
	var placa_id 			 			 	 = $("#placa_id").val();
	var contAnticipos     = 0;
	var contCostos     = 0;	
	var anticipos     = '';	
	var costos     = '';		
	
	var tableLegalizacion  = document.getElementById('tableLegalizacion');	
	
	var QueryString 		 = "ACTIONCONTROLER=getTotalDebitoCredito&legalizacion_manifiesto_id="+legalizacion_manifiesto_id;	
	if(parseInt(legalizacion_manifiesto_id)>0){
		if(!formSubmitted){	
			formSubmitted = true;			
			$.ajax({
			  url     : "LegalizacionClass.php",
			  data    : QueryString,
			  success : function(response){
						  
				  try{
					 var totalDebitoCredito = $.parseJSON(response); 
					 var totalDebito        = parseFloat(totalDebitoCredito[0]['debito']) > 0 ? totalDebitoCredito[0]['debito'] : 0;
					 var totalCredito       = parseFloat(totalDebitoCredito[0]['credito']) > 0 ? totalDebitoCredito[0]['credito'] : 0;
					
					 $("#totalDebito").html(totalDebito);
					 $("#totalCredito").html(totalCredito);	
					 
					 if(parseFloat(totalDebito)==parseFloat(totalCredito) ){ 

						var QueryString = "ACTIONCONTROLER=OnclickContabilizar&legalizacion_manifiesto_id="+legalizacion_manifiesto_id+"&fecha="+fecha+"&conductor_id="+conductor_id+"&manifiesto_id="+manifiesto_id+"&manifiesto="+manifiesto+"&placa_id="+placa_id;	

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

							var anticipos_manifiesto_id = '';
							var conductor               = '';
							var conductor_id            = '';
							var valor                   = '';
							var numero           = '';			
								
							$(this).find("input[name=anticipos]").each(function(){   
								if(this.id == 'anticipos_manifiesto_id'){
								   anticipos += '&anticipos['+contAnticipos+'][anticipos_manifiesto_id]='+this.value;							
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
							url     : "LegalizacionClass.php",
							data    : QueryString,
							success : function(response){
						  
								try{
									 if($.trim(response) == 'true'){
										 alertJquery('Legalizacion Contabilizada','Contabilizacion Exitosa');
										 setDataFormWithResponse(legalizacion_manifiesto_id);
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
	  
	  alertJquery('¡Debe seleccionar una legalizacion a imprimir!','Impresion Manifiesto');
	  return false;
	  
	}else{	  
	    return true;
	  }	
	
}

function frameAnticipo(manifiesto_id) {
	if (parseInt(manifiesto_id) > 0) {
		
		$("#detalleFrameAnticipo").attr("src", "../clases/AnticiposClass.php?manifiesto_id=" + manifiesto_id + "&rand=" + Math.random());
		$("#divDatosFrame").dialog({
			title: 'Datos Anticipos',
			width: 1250,
			height: 570,
			closeOnEscape: true,
			show: 'scale',
			hide: 'scale'
		});

	} else {
		alertJquery("Por favor seleccione un manifiesto");
	}


}

function setDataFormWithResponse(legalizacion_manifiesto_id){
	
	var formulario  = document.forms[0];	
	var QueryString = "ACTIONCONTROLER=onclickFind&legalizacion_manifiesto_id="+legalizacion_manifiesto_id;
	
	$.ajax({
	  url        : "LegalizacionClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
          clearRowAnticipos();
		  clearCostos();	
          	  
		  showDivLoading();
	  },
	  success    : function(resp){
		  
        try{
			
		  var data         = $.parseJSON(resp);
		  var anticipos    = data[0]['anticipos_manifiesto'];
		  var costos_viaje = data[0]['costos_viaje_manifiesto'];
		  var tiempos_dat            	 = data[0]['tiempos_dat'];  // reportar cumplido
		
		  setFormWithJSON(formulario,data[0]['legalizacion_manifiesto'],true);	
		  
		  var Tabla         = document.getElementById('tableLegalizacion');
		  var rowAnticipos  = document.getElementById('rowAnticipos');	
		  var rowCostos     = document.getElementById('rowCostos');	
		  var Tabla_tie      = document.getElementById('tiempos_reg');  //reportar cumplido
		  var rowTiempos     = document.getElementById('rowTiempos');	//reportar cumplido
		  var numRow        = 2;
		  		//inicio reportar cumplido
		if(tiempos_dat){
		
		 for(var i = 0; i < tiempos_dat.length; i++){
			 
			 if(i == 0){
													
				 $(rowTiempos).find("input[name=tiempos]").each(function(){
						
					var input = this;

					
					for(var llave in tiempos_dat[0]){
													
					  if(input.id == llave){
						  input.value = tiempos_dat[0][llave];
						  
					  }
					  
					
					}
																			 
				 });							 
				 
			 }else{

				  var newRow       = Tabla_tie.insertRow(numRow);
				  newRow.className = 'rowTiempos';
				  newRow.innerHTML = rowTiempos.innerHTML;
				  
				 $(newRow).find("input[name=tiempos]").each(function(){
						
					var input = this;
					
					for(var llave in tiempos_dat[i]){
					
					  if(input.id == llave){
						  input.value = tiempos_dat[i][llave];
					  }
					
					}
																			 
				 });


			 numRow++;                              
			 }
			 
			 
		 }
		 
	   }
	   //fin reportar cumplido


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
						  input.value = costos_viaje[0][llave];						  
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
						  input.value = costos_viaje[i][llave];
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
   
   clearRowTiempos();// reportar cumplido
   
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
	
	$("#concepto").val("LEGALIZACION ANTICIPOS MC: ");
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

      var manifiesto_id                       = $("#manifiesto_id").val();
	  
	  if($.trim(manifiesto_id).length > 0){
		  
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
		   alertJquery("Debe seleccionar un manifiesto!!","Validacion Legalizacion Manifiesto");
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

function getDataManifiesto(manifiesto_id,text,obj){
	
	//$("#manifiesto").blur(function(){
								   
       var legalizacion_manifiesto_id = $("#legalizacion_manifiesto_id").val();								   
	   
	   if(!legalizacion_manifiesto_id > 0){	 
	
		   var manifiesto  = $.trim(text).split("-");
		       manifiesto  = $.trim(manifiesto[0]);
		   var formulario  = obj.form;
		   var QueryString = "ACTIONCONTROLER=getDataManifiesto&manifiesto="+manifiesto+"&manifiesto_id="+manifiesto_id;
					  
		   if(parseInt(manifiesto_id) > 0){	    
		   
		   $.ajax({
			 url        : "LegalizacionClass.php?rand="+Math.random(),
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
				 $("#concepto").val(concepto+' '+manifiesto);
				 
				 removeDivLoading();
				 
				  var Tabla         = document.getElementById('tableLegalizacion');
				  var rowAnticipos  = document.getElementById('rowAnticipos');
				  var Tabla_tie     = document.getElementById('tiempos_reg');// reportar cumplido
				  var rowTiempos  = document.getElementById('rowTiempos');	// reportar cumplido
				  var manifiesto_id = data[0]['manifiesto_id'];
				  var numRow        = 2;
				  
				  QueryString  = "ACTIONCONTROLER=getAnticiposManifiesto&manifiesto_id="+manifiesto_id;
				  
				  $.ajax({
					url        : "LegalizacionClass.php?rand="+Math.random(),
					data       : QueryString,
					beforeSend : function(){
					  showDivLoading();
					},
					success    : function(resp){
						
					  try{
											  
						 if($.trim(resp).length == 0 || resp == 'null'){
													
							alertJquery("<p align='center'>Este manifiesto no tiene anticipos !! <br> No se puede legalizar</p>","Validacion Legalizacion"); 
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
				  
							//INICIO  reportar cumplido
				  QueryString  = "ACTIONCONTROLER=getLiquidacionManifiesto&manifiesto_id="+manifiesto_id;
				  
				  $.ajax({
					url        : "LiquidacionClass.php?rand="+Math.random(),
					data       : QueryString,
					beforeSend : function(){
					  showDivLoading();
					},
					success    : function(resp){
											
					  try{
											  
						 if($.trim(resp).length == 0 || resp == 'null'){
													
							alertJquery("<p align='center'>Este manifiesto no tiene Remesas Asociadas !! <br> No se puede legalizar</p>","Validacion Legalizacion"); 
							Reset(formulario);
							return true;
							 
						 }else{
										
							 var data            = $.parseJSON(resp); 
							 var tiempos_dat       = data[0]['tiempos_dat'];

							numRow  = 2;	
							
							if(tiempos_dat){
							
							 for(var i = 0; i < tiempos_dat.length; i++){
								 
								 if(i == 0){
																		
									 $(rowTiempos).find("input[name=tiempos]").each(function(){
											
										var input = this;
					
										
										for(var llave in tiempos_dat[0]){
																		
										  if(input.id == llave){
											  input.value = tiempos_dat[0][llave];
											  
										  }
										  
										

										}
																								 
									 });							 
									 
								 }else{
					
									  var newRow       = Tabla_tie.insertRow(numRow);
									  newRow.className = 'rowTiempos';
									  newRow.innerHTML = rowTiempos.innerHTML;
									  
									 $(newRow).find("input[name=tiempos]").each(function(){
											
										var input = this;
										
										for(var llave in tiempos_dat[i]){
										
										  if(input.id == llave){
											  input.value = tiempos_dat[i][llave];
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


				//FIN reportar cumplido
	  				  
			   }catch(e){
				   
				   alertJquery(resp,"Manifiesto : "+manifiesto);
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
		
  }); */
  

}

//inicio reportar cumplido
function clearRowTiempos(){
	
   $(".rowTiempos").each(function(){
									
       if(this.id != 'rowTiempos'){
		   $(this).remove();
	   }									
									
   });
     
	
}
//fin reportar cumplido


function autocompleteProveedor(){
	
  $("input[name=costos_viaje]&&input[id=tercero]").keypress(function(event){

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

//inicio reportar cumplido
var formSubmitted = false;

function cumplirManifiestoCargaMinisterio(){
		
	if(!formSubmitted){
	
	  var QueryString = FormSerialize(document.forms[0])+"&ACTIONCONTROLER=cumplirManifiestoCargaMinisterio";
	  	
	  $.ajax({
		 url        : "LegalizacionClass.php?rand="+Math.random(),	 
		 data       : QueryString,
		 beforeSend : function(){			
			showDivMessage("Reportando al Ministerio de Transporte<br>Por Favor Espere..","/logiscom/framework/media/images/general/cable_data_transfer_md_wht.gif");
			formSubmitted = true;
		 },
		 success    : function(resp){			
					
			removeDivMessage();
			
			showDivMessage(resp,"/logiscom/framework/media/images/general/cable_data_transfer_md_wht.gif");			
			formSubmitted = false;
							
		 }
	  }); 
	  
	}
	
}
//fin reportar cumplido
function setLiquidacion(){
		
	$("#guardar,#actualizar").click(function(){

	   var formulario   = this.form;	   
	   var anticipos    = '';
	   var numAnticipo  = 1;
	   var tiempos     = '';// reportar cumplido
	   var costos_viaje = '';
	   var numCosto     = 0;
	   var contTiempos     = 0;// reportar cumplido
   	   var tiempos_reg  = document.getElementById('tiempos_reg');// reportar cumplido

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

		var anticipos_manifiesto_id = '';
		var conductor               = '';
		var conductor_id            = '';
		var valor                   = '';
		var numero           = '';			
			
		$(this).find("input[name=anticipos]").each(function(){   
			if(this.id == 'anticipos_manifiesto_id'){
			   anticipos += '&anticipos['+numAnticipo+'][anticipos_manifiesto_id]='+this.value;							
			}
			
															 
		});
			
		numAnticipo++;
															 
	  });		  
	  

	  /* $("#rowAnticipos").each(function(){
										
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
	   
	   	   // inicio reportar cumplido
	  $(tiempos_reg).find(".rowTiempos").each(function(){
		
		var tiempos_clientes_remesas_id = '';
		var fecha_llegada_descargue     = '';
		var hora_llegada_descargue      = '';
		var fecha_entrada_descargue     = '';
		var hora_entrada_descargue      = '';		
		var fecha_salida_descargue      = '';		
		var hora_salida_descargue       = '';		
			
		$(this).find("input[name=tiempos]").each(function(){   
									
			if(this.id == 'tiempos_clientes_remesas_id'){
			    tiempos += '&t['+contTiempos+'][tiempos_clientes_remesas_id]='+this.value;							
			}else if(this.id == 'fecha_llegada_descargue'){
				tiempos += '&t['+contTiempos+'][fecha_llegada_descargue]='+this.value;	
			}else if(this.id == 'hora_llegada_descargue'){
				tiempos += '&t['+contTiempos+'][hora_llegada_descargue]='+this.value;	
			}else if(this.id == 'fecha_entrada_descargue'){
				tiempos += '&t['+contTiempos+'][fecha_entrada_descargue]='+this.value;	
			}else if(this.id == 'hora_entrada_descargue'){
				tiempos += '&t['+contTiempos+'][hora_entrada_descargue]='+this.value;	
			}else if(this.id == 'fecha_salida_descargue'){
				tiempos += '&t['+contTiempos+'][fecha_salida_descargue]='+this.value;	
			}else if(this.id == 'hora_salida_descargue'){
				tiempos += '&t['+contTiempos+'][hora_salida_descargue]='+this.value;	
				
			}
			
															 
		});
			
		contTiempos++;
															 
	  });		  
	  //fin reportar cumplido

	   
      if(ValidaRequeridos(formulario)){
		  
	   var legalizacion_manifiesto_id = $("#legalizacion_manifiesto_id").val();			
	   var encabezado_registro_id = parseInt($("#encabezado_registro_id").val())>0?$("#encabezado_registro_id").val():'NULL';	
	   var manifiesto = $("#manifiesto").val();	
	    var manifiesto_id = $("#manifiesto_id").val();	
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
		   
			   var QueryString  = 'ACTIONCONTROLER=onclickSave&legalizacion_manifiesto_id='+legalizacion_manifiesto_id+'&encabezado_registro_id='+encabezado_registro_id
			   +'&manifiesto='+manifiesto+'&manifiesto_id='+manifiesto_id+'&concepto='+concepto+'&fecha='+fecha+'&conductor='+conductor+'&conductor_id='+conductor_id
			   +'&placa='+placa+'&placa_id='+placa_id+'&origen='+origen+'&origen_id='+origen_id+'&destino='+destino+'&destino_id='+destino_id+'&valor='+valor
			   +'&total_anticipos='+total_anticipos+'&total_costos_viaje='+total_costos_viaje+'&diferencia='+diferencia+'&elaboro='+elaboro+'&usuario_id='+usuario_id+anticipos+costos_viaje;
			   
			   $.ajax({
				 url        : "LegalizacionClass.php?rand="+Math.random(),
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
						
						 $("#legalizacion_manifiesto_id").val(data['legalizacion_manifiesto_id']);
						 $("#encabezado_registro_id").val(data['encabezado_registro_id']);
					   
						 onclickPrint(formulario,'LegalizacionClass.php?encabezado_registro_id='+encabezado_registro_id,'Impresion Legalizacion','900',
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

		   var QueryString  = 'ACTIONCONTROLER=onclickUpdate&legalizacion_manifiesto_id='+legalizacion_manifiesto_id+'&encabezado_registro_id='+encabezado_registro_id
		   +'&manifiesto='+manifiesto+'&manifiesto_id='+manifiesto_id+'&concepto='+concepto+'&fecha='+fecha+'&conductor='+conductor+'&conductor_id='+conductor_id
		   +'&placa='+placa+'&placa_id='+placa_id+'&origen='+origen+'&origen_id='+origen_id+'&destino='+destino+'&destino_id='+destino_id+'&valor='+valor
		   +'&total_anticipos='+total_anticipos+'&total_costos_viaje='+total_costos_viaje+'&diferencia='+diferencia+'&elaboro='+elaboro+'&usuario_id='+usuario_id+anticipos+costos_viaje;

		   
		   $.ajax({
		     url        : "LegalizacionClass.php?rand="+Math.random(),
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