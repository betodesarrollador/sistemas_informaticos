// JavaScript Document
var formSubmitted = false;
function setDataFormWithResponse(){
    var abono_factura_proveedor_id  = $('#abono_factura_proveedor_id').val();
	 
    RequiredRemove();

    var parametros  = new Array({campos:"abono_factura_proveedor_id",valores:$('#abono_factura_proveedor_id').val()});
	var forma       = document.forms[0];
	var controlador = 'PagoClass.php';

	var url = "DetallesClass.php?abono_factura_proveedor_id="+abono_factura_proveedor_id+"&rand="+Math.random();
	$("#detalles").attr("src",url);						  	
	getTotalDebitoCredito(abono_factura_proveedor_id);
	FindRow(parametros,forma,controlador,null,function(resp){
      if($('#guardar'))    $('#guardar').attr("disabled","true");
	  if($('#estado_abono_factura_proveedor').val()=='A'){
		  if($('#actualizar')) 		$('#actualizar').attr("disabled","");
		  if($('#contabilizar')) 	$('#contabilizar').attr("disabled","");		  
		  if($('#anular')) 			$('#anular').attr("disabled","");  
		  if($('#reversar')) 		$('#reversar').attr("disabled","true");  
	   	  if($('#saveDetallepuc'))  $('#saveDetallepuc').attr("style","display:inherit");
	  }else if($('#estado_abono_factura_proveedor').val()=='C'){
		  if($('#actualizar')) 		$('#actualizar').attr("disabled","true");
		  if($('#contabilizar')) 	$('#contabilizar').attr("disabled","true");		  
		  if($('#anular')) 			$('#anular').attr("disabled","");  
	   	  if($('#reversar')) 		$('#reversar').attr("disabled",""); 
	   	  if($('#saveDetallepuc'))  $('#saveDetallepuc').attr("style","display:inherit");
		  
	  }else{
		  if($('#actualizar')) 		$('#actualizar').attr("disabled","true");
		  if($('#contabilizar')) 	$('#contabilizar').attr("disabled","true");			  
		  if($('#anular')) 			$('#anular').attr("disabled","true");  
		  if($('#reversar')) 		$('#reversar').attr("disabled","true");
		  if($('#saveDetallepuc'))  $('#saveDetallepuc').attr("style","display:none");		  
	  }
	  if($('#imprimir'))    	$('#imprimir').attr("disabled","");	
      if($('#limpiar'))    $('#limpiar').attr("disabled","");	  
    });
	
	var QueryString = "ACTIONCONTROLER=setDataFactura&abono_factura_proveedor_id="+abono_factura_proveedor_id;
	  
	  $.ajax({
		url        : "PagoClass.php?rand="+Math.random(),
		data       : QueryString,
		beforeSend : function(){
		  
		},
		success    : function(response){
		  
		  try{
		
			var responseArray         	= $.parseJSON(response); 
			var cliente_nit         	= responseArray[0]['cliente_nit'];
			var cliente_nombre      	= responseArray[0]['cliente_nombre'];
			
			$("#cliente").val(cliente_nombre);
			$("#cliente_nit").val(cliente_nit);
		  }catch(e){
		  alertJquery(e);
		  }
		  
		}
		
	  });

	
}

function cargardiv(){
	var cliente_id  = $('#cliente_hidden').val();
	
	if(parseInt(cliente_id)>0){
		$("#iframeSolicitud").attr("src","SolicFacturasClass.php?cliente_id="+cliente_id+"&rand="+Math.random());
		$("#divSolicitudFacturas").dialog({
			title: 'Facturas Contabilizadas',
			width: 950,
			height: 395,
			closeOnEscape:true,
			show: 'scale',
			hide: 'scale'
		});
	}else{
		alertJquery("Por Favor Seleccione un Cliente","Facturas");			   
	}
}

function closeDialog(){
	$("#divSolicitudFacturas").dialog('close');
}

function cargardatos(){
	var detalle_concepto='';
	var causaciones_abono_factura_proveedor  	= $('#causaciones_abono_factura_proveedor').val();
	var factura_proveedor_id		= causaciones_abono_factura_proveedor.split(",");

	for( var i in factura_proveedor_id){
		if(factura_proveedor_id[i]!=''){
		
			var QueryString = "ACTIONCONTROLER=setSolicitud&factura_proveedor_id="+factura_proveedor_id[i]+"&rand="+Math.random();
			$.ajax({
				url     : "PagoClass.php",
				data    : QueryString,
				success : function(resp){
					
					var resp 					= $.parseJSON(resp);
					var tipo					= resp[0]['tipo'];	
					var consecutivo_factura_proveedor		= resp[0]['consecutivo_factura_proveedor'];	

					detalle_concepto += "Factura de Venta No "+consecutivo_factura_proveedor+" Tipo: "+tipo+" / ";
					
					$("#concepto_abono_factura_proveedor").val(detalle_concepto);
				}
			});
		}
	}

}

function PagoOnSave(formulario,resp){
   if(isInteger(resp)){

		var abono_factura_proveedor_id = resp;
		var url = "DetallesClass.php?abono_factura_proveedor_id="+abono_factura_proveedor_id+"&rand="+Math.random();
		$("#abono_factura_proveedor_id").val(abono_factura_proveedor_id);						
		$("#detalles").attr("src",url);						  	
 	    $("#refresh_QUERYGRID_pago").click();
	   
		if($('#guardar'))    	$('#guardar').attr("disabled","true");
		if($('#actualizar')) 	$('#actualizar').attr("disabled","");
		if($('#contabilizar')) 	$('#contabilizar').attr("disabled","");				
		if($('#anular')) 		$('#anular').attr("disabled","");	
		if($('#reversar')) 		$('#reversar').attr("disabled","true"); 
		if($('#imprimir'))    	$('#imprimir').attr("disabled","");	
		if($('#limpiar'))    	$('#limpiar').attr("disabled","");	
		getTotalDebitoCredito(abono_factura_proveedor_id);
		alertJquery("Guardado Exitosamente","Pago");
   }else{
	
	   alertJquery(resp,"Pago");
   }
   
}

function PagoOnUpdate(formulario,resp){
   if(resp){
		var abono_factura_proveedor_id = $("#abono_factura_proveedor_id").val();
		var url = "DetallesClass.php?abono_factura_proveedor_id="+abono_factura_proveedor_id+"&rand="+Math.random();
		$("#detalles").attr("src",url);						  	
   }
   $("#refresh_QUERYGRID_pago").click();
   
    if($('#guardar'))    	$('#guardar').attr("disabled","true");
	if($("#estado_abono_factura_proveedor").val()=='A'){
		if($('#actualizar')) 		$('#actualizar').attr("disabled","");
		if($('#contabilizar')) 		$('#contabilizar').attr("disabled","");						
		if($('#anular')) 			$('#anular').attr("disabled","");	
		if($('#reversar')) 			$('#reversar').attr("disabled","true");  
   	    if($('#saveDetallepuc'))  	$('#saveDetallepuc').attr("style","display:inherit");	
  	}else if($('#estado_abono_factura_proveedor').val()=='C'){
	  	if($('#actualizar')) 		$('#actualizar').attr("disabled","true");
	  	if($('#contabilizar')) 		$('#contabilizar').attr("disabled","true");		  
	  	if($('#anular')) 			$('#anular').attr("disabled","");  
	  	if($('#reversar')) 			$('#reversar').attr("disabled","");  
	  	if($('#saveDetallepuc'))  	$('#saveDetallepuc').attr("style","display:inherit");
	}else{
		if($('#actualizar')) 		$('#actualizar').attr("disabled","true");
		if($('#contabilizar')) 		$('#contabilizar').attr("disabled","true");						
		if($('#anular')) 			$('#anular').attr("disabled","true");
		if($('#reversar')) 			$('#reversar').attr("disabled","true"); 
  		if($('#saveDetallepuc'))  	$('#saveDetallepuc').attr("style","display:none");			
		
	}
	if($('#imprimir'))    	$('#imprimir').attr("disabled","");	
    if($('#limpiar'))    	$('#limpiar').attr("disabled","");	
	getTotalDebitoCredito(abono_factura_proveedor_id);
	
   alertJquery(resp,"Pago");
   
}

function PagoOnReset(formulario){
	$("#detalles").attr("src","/rotterdan/framework/tpl/blank.html");
    if($('#guardar'))    		$('#guardar').attr("disabled","");
    if($('#actualizar')) 		$('#actualizar').attr("disabled","true");
	if($('#contabilizar')) 		$('#contabilizar').attr("disabled","true");						
    if($('#anular')) 			$('#anular').attr("disabled","true");	
    if($('#reversar')) 			$('#reversar').attr("disabled","true");	
    if($('#limpiar'))    		$('#limpiar').attr("disabled","");	
	if($('#imprimir'))    	    $('#imprimir').attr("disabled","true");	
	if($('#saveDetallepuc'))  	$('#saveDetallepuc').attr("style","display:inherit");
    $("#totalDebito").html("0.00");
    $("#totalCredito").html("0.00");	  
    clearFind();

	document.getElementById('usuario_id').value=document.getElementById('anul_usuario_id').value;
	document.getElementById('ingreso_abono_factura_proveedor').value=document.getElementById('anul_abono_factura_proveedor').value;
	document.getElementById('oficina_id').value=document.getElementById('oficina_anul').value;
	document.getElementById('estado_abono_factura_proveedor').value='A';

}


$(document).ready(function(){

  $("#saveDetallepuc").click(function(){										
    window.frames[0].saveDetalles();

  });  
  $("#Buscar").click(function(){										
    cargardiv();

  });  


  $("#guardar,#actualizar").click(function(){
	  
	  var formulario = document.getElementById('PagoForm');
	  
	  if(ValidaRequeridos(formulario)){ 
	    if(this.id == 'guardar'){
         Send(formulario,'onclickSave',null,PagoOnSave)
		}else{
            Send(formulario,'onclickUpdate',null,PagoOnUpdate)
		  }
	  }
	  	  
  });

});

function setDataCliente(cliente_id){

	var QueryString = "ACTIONCONTROLER=setDataCliente&cliente_id="+cliente_id;
	$.ajax({
    	url        : "PagoClass.php?rand="+Math.random(),
    	data       : QueryString,
    	beforeSend : function(){
    	},
    	success    : function(response){
      
			try{
		
				var responseArray         = $.parseJSON(response); 
				var cliente_nit         = responseArray[0]['cliente_nit'];
				$("#cliente_nit").val(cliente_nit);
			}catch(e){
				alertJquery(e);
			}
    	}
  	});
}

function onclickCancellation(formulario){
	
	if($("#divAnulacion").is(":visible")){

	   var causal_anulacion_id 		= $("#causal_anulacion_id").val();
	   var desc_anul_abono_factura_proveedor  = $("#desc_anul_abono_factura_proveedor").val();
	   var anul_abono_factura_proveedor   	= $("#anul_abono_factura_proveedor").val();
	   
       if(ValidaRequeridos(formulario)){
	
	     var QueryString = "ACTIONCONTROLER=onclickCancellation&"+FormSerialize(formulario)+"&abono_factura_proveedor_id="+$("#abono_factura_proveedor_id").val();
		
	     $.ajax({
           url  : "PagoClass.php",
	       data : QueryString,
	       beforeSend: function(){
			   showDivLoading();
	       },
	       success : function(response){
			              
		     if($.trim(response) == 'true'){
				 alertJquery('Pago Anulado','Anulado Exitosamente');
				 $("#refresh_QUERYGRID_pago").click();
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
		
	 var abono_factura_proveedor_id = $("#abono_factura_proveedor_id").val();
	 var estado_abono_factura_proveedor   	= $("#estado_abono_factura_proveedor").val();
	 
	 if(parseInt(abono_factura_proveedor_id) > 0){		

	 var QueryString = "ACTIONCONTROLER=getEstadoEncabezadoRegistro&abono_factura_proveedor_id="+abono_factura_proveedor_id;
	 
	 $.ajax({
       url        : "PagoClass.php",
	   data       : QueryString,
	   beforeSend : function(){
		 showDivLoading();
	   },
	   success : function(response){
		   	   
		   var estado = response;
		   
		   if($.trim(estado) == 'A' || $.trim(estado) == 'C'){
			   
		    $("#divAnulacion").dialog({
			  title: 'Anulacion Pago',
			  width: 450,
			  height: 280,
			  closeOnEscape:true
             });
			
		   }else{
		      alertJquery('Solo se permite anular Pagos en estado : <b>ACTIVO/CONTABILIZADO</b>','Anulacion');			   
		   }  
			 
	     removeDivLoading();			 
	     }
		 
	 });
	 
		
	 }else{
		alertJquery('Debe Seleccionar primero un Registro','Anulacion');
	  }		
		
	}  
}

function OnclickReversar(formulario){
	
	if($("#divReversar").is(":visible")){

	   var rever_documento_id 		= $("#rever_documento_id").val();
	   var desc_rever_abono_factura_proveedor = $("#desc_rever_abono_factura_proveedor").val();
	   var rever_abono_factura_proveedor   	= $("#rever_abono_factura_proveedor").val();
	   
       if(ValidaRequeridos(formulario)){

	     var QueryString = "ACTIONCONTROLER=OnclickReversar&"+FormSerialize(formulario)+"&abono_factura_proveedor_id="+$("#abono_factura_proveedor_id").val()+"&rever_abono_factura_proveedor="+rever_abono_factura_proveedor;
		
	     $.ajax({
           url  : "PagoClass.php",
	       data : QueryString,
	       beforeSend: function(){
			   showDivLoading();
	       },
	       success : function(response){
			              
		     if($.trim(response) == 'true'){
				 alertJquery('Pago Reversado','Reversado Exitosamente');
				 $("#refresh_QUERYGRID_pago").click();
				 setDataFormWithResponse();
			 }else{
				   alertJquery(response,'Inconsistencia Reversando');
			   }
			   
			 removeDivLoading();
             $("#divReversar").dialog('close');
			 
	       }
	   
	     });
	   
	   }
	
    }else{
		
	 var abono_factura_proveedor_id = $("#abono_factura_proveedor_id").val();
	 var estado_abono_factura_proveedor   	= $("#estado_abono_factura_proveedor").val();
	 
	 if(parseInt(abono_factura_proveedor_id) > 0){		

	 var QueryString = "ACTIONCONTROLER=getEstadoEncabezadoRegistro&abono_factura_proveedor_id="+abono_factura_proveedor_id;
	 
	 $.ajax({
       url        : "PagoClass.php",
	   data       : QueryString,
	   beforeSend : function(){
		 showDivLoading();
	   },
	   success : function(response){
		   	   
		   var estado = response;
		   
		   if($.trim(estado) == 'C'){
			   
		    $("#divReversar").dialog({
			  title: 'Reversar Pago',
			  width: 450,
			  height: 280,
			  closeOnEscape:true
             });
			
		   }else{
		      alertJquery('Solo se permite Reversar Pagos en estado : <b>CONTABILIZADO</b>','Reversar');			   
		   }  
			 
	     removeDivLoading();			 
	     }
		 
	 });
	 
		
	 }else{
		alertJquery('Debe Seleccionar primero un Registro','Reversar');
	  }		
		
	}  
}

function getTotalDebitoCredito(abono_factura_proveedor_id){ 
		
	var QueryString = "ACTIONCONTROLER=getTotalDebitoCredito&abono_factura_proveedor_id="+abono_factura_proveedor_id;
	
	$.ajax({
      url     : "PagoClass.php",
	  data    : QueryString,
	  success : function(response){
		  		  
		  try{
			 var totalDebitoCredito = $.parseJSON(response); 
             var totalDebito        = parseFloat(totalDebitoCredito[0]['debito']) > 0 ? totalDebitoCredito[0]['debito'] : 0;
			 var totalCredito       = parseFloat(totalDebitoCredito[0]['credito']) > 0 ? totalDebitoCredito[0]['credito'] : 0;
			 var valor_total		= parseFloat(totalDebito) > parseFloat(totalCredito) ? totalDebito : totalCredito;			 
			 
			 $("#totalDebito").html(setFormatCurrency(totalDebito));
			 $("#totalCredito").html(setFormatCurrency(totalCredito));	
			 
			 
		  }catch(e){
			  
			}
      }
	  
    });    


}

function OnclickContabilizar(){
	var abono_factura_proveedor_id			= $("#abono_factura_proveedor_id").val();	
	var ingreso_abono_factura_proveedor 		= $("#ingreso_abono_factura_proveedor").val();		
	var valor 				 		= $("#valor_abono_factura_proveedor").val();		
	var QueryString 		 		= "ACTIONCONTROLER=getTotalDebitoCredito&abono_factura_proveedor_id="+abono_factura_proveedor_id;	

	if(parseInt(abono_factura_proveedor_id)>0){
		if(!formSubmitted){	
			formSubmitted = true;			
		
			$.ajax({
			  url     : "PagoClass.php",
			  data    : QueryString,
			  success : function(response){
						  
				  try{
					 var totalDebitoCredito = $.parseJSON(response); 
					 var totalDebito        = parseFloat(totalDebitoCredito[0]['debito']) > 0 ? totalDebitoCredito[0]['debito'] : 0;
					 var totalCredito       = parseFloat(totalDebitoCredito[0]['credito']) > 0 ? totalDebitoCredito[0]['credito'] : 0;
					 
					 $("#totalDebito").html(totalDebito);
					 $("#totalCredito").html(totalCredito);	
					 
					 if(parseFloat(totalDebito)==parseFloat(totalCredito)  && parseFloat(removeFormatCurrency(valor))>0){
						var QueryString = "ACTIONCONTROLER=getContabilizar&abono_factura_proveedor_id="+abono_factura_proveedor_id+"&ingreso_abono_factura_proveedor="+ingreso_abono_factura_proveedor;	
	
						$.ajax({
							url     : "PagoClass.php",
							data    : QueryString,
							success : function(response){
						  
								try{
									 if($.trim(response) == 'true'){
										 alertJquery('Registro Contabilizado','Contabilizacion Exitosa');
										 $("#refresh_QUERYGRID_pago").click();
										 setDataFormWithResponse();
										  formSubmitted = false;	
									 }else{
										   alertJquery(response,'Inconsistencia Contabilizando');
									 }
									
		
								}catch(e){
								  
								}
							}
						});
					 }else if(!parseFloat(removeFormatCurrency(valor))>0){
						alertJquery('El valor del registro es igual a cero :<b>NO SE CONTABILIZARA</b>','Contabilizacion'); 
					 }else{
						alertJquery('No existen sumas iguales :<b>NO SE CONTABILIZARA</b>','Contabilizacion'); 
					 }
				  }catch(e){
					  
				  }
			  }
			  
			}); 
		}
	}else{
		alertJquery('Debe Seleccionar primero un Registro','Contabilizacion'); 
	}
}


function beforePrint(formulario,url,title,width,height){

	var encabezado_registro_id = parseInt($("#encabezado_registro_id").val());
	
	if(isNaN(encabezado_registro_id)){
	  
	  alertJquery('Debe seleccionar una Pago o Abono Contabilizado!!!','Impresion Pago o Abono');
	  return false;
	  
	}else{	  
	    return true;
	}
}
