// JavaScript Document
$(document).ready(function(){
  resetDetalle('detalleActa');
  $("#saveDetalles").click(function(){
    window.frames[0].saveDetallesSoliServi();
  });
    
  $("#deleteDetalles").click(function(){
    window.frames[0].deleteDetallesSoliServi();
  });   
  $("#saveTerceros").click(function(){
    window.frames[1].saveDetallesSoliServi();
  });
    
  $("#deleteTerceros").click(function(){
    window.frames[1].deleteDetallesSoliServi();
  }); 
  
  $("#saveParticipantes").click(function(){
    window.frames[2].saveDetallesSoliServi();
  });
    
  $("#deleteParticipantes").click(function(){
    window.frames[2].deleteDetallesSoliServi();
  }); 
});
function setDataFormWithResponse(){
	
RequiredRemove();
FindRow([{campos:"acta_id",valores:$('#acta_id').val()}],document.forms[0],'ActaClass.php',null, 
  function(resp){
	try{
		
	var data          = $.parseJSON(resp);  
	var acta_id = data[0]['acta_id']; 
		
	document.getElementById('detalleActa').src = "DetalleActaClass.php?acta_id="+acta_id+"&rand="+Math.random();
	document.getElementById('terceroActa').src = "TerceroActaClass.php?acta_id="+acta_id+"&rand="+Math.random();
  document.getElementById('participantesActa').src = "ParticipantesActaClass.php?acta_id="+acta_id+"&rand="+Math.random();
  
    if($('#guardar'))    $('#guardar').attr("disabled","true");
    if($('#actualizar')) $('#actualizar').attr("disabled","");
    if($('#borrar'))     $('#borrar').attr("disabled","");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");
	
	}catch(e){
		 alertJquery(resp,"Error :"+e);
	  }	
  });
}

function beforePrint(formulario,url,title,width,height){
  var acta_id = $('#acta_id').val();
  
  if(acta_id > 0){
    return true;
  }else{
	  alertJquery("Ningun Comprobante Seleccionado","Impresion Actas de Reunion");
	  return false;
	}	
}

function onclickEnviarMail() {
  //alertJquery("En construccion");
  var acta_id = $("#acta_id").val();
  if (parseInt(acta_id) > 0) {
      var QueryString = "ACTIONCONTROLER=onclickEnviarMail&acta_id=" + acta_id;
      $.ajax({
          url: "ActaClass.php?rand=" + Math.random(),
          data: QueryString,
          beforeSend: function() {
              showDivLoading();
          },
          success: function(response) {
              removeDivLoading();
              alertJquery(response, "Validacion Envio");
          }
      });
  } else {
      alertJquery("Por favor seleccione un Acta", "Validacion");
  }
}

function showTable(){
  
  var frame_grid =  document.getElementById('frame_grid');
  
    //Se valida que el iFrame no exista
    if(frame_grid == null ){

    var QueryString   = 'ACTIONCONTROLER=showGrid';

    $.ajax({
      url        : "ActaClass.php?rand="+Math.random(),
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

function ActaOnSaveOnUpdateonDelete(formulario,resp){
   Reset(formulario);
   clearFind();
   resetDetalle('detalleActa');   
   $("#refresh_QUERYGRID_forma_pago").click();
   
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
	
   alertJquery(resp,"Acta");
   
}
function ActaOnReset(formulario){
	
    Reset(formulario);
    clearFind();	
	resetDetalle('detalleActa');
	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
}