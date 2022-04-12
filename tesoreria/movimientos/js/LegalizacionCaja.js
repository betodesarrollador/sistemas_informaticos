// JavaScript Document
var formSubmitted = false;
$(document).ready(function(){		   

  autocompleteProveedor();
  addRowCosto();
  removeRowCosto();
  setLiquidacion();
  validaTipoDatoLegalizacion();  
  calculaTotalCostomov();
  calculaTotalCosto();
  
});

function calculaTotalCostomov(){

  $("input[id=valor]").blur(function(){
	   calculaTotalCosto();
   });

   $("input[id=valor]").keyup(function(event){
	   calculaTotalCosto();
   });

}
function OnclickLegalizar(formu){ 
	var legalizacion_caja_id	= $("#legalizacion_caja_id").val();
	var fecha_legalizacion		= $("#fecha_legalizacion").val();
	var contCostos     			= 0;	
	var costos     				= '';		
	
	var tableLegalizacion  = document.getElementById('tableLegalizacion');	
	var QueryString = "ACTIONCONTROLER=OnclickLegalizar&legalizacion_caja_id="+legalizacion_caja_id+"&fecha_legalizacion="+fecha_legalizacion;
	
	if(parseInt(legalizacion_caja_id)>0){
		if(!formSubmitted){	
			formSubmitted = true;			
			$.ajax({
			  url     : "LegalizacionCajaClass.php",
			  data    : QueryString,
			  success : function(response){
						  
				  try{
						
					 if($.trim(response) == 'true'){
						 alertJquery('Legalizacion Contabilizada','Contabilizacion Exitosa');
						 setDataFormWithResponse(legalizacion_caja_id);
						 formSubmitted = false;	
					 }else{
						   alertJquery(response,'Inconsistencia Contabilizando');
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
	  alertJquery('Debe seleccionar una legalizacion a imprimir !!!','Impresion Legalizacion');
	  return false;
	  	}else{	  
	    return true;
	  }		
}

function setDataFormWithResponse(legalizacion_caja_id){
	
	var formulario  = document.forms[0];	
	var QueryString = "ACTIONCONTROLER=onclickFind&legalizacion_caja_id="+legalizacion_caja_id;
	
	$.ajax({
	  url        : "LegalizacionCajaClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
          clearCostos();		  
		  showDivLoading();
	  },
	  success    : function(resp){
		  
        try{
			
		  var data         = $.parseJSON(resp);
		  var costos_legalizacion_caja = data[0]['costos_legalizacion_caja'];
		  var encabezado_registro_id   = data[0]['legalizacion_caja'][0]['encabezado_registro_id'];		  
		  var legalizacion_caja_id 	   = data[0]['legalizacion_caja'][0]['legalizacion_caja_id'];		  
		
		  setFormWithJSON(formulario,data[0]['legalizacion_caja'],true);	
		  
		  var Tabla         = document.getElementById('tableLegalizacion');
		  var rowCostos     = document.getElementById('rowCostos');	
		  var numRow        = 0;		  		  
		 
		  numRow = rowCostos.rowIndex + 1; 
		 
		 for(var i = 0; i < costos_legalizacion_caja.length; i++){
			 
			 if(i == 0){
												
				 $(rowCostos).find("input[name=costos_legalizacion_caja],select[name=costos_legalizacion_caja]").each(function(){

					var input = this;
					
					for(var llave in costos_legalizacion_caja[0]){														
					  if(input.id == llave){
						  input.value = costos_legalizacion_caja[0][llave];	
						  autocompleteProveedor();
						  calculaTotalCostomov();
					  }					
					}																			 
				 });	
				 
	             $(rowCostos).find("input[name=add]").replaceWith("<input type='button' name='remove' id='remove' value=' - ' />");	
		         removeRowCosto();				 
				 				 
			 }else{
	
				  var newRow       = Tabla.insertRow(numRow);
				  newRow.className = 'rowCostos';
				  newRow.innerHTML = rowCostos.innerHTML;
				  
				 $(newRow).find("input[name=costos_legalizacion_caja],select[name=costos_legalizacion_caja]").each(function(){
						
					var input = this;
					
					for(var llave in costos_legalizacion_caja[i]){					
					  if(input.id == llave){
						  input.value = costos_legalizacion_caja[i][llave];
						  autocompleteProveedor();
						  calculaTotalCostomov();
					  }		
					}																			 
				 });
				 
	             $(newRow).find("input[name=add]").replaceWith("<input type='button' name='remove' id='remove' value=' - ' />");	
		         removeRowCosto();					 
				 
				 numRow++;  
			 	  
			 }			 
		 }		
		 
		removeDivLoading();	 
		
		if($("#guardar"))  $("#guardar").attr("disabled","true");	
		if(parseInt($("#encabezado_registro_id").val())>0){
			if($("#legalizar"))  $("#legalizar").attr("disabled","true");
			if($("#actualizar"))  $("#actualizar").attr("disabled","true");
 
		}else{
			if($("#legalizar"))  $("#legalizar").attr("disabled","");
			if($("#actualizar"))  $("#actualizar").attr("disabled","");
		
		}
		if($("#imprimir")) $("#imprimir").attr("disabled","");	
  
		 var rowCostosNew       	= Tabla.insertRow(numRow);
		     rowCostosNew.className = 'rowCostos';		   
		     rowCostosNew.innerHTML = rowCostos.innerHTML;	  		   
		     Tabla.insertRow(newRow);	
		   
             $(rowCostosNew).find("input[name=remove]").replaceWith('<input type="button" name="add" id="add" value=" + " />');			             
			 addRowCosto();
		     autocompleteProveedor();
			 calculaTotalCostomov();
	    }catch(e){
			
			alert(e);
			  alertJquery(resp,"Error: "+e);
			  removeDivLoading();
		  }	
	   }		
    });
}

function legalizacionCajaOnSaveOnUpdateonDelete(formulario,resp){
	
   legalizacionCajaOnReset(formulario);   
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");	
   if($('#anular')) 	$('#anular').attr("disabled","");     
   //alertJquery(resp,"Parametros Legalizacion");   
}

function legalizacionCajaOnReset(formulario){
	
	Reset(formulario);
    clearFind();	
    setFocusFirstFieldForm(formulario);	
	
    $("#estado_legalizacion").val("E");
	$("#descripcion").val("LEGALIZACION CAJA: ");
	$("#fecha_legalizacion").val($("#fecha_static").val());
	$("#oficina_id").val($("#anul_oficina_id").val());
	$("#usuario_id").val($("#anul_usuario_id").val());
	$("#bandera").val('SI');	
    clearCostos();
	clearCostos();
		
    if($('#guardar'))    	$('#guardar').attr("disabled","");
    if($('#imprimir'))   	$('#imprimir').attr("disabled","true");	
    if($('#actualizar')) 	$('#actualizar').attr("disabled","true");
	if($("#legalizar"))     $("#legalizar").attr("disabled","true");
    if($('#borrar'))     	$('#borrar').attr("disabled","true");
	if($('#anular')) 		$('#anular').attr("disabled","");  	
    if($('#limpiar'))    	$('#limpiar').attr("disabled","");	

}

function addRowCosto(obj){  	
       
  $("input[name=add]").click(function(){
		  	  
      var row                                 		= this.parentNode.parentNode;							  
	  var detalle_parametros_legalizacion_caja_id  	= $(row).find("select[id=detalle_parametros_legalizacion_caja_id] option:selected").val();
	  var tercero_id                          		= $(row).find("input[name=costos_legalizacion_caja]&&input[id=tercero_id]").val();
	  var valor                               		= $(row).find("input[name=costos_legalizacion_caja]&&input[id=valor]").val();
	  var detalle_costo                             = $(row).find("input[name=costos_legalizacion_caja]&&input[id=detalle_costo]").val();	  
	  var centro_de_costo_id  						= $(row).find("select[id=centro_de_costo_id] option:selected").val();	 
	   var legalizacion_caja_id = $("#legalizacion_caja_id").val();		
	 	 	 	  
	  if(detalle_parametros_legalizacion_caja_id == 'NULL'){ 
	    alertJquery("Debe seleccionar un concepto de legalizacion!!!","Validacion Costos Legalizacion");		  
		return false;
	  }
	  
	  if(centro_de_costo_id == 'NULL'){ 
	    alertJquery("Debe seleccionar un Centro de Costo!!!","Validacion Costos Legalizacion");		  
		return false;
	  }	  
	  
	  if(!parseInt(tercero_id) > 0){ 
	    alertJquery("Debe seleccionar un proveedor!!!","Validacion Costos Legalizacion");		  
		return false;
	  }	  
	  
	  if(!$.trim(valor).length > 0){ 
	    alertJquery("Debe digitar un valor!!!","Validacion Costos Legalizacion");		  
		return false;
	  }	 	  
	  
	  var table    = row.parentNode;
	  var indexRow = row.rowIndex; 
	  var bandera = $("#bandera").val();
	  //var indexRow = 4;
	  if(parseInt(legalizacion_caja_id)>0)
	  indexRow--;
	  
	  if(bandera=='SI')
  	  indexRow--;
	  
 	  var newRow           = table.insertRow(indexRow);
      newRow.className = 'rowCostos';
      newRow.innerHTML = row.innerHTML;	
		  
	  autocompleteProveedor();
	  addRowCosto();
	  calculaTotalCostomov();
	
	 $(".rowCostos").each(function(){  indexRow++;  });
	
      $(row).find("input[name=add]").replaceWith("<input type='button' name='remove' id='remove' value=' - ' />");	
	  removeRowCosto();
	  
	  
	  	
	   var fecha_legalizacion = $("#fecha_legalizacion").val();
	   var total_costos_legalizacion_caja = removeFormatCurrency($("#total_costos_legalizacion_caja").val());
	   var oficina_id = $("#oficina_id").val();
      
	   var QueryString  = 'ACTIONCONTROLER=validaciontope&legalizacion_caja_id='+legalizacion_caja_id+'&fecha_legalizacion='+fecha_legalizacion+
	   '&total_costos_legalizacion_caja='+total_costos_legalizacion_caja+'&oficina_id='+oficina_id;
	 
	 $.ajax({
	   url        : "LegalizacionCajaClass.php?rand="+Math.random(),
	   data       : QueryString,
	   beforeSend : function(){
		 // showDivLoading();
	   },
	   success  : function(resp){
		   
	   if(resp=='SI' && parseInt(legalizacion_caja_id)>0){	
	      	   if($('#guardar'))    $('#guardar').attr("disabled","true");
    		   if($('#actualizar')) $('#actualizar').attr("disabled","");
			   if($("#legalizar"))  $("#legalizar").attr("disabled","");
	   }else if(resp=='SI' && !parseInt(legalizacion_caja_id)>0){			   
	      	   if($('#guardar'))    $('#guardar').attr("disabled","");
    		   if($('#actualizar')) $('#actualizar').attr("disabled","true");
			   if($("#legalizar"))  $("#legalizar").attr("disabled","true");
	   
		}else{
		   alertJquery(resp);
		       if($('#guardar'))    $('#guardar').attr("disabled","true");
    		   if($('#actualizar')) $('#actualizar').attr("disabled","true");
			   if($("#legalizar"))  $("#legalizar").attr("disabled","true");
		  }
		  // removeDivLoading();
	   }
	 });
	  
	  validaTipoDatoLegalizacion();						  
  });
}

function removeRowCosto(){    
	$("input[name=remove]").click(function(){										   
        var row = this.parentNode.parentNode;		
		$(row).remove();		
		  validaTipoDatoLegalizacion();											   
		  
	   var legalizacion_caja_id = $("#legalizacion_caja_id").val();			
	   var fecha_legalizacion = $("#fecha_legalizacion").val();
	   var total_costos_legalizacion_caja = removeFormatCurrency($("#total_costos_legalizacion_caja").val());
	   var oficina_id = $("#oficina_id").val();
      
	 var QueryString  = 'ACTIONCONTROLER=validaciontope&legalizacion_caja_id='+legalizacion_caja_id+'&fecha_legalizacion='+fecha_legalizacion+
	 '&total_costos_legalizacion_caja='+total_costos_legalizacion_caja+'&oficina_id='+oficina_id;
	 
	 $.ajax({
	   url        : "LegalizacionCajaClass.php?rand="+Math.random(),
	   data       : QueryString,
	   beforeSend : function(){
		  showDivLoading();
	   },
	   success  : function(resp){
		   
	   if(resp=='SI'){	
	      if(parseInt(legalizacion_caja_id) > 0)  {
	      	   if($('#guardar'))    $('#guardar').attr("disabled","true");
    		   if($('#actualizar')) $('#actualizar').attr("disabled","");
			   if($("#legalizar"))  $("#legalizar").attr("disabled","");
		  }else{
			   if($('#guardar'))    $('#guardar').attr("disabled","");
    		   if($('#actualizar')) $('#actualizar').attr("disabled","true");
			   if($("#legalizar"))  $("#legalizar").attr("disabled","true");
			  }
		}else{
		   alertJquery(resp);
		       if($('#guardar'))    $('#guardar').attr("disabled","true");
    		   if($('#actualizar')) $('#actualizar').attr("disabled","true");
			   if($("#legalizar"))  $("#legalizar").attr("disabled","true");
		  }
		   removeDivLoading();
	   }
	 });
    });  
}

function setProveedor(id,text,obj){	
 var row = obj.parentNode.parentNode; 
 $(row).find("#tercero_id").val(id);
}

function clearCostos(){
 $(".rowCostos").each(function(){	
							   
	   if(this.id != 'rowCostos'){
		 $(this).remove();

	   }else{	
     	   addRowCosto();			   		   
			$(this).find("input[name=remove]").replaceWith('<input type="button" name="add" id="add" value=" + " />');		   
	   }									
  });
}

function autocompleteProveedor(){	
  $("input[id=tercero]").keypress(function(event){
      ajax_suggest(this,event,"tercero","null",setProveedor,null);    
  });  
}

function calculaTotalCosto(){		
	var total_costos_legalizacion_caja = 0;	
    $("input[name=costos_legalizacion_caja]&&input[id=valor]").each(function(){
        total_costos_legalizacion_caja += (removeFormatCurrency(this.value) * 1);
    });	
	$("#total_costos_legalizacion_caja").val(setFormatCurrency(total_costos_legalizacion_caja,0));	
}

function setLiquidacion(){
		
	$("#guardar,#actualizar").click(function(){

	   var formulario   = this.form;	   
	   var costos_legalizacion_caja = '';
	   var numCosto     = 0;
	   var tableLegalizacion  = document.getElementById('tableLegalizacion');	

	  $(tableLegalizacion).find(".rowCostos").each(function(){
																			
		var detalle_parametros_legalizacion_caja_id	= '';
		var tercero       = '';
		var tercero_id    = '';							
		var valor         = '';
		var centro_de_costo_id	= '';							
		var detalle_costo		= '';		
				
		$(this).find("input[name=costos_legalizacion_caja],select[name=costos_legalizacion_caja]").each(function(){   
			if(this.id == 'detalle_parametros_legalizacion_caja_id'){ 
				costos_legalizacion_caja += '&costos_legalizacion_caja['+numCosto+'][d_p_l_c_id]='+this.value;													
			}else if(this.id == 'tercero_id'){
				   costos_legalizacion_caja += '&costos_legalizacion_caja['+numCosto+'][tercero_id]='+this.value;	
			 }else if(this.id == 'valor'){
					 costos_legalizacion_caja += '&costos_legalizacion_caja['+numCosto+'][valor]='+this.value;	
			  }else if(this.id == 'detalle_costo'){
					 costos_legalizacion_caja += '&costos_legalizacion_caja['+numCosto+'][det_c]='+this.value;	
			    }else if(this.id == 'centro_de_costo_id'){
					 costos_legalizacion_caja += '&costos_legalizacion_caja['+numCosto+'][cc_id]='+this.value;	
			    }else if(this.id == 'fecha'){
					 costos_legalizacion_caja += '&costos_legalizacion_caja['+numCosto+'][fe]='+this.value;	
					 
			   }																	 
		});
		numCosto++;
	  });	

	   
	  
      if(ValidaRequeridos(formulario)){
	   var legalizacion_caja_id = $("#legalizacion_caja_id").val();			
	   var encabezado_registro_id = parseInt($("#encabezado_registro_id").val())>0?$("#encabezado_registro_id").val():'NULL';	
       var descripcion = $("#descripcion").val();
	   var fecha_legalizacion = $("#fecha_legalizacion").val();
	   var total_costos_legalizacion_caja = $("#total_costos_legalizacion_caja").val();
	   var elaboro = $("#elaboro").val();
	   var usuario_id = $("#usuario_id").val();	
	   var oficina_id = $("#oficina_id").val();
	   var tipo_documento_id = $("#tipo_documento_id").val();
	   	   
       if(this.id == 'guardar'){
		   
		   var valorLegalizar = removeFormatCurrency($("#rowCostos").find("input[name=costos_legalizacion_caja]&&input[id=valor]").val());
		   		   
		  if(valorLegalizar > 0){
		   
			   var QueryString  = 'ACTIONCONTROLER=onclickSave&legalizacion_caja_id='+legalizacion_caja_id+'&encabezado_registro_id='+encabezado_registro_id
			   +'&descripcion='+descripcion+'&fecha_legalizacion='+fecha_legalizacion+'&total_costos_legalizacion_caja='+total_costos_legalizacion_caja+'&elaboro='+elaboro
			   +'&usuario_id='+usuario_id+'&oficina_id='+oficina_id+costos_legalizacion_caja;
			   
			   $.ajax({
				 url        : "LegalizacionCajaClass.php?rand="+Math.random(),
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
					 
					 jConfirm("<p align='center'>Se genero exitosamente la Legalización [ "+data['tipo_documento']+" : "+
																						 data['consecutivo']+"]<br>Desea Imprimir el documento contable</p>", "Legalizacion", 
					 
					 function(r) {  
																						   
					   if(r) {  
						
						 $("#legalizacion_caja_id").val(data['legalizacion_caja_id']);
						 $("#encabezado_registro_id").val(data['encabezado_registro_id']);
					   
						 onclickPrint(formulario,'LegalizacionCajaClass.php?encabezado_registro_id='+encabezado_registro_id,'Impresion Legalizacion','900','600',null);
						 Reset();			     
					   } else { 
							  legalizacionCajaOnReset(formulario);
						   }						   
					   }); 
					 
					   legalizacionCajaOnReset(formulario);
					   
					   }					 
					 }catch(e){
						  alertJquery(resp,"Error :"+e);
					   }					 
			    	}				 
			   });
		   
	     }else{
			   alertJquery("Debe adicionar al menos un concepto de legalizacion!!!","Validacion Costos Legalizacion");
			   return false;
		   }
		   
       }else{
		   
		   var QueryString  = 'ACTIONCONTROLER=onclickUpdate&legalizacion_caja_id='+legalizacion_caja_id+'&encabezado_registro_id='+encabezado_registro_id
			   +'&descripcion='+descripcion+'&fecha_legalizacion='+fecha_legalizacion+'&total_costos_legalizacion_caja='+total_costos_legalizacion_caja+'&elaboro='+elaboro
			   +'&usuario_id='+usuario_id+'&oficina_id='+oficina_id+costos_legalizacion_caja+'&tipo_documento_id='+tipo_documento_id;
		   
		   $.ajax({
		     url        : "LegalizacionCajaClass.php?rand="+Math.random(),
			 data       : QueryString,
			 beforeSend : function(){
				showDivLoading();
			 },
			 success  : function(resp){
				 if(resp=='true'){
					 alertJquery("Actualizado Exitosamente","Legalizacion");
				 }else{
	 				 alertJquery(resp,"error");
				 }
				 removeDivLoading();
 				 legalizacionCajaOnSaveOnUpdateonDelete(formulario,resp);
		     }
		   });		   
		 }			 
       }											 
    });	
}

function validaTipoDatoLegalizacion(){	
  $("input[name=costos_legalizacion_caja]&&input[id=valor]").keypress(function(event){																   
     var params = new Array({"campo":"valor","type":"numeric","length":null,"presicion":null,"patron":null,"mensaje":null,"value":null});
	 return SetValidacion(event,this,params);																	   												
  });	
  
  $("input[name=costos_legalizacion_caja]&&input[id=valor]").keyup(function(event){
     setFormatCurrencyInput(this,0);
  });	
}

function onclickCancellation(formulario){
	
	if($("#divAnulacion").is(":visible")){

	   var causal_anulacion_id 			  = $("#causal_anulacion_id").val();
	   var desc_anul_legalizacion_caja    = $("#desc_anul_legalizacion_caja").val();
	   var anul_legalizacion_caja   	  = $("#anul_legalizacion_caja").val();
	   
       if(ValidaRequeridos(formulario)){
	
	     var QueryString = "ACTIONCONTROLER=onclickCancellation&"+FormSerialize(formulario)+"&legalizacion_caja_id="+$("#legalizacion_caja_id").val();
		
	     $.ajax({
           url  : "LegalizacionCajaClass.php",
	       data : QueryString,
	       beforeSend: function(){
			   showDivLoading();
	       },
	       success : function(response){
		     if($.trim(response) == 'true'){
				 alertJquery('Legalizacion Anulada','Anulado Exitosamente');
				 $("#refresh_QUERYGRID_legalizacioncaja").click();
				 legalizacionCajaOnReset(formulario);  
				 clearCostos();
				// setDataFormWithResponse($("#legalizacion_caja_id").val());
			 }else{
				   alertJquery(response,'Inconsistencia Anulando');
			   }			   
			 removeDivLoading();
             $("#divAnulacion").dialog('close');			 
	       }	   
	     });	   
	   }	
    }else{
		
	 var legalizacion_caja_id  = $("#legalizacion_caja_id").val();
	 var estado_legalizacion   = $("#estado_legalizacion").val();
	 
	 if(parseInt(legalizacion_caja_id) > 0){		

	 var QueryString = "ACTIONCONTROLER=getEstadoEncabezadoRegistro&legalizacion_caja_id="+legalizacion_caja_id;
	 
	 $.ajax({
       url        : "LegalizacionCajaClass.php",
	   data       : QueryString,
	   beforeSend : function(){
		 showDivLoading();
	   },
	   success : function(response){
		   	   
		   var estado = response;
		   
		   if($.trim(estado) == 'E' || $.trim(estado) == 'C'){
			   
		    $("#divAnulacion").dialog({
			  title: 'Anulacion Legalizacion',
			  width: 650,
			  height: 280,
			  closeOnEscape:true
             });
			
		   }else{
		      alertJquery('Solo se permite anular en estado : <b>EDICION/CONTABILIZADO</b>','Anulacion');			   
		   }  			 
	     removeDivLoading();			 
	     }		 
	 });	 
		
	 }else{
		alertJquery('Debe Seleccionar primero un Registro ','Anulacion');
	  }			
   }  
}