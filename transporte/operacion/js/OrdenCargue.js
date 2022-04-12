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
	  
		var data                 = $.parseJSON(resp);
		var vencimiento_licencia = data[0]['vencimiento_licencia_cond'];
		var licencia_vencio      = data[0]['licencia_vencio'];
		var conductor            = data[0]['nombre'];
		var reportado_ministerio = data[0]['reportado_ministerio'];
	  
         setFormWithJSON(document.forms[0],resp,true);
	     removeDivLoading();

		  if(licencia_vencio == 'SI'){
			   
			   alertJquery("<div align='center'>La licencia del conductor : <b>"+conductor+"</b> <br> tiene fecha de vencimiento <b>"+vencimiento_licencia+"</b> en el sistema, el conductor fue bloqueado.<br><br> <b>no se permite asignar el manifiesto al conductor!!!</b><br><br>Contacte el area encargada de autorizar a los conductores por favor.</div>","Validacion Vencimiento Licencia");
			   $("#tableDataConductor").find("#nombre,#conductor_hidden,#numero_identificacion,#direccion_conductor,#categoria_licencia_conductor,#telefono_conductor,#ciudad_conductor,#numero_licencia_cond").val("");
			   return false;
		  }

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
			var data                   = $.parseJSON(resp);
			var vencimiento_licencia   = data[0]['vencimiento_licencia_cond'];
			var licencia_vencio        = data[0]['licencia_vencio'];			
	        var soat_vencio            = data[0]['soat_vencio'];
			var conductor              = data[0]['nombre'];	
	        var tecnicomecanica_vencio = data[0]['tecnicomecanica_vencio'];						

		    					
			
		   if(soat_vencio == 'SI' || tecnicomecanica_vencio == 'SI' ){
			    if(soat_vencio == 'SI' && tecnicomecanica_vencio == 'SI'){
				   
				 alertJquery("<div align='center'>El <b>SOAT</b> y la revision <b>TECNICOMECANICA</b> del vehiculo se encuentran vencidas en el sistema!!!<br>no se permite asignar este vehiculo a ningun manifiesto, el vehiculo fue bloqueado.<br><br>Contacte al area encargada de autorizar vehiculos.</div>","Validacion Vencimiento SOAT - TECNICOMECANICA");
									   
			    }else if(soat_vencio == 'SI'){
				   
					alertJquery("<div align='center'>El <b>SOAT</b> del vehiculo se encuentra vencido en el sistema!!!<br>no se permite asignar este vehiculo a ningun manifiesto, el vehiculo fue bloqueado.<br><br>Contacte al area encargada de autorizar vehiculos.</div>","Validacion Vencimiento SOAT");
													   
			 	}else if(tecnicomecanica_vencio == 'SI'){
				 
					  alertJquery("<div align='center'>la revision <b>TECNICOMECANICA</b> del vehiculo se encuentra vencida en el sistema!!!<br>no se permite asignar este vehiculo a ningun manifiesto, el vehiculo fue bloqueado.<br><br>Contacte al area encargada de autorizar vehiculos.</div>","Validacion Vencimiento TECNICOMECANICA");						 
				}
				removeDivLoading();
				return false;
		   }else{
			   
				setFormWithJSON(document.forms[0],resp,true);
				removeDivLoading();

			   if(licencia_vencio == 'SI'){
				   
				   alertJquery("<div align='center'>La licencia del conductor asignado al vehiculo : <b>"+conductor+"</b> <br> tiene fecha de vencimiento <b>"+vencimiento_licencia+"</b> en el sistema,el conductor fue bloqueado.<br><br> <b>no se permite asignar el manifiesto al conductor!!!</b><br><br>Contacte el area encargada de autorizar a los conductores por favor.</div>","Validacion Vencimiento Licencia");
				   
				   $("#tableDataConductor").find("#nombre,#conductor_hidden,#numero_identificacion,#direccion_conductor,#categoria_licencia_conductor,#telefono_conductor,#ciudad_conductor,#numero_licencia_cond").val("");					  								
				   
				   return false;
				   
			   }

		   }
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
		var placa_id 	   = parseInt(responseArray[0]['placa_id']);
		var placa   	   = responseArray[0]['placa'];
		
		if(placa_id>0){
			$("#placa_hidden").val(placa_id);
			$("#placa").val(placa);
			setDataVehiculo(placa_id,placa);
		}
		
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
		$("#remitente").val(responseArray[0]['remitente']);
		$("#remitente_hidden").val(responseArray[0]['remitente_id']);
		$("#destinatario").val(responseArray[0]['destinatario']);
		$("#destinatario_hidden").val(responseArray[0]['destinatario_id']);
		$("#tipo_servicio_id").val(responseArray[0]['tipo_servicio_id']);	
		$("#unidad_peso_id").val(responseArray[0]['unidad_peso_id']);	
		$("#unidad_volumen_id").val(responseArray[0]['unidad_volumen_id']);	
		$("#cantidad_cargue").val(responseArray[0]['cantidad_cargue']);	
		$("#producto").val(responseArray[0]['producto']);	
		$("#producto_id_hidden").val(responseArray[0]['producto_id']);			
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

function onclickGenerarDoc(formulario){
	//agregado 03/07
	
	   var orden_cargue_id 	= $("#orden_cargue_id").val();
	   var estado    			= $("#estado").val();
	   
       if(ValidaRequeridos(formulario) && parseInt(orden_cargue_id)>0){
		 var msj = '';
		  msj = "<div align='center'><b>Desea Generar Remesa y Manifiesto en este momento?</div>";

          jConfirm(msj, "Orden Cargue",  
		  function(r) {  
																					   
          if(r) {  

			 var QueryString = "ACTIONCONTROLER=onclickGenerarDoc&"+FormSerialize(formulario)+"&orden_cargue_id="+orden_cargue_id;
			
			 $.ajax({
			   url  : "OrdenCargueClass.php",
			   data : QueryString,
			   beforeSend: function(){
				   showDivLoading();
			   },
			   
			   success : function(response){
				   
				   if($.trim(response) != 'false'){
					 var responseArray  = $.parseJSON(response); 
					 var numero_remesa	= responseArray['numero_remesa'];
					 var manifiesto	    = responseArray['manifiesto'];					 
					 var remesa_id	    = responseArray['remesa_id'];
					 var manifiesto_id	= responseArray['manifiesto_id'];					 
				   
					 alertJquery('Remesa: '+numero_remesa+', Manifiesto: '+manifiesto,'Generacion Documentos');
					  window.open("../../../transporte/operacion/clases/ManifiestosClass.php?reporta=no&random="+Math.random()+"&manifiesto_id="+manifiesto_id);
					 //updateGrid();
					 //setDataFormWithResponse();
				   
					 removeDivLoading();
					 $("#divAnulacion").dialog('close');
				   }else{
					   alertJquery('Se presento un error al guardar los documentos!!!','Generacion Documentos');
				   }
				 
			   }
		   
			 });
		  }
		 }); 		  
	   }else if(!parseInt(orden_cargue_id)>0){
		   alertJquery("Por favor guarde o seleccione una orden de cargue","Inconsistencia Generando Documentos");
	   }
	
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

function setValorLiquidacion() {

	$("#tipo_liquidacion").change(function () {

		if (this.value == 'P') {

			var peso = $("#peso").val();
			var peso_neto = ((peso * 1) * 0.001);
			var valor_unidad = removeFormatCurrency($("#valor_unidad_facturar").val());
			var valor_facturar = (peso_neto * valor_unidad);

			if (!isNaN(valor_facturar)) {

				$("#valor_facturar").val(setFormatCurrency(valor_facturar, 2));
				document.getElementById('valor_unidad_facturar').readOnly = false;
				document.getElementById('valor_facturar').readOnly = true;

			}


		} else if (this.value == 'V') {

			var peso_volumen = (removeFormatCurrency($("#peso_volumen").val()) * 1);
			var valor_unidad = removeFormatCurrency($("#valor_unidad_facturar").val());
			var valor_facturar = (peso_volumen * valor_unidad);

			if (!isNaN(valor_facturar)) {

				$("#valor_facturar").val(setFormatCurrency(valor_facturar, 2));
				document.getElementById('valor_unidad_facturar').readOnly = false;
				document.getElementById('valor_facturar').readOnly = true;

			}

		} else if (this.value == 'C') {

			document.getElementById('valor_unidad_facturar').readOnly = true;
			document.getElementById('valor_facturar').readOnly = false;
			$("#valor_unidad_facturar").val("0");
			$("#valor_facturar").val("");

		}

	});

	$("#valor_unidad_facturar").keyup(function () {

		var tipo_liquidacion = document.getElementById('tipo_liquidacion').value;

		if (tipo_liquidacion == 'P') {

			var peso_neto = (($("#peso").val() * 1) * 0.001);
			var valor_unidad = removeFormatCurrency(this.value);
			var valor_facturar = (peso_neto * valor_unidad);

			if (!isNaN(valor_facturar)) {

				$("#valor_facturar").val(setFormatCurrency(valor_facturar, 2));
				document.getElementById('valor_unidad_facturar').readOnly = false;
				document.getElementById('valor_facturar').readOnly = true;

			}


		} else if (tipo_liquidacion == 'V') {

			var peso_volumen = (removeFormatCurrency($("#peso_volumen").val()) * 1);
			var valor_unidad = removeFormatCurrency(this.value);
			var valor_facturar = (peso_volumen * valor_unidad);

			if (!isNaN(valor_facturar)) {

				$("#valor_facturar").val(setFormatCurrency(valor_facturar, 2));
				document.getElementById('valor_unidad_facturar').readOnly = false;
				document.getElementById('valor_facturar').readOnly = true;

			}

		} else if (tipo_liquidacion == 'C') {

			document.getElementById('valor_unidad_facturar').readOnly = true;
			document.getElementById('valor_facturar').readOnly = false;
			$("#valor_unidad_facturar").val("0");
			$("#valor_facturar").val("");

		}

	});

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
	setValorLiquidacion();						   
});