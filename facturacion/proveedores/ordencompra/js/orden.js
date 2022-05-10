// JavaScript Document
function setDataFormWithResponse(){
    var ordenId = $('#orden_compra_id').val();
    RequiredRemove();

    var parametros  = new Array({campos:"orden_compra_id",valores:$('#orden_compra_id').val()});
	var forma       = document.forms[0];
	var controlador = 'OrdenClass.php';

	FindRow(parametros,forma,controlador,null,function(resp){
		if($('#guardar'))    $('#guardar').attr("disabled","true");
		
		if($("#estado_orden_compra").val()=='A'){
		   if($('#actualizar')) 		$('#actualizar').attr("disabled","");
		   if($('#anular'))     		$('#anular').attr("disabled","");
		   if($('#liquidar'))     		$('#liquidar').attr("disabled","");		   
   		   if($('#saveDetallepuc'))     $('#saveDetallepuc').attr("style","display:inherit");
		   if($('#deleteDetallepuc'))   $('#deleteDetallepuc').attr("style","display:inherit");
		   
		}else{
		   if($('#actualizar')) 		$('#actualizar').attr("disabled","true");	 
		   if($("#estado_orden_compra").val()=='L'){
		   		if($('#anular'))     		$('#anular').attr("disabled","");
		   }else{
				if($('#anular'))     		$('#anular').attr("disabled","true");
		   }
		   if($('#liquidar'))     		$('#liquidar').attr("disabled","true");	
   		   if($('#saveDetallepuc'))     $('#saveDetallepuc').attr("style","display:none");
		   if($('#deleteDetallepuc'))   $('#deleteDetallepuc').attr("style","display:none");
		}
      	if($('#limpiar'))    $('#limpiar').attr("disabled","");	  
		if($('#imprimir'))    $('#imprimir').attr("disabled","");
		configuracion(ordenId);
		getTotal(ordenId);	
		
		var data	= $.parseJSON(resp);
		
		var area_id     =  data[0]['area_id'];
		setArea1(ordenId,area_id);
		
    });


}

function viewDoc(orden_compra_id){
	$('#orden_compra_id').val(orden_compra_id);
	setDataFormWithResponse();
}

function OrdenOnSave(formulario,resp){
   if(resp){
	    var responseArray       = $.parseJSON(resp);
		var orden_compra_id 	= responseArray['orden_compra_id'];
		var consecutivo 		= responseArray['consecutivo'];
		
	   if(parseInt(consecutivo)>0 && parseInt(consecutivo)>0){
			$("#refresh_QUERYGRID_ordencompra").click();
			$("#orden_compra_id").val(orden_compra_id);		
			$("#consecutivo").val(consecutivo);		
			configuracion(orden_compra_id);
			getTotal(orden_compra_id);	
		   
			if($('#guardar'))    		$('#guardar').attr("disabled","true");
			if($('#actualizar')) 		$('#actualizar').attr("disabled","");
			if($('#anular'))     		$('#anular').attr("disabled","");
			if($('#limpiar'))    		$('#limpiar').attr("disabled","");
			if($('#liquidar'))     		$('#liquidar').attr("disabled","");	
			if($('#imprimir'))    		$('#imprimir').attr("disabled","");
			if($('#saveDetallepuc'))     $('#saveDetallepuc').attr("style","display:inherit");
			if($('#deleteDetallepuc'))   $('#deleteDetallepuc').attr("style","display:inherit");
		   
			alertJquery("Guardado Exitosamente","Orden de Compra");
	   }else{
			alertJquery("Inconsistencia Guardando","Orden de Compra");
	   }
   }else{
		alertJquery("Inconsistencia Guardando"+resp,"Orden de Compra");
   }
   
}

function setArea1(orden_id,area_id){

	var QueryString = "ACTIONCONTROLER=setArea1&orden_id="+orden_id+"&area_id="+area_id;
	
	$.ajax({
		url     : "OrdenClass.php",
		data    : QueryString,
		success : function(response){	
		
			$("#area_id").parent().html(response);
		}
	});	
}
function setArea(area_id){

	var departamento_id = $("#departamento_id").val();
	
	var QueryString = "ACTIONCONTROLER=setArea&departamento_id="+departamento_id+"&area_id="+area_id;
	
	$.ajax({
		url     : "OrdenClass.php",
		data    : QueryString,
		success : function(response){	
		
			$("#area_id").parent().html(response);
		}
	});	
}
function OrdenOnUpdate(formulario,resp){
   if(resp){
		var orden_compra_id = $("#orden_compra_id").val();
		configuracion(orden_compra_id);
		getTotal(orden_compra_id);	

   }
   $("#refresh_QUERYGRID_ordencompra").click();
   
   if($('#guardar'))    			$('#guardar').attr("disabled","true");

   if($("#estado_orden_compra").val()=='A'){
      if($('#actualizar')) 			$('#actualizar').attr("disabled","");
	   if($('#anular'))     		$('#anular').attr("disabled","");
	   if($('#liquidar'))     		$('#liquidar').attr("disabled","");	
	   if($('#saveDetallepuc'))     $('#saveDetallepuc').attr("style","display:inherit");
	   if($('#deleteDetallepuc'))   $('#deleteDetallepuc').attr("style","display:inherit");
	   
   }else{
      if($('#actualizar')) 			$('#actualizar').attr("disabled","true");
	   if($('#anular'))     		$('#anular').attr("disabled","true");
	   if($('#liquidar'))     		$('#liquidar').attr("disabled","true");	
	   if($('#saveDetallepuc'))     $('#saveDetallepuc').attr("style","display:none");
	   if($('#deleteDetallepuc'))   $('#deleteDetallepuc').attr("style","display:none");
   }
   if($('#imprimir'))    $('#imprimir').attr("disabled","");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
	
   alertJquery(resp,"Orden de Compra");
   
}

function OrdenOnReset(formulario){

	$("#detalles").attr("src","/rotterdan/framework/tpl/blank.html");	
	$("#subtotales").attr("src","/rotterdan/framework/tpl/blank.html");	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#anular'))     $('#anular').attr("disabled","true");
	if($('#liquidar'))   $('#liquidar').attr("disabled","");
	if($('#imprimir'))    $('#imprimir').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
    if($('#saveDetallepuc'))     $('#saveDetallepuc').attr("style","display:inherit");
    if($('#deleteDetallepuc'))   $('#deleteDetallepuc').attr("style","display:inherit");
	clearFind();	
	document.getElementById('usuario_id').value=document.getElementById('anul_usuario_id').value;
	document.getElementById('ingreso_orden_compra').value=document.getElementById('anul_orden_compra').value;
	document.getElementById('oficina_id').value=document.getElementById('anul_oficina_id').value;
	document.getElementById('estado_orden_compra').value='A';


}

//funcion para el orden de las areas y departamentos
function setArea(area_id){

	var departamento_id = $("#departamento_id").val();
	
	var QueryString = "ACTIONCONTROLER=setArea&departamento_id="+departamento_id+"&area_id="+area_id;
	
	$.ajax({
		url     : "OrdenClass.php",
		data    : QueryString,
		success : function(response){	
		
			$("#area_id").parent().html(response);
		}
	});	
}


function beforePrint(formulario,url,title,width,height){

	var orden_compra_id = parseInt($("#orden_compra_id").val());
	
	if(isNaN(orden_compra_id)){
	  
	  alertJquery('Debe seleccionar una Orden de Compra a imprimir !!!','Impresion Orden de Compra');
	  return false;
	  
	}else{	  
	    return true;
	}
}

function getTotal(orden_compra_id){ 

	 var QueryString = "ACTIONCONTROLER=getItemliquida&orden_compra_id="+orden_compra_id;
	 
	 $.ajax({
       url        : "OrdenClass.php",
	   data       : QueryString,
	   beforeSend : function(){

	   },
	   success : function(response){
		   	   
		   var totali = response;
		   
		   if(parseInt($.trim(totali)) > 0){
			   
				var url = "DetallesLiqClass.php?orden_compra_id="+orden_compra_id+"&rand="+Math.random();
				$("#detalles").attr("src",url);						  	

		   }else{
				var url = "DetallesClass.php?orden_compra_id="+orden_compra_id+"&rand="+Math.random();
				$("#detalles").attr("src",url);						  	
		   }  
			 

	     }
		 
	 });


	var url = "SubtotalClass.php?orden_compra_id="+orden_compra_id+"&rand="+Math.random();
	$("#subtotales").attr("src",url);						  	
}

$(document).ready(function(){


  $("#saveDetallepuc").click(function(){										
    window.frames[0].saveDetalles();	
  });  


  $("#deleteDetallepuc").click(function(){										
    window.frames[1].deleteDetalles();
  });  
   /**
    * cargamos el grid con las solicitudes de servicio
    */
   
  $("#iframeSolicitudOrden").attr("src","SolicServToOrdenClass.php");	
    
						   

  $("#importSolcitud").click(function(){
		
        var formulario = document.getElementById('OrdenForm');		
        Reset(formulario);	
        OrdenOnReset();						
										
	    $("#divSolicitudOrden").dialog({
		    title: 'Solicitud de Servicio para Importar',
		    width: 950,
		    height: 395,
		    closeOnEscape:true,
		    show: 'scale',
		    hide: 'scale'
	    });
    });
	
							   
  $("#guardar,#actualizar").click(function(){
	  
	  var formulario = document.getElementById('OrdenForm');
	  
	  if(ValidaRequeridos(formulario)){ 
	    if(this.id == 'guardar'){
         Send(formulario,'onclickSave',null,OrdenOnSave)
		}else{
            Send(formulario,'onclickUpdate',null,OrdenOnUpdate)
		  }
	  }
	  	  
  });

});


function closeDialog(){
	$("#divSolicitudOrden").dialog('close');
}

function cargaDatos(response){
	
  var formulario = document.getElementById('OrdenForm');
  
  var solicitud          = response[0]['solicitud'];
  
       	  
  setFormWithJSON(formulario,solicitud,'true');
  
  
 
  
  
  closeDialog();  
  $("#area_id").val(area_id);
  var area_id     =  solicitud[0]['area_id'];
  
  setArea(area_id);
}


function setDataProveedor(proveedor_id){
    
  var QueryString = "ACTIONCONTROLER=setDataProveedor&proveedor_id="+proveedor_id;
  
  $.ajax({
    url        : "OrdenClass.php?rand="+Math.random(),
    data       : QueryString,
    beforeSend : function(){
      
    },
    success    : function(response){
      
      try{
	
	var responseArray         = $.parseJSON(response); 
	var proveedor_tele        = responseArray[0]['proveedor_tele'];
	var proveedor_direccion   = responseArray[0]['proveedor_direccion'];
	var proveedor_contacto    = responseArray[0]['proveedor_contacto'];
	var proveedor_ciudad      = responseArray[0]['proveedor_ciudad'];
	var proveedor_correo      = responseArray[0]['proveedor_correo'];
	
	$("#proveedor_tele").val(proveedor_tele);
	$("#proveedor_direccion").val(proveedor_direccion);
	$("#proveedor_contacto").val(proveedor_contacto);
	$("#proveedor_ciudad").val(proveedor_ciudad);
	$("#proveedor_correo").val(proveedor_correo);
	
      }catch(e){
	  alertJquery(e);
       }
      
    }
    
  });
  
}

function onclickCancellation(formulario){
	
	if($("#divAnulacion").is(":visible")){
	 
	   var causal_anulacion_id 		= $("#causal_anulacion_id").val();
	   var desc_anul_orden_compra   = $("#desc_anul_orden_compra").val();
	   var anul_orden_compra   		= $("#anul_orden_compra").val();
	   
       if(ValidaRequeridos(formulario)){
	
	     var QueryString = "ACTIONCONTROLER=onclickCancellation&"+FormSerialize(formulario)+"&orden_compra_id="+$("#orden_compra_id").val();
		
	     $.ajax({
           url  : "OrdenClass.php",
	       data : QueryString,
	       beforeSend: function(){
			   showDivLoading();
	       },
	       success : function(response){
			              
		     if($.trim(response) == 'true'){
				 alertJquery('Orden de Compra Anulada','Anulado Exitosamente');
				 $("#refresh_QUERYGRID_ordencompra").click();
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
		
	 var orden_compra_id 		= $("#orden_compra_id").val();
	 var estado_orden_compra    = $("#estado_orden_compra").val();
	 
	 if(parseInt(orden_compra_id) > 0){		

	 var QueryString = "ACTIONCONTROLER=getEstadoEncabezadoRegistro&orden_compra_id="+orden_compra_id;
	 
	 $.ajax({
       url        : "OrdenClass.php",
	   data       : QueryString,
	   beforeSend : function(){
		 showDivLoading();
	   },
	   success : function(response){
		   	   
		   var estado = response;
		   
		   if($.trim(estado) == 'A'){
			   
		    $("#divAnulacion").dialog({
			  title: 'Anulacion Orden de Compra',
			  width: 450,
			  height: 280,
			  closeOnEscape:true
             });
			
		   }else if($.trim(estado) == 'L'){
			   
		    $("#divAnulacion").dialog({
			  title: 'Anulacion Orden de Compra',
			  width: 450,
			  height: 280,
			  closeOnEscape:true
             });
		   }
		   
		   else{
		      alertJquery('Solo se permite anular orden de compra en estado : <b>ACTIVO</b>','Anulacion');			   
		   }  
			 
	     removeDivLoading();			 
	     }
		 
	 });
	 
		
	 }else{
		alertJquery('Debe Seleccionar primero una Orden de Compra','Anulacion');
	  }		
		
	}  
	  
	
}

function configuracion(ordenId){

	 var QueryString = "ACTIONCONTROLER=Checkconfig&orden_compra_id="+ordenId;
	
	 $.ajax({
	   url  : "OrdenClass.php",
	   data : QueryString,
	   beforeSend: function(){
		   showDivLoading();
	   },
	   success : function(response){
		 var estado = response; 

		 if($.trim(estado) == 'no'){
			 $("#estado_orden_compra").val('N');
			if($('#liquidar'))    		$('#liquidar').attr("disabled","true");
			if($('#saveDetallepuc'))    $('#saveDetallepuc').attr("style","display:none");
			if($('#deleteDetallepuc'))  $('#deleteDetallepuc').attr("style","display:none");
			 
			 alertJquery("Configuracion de Tipo de Servicio Incorrecta<br> Por favor verifique",'Liquidacion');
		 }
		 removeDivLoading();
		 
	   }
	 });
}

function onclickLiquidar(formulario){
	
	if($("#divLiquidar").is(":visible")){
	 
	   var descrip_liq_orden_compra = $("#descrip_liq_orden_compra").val();
	   var fec_liq_orden_compra   	= $("#fec_liq_orden_compra").val();
	   var liq_usuario_id   		= $("#liq_usuario_id").val();
	   
       if(ValidaRequeridos(formulario)){
	
	     var QueryString = "ACTIONCONTROLER=onclickLiquidar&"+FormSerialize(formulario)+"&orden_compra_id="+$("#orden_compra_id").val();
		
	     $.ajax({
           url  : "OrdenClass.php",
	       data : QueryString,
	       beforeSend: function(){
			   showDivLoading();
	       },
	       success : function(response){
			              
		     if($.trim(response) == 'true'){
				 alertJquery('Orden de Compra Liquidada','Liquidado Exitosamente');
				 $("#refresh_QUERYGRID_ordencompra").click();
				 setDataFormWithResponse();
			 }else{
				   alertJquery(response,'Inconsistencia Liquidando');
			   }
			   
			 removeDivLoading();
             $("#divLiquidar").dialog('close');
			 
	       }
	   
	     });
	   
	   }
	
    }else{
		
	 var orden_compra_id 		= $("#orden_compra_id").val();
	 var estado_orden_compra    = $("#estado_orden_compra").val();
	 
	 if(parseInt(orden_compra_id) > 0){		

	 var QueryString = "ACTIONCONTROLER=getEstadoEncabezadoRegistro&orden_compra_id="+orden_compra_id;
	 
	 $.ajax({
       url        : "OrdenClass.php",
	   data       : QueryString,
	   beforeSend : function(){
		 showDivLoading();
	   },
	   success : function(response){
		   	   
		   var estado = response;
		   
		   if($.trim(estado) == 'A'){
			   
		    $("#divLiquidar").dialog({
			  title: 'Liquidacion Orden de Compra',
			  width: 450,
			  height: 280,
			  closeOnEscape:true
             });
			
		   }else{
		      alertJquery('Solo se permite Liquidar orden de compra en estado : <b>ACTIVO</b>','Liquidacion');			   
		   }  
			 
	     removeDivLoading();			 
	     }
		 
	 });
	 
		
	 }else{
		alertJquery('Debe Seleccionar primero una Orden de Compra','Liquidacion');
	  }		
		
	}  
	  
	
}



