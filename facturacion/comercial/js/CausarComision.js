// JavaScript Document
function setDataFormWithResponse(){
    var factura_proveedor_id  = $('#factura_proveedor_id').val();
	 var QueryString = "ACTIONCONTROLER=setDataFactura&factura_proveedor_id="+factura_proveedor_id;
	  
	  $.ajax({
		url        : "CausarComisionClass.php?rand="+Math.random(),
		data       : QueryString,
		beforeSend : function(){
		  
		},
		success    : function(response){
		  
		  try{
		
			var responseArray         	= $.parseJSON(response); 
			var proveedor_id         	= responseArray[0]['proveedor_id'];
			var proveedor_nit         	= responseArray[0]['proveedor_nit'];
			var codfactura_proveedor    = responseArray[0]['codfactura_proveedor'];			
			var proveedor_nombre      	= responseArray[0]['proveedor_nombre'];
			var fecha_factura_proveedor    = responseArray[0]['fecha_factura_proveedor'];	
			var vence_factura_proveedor    = responseArray[0]['vence_factura_proveedor'];	
			var concepto_factura_proveedor				= responseArray[0]['concepto_factura_proveedor'];	
			var fuente_servicio_cod			= responseArray[0]['fuente_servicio_cod'];	
			var comisiones_id			= responseArray[0]['comisiones_id'];	
			var tipo_bien_servicio_id 	= responseArray[0]['tipo_bien_servicio_id'];
			var valor_man				= responseArray[0]['valor'];	
			var valor_ord				= responseArray[0]['valor'];				
			var num_referencia		  	= responseArray[0]['num_referencia'];	


				
				$("#proveedornn").val(proveedor_nombre);
				$("#proveedor_id").val(proveedor_id);
				$("#codfactura_proveedornn").val(codfactura_proveedor);
				$("#tipo_bien_servicio_nn").val(tipo_bien_servicio_id);				
				$("#proveedor_nit").val(proveedor_nit);
				$("#valor").val(valor_ord);
				$("#idvacio").val(comisiones_id);
				$("#fecha_factura_proveedor").val(fecha_factura_proveedor);
				$("#vence_factura_proveedor").val(vence_factura_proveedor);
				$("#concepto_factura_proveedor").val(concepto_factura_proveedor);
				$("#fuente_servicio_cod").val(fuente_servicio_cod);
				
				
							  	
	
	

		  }catch(e){
		  alertJquery(e,'setDataFormWithResponse');
		  }
		  
		}
		
	  });

	var url = "DetallesCausacionClass.php?factura_proveedor_id="+factura_proveedor_id;
								
		$("#detalles").attr("src",url);		
	
   RequiredRemove();

    var parametros  = new Array({campos:"factura_proveedor_id",valores:$('#factura_proveedor_id').val()});
	var forma       = document.forms[0];
	var controlador = 'CausarComisionClass.php';
			  	
	
	FindRow(parametros,forma,controlador,null,function(resp){
      if($('#guardar'))    $('#guardar').attr("disabled","true");
	  if($('#estado_factura_proveedor').val()=='A'){
		  if($('#actualizar')) 		$('#actualizar').attr("disabled","");
		  if($('#contabilizar')) 	$('#contabilizar').attr("disabled","");		  
		  if($('#anular')) 			$('#anular').attr("disabled","");  
	   	  if($('#saveDetallepuc'))  $('#saveDetallepuc').attr("style","display:inherit");
	  }else if($('#estado_factura_proveedor').val()=='C' && ($('#numero_pagos').val()==0 || $('#numero_pagos').val()=='' )){
		  if($('#actualizar')) 		$('#actualizar').attr("disabled","true");
		  if($('#contabilizar')) 	$('#contabilizar').attr("disabled","true");			  
		  if($('#anular')) 			$('#anular').attr("disabled","");  
		  if($('#saveDetallepuc'))  $('#saveDetallepuc').attr("style","display:none");		  
		  
	  }else{
		  if($('#actualizar')) 		$('#actualizar').attr("disabled","true");
		  if($('#contabilizar')) 	$('#contabilizar').attr("disabled","true");			  
		  if($('#anular')) 			$('#anular').attr("disabled","true");  
		  if($('#saveDetallepuc'))  $('#saveDetallepuc').attr("style","display:none");		  
	  }
      if($('#limpiar'))    $('#limpiar').attr("disabled","");
	  if($('#imprimir'))   $('#imprimir').attr("disabled","");  
	  getTotalDebitoCredito(factura_proveedor_id);
    });
}



function CausarOnSave(formulario,resp){
	
   if(isInteger(resp)){

		var factura_proveedor_id = resp;
		var url = "DetallesCausacionClass.php?factura_proveedor_id="+factura_proveedor_id+"&rand="+Math.random();
		$("#factura_proveedor_id").val(factura_proveedor_id);						
		$("#detalles").attr("src",url);						  	
 	    $("#refresh_QUERYGRID_causar").click();
	   
		if($('#guardar'))    	$('#guardar').attr("disabled","true");
		if($('#actualizar')) 	$('#actualizar').attr("disabled","");
		if($('#contabilizar')) 	$('#contabilizar').attr("disabled","");				
		if($('#anular')) 		$('#anular').attr("disabled","");	
		if($('#limpiar'))    	$('#limpiar').attr("disabled","");	
	    if($('#imprimir'))      $('#imprimir').attr("disabled","");  
		
		getTotalDebitoCredito(factura_proveedor_id);
   }else{

       alertJquery(resp,"Causar");
	   
	 }

   
}

function CausarOnUpdate(formulario,resp){
   if(resp){
		var factura_proveedor_id = $("#factura_proveedor_id").val();
		var url = "DetallesCausacionClass.php?factura_proveedor_id="+factura_proveedor_id+"&rand="+Math.random();
		$("#detalles").attr("src",url);						  	
   }
   $("#refresh_QUERYGRID_causar").click();
   
    if($('#guardar'))    	$('#guardar').attr("disabled","true");
	if($("#estado_factura_proveedor").val()=='A'){
		if($('#actualizar')) 		$('#actualizar').attr("disabled","");
		if($('#contabilizar')) 		$('#contabilizar').attr("disabled","");						
		if($('#anular')) 			$('#anular').attr("disabled","");	
   	    if($('#saveDetallepuc'))  	$('#saveDetallepuc').attr("style","display:inherit");		

    }else if($('#estado_factura_proveedor').val()=='C' && ($('#numero_pagos').val()==0 || $('#numero_pagos').val()=='' )){
	    if($('#actualizar')) 		$('#actualizar').attr("disabled","true");
	    if($('#contabilizar')) 		$('#contabilizar').attr("disabled","true");			  
	    if($('#anular')) 			$('#anular').attr("disabled","");  
	    if($('#saveDetallepuc'))  	$('#saveDetallepuc').attr("style","display:none");		  

	}else{
		if($('#actualizar')) 		$('#actualizar').attr("disabled","true");
		if($('#contabilizar')) 		$('#contabilizar').attr("disabled","true");						
		if($('#anular')) 			$('#anular').attr("disabled","true");	
  		if($('#saveDetallepuc'))  	$('#saveDetallepuc').attr("style","display:none");			
		
	}
    if($('#limpiar'))    	$('#limpiar').attr("disabled","");	
    if($('#imprimir'))      $('#imprimir').attr("disabled","");  	
	getTotalDebitoCredito(factura_proveedor_id);
	
   alertJquery(resp,"Causar");
   
}

function CausarComisionOnReset(formulario){
	$("#detalles").attr("src","../../../framework/tpl/blank.html");
    if($('#guardar'))    		$('#guardar').attr("disabled","");
    if($('#actualizar')) 		$('#actualizar').attr("disabled","true");
	if($('#contabilizar')) 		$('#contabilizar').attr("disabled","true");						
    if($('#anular')) 			$('#anular').attr("disabled","true");	
    if($('#limpiar'))    		$('#limpiar').attr("disabled","");	
    if($('#imprimir'))          $('#imprimir').attr("disabled","true");  	
	if($('#saveDetallepuc'))  	$('#saveDetallepuc').attr("style","display:inherit");
    $("#totalDebito").html("0.00");
    $("#totalCredito").html("0.00");	  
    clearFind();
	
	document.getElementById('usuario_id').value=document.getElementById('anul_usuario_id').value;
	document.getElementById('ingreso_factura_proveedor').value=document.getElementById('anul_factura_proveedor').value;
	document.getElementById('oficina_id').value=document.getElementById('anul_oficina_id').value;
	document.getElementById('estado_factura_proveedor').value='A';
    document.getElementById('fuente_servicio_cod').value='CO';
}


$(document).ready(function(){

  $("#saveDetallepuc").click(function(){										
    window.frames[0].saveDetalles();	
  });  

    $("#Buscar").click(function() {
        cargardiv();
    });

  $("#guardar,#actualizar").click(function(){
	  
	  var formulario = document.getElementById('CausarComisionForm');
	  
	  if(ValidaRequeridos(formulario)){ 
	    if(this.id == 'guardar'){
         Send(formulario,'onclickSave',null,CausarOnSave)
		}else{
            Send(formulario,'onclickUpdate',null,CausarOnUpdate)
		  }
	  }
	  	  
  });

});

function setDataComercial(comercial_id){
    
  var QueryString = "ACTIONCONTROLER=setDataComercial&comercial_id="+comercial_id;
  
  $.ajax({
    url        : "CausarComisionClass.php?rand="+Math.random(),
    data       : QueryString,
    beforeSend : function(){
      
    },
    success    : function(response){

        try{
            var responseArray         = $.parseJSON(response); 
            var proveedor_nit         = responseArray[0]['proveedor_nit'];
            var proveedor_id         = responseArray[0]['proveedor_id'];
            var nombre_prov 		  = $('#comercial').val();
            var nombre_split		  =nombre_prov.split('-');
            $("#proveedor_nit").val(proveedor_nit);
            $("#proveedor_id").val(proveedor_id);
            var nombre_final=nombre_split[1].replace(/^\s+|\s+$/g,"");
            $("#comercial").val(nombre_final);
        }catch(e){
            console.log(e);
        }
    }
    
  });
  
}


function onclickCancellation(formulario){
	
	if($("#divAnulacion").is(":visible")){

	   var causal_anulacion_id 			= $("#causal_anulacion_id").val();
	   var desc_anul_factura_proveedor  = $("#desc_anul_factura_proveedor").val();
	   var anul_factura_proveedor   	= $("#anul_factura_proveedor").val();
	   
       if(ValidaRequeridos(formulario)){
	
	     var QueryString = "ACTIONCONTROLER=onclickCancellation&"+FormSerialize(formulario)+"&factura_proveedor_id="+$("#factura_proveedor_id").val();
		
	     $.ajax({
           url  : "CausarComisionClass.php",
	       data : QueryString,
	       beforeSend: function(){
			   showDivLoading();
	       },
	       success : function(response){
			              
		     if($.trim(response) == 'true'){
				 alertJquery('Causacion Anulada','Anulado Exitosamente');
				 $("#refresh_QUERYGRID_causar").click();
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
		
	 var factura_proveedor_id 		= $("#factura_proveedor_id").val();
	 var estado_factura_proveedor   = $("#estado_factura_proveedor").val();
	 
	 if(parseInt(factura_proveedor_id) > 0){		

	 var QueryString = "ACTIONCONTROLER=getEstadoEncabezadoRegistro&factura_proveedor_id="+factura_proveedor_id;
	 
	 $.ajax({
       url        : "CausarComisionClass.php",
	   data       : QueryString,
	   beforeSend : function(){
		 showDivLoading();
	   },
	   success : function(response){
		   	   
		   var estado = response;
		   
		   if($.trim(estado) == 'A' || $.trim(estado) == 'C'){
			   
		    $("#divAnulacion").dialog({
			  title: 'Anulacion Causacion',
			  width: 650,
			  height: 280,
			  closeOnEscape:true
             });
			
		   }else{
		      alertJquery('Solo se permite anular Causaciones en estado : <b>ACTIVO/CONTABILIZADO</b>','Anulacion');			   
		   }  
			 
	     removeDivLoading();			 
	     }
		 
	 });
	 
		
	 }else{
		alertJquery('Debe Seleccionar primero un Registro Liquidado','Anulacion');
	  }		
		
	}  
}

function getTotalDebitoCredito(factura_proveedor_id){ 
		
	var QueryString = "ACTIONCONTROLER=getTotalDebitoCredito&factura_proveedor_id="+factura_proveedor_id;
	
	$.ajax({
      url     : "CausarComisionClass.php",
	  data    : QueryString,
	  success : function(response){
		  		  
		  try{
			 var totalDebitoCredito = $.parseJSON(response); 
             var totalDebito        = parseFloat(totalDebitoCredito[0]['debito']) > 0 ? totalDebitoCredito[0]['debito'] : 0;
			 var totalCredito       = parseFloat(totalDebitoCredito[0]['credito']) > 0 ? totalDebitoCredito[0]['credito'] : 0;
			 
			 $("#totalDebito").html(setFormatCurrency(totalDebito));
			 $("#totalCredito").html(setFormatCurrency(totalCredito));			 
		  }catch(e){
			  
			}
      }
	  
    });    


}

function OnclickContabilizar(){
	var factura_proveedor_id = $("#factura_proveedor_id").val();
	var fecha_factura_proved = $("#fecha_factura_proveedor").val();	
	var valor 				 = $("#valor").val();		
	var QueryString 		 = "ACTIONCONTROLER=getTotalDebitoCredito&factura_proveedor_id="+factura_proveedor_id;	

	if(parseInt(factura_proveedor_id)>0){
		$.ajax({
		  url     : "CausarComisionClass.php",
		  data    : QueryString,
		  success : function(response){
					  
			  try{
				 var totalDebitoCredito = $.parseJSON(response); 
				 var totalDebito        = parseFloat(totalDebitoCredito[0]['debito']) > 0 ? totalDebitoCredito[0]['debito'] : 0;
				 var totalCredito       = parseFloat(totalDebitoCredito[0]['credito']) > 0 ? totalDebitoCredito[0]['credito'] : 0;
				 var contrapartidas       = parseInt(totalDebitoCredito[0]['contrapartidas']) > 0 ? totalDebitoCredito[0]['contrapartidas'] : 0;
				 
				 $("#totalDebito").html(setFormatCurrency(totalDebito));
				 $("#totalCredito").html(setFormatCurrency(totalCredito));	
				 
				 if(parseFloat(totalDebito)==parseFloat(totalCredito) && parseFloat(totalCredito)>0 && parseInt(contrapartidas)==1){
					var QueryString = "ACTIONCONTROLER=getContabilizar&factura_proveedor_id="+factura_proveedor_id+"&fecha_factura_proveedor="+fecha_factura_proved;	

					$.ajax({
						url     : "CausarComisionClass.php",
		  				data    : QueryString,
		  				success : function(response){
					  
							try{
								 if($.trim(response) == 'true'){
									 alertJquery('Registro Contabilizado','Contabilizacion Exitosa');
									 $("#refresh_QUERYGRID_causar").click();
									 setDataFormWithResponse();
								 }else{
									   alertJquery(response,'Inconsistencia Contabilizando');
								 }
								
	
							}catch(e){
							  
							}
						}
				 	});
				 }else if(parseFloat(totalDebito)==parseFloat(totalCredito) && parseFloat(totalCredito)==0){
					alertJquery('Los valores no Pueden estar En Ceros :<b>NO SE CONTABILIZARA</b>','Contabilizacion'); 
				 }else if(parseInt(contrapartidas)==0){
					alertJquery('No se escogio una contrapartida. :<b>NO SE CONTABILIZARA</b><br>Por favor escoja una de las cuentas y seleccione el Boton de contrapartida y actualiza la respectiva Fila','Contabilizacion'); 
				 }else if(parseInt(contrapartidas)>1){
					alertJquery('Se escogio mas de una contrapartida. :<b>NO SE CONTABILIZARA</b><br>Por favor escoja una de las cuentas y seleccione el Boton de contrapartida, <br> despues seleccione todas las cuentas y las actualiza','Contabilizacion'); 
					
				 }else{
					alertJquery('No existen sumas iguales :<b>NO SE CONTABILIZARA</b>','Contabilizacion'); 
				 }
			  }catch(e){
				  
			  }
		  }
		  
		});    
	}else{
		alertJquery('Debe Seleccionar primero un Registro Causado','Contabilizacion'); 
	}
}


function beforePrint(formulario,url,title,width,height){

	var encabezado_registro_id = parseInt($("#encabezado_registro_id").val());
	
	if(isNaN(encabezado_registro_id)){
	  
	  alertJquery('Debe seleccionar una Causacion Contabilizada!!!','Impresion Causacion');
	  return false;
	  
	}else{	  
	    return true;
	}
}
function cargardiv() {
    var comercial_id = $('#comercial_id').val();
    if (parseInt(comercial_id) > 0 ) {
        $("#iframeSolicitud").attr("src", "SolicComisionesClass.php?comercial_id="+comercial_id+"&rand=" + Math.random());
        $("#divSolicitudFacturas").dialog({
            title: 'Comisiones Pendientes',
            width: 950,
            height: 395,
            closeOnEscape: true,
            show: 'scale',
            hide: 'scale'
        });
    } else {
        alertJquery("Por Favor Seleccione un Comercial", "Causar comisiones");
    }
}
function closeDialog() {
    $("#divSolicitudFacturas").dialog('close');
}

function cargardatos() {
    var detalle_concepto = '';
    var concepto_item = $('#concepto_item').val();
    var estado_factura_proveedor = $('#estado_factura_proveedor').val();
    var QueryString = "ACTIONCONTROLER=setSolicitud&concepto_item=" + concepto_item + "&estado_factura_proveedor=" + estado_factura_proveedor + "&rand=" + Math.random();
    $.ajax({
        url: "CausarComisionClass.php",
        data: QueryString,
        success: function(resp) {

            
             try{
                // It is JSON
                var resp = $.parseJSON(resp);
                var valor = 0;
                var concepto_detalle = '';
                for(var i=0; i< resp.length; i++){
                    concepto_detalle += resp[i]['fecha_inicio']+' '+resp[i]['cliente']+'/';
                    valor = parseFloat(valor) + parseFloat(resp[i]['valor_neto_pagar']);
                }
                $("#concepto").val('Comisiones: '+concepto_detalle);
                $("#valor").val(setFormatCurrency(valor));
                
             }catch(e){
                 alertJquery(resp, "Causar comisiones");
		     }
        }
    });
}
