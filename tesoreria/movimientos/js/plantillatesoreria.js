// JavaScript Document
var formSubmitted = false;
function setDataFormWithResponse(){
	
    var parametros  = new Array({campos:"plantilla_tesoreria_id",valores:$('#plantilla_tesoreria_id').val()});
	var forma       = document.forms[0];
	var controlador = 'PlantillaTesoreriaClass.php';
	var plantilla_tesoreria_id=$('#plantilla_tesoreria_id').val()
	var url = "DetallesPlantillaTesoreriaClass.php?plantilla_tesoreria_id="+plantilla_tesoreria_id+"&rand="+Math.random();
	$("#detalles").attr("src",url);						  	
	
	FindRow(parametros,forma,controlador,null,function(resp){
      if($('#guardar'))   			 $('#guardar').attr("disabled","true");
	  if($('#estado_plantilla_tesoreria').val()=='A'){
		  if($('#actualizar')) 		$('#actualizar').attr("disabled","");
		  if($('#contabilizar')) 	$('#contabilizar').attr("disabled","");		  
		  if($('#anular')) 			$('#anular').attr("disabled","");  
	   	  if($('#saveDetallepuc'))  $('#saveDetallepuc').attr("style","display:inherit");
		  
		  $("#deleteDetallesPlantillaTesoreria").css("display","");
	  }else if($('#estado_plantilla_tesoreria').val()=='C'){		  
		  if($('#actualizar')) 		$('#actualizar').attr("disabled","true");
		  if($('#contabilizar')) 	$('#contabilizar').attr("disabled","true");			  
		  if($('#anular')) 			$('#anular').attr("disabled","");  
		  if($('#saveDetallepuc'))  $('#saveDetallepuc').attr("style","display:none");
		   $("#deleteDetallesPlantillaTesoreria").css("display","none");
	  }else{
		  if($('#actualizar')) 		$('#actualizar').attr("disabled","true");
		  if($('#contabilizar')) 	$('#contabilizar').attr("disabled","true");			  
		  if($('#anular')) 			$('#anular').attr("disabled","true");  
		  if($('#saveDetallepuc'))  $('#saveDetallepuc').attr("style","display:none");		  
	  }
      if($('#limpiar'))    $('#limpiar').attr("disabled","");
	  if($('#imprimir'))   $('#imprimir').attr("disabled","");  
	  getTotalDebitoCredito(plantilla_tesoreria_id);
    });
	
}

function PlantillaTesoreriaOnSave(formulario,resp){	
   if(isInteger(resp)){
		var plantilla_tesoreria_id = resp;
		var url = "DetallesPlantillaTesoreriaClass.php?plantilla_tesoreria_id="+plantilla_tesoreria_id+"&rand="+Math.random();
		$("#plantilla_tesoreria_id").val(plantilla_tesoreria_id);						
		$("#detalles").attr("src",url);						  	
 	    $("#refresh_QUERYGRID_plantillatesoreria").click();
	   
		if($('#guardar'))    	$('#guardar').attr("disabled","true");
		if($('#actualizar')) 	$('#actualizar').attr("disabled","");
		if($('#contabilizar')) 	$('#contabilizar').attr("disabled","");				
		if($('#anular')) 		$('#anular').attr("disabled","");	
		if($('#limpiar'))    	$('#limpiar').attr("disabled","");	
	    if($('#imprimir'))      $('#imprimir').attr("disabled","");  
		
		getTotalDebitoCredito(plantilla_tesoreria_id);
   }else{
       alertJquery(resp,"PlantillaTesoreria");	   
	 }   
}

function PlantillaTesoreriaOnUpdate(formulario,resp){
   if(resp){
		var plantilla_tesoreria_id = $("#plantilla_tesoreria_id").val();
		var url = "DetallesPlantillaTesoreriaClass.php?plantilla_tesoreria_id="+plantilla_tesoreria_id+"&rand="+Math.random();
		$("#detalles").attr("src",url);						  	
   }
   $("#refresh_QUERYGRID_plantillatesoreria").click();
   
    if($('#guardar'))    	$('#guardar').attr("disabled","true");
	if($("#estado_plantilla_tesoreria").val()=='A'){
	if($('#actualizar')) 		$('#actualizar').attr("disabled","");
	if($('#contabilizar')) 		$('#contabilizar').attr("disabled","");						
	if($('#anular')) 			$('#anular').attr("disabled","");	
   	if($('#saveDetallepuc'))  	$('#saveDetallepuc').attr("style","display:inherit");
    }else if($('#estado_plantilla_tesoreria').val()=='C'){		
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
	getTotalDebitoCredito(plantilla_tesoreria_id);
	
   alertJquery(resp,"PlantillaTesoreria");   
}

function PlantillaTesoreriaOnDelete(formulario,resp){
	
   Reset(document.getElementById('PlantillaTesoreriaForm'));
   PlantillaTesoreriaOnReset();
   
   alertJquery(resp);  
	
}

function PlantillaTesoreriaOnReset(formulario){
	$("#detalles").attr("src","/envipack/framework/tpl/blank.html");
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
	document.getElementById('ingreso_plantilla_tesoreria').value=document.getElementById('anul_plantilla_tesoreria').value;
	document.getElementById('oficina_id').value=document.getElementById('anul_oficina_id').value;
	document.getElementById('estado_plantilla_tesoreria').value='A';
}

$(document).ready(function(){

  $("#saveDetallepuc").click(function(){										
    window.frames[0].saveDetalles();	
  });  

  $("#tipo_bien_servicio_teso_id").change(function(){										
		var QueryString = "ACTIONCONTROLER=getmaneja_cheque&tipo_bien_servicio_teso_id="+$("#tipo_bien_servicio_teso_id").val();

	     $.ajax({
           url  : "PlantillaTesoreriaClass.php",
	       data : QueryString,
	       beforeSend: function(){},
	       success : function(response){
			              
		     if($.trim(response) == 'true'){
				 alertJquery('Este tipo de Servicio debe ser relacionado con Cheques','Plantilla');
				 $("#cheques1").attr("style","display:block");
				 $("#cheques2").attr("style","display:block");
				 
			 }else{
				 $("#cheques1").attr("style","display:none");
				 $("#cheques2").attr("style","display:none");
				 $("#cheques").val("");
				 
			 }
	       }
	     });

  });  
  $("#Buscar").click(function(){										
    cargardiv();

  });  

  $("#guardar,#actualizar").click(function(){	  
	  var formulario = document.getElementById('PlantillaTesoreriaForm');	  
	  if(ValidaRequeridos(formulario)){ 
	    if(this.id == 'guardar'){
         Send(formulario,'onclickSave',null,PlantillaTesoreriaOnSave)
		}else{
            Send(formulario,'onclickUpdate',null,PlantillaTesoreriaOnUpdate)
		  }
	  }	  	  
  });
});

function cargardiv(){
	var oficina_id  = $('#oficina_id').val();
	
	if(parseInt(oficina_id)>0){
		$("#iframeSolicitud").attr("src","ChequesClass.php?oficina_id="+oficina_id+"&rand="+Math.random());
		$("#divSolicitudCheques").dialog({
			title: 'Cheques Pendientes',
			width: 850,
			height: 285,
			closeOnEscape:true,
			show: 'scale',
			hide: 'scale'
		});
	}else{
		alertJquery("Por Favor Seleccione una oficina","Plantilla");			   
	}
}

function closeDialog(){
	$("#divSolicitudCheques").dialog('close');
}

function onclickCancellation(formulario){
	
	if($("#divAnulacion").is(":visible")){

	   var causal_anulacion_id 			  = $("#causal_anulacion_id").val();
	   var desc_anul_plantilla_tesoreria  = $("#desc_anul_plantilla_tesoreria").val();
	   var anul_plantilla_tesoreria   	  = $("#anul_plantilla_tesoreria").val();
	   
       if(ValidaRequeridos(formulario)){
	
	     var QueryString = "ACTIONCONTROLER=onclickCancellation&"+FormSerialize(formulario)+"&plantilla_tesoreria_id="+$("#plantilla_tesoreria_id").val();
		
	     $.ajax({
           url  : "PlantillaTesoreriaClass.php",
	       data : QueryString,
	       beforeSend: function(){
			   showDivLoading();
	       },
	       success : function(response){
			              
		     if($.trim(response) == 'true'){
				 alertJquery('Registro Anulada','Anulado Exitosamente');
				 $("#refresh_QUERYGRID_plantillatesoreria").click();
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
		
	 var plantilla_tesoreria_id 		= $("#plantilla_tesoreria_id").val();
	 var estado_plantilla_tesoreria   = $("#estado_plantilla_tesoreria").val();
	 
	 if(parseInt(plantilla_tesoreria_id) > 0){		

	 var QueryString = "ACTIONCONTROLER=getEstadoEncabezadoRegistro&plantilla_tesoreria_id="+plantilla_tesoreria_id;
	 
	 $.ajax({
       url        : "PlantillaTesoreriaClass.php",
	   data       : QueryString,
	   beforeSend : function(){
		 showDivLoading();
	   },
	   success : function(response){
		   	   
		   var estado = response;
		   
		   if($.trim(estado) == 'A' || $.trim(estado) == 'C'){
			   
		    $("#divAnulacion").dialog({
			  title: 'Anulacion Egresos',
			  width: 650,
			  height: 280,
			  closeOnEscape:true
             });
			
		   }else{
		      alertJquery('Solo se permite anular en estado : <b>ACTIVO/CONTABILIZADO</b>','Anulacion');			   
		   }  
			 
	     removeDivLoading();			 
	     }		 
	 });	 
		
	 }else{
		alertJquery('Debe Seleccionar primero un Registro Liquidado','Anulacion');
	  }			
   }  
}

function getTotalDebitoCredito(plantilla_tesoreria_id){ 
	//if(!parseInt(plantilla_tesoreria_id)>0) plantilla_tesoreria_id=$("#plantilla_tesoreria_id").val();

	var QueryString = "ACTIONCONTROLER=getTotalDebitoCredito&plantilla_tesoreria_id="+plantilla_tesoreria_id;
	
	$.ajax({
      url     : "PlantillaTesoreriaClass.php",
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
	var plantilla_tesoreria_id 		= $("#plantilla_tesoreria_id").val();
	var fecha_plantilla_tesoreria 	= $("#fecha_plantilla_tesoreria").val();	
	var valor_plantilla_tesoreria	= $("#valor_plantilla_tesoreria").val();		
	var QueryString 		 		= "ACTIONCONTROLER=getTotalDebitoCredito&plantilla_tesoreria_id="+plantilla_tesoreria_id;	

	if(parseInt(plantilla_tesoreria_id)>0){
		if(!formSubmitted){	
			formSubmitted = true;			
			$.ajax({
			  url     : "PlantillaTesoreriaClass.php",
			  data    : QueryString,
			  success : function(response){
						  
				  try{
					 var totalDebitoCredito = $.parseJSON(response); 
					 var totalDebito        = parseFloat(totalDebitoCredito[0]['debito']) > 0 ? totalDebitoCredito[0]['debito'] : 0;
					 var totalCredito       = parseFloat(totalDebitoCredito[0]['credito']) > 0 ? totalDebitoCredito[0]['credito'] : 0;
					 
					 $("#totalDebito").html(setFormatCurrency(totalDebito));
					 $("#totalCredito").html(setFormatCurrency(totalCredito));	
					 
					 if(parseFloat(totalDebito)==parseFloat(totalCredito) && parseFloat(totalCredito)>0){
						var QueryString = "ACTIONCONTROLER=getContabilizar&plantilla_tesoreria_id="+plantilla_tesoreria_id+"&fecha_plantilla_tesoreria="+fecha_plantilla_tesoreria;	
	
						$.ajax({
							url     : "PlantillaTesoreriaClass.php",
							data    : QueryString,
							success : function(response){
						  
								try{
									 if($.trim(response) == 'true'){
										 alertJquery('Registro Contabilizado','Contabilizacion Exitosa');
										 $("#refresh_QUERYGRID_plantillatesoreria").click();
										 setDataFormWithResponse();
									     formSubmitted = false;	
									 }else{
										   alertJquery(response,'Inconsistencia Contabilizando');
									 }	
								}catch(e){								  
							  }
							}
						});
					 }else if(parseFloat(totalDebito)==parseFloat(totalCredito) && parseFloat(totalCredito)==0){
						alertJquery('Los valores no Pueden estar En Ceros :<b>NO SE CONTABILIZARA</b>','Contabilizacion'); 
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

function setDataProveedor(proveedor_id){
    
  var QueryString = "ACTIONCONTROLER=setDataProveedor&proveedor_id="+proveedor_id;
  
  $.ajax({
    url        : "PlantillaTesoreriaClass.php?rand="+Math.random(),
    data       : QueryString,
    beforeSend : function(){      
    },
    success    : function(response){      
	   try{		
			var responseArray         = $.parseJSON(response); 
			var proveedor_nit         = responseArray[0]['proveedor_nit'];		
			$("#proveedor_nit").val(proveedor_nit);		
	  }catch(e){
		  alertJquery(e);
	   }    
     }    
  });  
}

function beforePrint(formulario,url,title,width,height){

	var encabezado_registro_id = parseInt($("#encabezado_registro_id").val());	
	if(isNaN(encabezado_registro_id)){	  
	  alertJquery('Debe seleccionar un Egreso Contabilizado!!!','Impresion PLantilla Egreso');
	  return false;	  
	}else{	  
	    return true;
	}
}
