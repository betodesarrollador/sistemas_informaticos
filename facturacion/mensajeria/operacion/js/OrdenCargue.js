// JavaScript Document
//eventos asignados a los objetos
function setDataFormWithResponse(){
	
	var forma 		= document.forms[0];	
	var QueryString = "ACTIONCONTROLER=onclickFind&orden_cargue_id="+$('#orden_cargue_id').val();
	
	$.ajax({
       url        : 'OrdenCargueClass.php?random='+Math.random(),
	   data       : QueryString,
	   beforeSend : function(){
		   showDivLoading();
	   },
	   success    : function(resp){
		   
		   var data       = $.parseJSON(resp);
		   
	       setFormWithJSON(forma,data,false,function(){
		   if($('#guardar')) 	$('#guardar').attr("disabled","true");
			if($('#estado').val()=='E'){
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

		   setContactos(0);												  
														  
         });		   
		   		   
		 removeDivLoading();
		 
	   }
    });

}


function OrdenCargueOnSave(formulario,resp){
	   
	try{
		
	  updateGrid();
	  
	  
	  resp = $.parseJSON(resp);
	  
	  if($.isArray(resp)){
		  
	    $("#orden_cargue_id").val(resp[0]['orden_cargue_id']);
		$("#consecutivo").val(resp[0]['consecutivo']);
		alertJquery("Orden de Cargue Guardada Exitosamente");

		if($('#guardar'))    $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#anular')) 	   $('#anular').attr("disabled","");
		if($('#imprimir'))   $('#imprimir').attr("disabled","");	  
		if($('#limpiar'))    $('#limpiar').attr("disabled","")

	  }else{
	    alertJquery("Ocurrio una inconsistencia : "+resp);
		if($('#guardar'))    $('#guardar').attr("disabled","");
		if($('#actualizar')) $('#actualizar').attr("disabled","true");
		if($('#anular')) 	   $('#anular').attr("disabled","true");
		if($('#imprimir'))   $('#imprimir').attr("disabled","true");	  
		if($('#limpiar'))    $('#limpiar').attr("disabled","");		 
		
	  }
  
	}catch(e){
	  
		alertJquery("Ocurrio una inconsistencia : "+resp,"Error Insercion Orden de Cargue");
		
		if($('#guardar'))    $('#guardar').attr("disabled","");
		if($('#actualizar')) $('#actualizar').attr("disabled","true");
		if($('#anular')) 	   $('#anular').attr("disabled","true");
		if($('#imprimir'))   $('#imprimir').attr("disabled","true");	  
		if($('#limpiar'))    $('#limpiar').attr("disabled","");		 
		
	  }
	
}

function OrdenCargueOnUpdate(formulario,resp){

    if($.trim(resp) ==  'true'){
		alertJquery("Orden de Cargue Actualizada Exitosamente","Orden de Cargue");
		if($('#guardar'))    $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#estado').val()=='E'){
			if($('#anular')) 	 $('#anular').attr("disabled","");
		}else{
			if($('#anular')) 	 $('#anular').attr("disabled","true");
		}
		if($('#imprimir'))   $('#imprimir').attr("disabled","");	  
		if($('#limpiar'))    $('#limpiar').attr("disabled","")
	  
	}else{
	    alertJquery(resp,"Error Actualizacion Orden de Cargue");
	}
	
	updateGrid();

}

function beforePrint(formulario,url,title,width,height){

	var orden_cargue_id = parseInt($("#orden_cargue_id").val());
	
	if(isNaN(orden_cargue_id)){
	  
	  alertJquery('Debe seleccionar una Orden de Cargue a imprimir !!!','Impresion Orden de Cargue');
	  return false;
	  
	}else{	  
	    return true;
	  }
	
}


function separaNombre(conductor_id){
		
	var QueryString = "ACTIONCONTROLER=setDataConductor&conductor_id="+conductor_id;
	
	$.ajax({
	  url        : "OrdenCargueClass.php?random="+Math.random(),
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

function OrdenCargueOnReset(){
	
	clearFind();
	
	$("#oficina_id").val($("#oficina_id_static").val());	
	$("#fecha_ingreso").val($("#fecha_ingreso_static").val());	
	$("#usuario_id").val($("#usuario_id_static").val());	
    $("#remolque").val("0");		
	$("#estado").val('E');	
	
	$('#guardar').attr("disabled","");
	$('#actualizar').attr("disabled","true");
	$('#imprimir').attr("disabled","true");
	$('#anular').attr("disabled","true");
	$('#limpiar').attr("disabled","");
	
}

function updateGrid(){
	$("#refresh_QUERYGRID_OrdenCargue").click();
}

function setDataVehiculo(placa_id,placa){
		  
  if(parseInt(placa_id) > 0){
	  
	  var QueryString = "ACTIONCONTROLER=setDataVehiculo&placa_id="+placa_id;
	  
	  $.ajax({
	    url        : "OrdenCargueClass.php?rand="+Math.random(),
		data       : QueryString,
		beforeSend : function(){
		  showDivLoading()
		},
		success    : function(resp){
            setFormWithJSON(document.forms[0],resp,true);
		    removeDivLoading();
		}
      });
	  	  
  }

}

function setDataTitular(tenedor_id,tenedor,obj){
  
  
  var QueryString = "ACTIONCONTROLER=setDataTitular&tenedor_id="+tenedor_id;
  
  $.ajax({
    url        : "OrdenCargueClass.php?rand="+Math.random(),
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

function setDataCliente(cliente_id){
    
  var QueryString = "ACTIONCONTROLER=setDataCliente&cliente_id="+cliente_id;
  
  $.ajax({
    url        : "OrdenCargueClass.php?rand="+Math.random(),
    data       : QueryString,
    beforeSend : function(){
      
    },
    success    : function(response){
      
      try{
	
		var responseArray       = $.parseJSON(response); 
		var cliente_tel        	= responseArray[0]['cliente_tel'];
		var direccion_cargue   	= responseArray[0]['direccion_cargue'];
		var cliente_nit    		= responseArray[0]['cliente_nit'];
		var cliente	    		= responseArray[0]['cliente'];	
		
		$("#cliente_tel").val(cliente_tel);
		$("#direccion_cargue").val(direccion_cargue);
		$("#cliente_nit").val(cliente_nit);
		$("#cliente").val(cliente);	
		 setContactos(cliente_id);
	
      }catch(e){
	  	alertJquery(e);
      }
      
    }
    
  });
  
}

function SetDataSolicitud(detalle_ss_id){
    
  var QueryString = "ACTIONCONTROLER=SetDataSolicitud&detalle_ss_id="+detalle_ss_id;
  
  $.ajax({
    url        : "OrdenCargueClass.php?rand="+Math.random(),
    data       : QueryString,
    beforeSend : function(){
      
    },
    success    : function(response){
      
      try{
	
		var responseArray  = $.parseJSON(response); 
		var fecha	       = responseArray[0]['fecha'];
		var fecha	       = responseArray[0]['fecha'];
		
		$("#cliente_tel").val(responseArray[0]['cliente_tel']);
		$("#direccion_cargue").val(responseArray[0]['direccion_cargue']);
		$("#cliente_nit").val(responseArray[0]['cliente_nit']);
		$("#cliente").val(responseArray[0]['cliente']);	
		$("#cliente_hidden").val(responseArray[0]['cliente_id']);			
		$("#fecha").val(responseArray[0]['fecha']);	
		$("#hora").val(responseArray[0]['hora']);	
		$("#origen_hidden").val(responseArray[0]['origen_id']);	
		$("#destino_hidden").val(responseArray[0]['destino_id']);
		$("#origen").val(responseArray[0]['origen']);	
		$("#destino").val(responseArray[0]['destino']);
		$("#tipo_servicio_id").val(responseArray[0]['tipo_servicio_id']);	
		$("#unidad_peso_id").val(responseArray[0]['unidad_peso_id']);	
		$("#unidad_volumen_id").val(responseArray[0]['unidad_volumen_id']);	
		$("#cantidad_cargue").val(responseArray[0]['cantidad_cargue']);	
		$("#producto").val(responseArray[0]['producto']);	
		$("#peso").val(responseArray[0]['peso']);	
		$("#peso_volumen").val(responseArray[0]['peso_volumen']);	
		setContactos(responseArray[0]['cliente_id']);
	
      }catch(e){
	  	alertJquery(e);
      }
      
    }
    
  });
  
}

function setContactos(cliente_id){

	var cliente_id = cliente_id>0 ? cliente_id:$("#cliente_hidden").val();
	var QueryString = "ACTIONCONTROLER=setContactos&cliente_id="+cliente_id+'&orden_cargue_id='+$("#orden_cargue_id").val();
	
	$.ajax({
		url     : "OrdenCargueClass.php",
		data    : QueryString,
		success : function(response){			
			$("#contacto_id").parent().html(response);
		}
	});	
}

function onclickCancellation(formulario){
	
	if($("#divAnulacion").is(":visible")){
	 
	   var desc_anul_orden_cargue   = $("#desc_anul_orden_cargue").val();
	   var anul_orden_cargue   		= $("#anul_orden_cargue").val();
	   
       if(ValidaRequeridos(formulario)){
	
	     var QueryString = "ACTIONCONTROLER=onclickCancellation&"+FormSerialize(formulario)+"&orden_cargue_id="+$("#orden_cargue_id").val();
		
	     $.ajax({
           url  : "OrdenCargueClass.php",
	       data : QueryString,
	       beforeSend: function(){
			   showDivLoading();
	       },
	       success : function(response){
			              
		     if($.trim(response) == 'true'){
				 alertJquery('Orden de Cargue Anulada','Anulado Exitosamente');
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
		
		 var orden_cargue_id 	= $("#orden_cargue_id").val();
		 var estado    			= $("#estado").val();
		 
		 if(parseInt(orden_cargue_id) > 0){		
	
			   
			if(estado == 'E'){
			   
				$("#divAnulacion").dialog({
				  title: 'Anulacion Orden de Cargue',
				  width: 450,
				  height: 280,
				  closeOnEscape:true
				 });
			
			}else{
			  alertJquery('Solo se permite anular orden de Cargue en estado : <b>ESPERA</b>','Anulacion');			   
			}  
				 
			 removeDivLoading();			 
			 
	
		 
			
		 }else{
			alertJquery('Debe Seleccionar primero una Orden de Cargue','Anulacion');
		 }		
		
	}  
	  
	
}


$(document).ready(function(){
						   
   $("#divAnulacion").css("display","none");						   
						   
   $("#guardar,#actualizar").click(function(){
											
	  var remolque = parseInt(document.getElementById('remolque').value);												
	  
	  if(remolque == 1){
				  
		var placa_remolque_id = document.getElementById('placa_remolque_hidden').value;	  
				  
		if(!placa_remolque_id > 0){
			alertJquery("Debe seleccionar un remolque para este tipo de vehiculo!!","Validacion Tipo de Vehiculo");
			return false;
		}
				  
	  }	 
	  
      if(this.name == 'guardar'){		  
         Send(this.form,'onclickSave',null,OrdenCargueOnSave,false);		  		  
      }else{		  
		  Send(this.form,'onclickUpdate',null,OrdenCargueOnUpdate,false);		  		  
		}											
											
   });						   
						   
});