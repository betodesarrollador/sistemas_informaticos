// JavaScript Document
//eventos asignados a los objetos
$(document).ready(function(){
	
});

function validaSeleccionSolicitud(){
  
    return true;
}

function onSendFile(response){
  
  if($.trim(response) == 'NA'){
    alertJquery('No se ha realizado parametrizacion para cargar archivo !!');
  }else{
    
	if($.trim(response).length > 0){
     alertJquery(response);
	}
    
  }

}

