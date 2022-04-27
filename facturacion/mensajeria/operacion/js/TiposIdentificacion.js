// JavaScript Document
//eventos asignados a los objetos
$(document).ready(function(){

   getDetalleTiposIdentificacion();
   setDetalleTiposIdentificacion();
   document.getElementById('detalleTiposIdentificacion').src = "about:blank";		   
  
});

function validaSeleccionSolicitud(){
  
  var cliente_id = $("#cliente_id").val();
  
  if(parseInt(cliente_id) > 0){
    return true;
  }else{
     alertJquery('Debe Seleccionar primero el cliente !!','Campos Archivo Solicitud');
     document.getElementById('detalleTiposIdentificacion').src = "about:blank";		   	 
     return false;
   }
  
}

function getDetalleTiposIdentificacion(){
  
  $("#cliente_id").change(function(){
								   								   
       if(this.value != 'NULL'){
         document.getElementById('detalleTiposIdentificacion').src = "DetalleTiposIdentificacionClass.php?cliente_id="+this.value;		
	   }else{
           document.getElementById('detalleTiposIdentificacion').src = "about:blank";		   
		 }
    

  });
  
   
}


function setDetalleTiposIdentificacion(){
 
  $("#guardar").click(function(){
  
  var form       = window.frames[0].document.getElementById('detalle_campos_archivo_cliente');
  var cliente_id = document.getElementById('cliente_id').value;
  
  if(form){
      
    var QueryString = "ACTIONCONTROLER=setDetalleTiposIdentificacion&cliente_id="+cliente_id+"&"+FormSerialize(form);
      
    $.ajax({
      url        : "DetalleTiposIdentificacionClass.php?rand="+Math.random(),
      data       : QueryString,
      beforeSend : function(){
        showDivLoading();
      },
      success    : function(resp){
        
		if($.trim(resp) == 'true'){
		 alertJquery("Guardado Exitosamente!!","Tipos Identificacion");
		}else{
			alertJquery(resp,"Error :");
		  }
		  
        removeDivLoading();
      }
      
    });
 
  }else{
      alertJquery("Seleccione un cliente por favor!!","Definicion de Campos Solicitud");
      document.getElementById('detalleTiposIdentificacion').src = "about:blank";		   	  
    }
  
  });
 
}