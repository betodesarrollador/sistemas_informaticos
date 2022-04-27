// JavaScript Document
//eventos asignados a los objetos
$(document).ready(function(){

   getDetalleGuiaMasivo();
   setDetalleGuiaMasivo();
   document.getElementById('detalleGuiaMasivo').src = "about:blank";  
   
  
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


function getDetalleGuiaMasivo(){
  
  $("#cliente_id").change(function(){
    
    if(this.value == 'NULL'){
     alertJquery("Debe Seleccionar un Cliente !!!","Campos Archivo Solicitud Cliente"); 
      document.getElementById('detalleGuiaMasivo').src = "about:blank"; 
    }else{
      document.getElementById('detalleGuiaMasivo').src = "DetalleGuiaMasivoClass.php?cliente_id="+this.value;
     }
    
  });
  
   
}



function setDetalleGuiaMasivo(){
 
  $("#guardar").click(function(){
  
  var cliente_id = document.getElementById('cliente_id').value;
  var form = this.form;
  

      
    var QueryString = "ACTIONCONTROLER=setDetalleGuiaMasivo&cliente_id="+cliente_id+"&"+FormSerialize(form);
          
    $.ajax({
      url        : "GuiaMasivoClass.php?rand="+Math.random(),
      data       : QueryString,
      beforeSend : function(){
        showDivLoading();
      },
      success    : function(resp){

		alertJquery(resp,"Guia por lotes");  
	
        removeDivLoading();
      }
      
    });
  
  });
 
}