// JavaScript Document
//eventos asignados a los objetos
$(document).ready(function(){

   getDetalleCamposArchivoCliente();
   setDetalleCamposArchivoCliente();
   document.getElementById('detalleCamposArchivoCliente').src = 'about:blank';		    
  
});

function validaSeleccionSolicitud(){
  
  var cliente_id = $("#cliente_id").val();
  
  if(parseInt(cliente_id) > 0){
    return true;
  }else{
     alertJquery('Debe Seleccionar primero el cliente !!','Campos Archivo Solicitud');
     document.getElementById('detalleCamposArchivoCliente').src = 'about:blank';		  	 
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

function getDetalleCamposArchivoCliente(){
  
  $("#cliente_id").change(function(){
    
	  if(this.value == 'NULL'){
       document.getElementById('detalleCamposArchivoCliente').src = 'about:blank';		  
	  }else{
        document.getElementById('detalleCamposArchivoCliente').src = "DetalleUnidadesClienteClass.php?cliente_id="+this.value;
	   }
    
    
  });
  
   
}


function setDetalleCamposArchivoCliente(){
 
  $("#guardar").click(function(){
  
  var form       = window.frames[0].document.getElementById('detalle_campos_archivo_cliente');
  var cliente_id = document.getElementById('cliente_id').value;
  
  if(form){
      
    var QueryString = "ACTIONCONTROLER=setDetalleUnidadesCliente&cliente_id="+cliente_id+"&"+FormSerialize(form);
      
    $.ajax({
      url        : "UnidadesClienteClass.php?rand="+Math.random(),
      data       : QueryString,
      beforeSend : function(){
        showDivLoading();
      },
      success    : function(resp){
        
	if($.trim(resp) == 'true'){
	 alertJquery("Registros guardados exitosamente !!","Unidades Cliente"); 
	}else{
	  
	 }
	 
        removeDivLoading();
      }
      
    });
 
  }else{
      alertJquery("Seleccione un cliente por favor!!","Definicion de Campos Solicitud");
      document.getElementById('detalleCamposArchivoCliente').src = 'about:blank';		  	  
    }
  
  });
 
}