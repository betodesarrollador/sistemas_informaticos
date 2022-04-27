// JavaScript Document
//eventos asignados a los objetos
$(document).ready(function(){

   getDetalleCamposArchivoTarifas();
   setDetalleCamposArchivoTarifas();
   document.getElementById('detalleCamposArchivoTarifas').src = "about:blank";  
  
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

function getDetalleCamposArchivoTarifas(){
  
  $("#cliente_id").change(function(){
    
    if(this.value == 'NULL'){
     alertJquery("Debe Seleccionar un Cliente !!!","Campos Archivo Solicitud Cliente"); 
      document.getElementById('detalleCamposArchivoTarifas').src = "about:blank"; 
    }else{
      document.getElementById('detalleCamposArchivoTarifas').src = "DetalleCamposArchivoTarifasClass.php?cliente_id="+this.value;
     }
    
  });
  
   
}


function CamposArchivoOnSave(resp){
  
  
  alertJquery(resp);
  
}

function setDetalleCamposArchivoTarifas(){
 
  $("#guardar").click(function(){
  
  var form       = window.frames[0].document.getElementById('detalle_campos_archivo_cliente');
  var cliente_id = document.getElementById('cliente_id').value;
  
  if(form){
      
    var QueryString = "ACTIONCONTROLER=setDetalleCamposArchivoTarifas&cliente_id="+cliente_id+"&"+FormSerialize(form);
          
    $.ajax({
      url        : "CamposArchivoTarifasClass.php?rand="+Math.random(),
      data       : QueryString,
      beforeSend : function(){
        showDivLoading();
      },
      success    : function(resp){
        
	
	if($.trim(resp) == 'true'){
	  alertJquery("Campos Archivo Actualizados Exitosamente !!","Campos Archivo Solicitud");
	}else{
	    alertJquery(resp);  
	  }
	
        removeDivLoading();
      }
      
    });
 
  }else{
      alertJquery("Seleccione un cliente por favor!!","Definicion de Campos Solicitud");
      document.getElementById('detalleCamposArchivoTarifas').src = "about:blank";	  
    }
  
  });
 
}