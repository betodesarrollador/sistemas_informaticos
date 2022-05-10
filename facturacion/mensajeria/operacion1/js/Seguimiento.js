$(document).ready(function(){
						   
   $("#calcularFlete").click(function(){ calcularFlete(null,this.id,this.form); }); 						   
   						   
   $("#divAnulacion").css("display","none");						   
		
   autocompleteConductorAnticipo();		
   addNewRowAnticipoTercero();		
		
   $("#guardar,#actualizar").click(function(){
											
     if(ValidaRequeridos(this.form)){	     										
											
	  var remolque = parseInt(document.getElementById('remolque').value);												
	  
	  if(remolque == 1){
				  
		var placa_remolque_id = document.getElementById('placa_remolque_hidden').value;	  
				  
		if(!placa_remolque_id > 0){
			alertJquery("Debe seleccionar un remolque para este tipo de vehiculo!!","Validacion Tipo de Vehiculo");
			return false;
		}
				  
	  }	 
	  	  
      calcularFlete(manifestar,this.id,this.form);	
	  
      }
											
   });	
   
   setValidacionAnticipos();
						   
});

function setDataFormWithResponse(){
	
	var forma 		= document.forms[0];	
	var QueryString = "ACTIONCONTROLER=onclickFind&seguimiento_id="+$('#seguimiento_id').val();
	
	$.ajax({
       url        : 'SeguimientoClass.php?random='+Math.random(),
	   data       : QueryString,
	   beforeSend : function(){
		   showDivLoading();
	   },
	   success    : function(resp){
		   
		   var data        = $.parseJSON(resp);		   		   
		   var seguimiento = data[0]['seguimiento'];
		   var cliente_id  = seguimiento['cliente_id'];
		   		   
		   $("#valor_flete").val(seguimiento['valor_flete']);
		   $("#saldo_por_pagar").val(seguimiento['saldo_por_pagar']);
		   $("#valor_neto_pagar").val(seguimiento['valor_neto_pagar']);
		   
	       setFormWithJSON(forma,seguimiento,false,function(){
													 
													 													
		   if($('#guardar')) 	$('#guardar').attr("disabled","true");
			if($('#estado').val()=='P'){
				if($('#anular')) 	 $('#anular').attr("disabled","");
		   		if($('#actualizar')) $('#actualizar').attr("disabled","");				
			}else{
				if($('#anular')) 	 $('#anular').attr("disabled","true");
				if($('#actualizar')) $('#actualizar').attr("disabled","true");				
			}

		   if($('#imprimir'))   $('#imprimir').attr("disabled","");
		   if($('#limpiar'))    $('#limpiar').attr("disabled","");
		   
			$("#oficina_id").val($("#oficina_id_static").val());	
			$("#fecha_ingreso").val($("#fecha_ingreso_static").val());	
			$("#usuario_id").val($("#usuario_id_static").val());	

		   setContactos(cliente_id);		
		   
														  
         });			   
		   
		   $("#valor_neto_pagar").val(seguimiento['valor_neto_pagar']);	  
		   $("#saldo_por_pagar").val(seguimiento['saldo_por_pagar']);			   
		   		   					
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
			   $(newRow).find("input[name=anticipo]&&input[id=conductor_anticipo]").each(function(){this.value = $("#nombre").val();});		
			   $(newRow).find("input[name=anticipo]&&input[id=conductor_anticipo_id]").each(function(){this.value = $("#conductor_hidden").val();});			
			  
			  removeAnticipoTercero();
			   

			}	   
		   		   
		   addNewRowAnticipoTercero();
		   autocompleteConductorAnticipo();
		   removeDivLoading();		   
		   setValidacionAnticipos();				   
				   		 
	   }
	   
    });

}


function SeguimientoOnSave(formulario,resp){
	   
	try{
		
	  updateGrid();
	  
	  	resp = $.parseJSON(resp);		  
	    $("#seguimiento_id").val(resp[0]['seguimiento_id']);
		$("#servicio_transporte_id").val(resp[0]['servicio_transporte_id']);
						   
		var msj = '';
										   
        jConfirm("<div align='center'><b>Despacho Particular Numero :</b><font color='red' size='10'><b>"+resp[0]['seguimiento_id']+"</b></font> generada exitosamente!!!</br>Desea Imprimir?</div>", "Manifiesto de Carga",  
		function(r) {  
																					   
          if(r) {  

           onclickPrint(formulario,'SeguimientoClass.php','Impresion Despacho Particular','900','600',null);						  
		   Reset(formulario);	
		   SeguimientoOnReset();
           clearFind();
           updateGrid();
				   
          } else { 
             Reset(formulario);	
			 SeguimientoOnReset();
             clearFind();
             updateGrid();				   
             return false;  
             }  
         }); 

	     		

		if($('#guardar'))    $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#anular')) 	   $('#anular').attr("disabled","");
		if($('#imprimir'))   $('#imprimir').attr("disabled","");	  
		if($('#limpiar'))    $('#limpiar').attr("disabled","")

  
	}catch(e){
	  
		alertJquery("Ocurrio una inconsistencia : "+resp,"Error Insercion Orden de Seguimiento a Terceros");
		
		if($('#guardar'))    $('#guardar').attr("disabled","");
		if($('#actualizar')) $('#actualizar').attr("disabled","true");
		if($('#anular')) 	   $('#anular').attr("disabled","true");
		if($('#imprimir'))   $('#imprimir').attr("disabled","true");	  
		if($('#limpiar'))    $('#limpiar').attr("disabled","");		 
		
	  }
	
}

function SeguimientoOnUpdate(formulario,resp){	
	   
	try{
		
	  updateGrid();
	  		
		var seguimiento_id         = $("#seguimiento_id").val();
		var servicio_transporte_id = $("#servicio_transporte_id").val();
										   
        jConfirm("<div align='center'><b>Despacho Particular Numero :</b><font color='red' size='10'><b>"+seguimiento_id+"</b></font> generada exitosamente!!!</br>Desea Imprimir?</div>", "Manifiesto de Carga",  
		function(r) {  
																					   
          if(r) {  

           onclickPrint(formulario,'SeguimientoClass.php','Impresion Despacho Particular','900','600',null);						  
		   Reset(formulario);	
           SeguimientoOnReset();		   
           clearFind();
           updateGrid();
				   
          } else { 
             Reset(formulario);
			 SeguimientoOnReset();
             clearFind();
             updateGrid();				   
             return false;  
             }  
         }); 
	     		
		if($('#guardar'))    $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#anular')) 	   $('#anular').attr("disabled","");
		if($('#imprimir'))   $('#imprimir').attr("disabled","");	  
		if($('#limpiar'))    $('#limpiar').attr("disabled","");
  
	}catch(e){
	  
		alertJquery("Ocurrio una inconsistencia : "+resp,"Error Insercion Orden de Seguimiento a Terceros");
		
		if($('#guardar'))    $('#guardar').attr("disabled","");
		if($('#actualizar')) $('#actualizar').attr("disabled","true");
		if($('#anular')) 	   $('#anular').attr("disabled","true");
		if($('#imprimir'))   $('#imprimir').attr("disabled","true");	  
		if($('#limpiar'))    $('#limpiar').attr("disabled","");		 
		
	  }
	
	
	
}

function beforePrint(formulario,url,title,width,height){

	var seguimiento_id = parseInt($("#seguimiento_id").val());
	
	if(isNaN(seguimiento_id)){
	  
	  alertJquery('Debe seleccionar una Orden de Seguimiento a imprimir !!!','Impresion Orden de Seguimiento');
	  return false;
	  
	}else{	  
	    return true;
	  }
	
}


function separaNombre(conductor_id){
		
	var QueryString = "ACTIONCONTROLER=setDataConductor&conductor_id="+conductor_id;
	
	$.ajax({
	  url        : "SeguimientoClass.php?random="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
		showDivLoading();
      },
	  success    : function(resp){		  
	  
         setFormWithJSON(document.forms[0],resp,true);
		 
			var data                  = $.parseJSON(resp);			
            var conductor_id          = data[0]['conductor_id'];
            var numero_identificacion = data[0]['numero_identificacion'];
            var nombre                = data[0]['nombre'];
			
			$(".rowAnticipos").find("input[name=anticipo]&&input[id=anticipos_particular_id]").each(function(){
																											 
               var anticipos_particular_id = $.trim(this.value);																											 
			   
			   if(!anticipos_particular_id.length > 0){
														   
                   var row = this.parentNode.parentNode;
				   
				   $(row).find("input[id=conductor_anticipo],input[id=conductor_anticipo_id]").each(function(){
														   														   														   
					   if(this.id == 'conductor_anticipo'){						   
						  this.value = nombre;						   
					   }else if(this.id == 'conductor_anticipo_id'){						   								  
							this.value = conductor_id;		
						 }														   														   										   
														   
                   });
				 
			   }
														   
            });		 
		 
	     removeDivLoading();
		 
	  }
	});
	
	
}

function SeguimientoOnReset(){
	
	clearFind();
	resetContactos();
	resetSeccionLiquidacion();
	
	$("#valor_flete,#valor_neto_pagar,saldo_por_pagar,#remolque").val("0");			
	
	$("#oficina_id").val($("#oficina_id_static").val());	
	$("#fecha_ingreso").val($("#fecha_ingreso_static").val());	
	$("#usuario_id").val($("#usuario_id_static").val());
	$("#estado").val('P');
	$("#estado_select").val('P');
    $("#remolque").val("0");		
	
	$('#guardar').attr("disabled","");
	$('#actualizar').attr("disabled","true");
	$('#imprimir').attr("disabled","true");
	$('#anular').attr("disabled","true");
	$('#limpiar').attr("disabled","");
	
}

function resetContactos(){

  $("#contacto_id option").each(function(){
    if(this.value != 'NULL') $(this).remove();
  });

}

function updateGrid(){
	$("#refresh_QUERYGRID_Seguimiento").click();
}

function setDataVehiculo(placa_id,placa){
		  
  if(parseInt(placa_id) > 0){
	  
	  var QueryString = "ACTIONCONTROLER=setDataVehiculo&placa_id="+placa_id;
	  
	  $.ajax({
	    url        : "SeguimientoClass.php?rand="+Math.random(),
		data       : QueryString,
		beforeSend : function(){
		  showDivLoading()
		},
		success    : function(resp){
			
            setFormWithJSON(document.forms[0],resp,true);
			
			var data                  = $.parseJSON(resp);			
            var conductor_id          = data[0]['conductor_id'];
            var numero_identificacion = data[0]['numero_identificacion'];
            var nombre                = data[0]['nombre'];
			
			$(".rowAnticipos").find("input[name=anticipo]&&input[id=anticipos_particular_id]").each(function(){
																											 
               var anticipos_particular_id = $.trim(this.value);																											 
			   
			   if(!anticipos_particular_id.length > 0){
														   
                   var row = this.parentNode.parentNode;
				   
				   $(row).find("input[id=conductor_anticipo],input[id=conductor_anticipo_id]").each(function(){
														   														   														   
					   if(this.id == 'conductor_anticipo'){						   
						  this.value = nombre;						   
					   }else if(this.id == 'conductor_anticipo_id'){						   								  
							this.value = conductor_id;		
						 }														   														   										   
														   
                   });
				 
			   }
														   
            });
			
		    removeDivLoading();
		}
      });
	  	  
  }

}


function setDataCliente(cliente_id){
    
  var QueryString = "ACTIONCONTROLER=setDataCliente&cliente_id="+cliente_id;
  
  $.ajax({
    url        : "SeguimientoClass.php?rand="+Math.random(),
    data       : QueryString,
    beforeSend : function(){
      
    },
    success    : function(response){
      
      try{
	
		var responseArray       = $.parseJSON(response); 
		var cliente_tel        	= responseArray[0]['cliente_tel'];
		var direccion_cargue   	= responseArray[0]['direccion_cargue'];
		var cliente_nit    		= responseArray[0]['cliente_nit'];
		var cliente_movil 		= responseArray[0]['cliente_movil'];
		var cliente	    		= responseArray[0]['cliente'];	
		
		$("#cliente_tel").val(cliente_tel);
		$("#direccion_cargue").val(direccion_cargue);
		$("#cliente_nit").val(cliente_nit);
		$("#cliente").val(cliente);
		$("#cliente_movil").val(cliente_movil);	
		 setContactos(cliente_id);
	
      }catch(e){
	  	alertJquery(e);
      }
      
    }
    
  });
  
}


function setContactos(cliente_id){

	var cliente_id = cliente_id>0 ? cliente_id:$("#cliente_hidden").val();
	var QueryString = "ACTIONCONTROLER=setContactos&cliente_id="+cliente_id+'&seguimiento_id='+$("#seguimiento_id").val();
	
	$.ajax({
		url     : "SeguimientoClass.php",
		data    : QueryString,
		success : function(response){			
			$("#contacto_id").parent().html(response);
			selectedContactos();
		}
	});	
}

function selectedContactos(){
	
  var SeguimientoId = $("#seguimiento_id").val();
  var QueryString   = "ACTIONCONTROLER=selectedContactos&seguimiento_id="+SeguimientoId;
  
  $.ajax({
    url      : "SeguimientoClass.php",
	data     : QueryString,
	dataType : "json",
	success  : function(response){
		
      $("#contacto_id option").each(function(){
         $(this).removeAttr("selected");
      });

       if($.isArray(response)){
		   		   
         for(var i = 0; i < response.length; i++){
			 
			var contacto_id = response[i]['contacto_id'];
  
            $("#contacto_id option").each(function(){

               if(parseInt(this.value) == parseInt(contacto_id)){
				   
				 $(this).attr("selected","selected");
               }

            });
			 
		 }
  
		   
		   
	   }else{
		   //alertJquery(response);
		 }
   
    }

  });

	
	
}


function onclickCancellation(formulario){
	
	if($("#divAnulacion").is(":visible")){
	 
	   var desc_anul_seguimiento    = $("#desc_anul_seguimiento").val();
	   var anul_seguimiento   		= $("#anul_seguimiento").val();
	   
       if(ValidaRequeridos(formulario)){
	
	     var QueryString = "ACTIONCONTROLER=onclickCancellation&"+FormSerialize(formulario)+"&seguimiento_id="+$("#seguimiento_id").val();
		
	     $.ajax({
           url  : "SeguimientoClass.php",
	       data : QueryString,
	       beforeSend: function(){
			   showDivLoading();
	       },
	       success : function(response){
			              
		     if($.trim(response) == 'true'){
				 alertJquery('Orden de Seguimiento Anulada','Anulado Exitosamente');
				 updateGrid();
				 setDataFormWithResponse();
			 }else{
				   alertJquery(response,'Inconsistencia Anulando');
			   }
			   
			 removeDivLoading();
             $("#divAnulacion").dialog('close');
			 
	       }
	   
	     });
	   
	   }
	
    }else{
		
		 var seguimiento_id 	= $("#seguimiento_id").val();
		 var estado    			= $("#estado").val();
		 
		 if(parseInt(seguimiento_id) > 0){		
	

			 var QueryString = "ACTIONCONTROLER=ComprobarTrafico&seguimiento_id="+seguimiento_id;
			
			 $.ajax({
			   url  : "SeguimientoClass.php",
			   data : QueryString,
			   success : function(estado_trafico){

				if((estado == 'P' || estado == 'T') && (estado_trafico == 'A' || estado_trafico == '')){
				   
					$("#divAnulacion").dialog({
					  title: 'Anulacion Orden de Seguimiento',
					  width: 450,
					  height: 280,
					  closeOnEscape:true
					 });
				
				}else if((estado == 'P' || estado == 'T')  && estado_trafico != 'A' && estado_trafico != ''){
				  alertJquery('Por favor Anule el Trafico para Anular La Orden de Seguimiento','Anulacion');			   
				}else{  
				  alertJquery('Solo se permite anular orden de Seguimiento en estado : <b>PENDIENTE</b> o <b>TRANSITO</b>','Anulacion');			   
				}

			   }
		   
			 });

			 removeDivLoading();			 
			
		 }else{
			alertJquery('Debe Seleccionar primero una Orden de Seguimiento','Anulacion');
		 }		
		
	}  
	  
	
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

function addNewRowAnticipoTercero(){
	
  $("input[name=addAnticipoTercero]").click(function(){
	
    if(this.parentNode){
		
		var row                 = this.parentNode.parentNode;		
		var valorAnticipo       = removeFormatCurrency($(row).find("input[name=anticipo]&&input[id=valor]").val());
		var conductor_anticipo_id = ($(row).find("input[name=anticipo]&&input[id=conductor_anticipo_id]").val() * 1);
		
		if(!valorAnticipo > 0){
			alertJquery("Debe digitar un valor para el anticipo !!","Validacion Anticipo");
			return false;
		}
		
		if(!conductor_anticipo_id > 0){
			alertJquery("Debe seleccionar un conductor!!","Validacion Anticipo");
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
		autocompleteConductorAnticipo();
		
		$(newRow).find("input[name=anticipo]&&input[id=conductor_anticipo]").each(function(){this.value = $("#nombre").val();});		
		$(newRow).find("input[name=anticipo]&&input[id=conductor_anticipo_id]").each(function(){this.value = $("#conductor_hidden").val();});	
		
		$("#calcularFlete").trigger("click");
		
		$("input[name=anticipo]&&input[id=valor]").each(function(){
		 setFormatCurrencyInput(this,2);														 
		});	
		
		setValidacionAnticipos();
		
    }

  });	  
	
}


function addNewAnticipoTercero(anticipo){
	
    var Table   = document.getElementById('tableAnticiposTercero');
	var numRows = Table.length;
    var newRow  = Table.insertRow(numRows);

    $(newRow).html($("#clon").html()); 
  
    $(newRow).find("input[type=text]:first").focus();
	addNewRowAnticipoTercero();

     $(newRow).find("input[name=addAnticipoTercero]").replaceWith("<input type='button' name='removeAnticipoTercero' id='removeAnticipoTercero' value=' - ' disabled  />");			
    $(newRow).find("input[name=anticipo]&&input[id=anticipos_manifiesto_id]").each(function(){this.value = anticipo['anticipos_manifiesto_id'];});			
	$(newRow).find("input[name=anticipo]&&input[id=conductor_anticipo]").each(function(){       this.value = anticipo['conductor'];                });		
    $(newRow).find("input[name=anticipo]&&input[id=conductor_anticipo_id]").each(function(){    this.value = anticipo['conductor_id'];             });
    $(newRow).find("input[name=anticipo]&&input[id=valor]").each(function(){                  this.value = anticipo['valor'];                  });	
    $(newRow).find("input[name=anticipo]&&input[id=observaciones]").each(function(){          this.value = anticipo['observaciones'];          });		
	
    $("input[name=anticipo]&&input[id=valor]").each(function(){
     setFormatCurrencyInput(this,2);														 
    });	
	
	setValidacionAnticipos();
	
}

function removeAnticipoTercero(){
	
  $("input[name=removeAnticipoTercero]").click(function(){

	var row  = this.parentNode.parentNode;

    $(row).remove();
	
	addNewRowAnticipoTercero();
	
	$("#calcularFlete").trigger("click");

  });	  	
	
}

function calcularFlete(afterCalculation,objId,formulario){

    var conductor_id = document.getElementById('conductor_hidden').value;
    var valor_flete  = document.getElementById('valor_flete').value;									 
	
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
	var QueryString   = 'ACTIONCONTROLER=calcularFlete&valor_flete='+valor_flete+'&conductor_id='+conductor_id;
	
	$(".rowImpuestos").each(function(){
	   
	   $(this).find("input[name=impuesto]").each(function(){
											   
         if(this.id == 'impuestos_particular_id'){
			 impuestos += '&impuestos['+contImpuesto+'][impuestos_particular_id]='+this.value;
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
												   
			 if(this.id == 'anticipos_particular_id'){
				 anticipos += '&anticipo['+contAnticipos+'][anticipos_particular_id]='+this.value;
			 }else if(this.id == 'numero'){
				   anticipos += '&anticipo['+contAnticipos+'][numero]='+this.value;			 
			  }else if(this.id == 'valor'){
					  anticipos += '&anticipo['+contAnticipos+'][valor]='+this.value;			  
				}else if(this.id == 'conductor_anticipo'){
						anticipos += '&anticipo['+contAnticipos+'][conductor]='+this.value;			  
				  }else if(this.id == 'conductor_anticipo_id'){
						  anticipos += '&anticipo['+contAnticipos+'][conductor_id]='+this.value;			  
				   }else if(this.id == 'observaciones'){
						   anticipos += '&anticipo['+contAnticipos+'][observaciones]='+this.value;			  
					}
																							   
		   });
		   
		   contAnticipos++;
	   
	   }
	   
    });		
	
    QueryString += anticipos;	
	
	$.ajax({
	  url        : "SeguimientoClass.php?rand="+Math.random(),
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
			   alertJquery(resp,"Error :"+e);
			}
		  
	   } 
	  
    });
	

	    									 
}


function manifestar(objId,formulario){		
	
    removeDivLoading();				
	setCamposNulosForm(formulario);											   
				 
	  var anticipos         = '';
	  var impuestos         = '';
	  var descuentos        = '';
	  var numAnticipos      = 0;
	  var contAnticipos     = 0;
	  var contImpuestos     = 0;
	  var contDescuentos    = 0;
	  var fletes            = '';			  	
	  
	  var QueryString       = '';	
	  
	  if(objId == 'guardar'){		  
        QueryString = "SeguimientoClass.php?ACTIONCONTROLER=onclickSave&"+FormSerialize(formulario);        		  		  
	  }else{
           QueryString = "SeguimientoClass.php?ACTIONCONTROLER=onclickUpdate&"+FormSerialize(formulario);        		  		  
	    }
	  
	  var tableAnticipos      = document.getElementById('tableAnticipos');
	  var tableFletePactado   = document.getElementById('tableFletePactado');		  
	  var valor_flete         = $("#valor_flete").val();		  
	  var valor_flete_validar = removeFormatCurrency(valor_flete) * 1;
			  
	  if(!valor_flete_validar > 0){			  		    	  
		alertJquery("Debe asignar el valor del flete !!","Validacion Liquidacion Flete");
		return false;
	  }		    		  
			  	  
	  $(tableFletePactado).find(".rowImpuestos").each(function(){			
				
	  var impuestos_particular_id = '';
	  var impuesto_id             = '';
	  var nombre                  = '';
	  var valor                   = '';
										
	  $(this).find("input[name=impuesto]").each(function(){   
									
		 if(this.id == 'impuestos_particular_id'){
			   impuestos += '&impuestos['+contImpuestos+'][impuestos_particular_id]='+this.value;							
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
					
				if(this.id == 'descuentos_particular_id'){
				   descuentos += '&descuentos['+contDescuentos+'][descuentos_particular_id]='+this.value;													
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
							
				var anticipos_particular_id = '';
				var conductor               = '';
				var conductor_id            = '';
				var valor                   = '';
				var observaciones           = '';
				
				
				$(this).find("select[name=anticipo],input[name=anticipo]").each(function(){   
											
					if(this.id == 'anticipos_particular_id'){
					   anticipos += '&anticipos['+contAnticipos+'][anticipos_particular_id]='+this.value;							
					}else if(this.id == 'conductor_anticipo'){
						 anticipos += '&anticipos['+contAnticipos+'][conductor]='+this.value;	
					}else if(this.id == 'conductor_anticipo_id'){
						   anticipos += '&anticipos['+contAnticipos+'][conductor_id]='+this.value;	
					  }else if(this.id == 'entrega'){
							 anticipos += '&anticipos['+contAnticipos+'][entrega]='+this.value;	
						 }else if(this.id == 'valor'){
							   anticipos += '&anticipos['+contAnticipos+'][valor]='+this.value;	
						   }
					
																	 
				});
				
				contAnticipos++;
				
													 
		  });		  
		  
		  QueryString += anticipos;
		  		  
		  $.ajax({
			url        : QueryString,
			beforeSend : function(){
			  showDivLoading();
            },
			success    : function(resp){
				
				if(objId == 'guardar'){
					SeguimientoOnSave(formulario,resp);
				}else{
					  SeguimientoOnUpdate(formulario,resp);
				  }
				  
				removeDivLoading();
				
			}
		  });

}

function setConductorIdAnticipo(id,text,obj){
	
	var fila = obj.parentNode.parentNode;
	
	$(fila).find("input[name=anticipo]&&input[id=conductor_anticipo_id]").val(id);
	
}

function autocompleteConductorAnticipo(){
	
  $("input[name=anticipo]&&input[id=conductor_anticipo]").keypress(function(event){
	 ajax_suggest(this,event,"conductor","null",setConductorIdAnticipo,null,null);															   
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
	   
       $(newRow).find("input[name=anticipo]&&input[id=conductor_anticipo]").each(function(){this.value = $("#nombre").val();});		
       $(newRow).find("input[name=anticipo]&&input[id=conductor_anticipo_id]").each(function(){this.value = $("#conductor_hidden").val();});	   
	   
   }  
   
   addNewRowAnticipoTercero();
   
   $("input[type=text]&&input[id=valor]").each(function(){
     setFormatCurrencyInput(this,2);														 
   }); 
   
   setValidacionAnticipos();

}