// JavaScript Document
//eventos asignados a los objetos
$(document).ready(function(){

    $("#divAnulacion").css("display","none");	

	$("#importRemesas").click(function(){
		
		if($('#despachos_urbanos_id').val().length > 0){
			
			$("#divRemesas").dialog({
				title: 'Remesas a Despachar',
				width: 800,
				height: 395,
				closeOnEscape:true,
				show: 'scale',
				hide: 'scale'
			});
			
			var despachos_urbanos_id = $('#despachos_urbanos_id').val();
			var url           = "RemesaToDUClass.php?despachos_urbanos_id="+despachos_urbanos_id;
			$("#iframeRemesas").attr("src",url);
			
		}else {
			alertJquery('Debe Guardar o Seleccionar el Despacho');
		 }
		
	});	
	
	$("#deleteDetallesManifiesto").click(function(){
		window.frames[0].deleteDetallesManifiesto();
	});
	
   $("#remesasManifestar,#fletePactado,#anticipos,#divToolBarButtons").css("display","none");
   
   $("#detalleDespacho").load(function(){
      closeDialog();
   });   
   
   addNewRowAnticipo();
   addNewRowAnticipoTercero();
   
   $("#clon").css("display","none");
   $("#rowDTA").css("display","none");
   
   setManifiesto();
   autocompleteConductorAnticipo();
   autocompleteTenedorAnticipo();
   showSectionDTA(); 
   
   $("#calcularFlete").click(function(){ calcularFlete(null,this.id,this.form); });   
   
   $("input[name=numero_precinto]").keyup(function(){
       var valor = this.value;	   
	   $("input[name=numero_precinto]").val(valor);
   });
   
   $("#observaciones").blur(function(){

     var valor = $.trim(this.value);
	 
	 if(!valor.length > 0){
		 $("#observaciones").val("NINGUNA");
	 }
									 
   });
   
   validaNumeroFormulario();
   onclickSave();
	
   $("input[type=text]&&input[id=valor]").each(function(){
     setFormatCurrencyInput(this,2);														 
   });
   
   setValidacionAnticipos();
	
});

function closeDialog(){
	$("#divRemesas").dialog('close');
}

function setDataFormWithResponse(){
	
	var forma 		= document.forms[0];	
	var QueryString = "ACTIONCONTROLER=onclickFind&despachos_urbanos_id="+$('#despachos_urbanos_id').val();
	
	$.ajax({
       url        : 'DespachosUrbanosClass.php?random='+Math.random(),
	   data       : QueryString,
	   beforeSend : function(){
		   showDivLoading();
	   },
	   success    : function(resp){		   
		   	  
		try{
			
		   var data       = $.parseJSON(resp);
		   var despacho   = data[0]['despacho'];
		   var propio     = parseInt(despacho[0]['propio']);		   
		   var modalidad  = despacho[0]['modalidad'];		   
		   var estado     = despacho[0]['estado'];		   
								
		   if(modalidad == 'D'){
		     $("#rowDTA").css("display","");
		   }else{
			   $("#rowDTA").css("display","none");
		     }
		   
	       setFormWithJSON(forma,despacho,false,function(){														  
		   loadDetalle();
		   resetSeccionLiquidacion();
				
		   if(propio == 1){			  
			 
			 if(data[0]['anticipos'])  {
				 
			   var anticipos      = data[0]['anticipos'];  
			   var tableAnticipos = document.getElementById('tableAnticipos'); 
			 
			   clearAnticipos();
			 
			   for(var i = 0; i < anticipos.length; i++){
				 addNewAnticipo(anticipos[i]);
			   }
			 
			 }
			 
		     $(tableAnticipos).find("input[name=anticipo]&&input[id=conductor]").each(function(){
																							   
               if(!$.trim(this.value).length > 0){				   
				  this.value = $("#nombre").val();   
			   }               
			   
			 });		
			 
             $(tableAnticipos).find("input[name=anticipo]&&input[id=conductor_id]").each(function(){
				
			    if(!$.trim(this.value).length > 0){
                  this.value = $("#conductor_hidden").val(); 					
				}
			   
			 });				
			   
		   }else{

			    clearAnticipos();
			   			   
			    if(data[0]['impuestos']){
					
			       var impuestos  = data[0]['impuestos'];		
				   var indexRow   = 0;
				   				   
                   $(".rowImpuestos").each(function(){ indexRow = this.rowIndex; return false; });
				   $(".rowImpuestos").remove();
				   				   
				   var Table   = document.getElementById('tableFletePactado');				   
				   
				   for(var i = 0; i < impuestos.length; i++){
					   
				       var newRow           = Table.insertRow(indexRow);				   					   
					       newRow.className = 'rowImpuestos';
						   
				       $(newRow).html($("#clonImpuestos").html()); 					   
					   
					   for(var llave in impuestos[i]){
						   
						   $(newRow).find("input[name=impuesto]").each(function(){
																				
							  if(this.id == llave){
								  this.value = impuestos[i][llave];
							  }
							
                           });
						   
					   }
					   
					   indexRow++;
					   
				   }
				   
				}				
				
				if(data[0]['descuentos']){

			       var descuentos  = data[0]['descuentos'];		
				   var indexRow    = 0;
				   				   
                   $(".rowDescuentos").each(function(){ indexRow = this.rowIndex; return false; });
				   $(".rowDescuentos").remove();
				   				   
				   var Table   = document.getElementById('tableFletePactado');				   
				   
				   for(var i = 0; i < descuentos.length; i++){
					   
				       var newRow           = Table.insertRow(indexRow);				   					   
					       newRow.className = 'rowDescuentos';
						   
				       $(newRow).html($("#clonDescuentos").html()); 					   
					   
					   for(var llave in descuentos[i]){
						   
						   $(newRow).find("input[name=descuento]").each(function(){
																				
							  if(this.id == llave){
								  this.value = descuentos[i][llave];
							  }
							
                           });
						   
					   }
					   
					   indexRow++;
					   
				   }


				}
			   
				if(data[0]['anticipos']){

			       var anticipos  = data[0]['anticipos'];		
				   var indexRow   = 0;
				   				   				   
                   $(".rowAnticipos").each(function(){ indexRow = this.rowIndex; return false; });
				   $(".rowAnticipos").remove();
				   				   
				   var Table  = document.getElementById('tableFletePactado');				   				   				  											
										
				   for(var i = 0; i < anticipos.length; i++){
					   
				       var newRow           = Table.insertRow(indexRow);				   					   
					       newRow.className = 'rowAnticipos';
						   
				       $(newRow).html($("#clonAnticipos").html()); 		
					   
					   if(estado == 'P'){
                       $(newRow).find("input[name=addAnticipoTercero]").replaceWith("<input type='button' name='removeAnticipoTercero' id='removeAnticipoTercero' value=' - ' />");	
					   }else{
                              $(newRow).find("input[name=addAnticipoTercero]").replaceWith("<input type='button' name='removeAnticipoTercero' id='removeAnticipoTercero' value=' - ' disabled  />");							   
						   }
					   					   
					   for(var llave in anticipos[i]){
						   
						   $(newRow).find("select[name=anticipo],input[name=anticipo]").each(function(){
																				
							  if(this.id == llave){
								  this.value = anticipos[i][llave];
							  }
							
                           });
						   
					   }
					   
					   indexRow++;
					   
				   }
				   
			       var newRow           = Table.insertRow(indexRow);				   					   
			           newRow.className = 'rowAnticipos';
						   
				   $(newRow).html($("#clonAnticipos").html()); 				   
	               $(newRow).find("input[name=anticipo]&&input[id=tenedor_anticipo]").each(function(){this.value = $("#tenedor").val();});		
                   $(newRow).find("input[name=anticipo]&&input[id=tenedor_anticipo_id]").each(function(){this.value = $("#tenedor_id").val();});			
				  
				  removeAnticipoTercero();
				   

				}

				
			  }
			  
			  
           disabledInputsFormDespacho(forma);			  
			  			  
		   $("#valor_neto_pagar").val(despacho['valor_neto_pagar']);	  
		   $("#saldo_por_pagar").val(despacho['saldo_por_pagar']);	  

		   if($('#guardar'))    $('#guardar').attr("disabled","true");
           if($('#importRemesas'))  document.getElementById('importRemesas').disabled = false;
		   if($('#manifestar')) $('#manifestar').attr("disabled","true");
		   
		   if(estado == 'P'){
		     if($('#actualizar')) document.getElementById('actualizar').disabled = false;			   
		   }else{
		       if($('#actualizar')) document.getElementById('actualizar').disabled = true;
			 }
			 
			 			 
		   if(estado == 'P' || estado == 'M'){			   
		     if($('#anular')) document.getElementById('anular').disabled = false;			   
		   }else{
		       if($('#anular')) document.getElementById('anular').disabled = true;
			 }						 
			 
		   if(estado == 'P'){
		     if($('#importRemesas')) document.getElementById('importRemesas').disabled   = false;			   
		   }else{
		       if($('#importRemesas')) document.getElementById('importRemesas').disabled = true;
			 }		
			 
			 
		   if(estado == 'M'){
		     if($('#actualizar')) document.getElementById('actualizar').disabled = false;			   
		   }else{
		         if($('#actualizar')) document.getElementById('actualizar').disabled = true;			   
			 }				 
			 
		   if($('#imprimir'))   if(document.getElementById('imprimir'))document.getElementById('imprimir').disabled = false;
		   if($('#limpiar'))    $('#limpiar').attr("disabled","");
		   
		   addNewRowAnticipo();
		   addNewRowAnticipoTercero();
		   autocompleteConductorAnticipo();
		   autocompleteTenedorAnticipo();
		   removeDivLoading();		   
		   setValidacionAnticipos();
		   
		   
		   if(propio == 1){
			   
			   var tableAnticipos = document.getElementById('tableAnticipos');
			   
			   $(tableAnticipos).find("input[name=addAnticipo]").each(function(){
																		  
                   var row = this.parentNode.parentNode;																	  
				   
				   $(row).find("input[name=anticipo]").each(function(){ this.disabled = false; });
																		  
               });
			   
		   }else{
			   
			      var tableFletePactado = document.getElementById('tableFletePactado');
				  				  				  
				  $(tableFletePactado).find(".rowAnticipos").each(function(){																	   
																		   																				
                       $(this).find("input[name=addAnticipoTercero]").each(function(){
																   
                          var row = this.parentNode.parentNode;
						  
				          $(row).find("input[name=anticipo]").each(function(){ this.disabled = false; });
																   
                       });																		   
																		   
                  });
			   
			   
			  }
														  
         });		   
		 
		 
	   }catch(e){
		   //alertJquery(resp,"Error : "+e);
   		   removeDivLoading();
		 }
		 
	   }
    });
		

}

function resetSeccionLiquidacion(){
	
   var indexRowImpuestos  = '';
   var indexRowDescuentos = ''; 
   var indexRowAnticipos  = '';
	
   $(".rowImpuestos").each(function(){ indexRowImpuestos = this.rowIndex; return false; });
   $(".rowImpuestos").remove();	
   
   var rowImpuestosClon = document.getElementById('rowImpuestosClon');
   var Table            = document.getElementById('tableFletePactado');   
   
   for(var i = 0; i < rowImpuestosClon.rows.length; i++){
	   
	   var newRow           = Table.insertRow(indexRowImpuestos);				   					   
		   newRow.className = 'rowImpuestos';
		   
	   $(newRow).html($(rowImpuestosClon.rows[i]).html()); 					   
	   
	   indexRowImpuestos++;
	   
   }   

   $(".rowDescuentos").each(function(){ indexRowDescuentos = this.rowIndex; return false; });
   $(".rowDescuentos").remove();
   
   var rowDescuentosClon = document.getElementById('rowDescuentosClon');
   var Table             = document.getElementById('tableFletePactado');   
   
   for(var i = 0; i < rowDescuentosClon.rows.length; i++){
	   
	   var newRow           = Table.insertRow(indexRowDescuentos);				   					   
		   newRow.className = 'rowDescuentos';
		   
	   $(newRow).html($(rowDescuentosClon.rows[i]).html()); 					   

	   
	   indexRowDescuentos++;
	   
   }     

   $(".rowAnticipos").each(function(){ indexRowAnticipos = this.rowIndex; return false; });
   $(".rowAnticipos").remove();   
   
   var rowAnticiposClon = document.getElementById('rowAnticiposClon');
   var Table            = document.getElementById('tableFletePactado');   
   
   for(var i = 0; i < rowAnticiposClon.rows.length; i++){
	   
	   var newRow           = Table.insertRow(indexRowAnticipos);				   					   
		   newRow.className = 'rowAnticipos';
		   
	   $(newRow).html($(rowAnticiposClon.rows[i]).html()); 					   
	   
	   indexRowAnticipos++;
	   
       $(newRow).find("input[name=anticipo]&&input[id=tenedor_anticipo]").each(function(){this.value = $("#tenedor").val();});		
       $(newRow).find("input[name=anticipo]&&input[id=tenedor_anticipo_id]").each(function(){this.value = $("#tenedor_id").val();});	   
	   
   }  
   
   addNewRowAnticipoTercero();
   
   $("input[type=text]&&input[id=valor]").each(function(){
     setFormatCurrencyInput(this,2);														 
   }); 
   
   setValidacionAnticipos();

}

function loadDetalle(){
		
	var despachos_urbanos_id  = $('#despachos_urbanos_id').val();	
    var url            = "DetalleDespachosUrbanosClass.php?despachos_urbanos_id="+despachos_urbanos_id;
	var vehiculoPropio = document.getElementById('propio').value;
	
	document.getElementById('detalleDespacho').src = url;
	
	$("#remesasManifestar,#divToolBarButtons").css("display","");
		
	if(parseInt(vehiculoPropio) == 1){
		
		$("#anticipos").css("display","");
		$("#fletePactado").css("display","none");		
		
	}else{
		
   		  $("#anticipos").css("display","none");
		  $("#fletePactado").css("display","");				
		
	  }
	  
   if(document.getElementById('imprimir'))document.getElementById('imprimir').disabled    = false;	
   document.getElementById('guardar').disabled     = true;   
   document.getElementById('manifestar').disabled  = false;   
   updateGrid();
	
}

function DespachosUrbanosOnSave(formulario,resp){		

	try{
		
	  updateGrid();
	  
	  if($('#guardar'))    $('#guardar').attr("disabled","true");
	  if($('#limpiar'))    $('#limpiar').attr("disabled","")
	  
	  resp = $.parseJSON(resp);
	 
		  
	    $("#despachos_urbanos_id").val(resp[0]['despachos_urbanos_id']);
	    $("#despacho").val(resp[0]['despacho']);
	    $("#servicio_transporte_id").val(resp[0]['servicio_transporte_id']);
	    $("#propio").val(resp[0]['propio']);		
	    
	    $("#importRemesas").trigger("click");
		document.getElementById('importRemesas').disabled = false;
		
		var tableAnticipos = document.getElementById('tableAnticipos');
		
		$(tableAnticipos).find("input[name=anticipo]&&input[id=conductor]").each(function(){this.value = $("#nombre").val();                });		
        $(tableAnticipos).find("input[name=anticipo]&&input[id=conductor_id]").each(function(){this.value = $("#conductor_hidden").val();   });		

		$(".rowAnticipos").find("input[name=anticipo]&&input[id=tenedor_anticipo]").each(function(){this.value = $("#tenedor").val();       });		
        $(".rowAnticipos").find("input[name=anticipo]&&input[id=tenedor_anticipo_id]").each(function(){this.value = $("#tenedor_id").val(); });		

  
	}catch(e){
	  
	     var error = e;
	  
	     try{
	       resp = $.parseJSON(resp);
		 }catch(e){
			 alertJquery(resp,"Error :"+error);			 
		   }
		
		if($('#guardar'))    $('#guardar').attr("disabled","");
		if($('#actualizar')) $('#actualizar').attr("disabled","true");
		if($('#borrar'))     $('#borrar').attr("disabled","true");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");		 
		
	  }
	
}

function DespachosUrbanosOnUpdate(formulario,resp){

    if($.trim(resp) ==  'true'){
	  alertJquery("Despacho Actualizado Exitosamente","Despacho Carga");
	}else{
	    alertJquery(resp,"Error Actualizacion Despacho");
	}
	
	updateGrid();

}

function beforePrint(formulario,url,title,width,height){

	var despachos_urbanos_id = parseInt($("#despachos_urbanos_id").val());
	
	if(isNaN(despachos_urbanos_id)){
	  
	  alertJquery('Debe seleccionar un Despacho a imprimir !!!','Impresion Despacho');
	  return false;
	  
	}else{	  
	    return true;
	  }
	
}

function DespachosUrbanosOnDelete(formulario,resp){
	Reset(formulario);	
	DespachosUrbanosOnReset(formulario);
	clearFind();
	updateGrid();
	alertJquery(resp);
}

function separaNombre(conductor_id){
		
	var QueryString = "ACTIONCONTROLER=setDataConductor&conductor_id="+conductor_id;
	
	$.ajax({
	  url        : "DespachosUrbanosClass.php?random="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
		showDivLoading();
      },
	  success    : function(resp){		  
         setFormWithJSON(document.forms[0],resp,true);
	     removeDivLoading();
	  }
	});
	
	
}

function DespachosUrbanosOnReset(forma){
	
    enabledInputsFormDespacho(forma);	
	clearFind();
	clearAnticipos();
	resetSeccionLiquidacion();
	document.getElementById('detalleDespacho').src = "about:blank";
	
	$("#empresa_id").val($("#empresa_id_static").val());	
	$("#oficina_id").val($("#oficina_id_static").val());	
	$("#updateManifiesto").val('false');	
	
	document.getElementById('oficina_pago_saldo_id').value = $("#oficina_id_static").val();	
	document.getElementById('cargue_pagado_por').value     = 'T';
	document.getElementById('descargue_pagado_por').value  = 'C';	
	document.getElementById('estado').disabled = false;
	document.getElementById('estado').value    = 'P';	
	document.getElementById('estado').disabled = true;	
	$("#estado_dta").val("A");
	$("#observaciones").val("NINGUNA");
	
	$("#fecha_du,#fecha_entrega_mcia_du,#fecha_pago_saldo").val($("#fecha_static").val());	
	
	$("#aseguradora").val($("#aseguradora_static").val());	
	$("#poliza").val($("#poliza_static").val());	
	$("#vencimiento_poliza").val($("#vencimiento_poliza_static").val());		
	
	$("#valor_flete,#valor_neto_pagar,saldo_por_pagar,#remolque").val("0");		
    $("#remesasManifestar,#fletePactado,#anticipos,#divToolBarButtons").css("display","none");	
	
   $("#rowDTA").css("display","none");	
   $("#divAnulacion").css("display","none");
	
	$('#guardar').attr("disabled","");
	if($('#importRemesas'))  document.getElementById('importRemesas').disabled = true;
	$('#actualizar').attr("disabled","true");
    if($('#anular')) document.getElementById('anular').disabled = true;	
	$('#imprimir').attr("disabled","true");
	$('#limpiar').attr("disabled","");
	
}

function updateGrid(){
	$("#refresh_QUERYGRID_Manifiestos").click();
}

function setDataVehiculo(placa_id,placa){
		  
  if(parseInt(placa_id) > 0){
	  
	  var QueryString = "ACTIONCONTROLER=setDataVehiculo&placa_id="+placa_id;
	  
	  $.ajax({
	    url        : "DespachosUrbanosClass.php?rand="+Math.random(),
		data       : QueryString,
		beforeSend : function(){
		  showDivLoading()
		},
		success    : function(resp){					
		
            setFormWithJSON(document.forms[0],resp,true,function(){
               
			   var propio        = $("#propio").val();
			   var despachos_urbanos_id = $("#despachos_urbanos_id").val();
			   
			   if(despachos_urbanos_id > 0){
			   
				if(parseInt(propio) == 1){
					
					$("#anticipos").css("display","");
					$("#fletePactado").css("display","none");		
					
				}else{
					
					  $("#anticipos").css("display","none");
					  $("#fletePactado").css("display","");				
					
				  }
				  
				
			   }
			   
			   
            });
			
		    removeDivLoading();
			
		}
      });
	  	  
  }

}

function setDataTitular(tenedor_id,tenedor,obj){
  
  
  var QueryString = "ACTIONCONTROLER=setDataTitular&tenedor_id="+tenedor_id;
  
  $.ajax({
    url        : "DespachosUrbanosClass.php?rand="+Math.random(),
    data       : QueryString,
    beforeSend : function(){
      
    },
    success    : function(resp){
      
      try{
	
	var forma = obj.form;
	var data  = $.parseJSON(resp);
		
	for(var llave in data[0]){	  	  
	  $(forma).find("input[name="+llave+"]").val(data[0][llave]);
	}
	
      }catch(e){
	 alertJquery(resp,"Error: "+e);
       }
      
    }
  });
  
  
}

function addNewRowAnticipo(){
	
  $("input[name=addAnticipo]").click(function(){
	
	if(this.parentNode){
	
		var row           = this.parentNode.parentNode;
		var valorAnticipo = removeFormatCurrency($(row).find("input[name=anticipo]&&input[id=valor]").val());
		var conductor_id  = ($(row).find("input[name=anticipo]&&input[id=conductor_id]").val() * 1);
		
		if(!valorAnticipo > 0){
			alertJquery("Debe digitar un valor para el anticipo !!","Validacion Anticipo");
			return false;
		}
		
		if(!conductor_id > 0){
			alertJquery("Debe seleccionar un conductor!!","Validacion Anticipo");
			return false;
		}		
		
		var Table   = row.parentNode;
		var numRows = (Table.rows.length);
		var newRow  = Table.insertRow(numRows);
	
		$(newRow).html($("#clon").html()); 
	  
		$(newRow).find("input[type=text]:first").focus();
		addNewRowAnticipo();
	
		$(this).replaceWith("<input type='button' name='removeAnticipo' id='removeAnticipo' value=' - ' />");	
		removeAnticipo();
		autocompleteConductorAnticipo();
		
		$(newRow).find("input[name=anticipo]&&input[id=conductor]").each(function(){this.value = $("#nombre").val();});		
		$(newRow).find("input[name=anticipo]&&input[id=conductor_id]").each(function(){this.value = $("#conductor_hidden").val();});	
	
		$("input[name=anticipo]&&input[id=valor]").each(function(){
		 setFormatCurrencyInput(this,2);														 
		});
		
		setValidacionAnticipos();
	
    }

  });	  
	
}

function addNewRowAnticipoTercero(){
	
  $("input[name=addAnticipoTercero]").click(function(){
	
    if(this.parentNode){
		
		var row                 = this.parentNode.parentNode;		
		var valorAnticipo       = removeFormatCurrency($(row).find("input[name=anticipo]&&input[id=valor]").val());
		var tenedor_anticipo_id = ($(row).find("input[name=anticipo]&&input[id=tenedor_anticipo_id]").val() * 1);
		
		if(!valorAnticipo > 0){
			alertJquery("Debe digitar un valor para el anticipo !!","Validacion Anticipo");
			return false;
		}
		
		if(!tenedor_anticipo_id > 0){
			alertJquery("Debe seleccionar un tenedor!!","Validacion Anticipo");
			return false;
		}		
								
		var Table   = row.parentNode;
		var posRow  = parseInt(row.rowIndex) + (1 * 1);
		var newRow  = Table.insertRow(posRow);
			newRow.className = 'rowAnticipos';
	
		$(newRow).html($(row).html()); 
	  
		$(newRow).find("input[type=text]:first").focus();
		addNewRowAnticipoTercero();
	
		$(this).replaceWith("<input type='button' name='removeAnticipoTercero' id='removeAnticipoTercero' value=' - ' />");	
		removeAnticipoTercero();
		autocompleteTenedorAnticipo();
		
		$(newRow).find("input[name=anticipo]&&input[id=tenedor_anticipo]").each(function(){this.value = $("#tenedor").val();});		
		$(newRow).find("input[name=anticipo]&&input[id=tenedor_anticipo_id]").each(function(){this.value = $("#tenedor_id").val();});	
		
		$("#calcularFlete").trigger("click");
		
		$("input[name=anticipo]&&input[id=valor]").each(function(){
		 setFormatCurrencyInput(this,2);														 
		});	
		
		setValidacionAnticipos();
		
    }

  });	  
	
}

function addNewAnticipo(anticipo){
	
    var Table            = document.getElementById('tableAnticipos');
	var numRows          = Table.length;
    var newRow           = Table.insertRow(numRows);

    $(newRow).html($("#clon").html()); 
  
    $(newRow).find("input[type=text]:first").focus();
	addNewRowAnticipo();

    $(newRow).find("input[name=addAnticipo]").replaceWith("<input type='button' name='removeAnticipo' id='removeAnticipo' value=' - ' disabled />");		
    $(newRow).find("input[name=anticipo]&&input[id=anticipos_despacho_id]").each(function(){this.value = anticipo['anticipos_despacho_id'];});			
	$(newRow).find("input[name=anticipo]&&input[id=conductor]").each(function(){              this.value = anticipo['conductor'];              });		
    $(newRow).find("input[name=anticipo]&&input[id=conductor_id]").each(function(){           this.value = anticipo['conductor_id'];           });
    $(newRow).find("input[name=anticipo]&&input[id=valor]").each(function(){                  this.value = anticipo['valor'];                  });	
    $(newRow).find("input[name=anticipo]&&input[id=observaciones]").each(function(){          this.value = anticipo['observaciones'];          });		
	
    $("input[name=anticipo]&&input[id=valor]").each(function(){
     setFormatCurrencyInput(this,2);														 
    });	
	
	setValidacionAnticipos();
	
}

function addNewAnticipoTercero(anticipo){
	
    var Table   = document.getElementById('tableAnticiposTercero');
	var numRows = Table.length;
    var newRow  = Table.insertRow(numRows);

    $(newRow).html($("#clon").html()); 
  
    $(newRow).find("input[type=text]:first").focus();
	addNewRowAnticipo();

     $(newRow).find("input[name=addAnticipoTercero]").replaceWith("<input type='button' name='removeAnticipoTercero' id='removeAnticipoTercero' value=' - ' disabled  />");			
    $(newRow).find("input[name=anticipo]&&input[id=anticipos_despacho_id]").each(function(){this.value = anticipo['anticipos_despacho_id'];});			
	$(newRow).find("input[name=anticipo]&&input[id=tenedor_anticipo]").each(function(){       this.value = anticipo['tenedor'];                });		
    $(newRow).find("input[name=anticipo]&&input[id=tenedor_anticipo_id]").each(function(){    this.value = anticipo['tenedor_id'];             });
    $(newRow).find("input[name=anticipo]&&input[id=valor]").each(function(){                  this.value = anticipo['valor'];                  });	
    $(newRow).find("input[name=anticipo]&&input[id=observaciones]").each(function(){          this.value = anticipo['observaciones'];          });		
	
    $("input[name=anticipo]&&input[id=valor]").each(function(){
     setFormatCurrencyInput(this,2);														 
    });	
	
	setValidacionAnticipos();
	
}

function removeAnticipo(){
	
  $("input[name=removeAnticipo]").click(function(){

	var row  = this.parentNode.parentNode;

    $(row).remove();
	
	addNewRowAnticipo();

  });	  	
	
}

function removeAnticipoTercero(){
	
  $("input[name=removeAnticipoTercero]").click(function(){

	var row  = this.parentNode.parentNode;

    $(row).remove();
	
	addNewRowAnticipoTercero();
	
	$("#calcularFlete").trigger("click");

  });	  	
	
}

function onclickSave(){

   $("#guardar").click(function(){
								
		var modalidad = document.getElementById('modalidad').value;
		var valida    = true;
				
		if(modalidad == 'D'){
			
           $("#rowDTA").find("input[type=text],input[type=file],select").each(function(){
														   
               if(this.type == 'select-one'){
				   
				  if(this.value == 'NULL'){
					  alertJquery("Todos los campos en la seccion DTA son obligatorios");
					  valida = false;
				  } 
				   
			   }else{
				   
				    if($.trim(this.value).length == 0){
					  alertJquery("Todos los campos en la seccion DTA son obligatorios");
					  valida = false;
					}
				   
				}				
														   
           });	
		   
	       if(valida){
	         Send(this.form,'onclickSave',null,DespachosUrbanosOnSave,false);											
		   }else{
			    return false;
			 }		   
			
		}else{
            Send(this.form,'onclickSave',null,DespachosUrbanosOnSave,false);											
		  }
								
   });

}

function setManifiesto(){
	
   $("#manifestar,#actualizar").click(function(){
		calcularFlete(manifestar,this.id,this.form);									   
   });		
	
}

function manifestar(objId,formulario){
	
	if(objId == 'actualizar'){
	 document.getElementById('updateManifiesto').value = 'true';
	}else{
	    document.getElementById('updateManifiesto').value = 'false';
	  }		
	
    var despachos_urbanos_id = document.getElementById('despachos_urbanos_id').value;
    var QueryString   = 'ACTIONCONTROLER=asignoRemesasManifiesto&despachos_urbanos_id='+despachos_urbanos_id;

    $.ajax({
	  url        : "DespachosUrbanosClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
		 showDivLoading();
	  },
	  success    : function(resp){
		  
		if($.trim(resp) == 'false'){
		
		  alertJquery("Debe asignar remesas al despacho antes de manifestar!!!!","Validacion Remesas Despacho");
		  return false;
			
		}else{
			  
			removeDivLoading();	
	
			var modalidad = document.getElementById('modalidad').value;
			var valida    = true;
					
			if(modalidad == 'D'){
				
			   $("#rowDTA").find("input[type=text],input[type=file],select").each(function(){
															   
				   if(this.type == 'select-one'){
					   
					  if(this.value == 'NULL'){
						  alertJquery("Todos los campos en la seccion DTA son obligatorios","Validacion DTA");
						  valida = false;
					  } 
					   
				   }else{
					   
						if($.trim(this.value).length == 0){
						  alertJquery("Todos los campos en la seccion DTA son obligatorios","Validacion DTA");
						  valida = false;
						}
					   
					}				
															   
			   });	
			   
			   if(!valida){
				 return false;
			   }		   
				
			}
		
			  setCamposNulosForm(formulario);											   
				
			  var propio            = document.getElementById('propio').value;
			  var modalidad         = document.getElementById('modalidad').value;	  
			  var remolque          = parseInt(document.getElementById('remolque').value);	  
			  var anticipos         = '';
			  var impuestos         = '';
			  var descuentos        = '';
			  var numAnticipos      = 0;
			  var contAnticipos     = 0;
			  var contImpuestos     = 0;
			  var contDescuentos    = 0;
			  var fletes            = '';
			  
			  var actionControler      = document.getElementById('ACTIONCONTROLER');
		
			  if(actionControler){
				 actionControler.value = 'setManifiesto';
			  }	  
			  
			  var QueryString       = '';	
			  var tableAnticipos    = document.getElementById('tableAnticipos');
			  var tableFletePactado = document.getElementById('tableFletePactado');
			  var despacho        = document.getElementById('despacho').value;
			  
			  var valor_flete       = document.getElementById('valor_flete').value;
			  var valor_neto_pagar  = document.getElementById('valor_neto_pagar').value;
			  var saldo_por_pagar   = document.getElementById('saldo_por_pagar').value;	 
				  
		//	  QueryString += "&valor_flete="+valor_flete+"&valor_neto_pagar="+valor_neto_pagar+"&saldo_por_pagar="+saldo_por_pagar;
			  
			  if(remolque == 1){
				  
				  var placa_remolque_id = document.getElementById('placa_remolque_hidden').value;	  
				  
				  if(!placa_remolque_id > 0){
					  alertJquery("Debe seleccionar un remolque !!","Validacion Despacho");
					  return false;
				  }
				  
			  }	  
					  
			  if(parseInt(propio) == 1){
				  
				  var numAnticipos = parseInt(0);
				  
				  $(tableAnticipos).find("tr").each(function(){
					
					var adiciono = false;
					
					$(this).find("*[name=removeAnticipo]").each(function(){   
					  adiciono = true;    
					  numAnticipos += parseInt(1);
					  return true;
					});
					
					if(adiciono){
						
						var anticipos_despacho_id = '';
						var conductor               = '';
						var conductor_id            = '';
						var valor                   = '';
						var observaciones           = '';
						
						
						$(this).find("select[name=anticipo],input[name=anticipo]").each(function(){   
													
							if(this.id == 'anticipos_despacho_id'){
							   anticipos += '&anticipos['+contAnticipos+'][anticipos_despacho_id]='+this.value;							
							}else if(this.id == 'conductor'){
								 anticipos += '&anticipos['+contAnticipos+'][conductor]='+this.value;	
							}else if(this.id == 'conductor_id'){
								   anticipos += '&anticipos['+contAnticipos+'][conductor_id]='+this.value;	
							 }else if(this.id == 'valor'){
									 anticipos += '&anticipos['+contAnticipos+'][valor]='+this.value;	
							  }
							
																			 
						});
						
						contAnticipos++;
						
						
					}
		 
															 
				  });
				  
				 
				 QueryString += anticipos;
				 
			  }else{
				  
				  var valor_flete         = $("#valor_flete").val();		  
				  var valor_flete_validar = removeFormatCurrency(valor_flete) * 1;
					  
				  if(!valor_flete_validar > 0){			  		    	  
					  alertJquery("Debe asignar el valor del flete !!","Validacion Liquidacion Flete");
					  return false;
				  }		    
				  
				  var fecha_pago_saldo       = $("#fecha_pago_saldo").val();		  
				  var oficina_pago_saldo_id  = document.getElementById("oficina_pago_saldo_id").value;
				  var cargue_pagado_por      = document.getElementById("cargue_pagado_por").value;		  
				  var descargue_pagado_por   = document.getElementById("descargue_pagado_por").value;	
				  
				  if($.trim(fecha_pago_saldo).length > 0 && oficina_pago_saldo_id != 'NULL' && cargue_pagado_por != 'NULL' && 
					 descargue_pagado_por != 'NULL'){
				  
						var tableFletePactado = document.getElementById('tableFletePactado');		  
						$(tableFletePactado).find(".rowImpuestos").each(function(){			
						
						var impuestos_despachos_urbanos_id = '';
						var impuesto_id             = '';
						var nombre                  = '';
						var valor                   = '';
						
						
						$(this).find("input[name=impuesto]").each(function(){   
													
							if(this.id == 'impuestos_despachos_urbanos_id'){
							   impuestos += '&impuestos['+contImpuestos+'][impuestos_despachos_urbanos_id]='+this.value;							
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
				  
				  
				  $(tableFletePactado).find(".rowDescuentos").each(function(){
										
						var descuento_id = '';
						var nombre       = '';
						var valor        = '';						
						
						$(this).find("input[name=descuento]").each(function(){   
								
							if(this.id == 'descuentos_despachos_urbanos_id'){
							   descuentos += '&descuentos['+contDescuentos+'][descuentos_despachos_urbanos_id]='+this.value;													
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
				  
				  
				  $(tableFletePactado).find(".rowAnticipos").each(function(){
					
					var adiciono = false;
					
					$(this).find("*[name=removeAnticipoTercero]").each(function(){   
					  adiciono = true;    
					  numAnticipos += parseInt(1);
					  return true;
					});
					
					if(adiciono){
						
						var anticipos_despacho_id = '';
						var conductor               = '';
						var conductor_id            = '';
						var valor                   = '';
						var observaciones           = '';
						
						
						$(this).find("select[name=anticipo],input[name=anticipo]").each(function(){   
													
							if(this.id == 'anticipos_despacho_id'){
							   anticipos += '&anticipos['+contAnticipos+'][anticipos_despacho_id]='+this.value;							
							}else if(this.id == 'tenedor_anticipo'){
								 anticipos += '&anticipos['+contAnticipos+'][tenedor]='+this.value;	
							}else if(this.id == 'tenedor_anticipo_id'){
								   anticipos += '&anticipos['+contAnticipos+'][tenedor_id]='+this.value;	
							 }else if(this.id == 'valor'){
									 anticipos += '&anticipos['+contAnticipos+'][valor]='+this.value;	
							  }
							
																			 
						});
						
						contAnticipos++;
						
						
					}
		 
															 
				  });		  
				  
				  QueryString += anticipos;
				  
				  }else{
					  
					if(!$.trim(fecha_pago_saldo).length > 0) { 
					 alertJquery("Debe asignar la fecha para pago de saldo primero !!","Validacion")
					 return false;
					}
					
					if(oficina_pago_saldo_id == 'NULL'){
					 alertJquery("Debe asignar la Oficina para pago de saldo primero !!","Validacion")
					 return false;
						
					}
					
					if(cargue_pagado_por == 'NULL'){
					 alertJquery("Debe definir quien paga el cargue primero !!","Validacion")
					 return false;				
					}
					
					if(descargue_pagado_por == 'NULL'){
					 alertJquery("Debe definir quien paga el descargue primero !!","Validacion")
					 return false;				
					}
					
				  }		  
				  
				}
										
			  submitIframe(formulario,QueryString,objId,despacho);		
			 
			}
		  
	  } 
	  
    });

}

function submitIframe(formulario,QueryString,objId,despacho){
	
	enabledInputsFormDespacho(formulario);
    var option = 'setManifiesto';
	showDivLoading();
	document.getElementById('manifestar').disabled = true;
	if(document.getElementById('imprimir'))document.getElementById('imprimir').disabled   = true;	
         	   	   	  	 
	 $(formulario).find("input[type=checkbox]").each(function(){

       if(this.checked == false){
		   
         var Longitud    = this.name.length;
         var NombreCampo = this.name.substring(Longitud - 13,Longitud);
	  
	     if(NombreCampo == '_checked_file'){
			 
	        var fileDelete   = document.createElement("input");   		  
 	        fileDelete.type  = "hidden";
	        fileDelete.name  = this.name;         
            fileDelete.id    = this.name+'_hidden';         			
            fileDelete.value = 'false';	
			
			formulario.appendChild(fileDelete);
			   
		  }		 
		 
	   }else if(document.getElementById(this.name+'_hidden')){
            var objRemove = document.getElementById(this.name+'_hidden');		 
   			objRemove.parentNode.removeChild(objRemove);
		 }
															  
	 });
	 	     	   
	 var FrameEnvio      = document.getElementById('frmsend');
	 var ActionControler = document.getElementById('ACTIONCONTROLER');
	 
     if(!FrameEnvio){
     var  FrameEnvio      = document.createElement("iframe");
  	      FrameEnvio.width     = "0";     
		  FrameEnvio.height    = "0";
   		  FrameEnvio.name      = "frmsend";
   		  FrameEnvio.id        = "frmsend";
   		  FrameEnvio.className = "frmsend";		  
		  FrameEnvio.style.display = 'none';
		  
	 var  ControlerAction       = document.createElement("input");   		  
 	      ControlerAction.type  = "hidden";
	      ControlerAction.name  = "ACTIONCONTROLER";
   		  ControlerAction.id    = "ACTIONCONTROLER";
		  ControlerAction.value = option;
		  
	 var  TypeSend              = document.createElement("input");   		  
 	      TypeSend.type         = "hidden";
	      TypeSend.name         = "async";
   		  TypeSend.id           = "async";
		  TypeSend.value        = "true";

          formulario.appendChild(TypeSend);	
          formulario.appendChild(ControlerAction);	
          formulario.appendChild(FrameEnvio);				 	 
	 
	 }else{
		 $("#ACTIONCONTROLER").val(option);
	  }

     formulario.target  = "frmsend";		 
	 var formAction     = formulario.action;	 	 	 
	 formulario.action  = formAction+'?'+QueryString;
     
     setCamposNulosForm(formulario);	      	 	   		   
					   
 	 $("#frmsend").load(function() { 
	 	 
	    formulario.action  = formAction;
	 
        var response = getFrameContents(this);			 	
	   
	    if(response.substring(0,10) == 'ENDSESSION'){
		  logOut($.trim(response).substring(10));
	    }
	   
        $('#loading').html("");		
	  
	    RemovervaloresNulosForm(formulario);	  				
						
	    if($.trim(response) == 'true'){
				   
		var msj = '';
						
		if(objId == 'manifestar'){
		  msj = "<div align='center'><b>Despacho Numero: </b><font color='red' size='10'><b>"+despacho+"</b></font>generado exitosamente!!!</br></br> Desea Imprimir el Despacho ?</div>";
		}else{
			msj = "<div align='center'><b>Despacho Numero: </b><font color='red' size='10'><b>"+despacho+"</b></font>actualizado exitosamente!!!</br></br> Desea Imprimir el Despacho ?</div>";
		}
 				   
        jConfirm(msj, "Despacho de Carga",  
		function(r) {  
																					   
          if(r) {  

           onclickPrint(formulario,'DespachosUrbanosClass.php','Impresion Despacho Carga','900','600',null);						  
		   Reset(formulario);	
           DespachosUrbanosOnReset(formulario);
           clearFind();
           updateGrid();
				   
          } else { 
             Reset(formulario);	
             DespachosUrbanosOnReset(formulario);
             clearFind();
             updateGrid();				   
             return false;  
             }  
         }); 

	     }else{
			//alertJquery(response,"Error :");
		 }
			   
			   
	    removeDivLoading();
	   

	 });
	 	 
     formulario.submit();   
	
}

function autocompleteConductorAnticipo(){
	
  $("input[name=anticipo]&&input[id=conductor]").keypress(function(event){
	 ajax_suggest(this,event,"conductor","null",setConductorIdAnticipo,null,null);															   
  });	
	
}

function autocompleteTenedorAnticipo(){
	
  $("input[name=anticipo]&&input[id=tenedor_anticipo]").keypress(function(event){
	 ajax_suggest(this,event,"tenedor","null",setTenedorIdAnticipo,null,null);															   
  });	
	
}


function setConductorIdAnticipo(id,text,obj){
	
	var fila = obj.parentNode.parentNode;
	
	$(fila).find("input[name=anticipo]&&input[id=conductor_id]").val(id);
	
}

function setTenedorIdAnticipo(id,text,obj){
	
	var fila = obj.parentNode.parentNode;
	
	$(fila).find("input[name=anticipo]&&input[id=tenedor_anticipo_id]").val(id);
	
}

function clearAnticipos(){

  var Table   = document.getElementById('tableAnticipos');
  var numRows = Table.length;
  
  $(Table).find("tr").each(function(){
									
    if(this.id != 'clon'){
		
		var rowDefault = false;
		
		$(this).find("input[name=addAnticipo]").each(function(){
          rowDefault = true;
        });
		
		
		if(!rowDefault){
			$(this).remove();
		}
		
	}								
									
  });
  
  $("input[type=text]&&input[id=valor]").each(function(){
    setFormatCurrencyInput(this,2);														 
  });  
	
  setValidacionAnticipos();
  
}


function calcularFlete(afterCalculation,objId,formulario){

    var tenedor_id = document.getElementById('tenedor_id').value;
    var propio     = document.getElementById('propio').value;

   if(propio == 0){

    var valor_flete = document.getElementById('valor_flete').value;									 
	
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
	var QueryString   = 'ACTIONCONTROLER=calcularFlete&valor_flete='+valor_flete+'&tenedor_id='+tenedor_id;
	
	$(".rowImpuestos").each(function(){
	   
	   $(this).find("input[name=impuesto]").each(function(){
											   
         if(this.id == 'impuestos_despachos_urbanos_id'){
			 impuestos += '&impuestos['+contImpuesto+'][impuestos_despachos_urbanos_id]='+this.value;
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
	   
	   $(this).find("input[name=descuento]").each(function(){
											   
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
	   
	   $(this).find("input[name=removeAnticipoTercero]").each(function(){  adiciono = true; return true;  });	   
	   
	   if(adiciono){
		   
		   $(this).find("input[name=anticipo]").each(function(){
												   
			 if(this.id == 'anticipos_despacho_id'){
				 anticipos += '&anticipo['+contAnticipos+'][anticipos_despacho_id]='+this.value;
			 }else if(this.id == 'numero'){
				   anticipos += '&anticipo['+contAnticipos+'][numero]='+this.value;			 
			  }else if(this.id == 'valor'){
					  anticipos += '&anticipo['+contAnticipos+'][valor]='+this.value;			  
				}else if(this.id == 'tenedor_anticipo'){
						anticipos += '&anticipo['+contAnticipos+'][tenedor]='+this.value;			  
				  }else if(this.id == 'tenedor_anticipo_id'){
						  anticipos += '&anticipo['+contAnticipos+'][tenedor_id]='+this.value;			  
				   }else if(this.id == 'observaciones'){
						   anticipos += '&anticipo['+contAnticipos+'][observaciones]='+this.value;			  
					}
																							   
		   });
		   
		   contAnticipos++;
	   
	   }
	   
    });		
	
    QueryString += anticipos;	
	
	$.ajax({
	  url        : "DespachosUrbanosClass.php?rand="+Math.random(),
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
				  
			      $(".rowImpuestos").find("input[name=impuesto]&&input[id=impuesto_id]").each(function(){
																									  
				  if(this.value == impuesto_id){
					    
				    var row = this.parentNode.parentNode;
					
				    $(row).find("input[name=impuesto]&&input[id=valor]").val(valor);
				    $(row).find("input[name=impuesto]&&input[id=base]").val(base);					
					
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
				    
				$(".rowDescuentos").find("input[name=descuento]&&input[id=descuento_id]").each(function(){
																									    
					if(this.value == descuento_id){
							  
					  var row = this.parentNode.parentNode;
							  
					  $(row).find("input[name=descuento]&&input[id=valor]").val(valor);
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
			 
			 var saldo_por_pagar_validar = removeFormatCurrency(saldo_por_pagar); 
			 
			 if(saldo_por_pagar_validar >= 0){
			   if(afterCalculation) afterCalculation(objId,formulario);				 
			 }else{
				   alertJquery("El saldo por pagar no puede ser un valor negativo!!","Validacion Saldo");
				   return false;
			   }


			  
		  }catch(e){
			   alertJquery(resp,"Error :");
			}
		  
	   } 
	  
    });
	
  }else{	  
	    if(afterCalculation) afterCalculation(objId,formulario);
	 }
	    									 
}

function showSectionDTA(){

  $("#modalidad").change(function(){
     
	 if(this.value == 'D'){
	   $("#rowDTA").css("display","");
	   $("#rowMANIFIESTO").css("display","none");	  
     }else{
	 	   $("#rowDTA").css("display","none");
	       $("#rowMANIFIESTO").css("display","");		
	   }
	 
  });
	
}

function setDataProducto(id,text,obj){
	
	var dataProducto = text.split("-");
	var codigo       = $.trim(dataProducto[0]);
	var producto     = $.trim(dataProducto[1].substring(0,17));	
	
	$("#producto_id").val(id);
	$("#codigo").val(codigo);		
	$("#producto").val(producto);	
	
}

function validaNumeroFormulario(){
		
	$("#numero_formulario").blur(function(){

        var obj               = this;
        var numero_formulario = this.value;
		var QueryString       = "ACTIONCONTROLER=validaNumeroFormulario&numero_formulario="+numero_formulario;
		
		$.ajax({
		  url        : "DespachosUrbanosClass.php?rand="+Math.random(),
		  data       : QueryString,
		  beforeSend : function(){
			showDivLoading();
		  },
		  success    : function(resp){
			  			  
			  try{
				  
				var formulario = $.trim(resp);  
				
				if(formulario == "true"){
					alertJquery("Ya existe un formulario ingresado con este numero : [ "+numero_formulario+" ] ");
					obj.value = '';
					return false;
				}else if(formulario != "false"){
					    alertJquery(resp);
					}
				  
			  }catch(e){
				    alertJquery(resp," Error :"+e);
				}
			  
			  removeDivLoading();
		  }
		});         										  
										  
    });	
	
}


function setValidacionAnticipos(){

   $("input[type=text]&&input[name=anticipo]&&input[id=valor],input[type=text]&&input[name=descuento]&&input[id=valor]").each(function(){
																																	   
     $(this).keypress(function(event){					
	   return solonumeros(this,event);						     	   
	});	 														   
	 
    $(this).focus(function(event){					
        
		var valor = removeFormatCurrency(this.value) * 1;
		
		if(!valor > 0){
			this.value = '';
		}
		
	});	 
	
    $(this).blur(function(event){					
        
		var valor = removeFormatCurrency(this.value) * 1;
		
		if(!valor > 0){
			this.value = 0;
		}
		
	});		
	 
   });
	
}

function onclickCancellation(formulario){
	
	if($("#divAnulacion").is(":visible")){
	 
	   var formularioPrincipal = document.forms[0];
	   var causal_anulacion_id = $("#causal_anulacion_id").val();
	   var observaciones       = $("#observaciones_anulacion").val();
	   
       if(ValidaRequeridos(formulario)){
	
	     var QueryString = "ACTIONCONTROLER=onclickCancellation&"+FormSerialize(formulario)+"&despachos_urbanos_id="+$("#despachos_urbanos_id").val();
		
	     $.ajax({
           url  : "DespachosUrbanosClass.php",
	       data : QueryString,
	       beforeSend: function(){
			   showDivLoading();
	       },
	       success : function(response){
			 
			 Reset(formularioPrincipal);
             DespachosUrbanosOnReset(formulario);						  
						  
		     if($.trim(response) == 'true'){
				 alertJquery('Despacho Carga Anulado','Anulado Exitosamente');
			 }else{
				   alertJquery(response,'Inconsistencia Anulando');
			   }
			   
			 removeDivLoading();
             $("#divAnulacion").dialog('close');
			 
	       }
	   
	     });
	   
	   }
	
    }else{
		
	 var despachos_urbanos_id = $("#despachos_urbanos_id").val();
	 var estado        = document.getElementById("estado").value;
	 
	 if(parseInt(despachos_urbanos_id) > 0){		

		$("#divAnulacion").dialog({
		  title: 'Anulacion Despacho de Carga',
		  width: 450,
		  height: 280,
		  closeOnEscape:true
		 });
			
	 }else{
		alertJquery('Debe Seleccionar primero un despacho de carga','Anulacion');
	  }		
		
	}  
	  
	
}


function disabledInputsFormDespacho(forma){
	
   $(forma).find("input,select,textarea").each(function(){

																				
		 if(this.type != 'button'){
			this.disabled = true;
		 }										
		
   });	
	
}

function enabledInputsFormDespacho(forma){
	
	
   $(forma).find("input,select,textarea").each(function(){
																				
		 if(this.type != 'button'){
			this.disabled = false;
		 }										
		
   });	
	
}

function setDivipolaOrigen(value,text,obj){
	
	var ubicacion_id = value;
	var QueryString  = "ACTIONCONTROLER=setDivipolaOrigen&ubicacion_id="+ubicacion_id;
	
	$.ajax({
	  url        : "DespachosUrbanosClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
		 showDivLoading();
	  },
	  success    : function(resp){
		  
		  var divipola = $.trim(resp);
		  		  		  
		  $("#origen_divipola").val(divipola);
		  
		  removeDivLoading();
	  }
	  
    });
	
}

function setDivipolaDestino(value,text,obj){
	
	var ubicacion_id = value;
	var QueryString  = "ACTIONCONTROLER=setDivipolaDestino&ubicacion_id="+ubicacion_id;
	
	$.ajax({
	  url        : "DespachosUrbanosClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
		 showDivLoading();
	  },
	  success    : function(resp){
		  
		  var divipola = $.trim(resp);
		  		  
		  $("#destino_divipola").val(divipola);
		  
		  removeDivLoading();
	  }
	  
    });
	
}

function setDataRemolque(value,text,obj){
	
	var ubicacion_id = value;
	var QueryString  = "ACTIONCONTROLER=setDataRemolque&placa_remolque_id="+value;
	
	$.ajax({
	  url        : "DespachosUrbanosClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
		 showDivLoading();
	  },
	  success    : function(resp){
		  
          setFormWithJSON(document.forms[0],resp,true,null);		  
		  removeDivLoading();
		  
	  }
	  
    });
	
}