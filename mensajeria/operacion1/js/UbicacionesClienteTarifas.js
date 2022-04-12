// JavaScript Document
//eventos asignados a los objetos
$(document).ready(function(){

   getDetalleUbicacionesClienteTarifas();
   setDetalleUbicacionesClienteTarifas();
      
   document.getElementById('detalleUbicacionesClienteTarifas').src = "about:blank";

});

function validaSeleccionSolicitud(){
  
  var cliente_id = $("#cliente_id").val();
  
  if(parseInt(cliente_id) > 0){
    return true;
  }else{
     alertJquery('Debe Seleccionar primero el cliente !!','Campos Archivo Solicitud');
     return false;
   }
  
}

function onSendFile(response){
  
  if($.trim(response) == 'NA'){
    alertJquery('No se ha realizado parametrizacion para cargar archivo a este cliente !!');
  }else{
        
    $("#cliente_id").trigger("change");
    
  }
  
  
}

function getDetalleUbicacionesClienteTarifas(){
  
  $("#cliente_id").change(function(){
    	
	  if(this.value == 'NULL'){
        document.getElementById('detalleUbicacionesClienteTarifas').src = "about:blank";
	  }else{
          document.getElementById('detalleUbicacionesClienteTarifas').src = "DetalleUbicacionesClienteTarifasClass.php?cliente_id="+this.value;	
		}

  });
  
   
}


function setDetalleUbicacionesClienteTarifas(){
 
  $("#guardar").click(function(){
  
  var form       = window.frames[0].document.getElementById('detalle_campos_archivo_cliente');
  var cliente_id = document.getElementById('cliente_id').value;
  
  if(form && cliente_id != 'NULL'){
      
	var ubicaciones = '';
	var i           = 0;
	
	$(form).find("*[name=nombre]").each(function(){
	
	   var row = this.parentNode.parentNode;
	   
	   if(row.id != 'clon'){
	   
		   var nombre       = $(row).find("input[name=nombre]").val();
		   var ubicacion_id = $(row).find("select[name=ubicacion_id] option:selected").val();
		   
		   if($.trim(nombre).length > 0){
		   
		     ubicaciones += "ubicaciones["+i+"][nombre]="+nombre+"&";
		     ubicaciones += "ubicaciones["+i+"][ubicacion_id]="+ubicacion_id+"&";
		   
		     i++;
			 
		   }
	   
	   }
																						 
    });
	
    var QueryString = "ACTIONCONTROLER=setDetalleUbicacionesClienteTarifas&cliente_id="+cliente_id+"&"+ubicaciones;
      
    $.ajax({
      url        : "UbicacionesClienteTarifasClass.php?rand="+Math.random(),
      type       : "POST",	   
      data       : QueryString,
      beforeSend : function(){
        showDivLoading();
      },
      success    : function(resp){
        
		if($.trim(resp) == 'true'){
		  alertJquery("Registro Guardado Exitosamente","Ubicacion Cliente");
		}else{
			alertJquery(resp,"Error:");
		  }
		  
        removeDivLoading();
      }
      
    });
 
  }else{
      alertJquery("Seleccione un cliente por favor!!","Definicion de Campos Solicitud");
      document.getElementById('detalleUbicacionesClienteTarifas').src = "about:blank";	  
    }
  
  });
 
}