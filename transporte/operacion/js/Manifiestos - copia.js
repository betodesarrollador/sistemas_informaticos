// JavaScript Document
//eventos asignados a los objetos
var foto_precinto_normal_checked_file = false;
var foto_amarres_checked_file         = false;

$(document).ready(function(){
						   
    $("#modalidad").change(function(){
							   
        if(this.value == 'D'){
		  $("#numero_formulario").addClass("obligatorio");
		}else{
	 		  $("#numero_formulario").removeClass("obligatorio");
	       }
							   
    });						   

    $("#divAnulacion").css("display","none");	

	$("#importRemesas").click(function(){
		
		if($('#manifiesto_id').val().length > 0){
			
			$("#divRemesas").dialog({
				title: 'Remesas a Despachar',
				width: 800,
				height: 395,
				closeOnEscape:true,
				show: 'scale',
				hide: 'scale'
			});
			
			var manifiesto_id = $('#manifiesto_id').val();
			var url           = "RemesaToMCClass.php?manifiesto_id="+manifiesto_id;
			$("#iframeRemesas").attr("src",url);
			
		}else {
			alertJquery('Debe Guardar o Seleccionar el Despacho');
		 }
		
	});	
	
	$("#deleteDetallesManifiesto").click(function(){
		window.frames[0].deleteDetallesManifiesto();
	});
	
   $("#remesasManifestar,#tiemposManifestar,#fletePactado,#anticipos,#divToolBarButtons").css("display","none");
   
   $("#detalleManifiesto").load(function(){										 
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
   
   
   $("#numero_contenedor,#numero_contenedor_dta").keyup(function(){

      if(this.id == 'numero_contenedor'){
        $("#numero_contenedor_dta").val(this.value);																 		  
	  }else{
           $("#numero_contenedor").val(this.value);																 		  		  
		}
																 
   });
	
});

function closeDialog(){
	$("#divRemesas").dialog('close');
}

function setDataFormWithResponse(){
	
	var forma 		= document.forms[0];	
	var QueryString = "ACTIONCONTROLER=onclickFind&manifiesto_id="+$('#manifiesto_id').val();
	
	$.ajax({
       url        : 'ManifiestosClass.php?random='+Math.random(),
	   data       : QueryString,
	   beforeSend : function(){
           foto_precinto_normal_checked_file = false;
           foto_amarres_checked_file         = false;		   
		   showDivLoading();
	   },
	   success    : function(resp){		   
		   	  			  
		try{
			
		   var data       = $.parseJSON(resp);
		   var manifiesto = data[0]['manifiesto'];
		   var ruta_id    = data[0]['manifiesto'][0]['ruta_id'];
		   var propio     = parseInt(manifiesto[0]['propio']);		   
		   var modalidad  = manifiesto[0]['modalidad'];		   
		   var estado     = manifiesto[0]['estado'];		   
		   								
		   if(modalidad == 'D'){
		     $("#rowDTA").css("display","");
		   }else{
			   $("#rowDTA").css("display","none");
		     }
		   
	       setFormWithJSON(forma,manifiesto,false,function(){														  
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
			  
			  
           if(estado != 'P'){ 
		     disabledInputsFormManifiesto(forma);			  
		   }
			  			  
		   $("#valor_neto_pagar").val(manifiesto['valor_neto_pagar']);	  
		   $("#saldo_por_pagar").val(manifiesto['saldo_por_pagar']);	  

		   if($('#guardar'))    $('#guardar').attr("disabled","true");
           if($('#importRemesas'))  document.getElementById('importRemesas').disabled = false;
		   if($('#manifestar')) $('#manifestar').attr("disabled","true");
		   
		   if(estado == 'P' || estado == 'M'){
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
			  
			  
			  setRuta(ruta_id);
														  
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
		
	var manifiesto_id  = $('#manifiesto_id').val();	
    var url            = "DetalleManifiestosClass.php?manifiesto_id="+manifiesto_id;
    var url2           = "TiemposManifiestosClass.php?manifiesto_id="+manifiesto_id;	
	var vehiculoPropio = document.getElementById('propio').value;
	
	document.getElementById('detalleManifiesto').src = url;
	document.getElementById('tiemposManifiesto').src = url2;	
	
	
	$("#remesasManifestar,#tiemposManifestar,#divToolBarButtons").css("display","");
		
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
   
   
   
   
	  var QueryString = FormSerialize(document.forms[0])+"&ACTIONCONTROLER=sendInformacionViaje";
	  	
	 /* $.ajax({
		 url        : "ManifiestosClass.php?rand="+Math.random(),	 
		 data       : QueryString,
		 beforeSend : function(){			
			showDivMessage("Reportando al Ministerio de Transporte<br>Por Favor Espere..","../../../framework/media/images/general/cable_data_transfer_md_wht.gif");
		 },
		 success    : function(resp){			
					
			removeDivMessage();
			
			showDivMessage(resp,"../../../framework/media/images/general/cable_data_transfer_md_wht.gif");			
							
		 }
	  });   */
	
}

function ManifiestosOnSave(formulario,resp){	
   
	try{
		
	  updateGrid();
	  	  
	  if(foto_precinto_normal_checked_file){
		document.getElementById('foto_precinto_normal_checked_file').checked = true;
	  }
	  
	  if(foto_amarres_checked_file){
		document.getElementById('foto_amarres_checked_file').checked = true;
	  }	  
	  
	  if($('#guardar'))    $('#guardar').attr("disabled","true");
	  if($('#limpiar'))    $('#limpiar').attr("disabled","")
	  
	  resp = $.parseJSON(resp);
	  		  
	    $("#manifiesto_id").val(resp[0]['manifiesto_id']);
	    $("#manifiesto").val(resp[0]['manifiesto']);
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
			 alertJquery(resp,"Error :");			 
		   }		    
		
		if($('#guardar'))    $('#guardar').attr("disabled","");
		if($('#actualizar')) $('#actualizar').attr("disabled","true");
		if($('#borrar'))     $('#borrar').attr("disabled","true");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");		 
		
	  }
	
}

function ManifiestosOnUpdate(formulario,resp){

    if($.trim(resp) ==  'true'){
	  alertJquery("Manifiesto Actualizado Exitosamente","Manifiesto Carga");
	}else{
	    alertJquery(resp,"Error Actualizacion Manifiesto");
	}
	
	updateGrid();

}

function beforePrint(formulario,url,title,width,height){

	var manifiesto_id = parseInt($("#manifiesto_id").val());
	
	if(isNaN(manifiesto_id)){
	  
	  alertJquery('Debe seleccionar un Manifiesto a imprimir !!!','Impresion Manifiesto');
	  return false;
	  
	}else{	  
	    return true;
	  }
	
}

function beforePrintRuta(){
	
	var manifiesto_id = parseInt($("#manifiesto_id").val());
	
	if(isNaN(manifiesto_id)){
	  
	  alertJquery('Debe seleccionar un Manifiesto a imprimir !!!','Impresion Plan Ruta');
	  return false;
	  
	}else{	  
	    return true;
	  }	
	
}

function ManifiestosOnDelete(formulario,resp){
	Reset(formulario);	
	ManifiestosOnReset(formulario);
	clearFind();
	updateGrid();
	alertJquery(resp);
}

function separaNombre(conductor_id){
		
	var QueryString = "ACTIONCONTROLER=setDataConductor&conductor_id="+conductor_id;
	
	$.ajax({
	  url        : "ManifiestosClass.php?random="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
		showDivLoading();
      },
	  success    : function(resp){		  
	  
            var data                 = $.parseJSON(resp);
			var vencimiento_licencia = data[0]['vencimiento_licencia_cond'];
			var licencia_vencio      = data[0]['licencia_vencio'];
			var conductor            = data[0]['nombre'];
			var reportado_ministerio = data[0]['reportado_ministerio'];
					
            setFormWithJSON(document.forms[0],resp,true,function(){
			
              removeDivLoading();			
																 
			  if(licencia_vencio == 'SI'){
				   
		       alertJquery("<div align='center'>La licencia del conductor : <b>"+conductor+"</b> <br> tiene fecha de vencimiento <b>"+vencimiento_licencia+"</b> en el sistema, el conductor fue bloqueado.<br><br> <b>no se permite asignar el manifiesto al conductor!!!</b><br><br>Contacte el area encargada de autorizar a los conductores por favor.</div>","Validacion Vencimiento Licencia");
				   
			   $("#tableDataConductor").find("#nombre,#conductor_hidden,#numero_identificacion,#tipo_identificacion_conductor_codigo,#direccion_conductor,#categoria_licencia_conductor,#telefono_conductor,#ciudad_conductor,#numero_licencia_cond").val("");
			   
			   return false;
				   
			  }
			  
			  
			  if(reportado_ministerio == '0'){
				  
		       alertJquery("<div align='center'>El conductor : <b>"+conductor+" </b>no ha sido reportado al Ministerio de Transporte aun.<br><br>Ingrese por la opcion <b>Conductor</b> y actualice el registro para que sea reportado.</div>","Validacion Ministerio de Transporte");
				   
			   $("#tableDataConductor").find("#nombre,#conductor_hidden,#numero_identificacion,#tipo_identificacion_conductor_codigo,#direccion_conductor,#categoria_licencia_conductor,#telefono_conductor,#ciudad_conductor,#numero_licencia_cond").val("");
			   
			   return false;				  
				  
			  }
																 
            });
			
	       
	  }
	  
	});
	
	
}

function ManifiestosOnReset(forma){
	
    enabledInputsFormManifiesto(forma);	
	clearFind();
	clearAnticipos();
	resetSeccionLiquidacion();
	document.getElementById('detalleManifiesto').src = "about:blank";
	
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
	
    $("#numero_formulario").removeClass("obligatorio");	
	
	$("#fecha_mc,#fecha_entrega_mcia_mc,#fecha_pago_saldo").val($("#fecha_static").val());	
	
	$("#aseguradora").val($("#aseguradora_static").val());	
	$("#poliza").val($("#poliza_static").val());	
	$("#vencimiento_poliza").val($("#vencimiento_poliza_static").val());		
	
	$("#valor_flete,#valor_neto_pagar,saldo_por_pagar,#remolque").val("0");		
    $("#remesasManifestar,#tiemposManifestar,#fletePactado,#anticipos,#divToolBarButtons").css("display","none");	
	
   $("#rowDTA").css("display","none");	
   $("#divAnulacion").css("display","none");	
   
   foto_precinto_normal_checked_file = false;
   foto_amarres_checked_file         = false;
   
    $("#ruta_id option").each(function(){
 
       if(this.value != 'NULL'){
		   $(this).remove();
	   }
 										
    });   
   	
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
	    url        : "ManifiestosClass.php?rand="+Math.random(),
		data       : QueryString,
		beforeSend : function(){
		  showDivLoading()
		},
		success    : function(resp){					
		
            var data                   = $.parseJSON(resp);
			var vencimiento_licencia   = data[0]['vencimiento_licencia_cond'];
			var licencia_vencio        = data[0]['licencia_vencio'];			
	        var soat_vencio            = data[0]['soat_vencio'];
	        var tecnicomecanica_vencio = data[0]['tecnicomecanica_vencio'];						
			var conductor              = data[0]['nombre'];	
			var reportado_ministerio   = data[0]['reportado_ministerio'];				
			
			var num_manact   = data[0]['num_manact'];				
		
		    removeDivLoading();					
			
		   if(soat_vencio == 'SI' || tecnicomecanica_vencio == 'SI' || parseInt(num_manact)>0){
			   
			   $("#placa,#placa_hidden").val("");
							   
			   if(soat_vencio == 'SI' && tecnicomecanica_vencio == 'SI'){
				   
				alertJquery("<div align='center'>El <b>SOAT</b> y la revision <b>TECNICOMECANICA</b> del vehiculo se encuentran vencidas en el sistema!!!<br>no se permite asignar este vehiculo a ningun manifiesto, el vehiculo fue bloqueado.<br><br>Contacte al area encargada de autorizar vehiculos.</div>","Validacion Vencimiento SOAT - TECNICOMECANICA");
									   
			   }else if(soat_vencio == 'SI'){
				   
					alertJquery("<div align='center'>El <b>SOAT</b> del vehiculo se encuentra vencido en el sistema!!!<br>no se permite asignar este vehiculo a ningun manifiesto, el vehiculo fue bloqueado.<br><br>Contacte al area encargada de autorizar vehiculos.</div>","Validacion Vencimiento SOAT");
													   
				 }else if(tecnicomecanica_vencio == 'SI'){
					 
					  alertJquery("<div align='center'>la revision <b>TECNICOMECANICA</b> del vehiculo se encuentra vencida en el sistema!!!<br>no se permite asignar este vehiculo a ningun manifiesto, el vehiculo fue bloqueado.<br><br>Contacte al area encargada de autorizar vehiculos.</div>","Validacion Vencimiento TECNICOMECANICA");						 
					 
				 }else if(parseInt(num_manact)>0){
					 
					  alertJquery("<div align='center'>Este vehiculo Tiene un Trafico con manifiesto activo!!!<br>Por favor finalice el Trafico para poder asignar el vehiculo a este manifiesto.","Validacion Vehiculo");						 
					 
				   }
			   
			   return false;
			   
		   }else{
			   
		
		       /* if(reportado_ministerio == '0'){
					
					  alertJquery("<div align='center'>El vehiculo aun no ha sido reportado al ministerio de transporte<br><br>Por favor ingrese al formulario de vehiculos y actualice el vehiculo para que sea reportado al ministerio!!</div>","Validacion Ministerio de Transporte");		
					  
					  return false;
					
				}else{ */
			
					setFormWithJSON(document.forms[0],resp,true,function(){
						   
					   
					   var propio        = $("#propio").val();
					   var manifiesto_id = $("#manifiesto_id").val();
					   
					   if(manifiesto_id > 0){
					   
						if(parseInt(propio) == 1){
							
							$("#anticipos").css("display","");
							$("#fletePactado").css("display","none");		
							
						}else{
							
							  $("#anticipos").css("display","none");
							  $("#fletePactado").css("display","");				
							
						  }
						  
						
					   }
					   
	
					   if(licencia_vencio == 'SI'){
						   
						   alertJquery("<div align='center'>La licencia del conductor asignado al vehiculo : <b>"+conductor+"</b> <br> tiene fecha de vencimiento <b>"+vencimiento_licencia+"</b> en el sistema,el conductor fue bloqueado.<br><br> <b>no se permite asignar el manifiesto al conductor!!!</b><br><br>Contacte el area encargada de autorizar a los conductores por favor.</div>","Validacion Vencimiento Licencia");
						   
						   $("#tableDataConductor").find("#nombre,#conductor_hidden,#numero_identificacion,#tipo_identificacion_conductor_codigo,#direccion_conductor,#categoria_licencia_conductor,#telefono_conductor,#ciudad_conductor,#numero_licencia_cond").val("");					  								
						   
						   return false;
						   
					   }
					   
		
					  
					});	
					
					
				 // }
		
		
			}			
			
			
		  }
		
      });
	  	  
  }

}

function setDataTitular(tenedor_id,tenedor,obj){
  
  
  var QueryString = "ACTIONCONTROLER=setDataTitular&tenedor_id="+tenedor_id;
  
  $.ajax({
    url        : "ManifiestosClass.php?rand="+Math.random(),
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
    $(newRow).find("input[name=anticipo]&&input[id=anticipos_manifiesto_id]").each(function(){this.value = anticipo['anticipos_manifiesto_id'];});			
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
    $(newRow).find("input[name=anticipo]&&input[id=anticipos_manifiesto_id]").each(function(){this.value = anticipo['anticipos_manifiesto_id'];});			
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
		
        foto_precinto_normal_checked_file = document.getElementById('foto_precinto_normal_checked_file').checked;
        foto_amarres_checked_file         = document.getElementById('foto_amarres_checked_file').checked;		
				
		if(modalidad == 'D'){
			
	      // if(valida){
	         Send(this.form,'onclickSave',null,ManifiestosOnSave,false);											
		   //}else{
			   // return false;
			 //}		   
			
		}else{
            Send(this.form,'onclickSave',null,ManifiestosOnSave,false);											
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
		
    var manifiesto_id = document.getElementById('manifiesto_id').value;
    var QueryString   = 'ACTIONCONTROLER=asignoRemesasManifiesto&manifiesto_id='+manifiesto_id;

    $.ajax({
	  url        : "ManifiestosClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
		 showDivLoading();
	  },
	  success    : function(resp){
		  
		if($.trim(resp) == 'false'){
		
		  alertJquery("Debe asignar remesas al manifiesto antes de manifestar!!!!","Validacion Remesas Manifiesto");
		  return false;
			
		}else{
			  
			removeDivLoading();	
	
			var modalidad = document.getElementById('modalidad').value;
			var valida    = true;
					
			if(modalidad == 'D'){
				
			  /* $("#rowDTA").find("input[type=text],input[type=file],select").each(function(){
															   
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
															   
			   });	*/
			   
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
			  var manifiesto        = document.getElementById('manifiesto').value;
			  
			  var valor_flete       = document.getElementById('valor_flete').value;
			  var valor_neto_pagar  = document.getElementById('valor_neto_pagar').value;
			  var saldo_por_pagar   = document.getElementById('saldo_por_pagar').value;	 
				  
		//	  QueryString += "&valor_flete="+valor_flete+"&valor_neto_pagar="+valor_neto_pagar+"&saldo_por_pagar="+saldo_por_pagar;
			  
			  if(remolque == 1){
				  
				  var placa_remolque_id = document.getElementById('placa_remolque_hidden').value;	  
				  
				  if(!placa_remolque_id > 0){
					  alertJquery("Debe seleccionar un remolque !!","Validacion Manifiesto");
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
						
						var anticipos_manifiesto_id = '';
						var conductor               = '';
						var conductor_id            = '';
						var valor                   = '';
						var observaciones           = '';
						
						
						$(this).find("select[name=anticipo],input[name=anticipo]").each(function(){   
													
							if(this.id == 'anticipos_manifiesto_id'){
							   anticipos += '&anticipos['+contAnticipos+'][anticipos_manifiesto_id]='+this.value;							
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
						
						var impuestos_manifiesto_id = '';
						var impuesto_id             = '';
						var nombre                  = '';
						var valor                   = '';
						
						
						$(this).find("input[name=impuesto]").each(function(){   
													
							if(this.id == 'impuestos_manifiesto_id'){
							   impuestos += '&impuestos['+contImpuestos+'][impuestos_manifiesto_id]='+this.value;							
							}else if(this.id == 'impuesto_id'){
								 impuestos += '&impuestos['+contImpuestos+'][impuesto_id]='+this.value;	
							}else if(this.id == 'nombre'){
								   impuestos += '&impuestos['+contImpuestos+'][nombre]='+this.value;	
							 }else if(this.id == 'base'){
									 impuestos += '&impuestos['+contImpuestos+'][base]='+this.value;	
							  }else if(this.id == 'porcentaje'){
									 impuestos += '&impuestos['+contImpuestos+'][porcentaje]='+this.value;	
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
								
							if(this.id == 'descuentos_manifiesto_id'){
							   descuentos += '&descuentos['+contDescuentos+'][descuentos_manifiesto_id]='+this.value;													
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
						
						var anticipos_manifiesto_id = '';
						var conductor               = '';
						var conductor_id            = '';
						var valor                   = '';
						var observaciones           = '';
						
						
						$(this).find("select[name=anticipo],input[name=anticipo]").each(function(){   
													
							if(this.id == 'anticipos_manifiesto_id'){
							   anticipos += '&anticipos['+contAnticipos+'][anticipos_manifiesto_id]='+this.value;							
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
										
			  submitIframe(formulario,QueryString,objId,manifiesto);		
			 
			}
		  
	  } 
	  
    });

}

function submitIframe(formulario,QueryString,objId,manifiesto){
	
	enabledInputsFormManifiesto(formulario);
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
			
        sendInformacionViaje();			
			
		var msj = '';
						
		if(objId == 'manifestar'){
		  msj = "<div align='center'><b>Manifiesto Numero: </b><font color='red' size='10'><b>"+manifiesto+"</b></font>generado exitosamente!!!</br></br> Desea Imprimir el Manifiesto ?</div>";
		}else{
			msj = "<div align='center'><b>Manifiesto Numero: </b><font color='red' size='10'><b>"+manifiesto+"</b></font>actualizado exitosamente!!!</br></br> Desea Imprimir el Manifiesto ?</div>";
		}
 				   
        jConfirm(msj, "Manifiesto de Carga",  
		function(r) {  
																					   
          if(r) {  

           onclickPrint(formulario,'ManifiestosClass.php','Impresion Manifiesto Carga','900','600',null);						  
		   Reset(formulario);	
           ManifiestosOnReset(formulario);
           clearFind();
           updateGrid();
				   
          } else { 
             Reset(formulario);	
             ManifiestosOnReset(formulario);
             clearFind();
             updateGrid();				   
             return false;  
             }  
         }); 
						

	     }else{
			 
			alertJquery(response,"Error :");
			document.getElementById('manifestar').disabled = false;
		 }
			   
			   
	    removeDivLoading();
	   

	 });
	 	 
     formulario.submit();   
	
}

var formSubmitted = false;

function sendInformacionViaje(){
		
	if(!formSubmitted){
	
	  var QueryString = FormSerialize(document.forms[0])+"&ACTIONCONTROLER=sendInformacionViaje";
	  	
	 /* $.ajax({
		 url        : "ManifiestosClass.php?rand="+Math.random(),	 
		 data       : QueryString,
		 beforeSend : function(){			
			showDivMessage("Reportando al Ministerio de Transporte<br>Por Favor Espere..","../../../framework/media/images/general/cable_data_transfer_md_wht.gif");
			formSubmitted = true;
		 },
		 success    : function(resp){			
					
			removeDivMessage();
			
			showDivMessage(resp,"../../../framework/media/images/general/cable_data_transfer_md_wht.gif");			
			formSubmitted = false;
							
		 }
	  }); */
	  
	}
	
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
											   
         if(this.id == 'impuestos_manifiesto_id'){
			 impuestos += '&impuestos['+contImpuesto+'][impuestos_manifiesto_id]='+this.value;
		 }else if(this.id == 'impuesto_id'){
			   impuestos += '&impuestos['+contImpuesto+'][impuesto_id]='+this.value;			 
		  }else if(this.id == 'nombre'){
			      impuestos += '&impuestos['+contImpuesto+'][nombre]='+this.value;			  
			}else if(this.id == 'base'){
			        impuestos += '&impuestos['+contImpuesto+'][base]='+this.value;				
			  }else if(this.id == 'valor'){
			        impuestos += '&impuestos['+contImpuesto+'][valor]='+this.value;				
			  }else if(this.id == 'porcentaje'){
			        impuestos += '&impuestos['+contImpuesto+'][porcentaje]='+this.value;				
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
												   
			 if(this.id == 'anticipos_manifiesto_id'){
				 anticipos += '&anticipo['+contAnticipos+'][anticipos_manifiesto_id]='+this.value;
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
	  url        : "ManifiestosClass.php?rand="+Math.random(),
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
  			      var porcentaje  = impuestos[i]['porcentaje'];		
				  
			      $(".rowImpuestos").find("input[name=impuesto]&&input[id=impuesto_id]").each(function(){
																									  
				  if(this.value == impuesto_id){
					    
				    var row = this.parentNode.parentNode;
					
				    $(row).find("input[name=impuesto]&&input[id=valor]").val(valor);
				    $(row).find("input[name=impuesto]&&input[id=base]").val(base);	
				    $(row).find("input[name=impuesto]&&input[id=porcentaje]").val(porcentaje);						
					
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
	   
	   $("#foto_precinto_normal,#foto_amarres").removeClass("obligatorio");
	   
     }else{
	 	   $("#rowDTA").css("display","none");
	       $("#rowMANIFIESTO").css("display","");		   
	       //$("#foto_precinto_normal,#foto_amarres").addClass("obligatorio");		   
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
		  url        : "ManifiestosClass.php?rand="+Math.random(),
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

formSubmitted = false;

function onclickCancellation(formulario){
	
	var manifiesto_id = $("#manifiesto_id").val();
	var manifiesto    = $("#manifiesto").val();	
	
	if($("#divAnulacion").is(":visible")){
	 
	   var formularioPrincipal = document.forms[0];
	   var causal_anulacion_id = $("#causal_anulacion_id").val();
	   var observaciones       = $("#observaciones_anulacion").val();
	   
       if(ValidaRequeridos(formulario)){
		   
		 if(!formSubmitted){  		   
	
	     var QueryString = "ACTIONCONTROLER=onclickCancellation&manifiesto_id="+manifiesto_id;
		
	     $.ajax({
           url  : "ManifiestosClass.php",
	       data : QueryString,
	       beforeSend: function(){
			   showDivLoading();
			   formSubmitted = true;
	       },
	       success : function(response){
			 
			 formSubmitted = false;
			 Reset(formularioPrincipal);
             ManifiestosOnReset(formulario);						  
						  
		     if($.trim(response) == 'true'){
				 
			   alertJquery('Manifiesto Carga Anulado','Anulado Exitosamente');
				 
				 
               if(!formSubmitted){ 
				
				var QueryString = "ACTIONCONTROLER=anularManifiestoMinisterio&manifiesto="+manifiesto+"&causal_anulacion_id="+causal_anulacion_id+"&manifiesto_id="+manifiesto_id;
				
				$.ajax({
				 url        : "ManifiestosClass.php?rand="+Math.random(),	 
				 data       : QueryString,
				 beforeSend : function(){			
					showDivMessage("Reportando al Ministerio de Transporte<br>Por Favor Espere..","../../../framework/media/images/general/cable_data_transfer_md_wht.gif");
					formSubmitted = true;
				 },
				 success    : function(resp){			
							
					removeDivMessage();
					
					showDivMessage(resp,"../../../framework/media/images/general/cable_data_transfer_md_wht.gif");			
					formSubmitted = false;
												 
				 }
				 
			   });								
			
			  }
				 
				 				 
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
		
	 var manifiesto_id = $("#manifiesto_id").val();
	 var estado        = document.getElementById("estado").value;
	 
	 if(parseInt(manifiesto_id) > 0){		

		$("#divAnulacion").dialog({
		  title: 'Anulacion Manifiesto de Carga',
		  width: 450,
		  height: 280,
		  closeOnEscape:true
		 });
			
	 }else{
		alertJquery('Debe Seleccionar primero un manifiesto de carga','Anulacion');
	  }		
		
	}  
	  
	
}

function disabledInputsFormManifiesto(forma){
	
   $(forma).find("input,select,textarea").each(function(){
																				
		 if(this.type != 'button'){
			this.disabled = true;
		 }										
		
   });	
	
}

function enabledInputsFormManifiesto(forma){
	
	
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
	  url        : "ManifiestosClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
		 showDivLoading();
	  },
	  success    : function(resp){
		  
		  var divipola = $.trim(resp);
		  		  
		  $("#origen_divipola").val(divipola);
		  
		  removeDivLoading();
		  
		  setRuta(null);		  
	  }
	  
    });
	
}

function setDivipolaDestino(value,text,obj){
	
	var ubicacion_id = value;
	var QueryString  = "ACTIONCONTROLER=setDivipolaDestino&ubicacion_id="+ubicacion_id;
	
	$.ajax({
	  url        : "ManifiestosClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
		 showDivLoading();
	  },
	  success    : function(resp){
		  
		  var divipola = $.trim(resp);
		  		  
		  $("#destino_divipola").val(divipola);
		  
		  removeDivLoading();
		  
		  setRuta(null);
		  
		  
	  }
	  
    });
	
}

function setRuta(ruta_id){
	
  var origen_id   = $("#origen_hidden").val();
  var destino_id  = $("#destino_hidden").val();  
    
  if($.trim(origen_id).length > 0 && $.trim(destino_id).length > 0){
  
    var QueryString = "ACTIONCONTROLER=setRuta&origen_id="+origen_id+"&destino_id="+destino_id+"&ruta_id="+ruta_id;
  
    $.ajax({
     url        : "ManifiestosClass.php?rand="+Math.random(),
	 data       : QueryString,
	 beforeSend : function(){
	  showDivLoading();
	 },
	 success    : function(response){

      $("#ruta_id").replaceWith(response);
	  
      var estado = $("#estado").val();
	  
	  if(estado != 'P' && estado != 'NULL'){
		  document.getElementById('ruta_id').disabled = true;
	  }
	  
	  removeDivLoading();
   	  
     }

   });	
  
  }
	
	
}

function setDataRemolque(value,text,obj){
	
	var ubicacion_id = value;
	var QueryString  = "ACTIONCONTROLER=setDataRemolque&placa_remolque_id="+value;
	
	$.ajax({
	  url        : "ManifiestosClass.php?rand="+Math.random(),
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