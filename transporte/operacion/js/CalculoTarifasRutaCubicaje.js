// JavaScript Document
//eventos asignados a los objetos
$(document).ready(function(){
	
    $("#saveDetallesSoliServi").click(function(){
      window.frames[0].saveDetallesSoliServi();
    });
    
    $("#deleteDetallesSoliServi").click(function(){
  	   window.frames[0].deleteDetallesSoliServi();
    });

    resetDetalle("detalleCalculoTarifasRutaCubicaje");resetDetalle("detalleCalculoTarifasRutaCubicajeCalculado");
	
	$("#detalleSolicitud").css("display","none");
	
	calcularTarifasOrdenCliente();
    

});


function setDataFormWithResponse(){
	
    var parametros 	= new Array ({campos:"solicitud_servicio_tarifar_id", valores:$('#solicitud_servicio_tarifar_id').val()});
    var forma 	= document.forms[0];
    var controlador = 'CalculoTarifasRutaCubicajeClass.php';
    
    FindRow(parametros,forma,controlador,null,function(resp){
	    
      var solicitud_servicio_tarifar_id = $('#solicitud_servicio_tarifar_id').val();
      var url 	    = "DetalleCalculoTarifasRutaCubicajeClass.php?solicitud_servicio_tarifar_id="+solicitud_servicio_tarifar_id;
      
      $("#detalleCalculoTarifasRutaCubicaje").attr("src",url);
      
      if($('#guardar'))    $('#guardar').attr("disabled","true");
      if($('#actualizar')) $('#actualizar').attr("disabled","");
      if($('#borrar'))     $('#borrar').attr("disabled","");
      if($('#limpiar'))    $('#limpiar').attr("disabled","");
      
      document.getElementById('cliente_id').disabled = true;	    
      setContactos();
	    
    });
}

function setDataFormWithResponseGrid(solicitud_servicio_tarifar_id){

    var parametros  = new Array ({campos:"solicitud_servicio_tarifar_id", valores:""+solicitud_servicio_tarifar_id+""});	
    var forma 	    = document.forms[0];
    var controlador = 'CalculoTarifasRutaCubicajeClass.php';
    
    FindRow(parametros,forma,controlador,null,function(resp){
	    
      var solicitud_servicio_tarifar_id = solicitud_servicio_tarifar_id;
      var url 	    = "DetalleCalculoTarifasRutaCubicajeClass.php?solicitud_servicio_tarifar_id="+solicitud_servicio_tarifar_id;
      
      $("#detalleCalculoTarifasRutaCubicaje").attr("src",url);
      
      if($('#guardar'))    $('#guardar').attr("disabled","true");
      if($('#actualizar')) $('#actualizar').attr("disabled","");
      if($('#borrar'))     $('#borrar').attr("disabled","");
      if($('#limpiar'))    $('#limpiar').attr("disabled","");
      
      document.getElementById('cliente_id').disabled = true;
      setContactos();
	    
    });
  
}

function validaSeleccionSolicitud(){
  
  var solicitud_servicio_tarifar_id = $("#solicitud_servicio_tarifar_id").val();
  
  if(parseInt(solicitud_servicio_tarifar_id) > 0){
    return true;
  }else{
     alertJquery('Debe ingresar primero los datos generales de la solicitud de servicio !!','Validacion');
     return false;
   }
  
}

function onSendFile(response){
  
  if($.trim(response) == 'NA'){
    alertJquery('No se ha realizado parametrizacion para cargar archivo a este cliente !!');
  }else{
    
	if($.trim(response).length > 0){
     alertJquery(response);
	}
    
  }

     var solicitud_servicio_tarifar_id = $('#solicitud_servicio_tarifar_id').val();
     var url 	                 = "DetalleCalculoTarifasRutaCubicajeClass.php?solicitud_servicio_tarifar_id="+solicitud_servicio_tarifar_id;
      
     $("#detalleCalculoTarifasRutaCubicaje").attr("src",url);
  
  
}

function CalculoTarifasRutaCubicajeOnSave(formulario,resp){	
  	
   try{
	   
	resp = $.parseJSON(resp);
	
	if($.isArray(resp)){
				
		$("#solicitud_servicio_tarifar_id").val(resp[0]['solicitud_servicio_tarifar_id']);
		
		var solicitud_servicio_tarifar_id = $('#solicitud_servicio_tarifar_id').val();
		var url 		= "DetalleCalculoTarifasRutaCubicajeClass.php?solicitud_servicio_tarifar_id="+solicitud_servicio_tarifar_id;
		
		$("#detalleCalculoTarifasRutaCubicaje").attr("src",url);
		
		if($('#guardar'))    $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#borrar'))     $('#borrar').attr("disabled","");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");
		
		updateGrid();
	
	}else{
		alertJquery("Ocurrio una inconsistencia : "+resp);
	}
	
       }catch(e){
	 alertJquery(e);
        }
}


function CalculoTarifasRutaCubicajeOnUpdate(formulario,resp){
	
          
	if($.trim(resp) == 'true'){
	  
	        alertJquery("Datos guardados Exitosamente","Solicitud de Servicio");
		
		var solicitud_servicio_tarifar_id = $("#solicitud_servicio_tarifar_id").val();
		var url          = "DetalleCalculoTarifasRutaCubicajeClass.php?solicitud_servicio_tarifar_id="+solicitud_servicio_tarifar_id;
		
		$("#detalleCalculoTarifasRutaCubicaje").attr("src",url);
		
		updateGrid();
	
	}else{
		alertJquery(resp,"Solicitud de Servicio");
	}
}


function CalculoTarifasRutaCubicajeOnDelete(formulario,resp){
	resetContactos();
	CalculoTarifasRutaCubicajeOnReset();
	Reset(formulario);
	clearFind();
	updateGrid();

    $("#oficina").val($("#oficina_hidden").val());
    $("#oficina_id").val($("#oficina_id_hidden").val());	
    $("#fecha").val($("#fecha_static").val());	
	
	alertJquery(resp);
}


function setContactos(){

	var QueryString = "ACTIONCONTROLER=setContactos&cliente_id="+ $("#cliente_id").val()+'&solicitud_servicio_tarifar_id='+$("#solicitud_servicio_tarifar_id").val();
	
	$.ajax({
		url     : "CalculoTarifasRutaCubicajeClass.php",
		data    : QueryString,
		success : function(response){			
			$("#contacto_id").parent().html(response);
		}
	});	
}

function CalculoTarifasRutaCubicajeOnReset(){
  
    var oficina    = $("#oficina_hidden").val();
    var oficina_id = $("#oficina_id_hidden").val();
    var fecha      = $("#fecha_static").val();	
    
    resetContactos();
    clearFind();
    resetDetalle("detalleCalculoTarifasRutaCubicaje");resetDetalle("detalleCalculoTarifasRutaCubicajeCalculado");
    
    $('#guardar').attr("disabled","");
    $('#actualizar').attr("disabled","true");
    $('#borrar').attr("disabled","true");
    $('#limpiar').attr("disabled","");
    
    $("#oficina").val(oficina);
    $("#oficina_id").val(oficina_id);	
    $("#fecha").val($("#fecha_static").val());		
    document.getElementById('cliente_id').disabled = false;
	
}


function resetContactos(){
	$("#contacto_id option").each(function(){
		if(this.value != 'NULL') $(this).remove();
	});
}


function updateGrid(){
	$("#refresh_QUERYGRID_CalculoTarifasRutaCubicaje").click();
}


function calcularTarifasOrdenCliente(){
	
	$("#detalleCalculoTarifasRutaCubicaje").load(function(){
														  
        var cliente_id                    = document.getElementById('cliente_id').value;														  
		var solicitud_servicio_tarifar_id = $("#solicitud_servicio_tarifar_id").val();				
		var QueryString = "ACTIONCONTROLER=calcularTarifasOrdenCliente&solicitud_servicio_tarifar_id="+solicitud_servicio_tarifar_id+"&cliente_id="+cliente_id;
		
		if(solicitud_servicio_tarifar_id > 0){		
		  document.getElementById('detalleCalculoTarifasRutaCubicajeCalculado').src = 'CalculoTarifasRutaCubicajeClass.php?'+QueryString;													  														  
		}
		
    });
	
	
}