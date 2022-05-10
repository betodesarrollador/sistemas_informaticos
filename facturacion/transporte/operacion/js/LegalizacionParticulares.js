// JavaScript Document

$(document).ready(function(){

  autocompleteProveedor();
  addRowCosto();
  removeRowCosto();
  setLiquidacion();
  validaTipoDatoLegalizacion();  
  
});

function beforePrint(formulario,url,title,width,height){
	
	var encabezado_registro_id = parseInt($("#encabezado_registro_id").val());
	
	if(isNaN(encabezado_registro_id)){
	  
	  alertJquery('Debe seleccionar una legalizacion a imprimir !!!','Impresion orden');
	  return false;
	  
	}else{	  
	    return true;
	  }	
	
}

function setDataFormWithResponse(legalizacion_seguimiento_id){
	
	var formulario  = document.forms[0];	
	var QueryString = "ACTIONCONTROLER=onclickFind&legalizacion_seguimiento_id="+legalizacion_seguimiento_id;
	
	$.ajax({
	  url        : "LegalizacionParticularesClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
		  showDivLoading();
	  },
	  success    : function(resp){
		  
        try{
			
		  var data         = $.parseJSON(resp);
		  var anticipos    = data[0]['anticipos_Orden'];
		  var costos_viaje = data[0]['costos_viaje_Orden'];
		
		  setFormWithJSON(formulario,data[0]['legalizacion_Orden'],true);	
		  
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
		if($("#imprimir")) $("#imprimir").attr("disabled","");			
			
	    }catch(e){
			  alertJquery(resp,"Error: "+e);
			  removeDivLoading();
		  }
		
	  }
		
    });

}

function legalizacionOrdenOnSaveOnUpdateonDelete(formulario,resp){

   legalizacionOrdenOnReset(formulario);
   
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
	
   alertJquery(resp,"parametros Legalizacion");
   
}
function legalizacionOrdenOnReset(formulario){
	
	Reset(formulario);
    clearFind();	
    setFocusFirstFieldForm(formulario);	
	
	$("#concepto").val("LEGALIZACION ANTICIPOS PT: ");
	$("#fecha").val($("#fecha_static").val());	
	
    clearRowAnticipos();
    clearCostos();
		
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#imprimir'))   $('#imprimir').attr("disabled","true");	
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
}

function addRowCosto(obj){  	
       
  $("input[name=add]").click(function(){

      var seguimiento_id                       = $("#seguimiento_id").val();
	  
	  if($.trim(seguimiento_id).length > 0){
		  
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
		   alertJquery("Debe seleccionar un orden!!","Validacion Legalizacion orden");
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

function getDataOrden(seguimiento_id,text,obj){
	
	//$("#orden").blur(function(){
								   
       var legalizacion_particular_id = $("#legalizacion_particular_id").val();								   
	   
	   if(!legalizacion_particular_id > 0){	 
	
		   var orden  = $.trim(text).split("-");
		       orden  = $.trim(orden[0]);
		   var formulario  = obj.form;
		   var QueryString = "ACTIONCONTROLER=getDataOrden&orden="+orden+"&seguimiento_id="+seguimiento_id;
					  
		   if(parseInt(seguimiento_id) > 0){	    
		   
		   $.ajax({
			 url        : "LegalizacionParticularesClass.php?rand="+Math.random(),
			 data       : QueryString,
			 beforeSend : function(){
				showDivLoading();
				legalizacionOrdenOnReset(formulario);
			 },
			 success    : function(resp){
				 
			   try{
						 
				 var data = $.parseJSON(resp); 
				 
				 setFormWithJSON(formulario,resp,true);
				 
				 var concepto = $("#concepto").val();
				 $("#concepto").val(concepto+' '+orden);
				 
				 removeDivLoading();
				 
				  var Tabla         = document.getElementById('tableLegalizacion');
				  var rowAnticipos  = document.getElementById('rowAnticipos');
				  var seguimiento_id = data[0]['seguimiento_id'];
				  var numRow        = 2;
				  
				  QueryString  = "ACTIONCONTROLER=getAnticiposOrden&seguimiento_id="+seguimiento_id;
				  
				  $.ajax({
					url        : "LegalizacionParticularesClass.php?rand="+Math.random(),
					data       : QueryString,
					beforeSend : function(){
					  showDivLoading();
					},
					success    : function(resp){
						
					  try{
											  
						 if($.trim(resp).length == 0 || resp == 'null'){
													
							alertJquery("<p align='center'>Este orden no tiene anticipos !! <br> No se puede legalizar</p>","Validacion Legalizacion"); 
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
				   
				   alertJquery(resp,"orden : "+orden);
				   legalizacionOrdenOnReset(formulario);
				   
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

function setLiquidacion(){
		
	$("#guardar,#actualizar").click(function(){

	   var formulario   = this.form;	   
	   var anticipos    = '';
	   var numAnticipo  = 1;
	   var costos_viaje = '';
	   var numCosto     = 0;
	   
	   $("#rowAnticipos").each(function(){
										
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
										
	   });		
	   
      if(ValidaRequeridos(formulario)){
	   	   
       if(this.id == 'guardar'){
		   
		   var valorLegalizar = removeFormatCurrency($("#rowCostos").find("input[name=costos_viaje]&&input[id=valor]").val());
		   		   
		  if(valorLegalizar > 0){
		   
			   var QueryString  = 'ACTIONCONTROLER=onclickSave&'+FormSerialize(formulario)+anticipos+costos_viaje;
			   
			   $.ajax({
				 url        : "LegalizacionParticularesClass.php?rand="+Math.random(),
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
						
						 $("#legalizacion_particular_id").val(data['legalizacion_particular_id']);
						 $("#encabezado_registro_id").val(data['encabezado_registro_id']);
					   
						 onclickPrint(formulario,'LegalizacionParticularesClass.php?encabezado_registro_id='+encabezado_registro_id,'Impresion Legalizacion','900',
									  '600',null);
						 Reset();			     
					   } else { 
							  legalizacionOrdenOnReset(formulario);
						   }
						   
					   }); 
					 
					   legalizacionOrdenOnReset(formulario);	
					   
					   
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

		   
       }else{/*
		   
   		   var QueryString  = 'ACTIONCONTROLER=onclickUpdate&'+FormSerialize(formulario)+anticipos+costos_viaje;
		   
		   $.ajax({
		     url        : "LegalizacionParticularesClass.php?rand="+Math.random(),
			 data       : QueryString,
			 beforeSend : function(){
				showDivLoading();
			 },
			 success  : function(resp){
				 alertJquery(resp);
				 removeDivLoading();
 				 legalizacionOrdenOnSaveOnUpdateonDelete(formulario,resp);
		     }
		   });	*/	   
		   
		   
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