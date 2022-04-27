// JavaScript Document
//eventos asignados a los objetos
$(document).ready(function(){
	
    $("#saveDetallesSoliServi").click(function(){
      window.frames[0].saveDetallesSoliServi();
    });
    
    $("#deleteDetallesSoliServi").click(function(){
	window.frames[0].deleteDetallesSoliServi();
    });

    resetDetalle("detalleSoliServi");
	
	/*
    $('#fileInput').uploadify({
        'uploader'  : '../../../framework/js/jquery-uploader/uploadify.swf',
        'script'    : 'SolicitudServiciosClass.php?ACTIONCONTROLER=uploadFile',
	'scriptData' : {'ACTIONCONTROLER': 'uploadFile'},
        'cancelImg' : '../../../framework/js/jquery-uploader/cancel.png',
        'auto'      : true,
        'folder'    : '../../../framework/js/jquery-uploader/uploads',
        'onComplete': function(event, queueID, fileObj, response, data) {
                    alertJquery(response);
            
        }
    });*/
    

});


function setDataFormWithResponse(){
	
    var parametros 	= new Array ({campos:"solicitud_id", valores:$('#solicitud_id').val()});
    var forma 	= document.forms[0];
    var controlador = 'SolicitudServiciosClass.php';
    
    FindRow(parametros,forma,controlador,null,function(resp){
	    
      var solicitudId = $('#solicitud_id').val();
      var url 	    = "DetalleSolicitudServiciosClass.php?solicitud_id="+solicitudId;
      
      $("#detalleSoliServi").attr("src",url);
      
      if($('#guardar'))    $('#guardar').attr("disabled","true");
      if($('#actualizar')) $('#actualizar').attr("disabled","");
      if($('#borrar'))     $('#borrar').attr("disabled","");
      if($('#limpiar'))    $('#limpiar').attr("disabled","");
      
      document.getElementById('cliente_id').disabled = true;	    
      setContactos();
	    
    });
}

function setDataFormWithResponseGrid(solicitud_id){

    var parametros  = new Array ({campos:"solicitud_id", valores:""+solicitud_id+""});	
    var forma 	    = document.forms[0];
    var controlador = 'SolicitudServiciosClass.php';
    
    FindRow(parametros,forma,controlador,null,function(resp){
	    
      var solicitudId = solicitud_id;
      var url 	    = "DetalleSolicitudServiciosClass.php?solicitud_id="+solicitudId;
      
      $("#detalleSoliServi").attr("src",url);
      
      if($('#guardar'))    $('#guardar').attr("disabled","true");
      if($('#actualizar')) $('#actualizar').attr("disabled","");
      if($('#borrar'))     $('#borrar').attr("disabled","");
      if($('#limpiar'))    $('#limpiar').attr("disabled","");
      
      document.getElementById('cliente_id').disabled = true;
      setContactos();
	    
    });
  
}

function validaSeleccionSolicitud(){
  
  var solicitud_id = $("#solicitud_id").val();
  
  if(parseInt(solicitud_id) > 0){
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

     var solicitudId = $('#solicitud_id').val();
     var url 	    = "DetalleSolicitudServiciosClass.php?solicitud_id="+solicitudId;
      
     $("#detalleSoliServi").attr("src",url);
  
  
}

function SolicitudServiciosOnSave(formulario,resp){
  	
       try{
	resp = $.parseJSON(resp);
	
	if($.isArray(resp)){
				
		$("#solicitud_id").val(resp[0]['solicitud_id']);
		
		var solicitudId = $('#solicitud_id').val();
		var url 		= "DetalleSolicitudServiciosClass.php?solicitud_id="+solicitudId;
		
		$("#detalleSoliServi").attr("src",url);
		
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


function SolicitudServiciosOnUpdate(formulario,resp){
	
          
	if($.trim(resp) == 'true'){
	  
	        alertJquery("Datos guardados Exitosamente","Solicitud de Servicio");
		
		var solicitud_id = $("#solicitud_id").val();
		var url          = "DetalleSolicitudServiciosClass.php?solicitud_id="+solicitud_id;
		
		$("#detalleSoliServi").attr("src",url);
		
		updateGrid();
	
	}else{
		alertJquery(resp,"Solicitud de Servicio");
	}
}


function SolicitudServiciosOnDelete(formulario,resp){
	resetContactos();
	SolicitudServiciosOnReset();
	Reset(formulario);
	clearFind();
	updateGrid();
	alertJquery(resp);
}


function setContactos(){

	var QueryString = "ACTIONCONTROLER=setContactos&cliente_id="+ $("#cliente_id").val()+'&solicitud_id='+$("#solicitud_id").val();
	
	$.ajax({
		url     : "SolicitudServiciosClass.php",
		data    : QueryString,
		success : function(response){			
			$("#contacto_id").parent().html(response);
		}
	});	
}

function SolicitudServiciosOnReset(){
  
    var oficina    = $("#oficina_hidden").val();
    var oficina_id = $("#oficina_id_hidden").val();
    
    resetContactos();
    clearFind();
    resetDetalle("detalleSoliServi");
    
    $('#guardar').attr("disabled","");
    $('#actualizar').attr("disabled","true");
    $('#borrar').attr("disabled","true");
    $('#limpiar').attr("disabled","");
    
    $("#oficina").val(oficina);
    $("#oficina_id").val(oficina_id);	
    $("#fecha_ss").val($("#fecha_ss_static").val());		
    document.getElementById('cliente_id').disabled = false;
	
}


function resetContactos(){
	$("#contacto_id option").each(function(){
		if(this.value != 'NULL') $(this).remove();
	});
}


function updateGrid(){
	$("#refresh_QUERYGRID_SolicitudServicios").click();
}