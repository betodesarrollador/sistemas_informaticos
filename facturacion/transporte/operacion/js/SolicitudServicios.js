// JavaScript Document
//eventos asignados a los objetos
$(document).ready(function(){
    $("#paqueteo").change(function(){
      if(this.value=='S'){
		  document.getElementById('historico_val').style.display='none';
		  document.getElementById('tipo_servicio').style.display='';
		  document.getElementById('tipo_servicio1').style.display='';
		  document.getElementById('tipo_servicio_id').value='NULL';
		  document.getElementById('detailToolbar').style.display='';		  
		  document.getElementById('fileUpload').style.display='';		  		  
		  document.getElementById('fechas_recogidas').style.display='';
		  $("#fecha_ss_final,#valor_costo,#valor_facturar").removeClass("obligatorio");
		  $("#detalleSoliServi").removeClass("iframe_min");
		  $("#detalleSoliServi").addClass("iframe_max");		  
		  
	  }else if(this.value=='N'){
  		  document.getElementById('historico_val').style.display='';
		  document.getElementById('tipo_servicio').style.display='none';
		  document.getElementById('tipo_servicio1').style.display='none';
		  document.getElementById('tipo_servicio_id').value='1';
		  document.getElementById('detailToolbar').style.display='none';		  
		  document.getElementById('fileUpload').style.display='none';		  		  
		  document.getElementById('fechas_recogidas').style.display='none';			  
		  $("#fecha_ss_final,#valor_costo,#valor_facturar").addClass("obligatorio");
		  $("#detalleSoliServi").removeClass("iframe_max");		  
		  $("#detalleSoliServi").addClass("iframe_min");
	  }else{
  		  document.getElementById('historico_val').style.display='none';
		  document.getElementById('tipo_servicio').style.display='none';
		  document.getElementById('tipo_servicio1').style.display='none';
		  document.getElementById('tipo_servicio_id').value='NULL';
		  document.getElementById('detailToolbar').style.display='none';		  
		  document.getElementById('fileUpload').style.display='none';		  		  
		  document.getElementById('fechas_recogidas').style.display='none';	
  		  $("#detalleSoliServi").removeClass("iframe_min");
		  $("#detalleSoliServi").addClass("iframe_max");		  

		  
	  }
    });
	
    $("#saveDetallesSoliServi").click(function(){
      window.frames[1].saveDetallesSoliServi();
    });
    
    $("#deleteDetallesSoliServi").click(function(){
	window.frames[1].deleteDetallesSoliServi();
    });

    resetDetalle("detalleSoliServi");
	
	/*
    $('#fileInput').uploadify({
        'uploader'  : '/cootransvalle/framework/js/jquery-uploader/uploadify.swf',
        'script'    : 'SolicitudServiciosClass.php?ACTIONCONTROLER=uploadFile',
	'scriptData' : {'ACTIONCONTROLER': 'uploadFile'},
        'cancelImg' : '/cootransvalle/framework/js/jquery-uploader/cancel.png',
        'auto'      : true,
        'folder'    : '/cootransvalle/framework/js/jquery-uploader/uploads',
        'onComplete': function(event, queueID, fileObj, response, data) {
                    alertJquery(response);
             
        }
    });*/
    

});
function setTipo(){
	var paqueteo = $('#paqueteo').val();
    var solicitudId = $('#solicitud_id').val();

      if(paqueteo=='S'){
		  document.getElementById('historico_val').style.display='none';
		  document.getElementById('tipo_servicio').style.display='';
		  document.getElementById('tipo_servicio1').style.display='';
		  document.getElementById('detailToolbar').style.display='';		  
		  document.getElementById('fileUpload').style.display='';		  		  
		  document.getElementById('fechas_recogidas').style.display='';
		  $("#fecha_ss_final,#valor_costo,#valor_facturar").removeClass("obligatorio");
		  $("#detalleSoliServi").removeClass("iframe_min");
		  $("#detalleSoliServi").addClass("iframe_max");		  
		  
	  }else if(paqueteo=='N'){
  		  document.getElementById('historico_val').style.display='';
		  document.getElementById('tipo_servicio').style.display='none';
		  document.getElementById('tipo_servicio1').style.display='none';
		  document.getElementById('detailToolbar').style.display='none';		  
		  document.getElementById('fileUpload').style.display='none';		  		  
		  document.getElementById('fechas_recogidas').style.display='none';			  
		  $("#fecha_ss_final,#valor_costo,#valor_facturar").addClass("obligatorio");
		  $("#detalleSoliServi").removeClass("iframe_max");		  
		  $("#detalleSoliServi").addClass("iframe_min");
          var url1 	    = "SolicitudServiciosClass.php?solicitud_id="+solicitudId+"&historico=si";
		  $("#detalleTarifa").attr("src",url1);

	  }
}

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
	  if($('#imprimir'))    $('#imprimir').attr("disabled","");
      
      document.getElementById('cliente_id').disabled = true;
	  document.getElementById('paqueteo').disabled = true;
	  document.getElementById('tipo_liquidacion').disabled = true;
      setContactos();
	  setTipo();
	    
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
	  if($('#imprimir'))    $('#imprimir').attr("disabled","");
      
      document.getElementById('cliente_id').disabled = true;
	  document.getElementById('tipo_liquidacion').disabled = true;
      setContactos();
	    
    });
  
}

function validaSeleccionSolicitud(){
  
  var solicitud_id = $("#solicitud_id").val();
   var paqueteo = $("#paqueteo").val();
  
  if(parseInt(solicitud_id) > 0 && paqueteo=='S' ){
    return true;
  }else if(parseInt(solicitud_id) > 0 && paqueteo=='N' ){	
     alertJquery('No se puede subir archivo para solicitud de tipo masivo !!','Validacion');
     return false;
  
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
		var url1 		= "SolicitudServiciosClass.php?solicitud_id="+solicitudId+"&historico=si";
		
		$("#detalleSoliServi").attr("src",url);
		$("#detalleTarifa").attr("src",url1);
		
		if($('#guardar'))    $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#borrar'))     $('#borrar').attr("disabled","");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");
		if($('#imprimir'))    $('#imprimir').attr("disabled","true");
		
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
		var url1 		= "SolicitudServiciosClass.php?solicitud_id="+solicitud_id+"&historico=si";
		
		$("#detalleSoliServi").attr("src",url);
		$("#detalleTarifa").attr("src",url1);
		
		
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
	resetDetalle("detalleTarifa");
    
    $('#guardar').attr("disabled","");
    $('#actualizar').attr("disabled","true");
    $('#borrar').attr("disabled","true");
    $('#limpiar').attr("disabled","");
	$('#imprimir').attr("disabled","true");
    
    $("#oficina").val(oficina);
    $("#oficina_id").val(oficina_id);	
    $("#fecha_ss").val($("#fecha_ss_static").val());	
	$("#fecha_ss_final").val($("#fecha_ss_static").val());	
    document.getElementById('cliente_id').disabled = false;
    document.getElementById('tipo_liquidacion').disabled = false;
	document.getElementById('paqueteo').disabled = false;

	document.getElementById('historico_val').style.display='none';
	document.getElementById('tipo_servicio').style.display='';
	document.getElementById('tipo_servicio1').style.display='';
	document.getElementById('tipo_servicio_id').value='NULL';
	document.getElementById('detailToolbar').style.display='';		  
	document.getElementById('fileUpload').style.display='';		  		  
	document.getElementById('fechas_recogidas').style.display='';	
	$("#detalleSoliServi").removeClass("iframe_min");
	$("#detalleSoliServi").addClass("iframe_max");		  

	
}

function beforePrint(formulario,url,title,width,height){

	var solicitud_id = parseInt($("#solicitud_id").val());
	
	if(isNaN(solicitud_id)){
	  
	  alertJquery('Debe seleccionar una Solicitud a imprimir !!!','Impresion Orden de Cargue');
	  return false;
	  
	}else{	  
	    return true;
	  }
	
}


function resetContactos(){
	$("#contacto_id option").each(function(){
		if(this.value != 'NULL') $(this).remove();
	});
}


function updateGrid(){
	$("#refresh_QUERYGRID_SolicitudServicios").click();
}