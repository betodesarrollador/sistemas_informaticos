// JavaScript Document
$(document).ready(function(){
  resetDetalle('detalleCertificados');
  $("#saveDetalles").click(function(){
    window.frames[0].saveDetallesSoliServi();
  });
    
  $("#deleteDetalles").click(function(){
    window.frames[0].deleteDetallesSoliServi();
  });   
});
function setDataFormWithResponse(){
	
RequiredRemove();
FindRow([{campos:"certificados_id",valores:$('#certificados_id').val()}],document.forms[0],'CertificadosClass.php',null, 
  function(resp){
	  
	try{
		
	var data          = $.parseJSON(resp);  
	var certificados_id = data[0]['certificados_id']; 
		
	document.getElementById('detalleCertificados').src = "DetalleCertificadosClass.php?certificados_id="+certificados_id+"&rand="+Math.random();
  
    if($('#guardar'))    $('#guardar').attr("disabled","true");
    if($('#actualizar')) $('#actualizar').attr("disabled","");
    if($('#borrar'))     $('#borrar').attr("disabled","");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");
	
	}catch(e){
		 alertJquery(resp,"Error :"+e);
	  }
	
  });

}

function showTable(){
  
  var frame_grid =  document.getElementById('frame_grid');
  
    //Se valida que el iFrame no exista
    if(frame_grid == null ){

    var QueryString   = 'ACTIONCONTROLER=showGrid';

    $.ajax({
      url        : "CertificadosClass.php?rand="+Math.random(),
      data       : QueryString,
       async     : false,
      beforeSend : function(){
      showDivLoading();
      },
      success    : function(resp){
        console.log(resp);
        try{
          
          var iframe           = document.createElement('iframe');
          iframe.id            ='frame_grid';
          iframe.style.cssText = "border:0; height: 400px; background-color:transparent";
          //iframe.scrolling   = 'no';
          
          document.body.appendChild(iframe); 
          iframe.contentWindow.document.open();
          iframe.contentWindow.document.write(resp);
          iframe.contentWindow.document.close();
          
          $('#mostrar_grid').removeClass('btn btn-warning btn-sm');
          $('#mostrar_grid').addClass('btn btn-secondary btn-sm');
          $('#mostrar_grid').html('Ocultar tabla');
          
        }catch(e){
          
          console.log(e);
          
        }
        removeDivLoading();
      } 
    });
    
  }else{
    
      $('#frame_grid').remove();
      $('#mostrar_grid').removeClass('btn btn-secondary btn-sm');
      $('#mostrar_grid').addClass('btn btn-warning btn-sm');
      $('#mostrar_grid').html('Mostrar tabla');
    
  }
  
}

function CertificadosOnSave(formulario,resp){
   Reset(formulario);
   clearFind();
   resetDetalle('detalleCertificados');   
   $("#refresh_QUERYGRID_certificados").click();
   
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
	
   if(!isNaN(parseInt(resp))){
    var certificados_id = resp;
		   
    alertJquery("Se Guardo Exitosamente el Certificado!!","Certificados");
   
	document.getElementById('detalleCertificados').src = "DetalleCertificadosClass.php?certificados_id="+certificados_id+"&rand="+Math.random();
	   
   }else{
	   alertJquery(resp,"Certificados");
	}		   
   
}
function CertificadosOnUpdateonDelete(formulario,resp){
   Reset(formulario);
   clearFind();
   resetDetalle('detalleCertificados');   
   $("#refresh_QUERYGRID_certificados").click();
   
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
	
   alertJquery(resp,"Certificados");
   
	document.getElementById('detalleCertificados').src = "DetalleCertificadosClass.php?certificados_id="+certificados_id+"&rand="+Math.random();
   
   
}
function CertificadosOnReset(formulario){
	
    Reset(formulario);
    clearFind();	
	resetDetalle('detalleCertificados');
	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
}