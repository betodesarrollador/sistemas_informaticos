// JavaScript Document
$(document).ready(function(){
  resetDetalle('detalleDocumento');
  $("#saveDetalles").click(function(){
    window.frames[0].saveDetallesSoliServi();
  });
    
  $("#deleteDetalles").click(function(){
    window.frames[0].deleteDetallesSoliServi();
  }); 

  $("#consecutivo_por").change(function(){
    if ($("#consecutivo_por").val() == 'E') {
      $('#consecutivo').attr("disabled","");
    }else{
      $('#consecutivo').attr("disabled","true");
      $('#consecutivo').removeClass("requerido");
      $('#consecutivo').removeClass("obligatorio");
    }
  });  
  
  resetDetalle('detalleDocumento');
  
});
function LlenarFormDocumentos(){
RequiredRemove();
var params     = new Array({campos:"tipo_documento_id",valores:$('#tipo_documento_id').val()});
var formulario = document.forms[0];
var url        = 'DocumentosClass.php';
FindRow(params,formulario,url,null,function(resp){
 var data              = $.parseJSON(resp);
 var tipo_documento_id = data[0]['tipo_documento_id']; 

 if ($('#consecutivo_por').val()== 'O') {
   
   document.getElementById('detalleDocumento').src = 'DetalleDocumentoClass.php?tipo_documento_id='+tipo_documento_id;
 }else{
  resetDetalle('detalleDocumento');	
 }

 if($('#guardar'))    $('#guardar').attr("disabled","true");
 if($('#actualizar')) $('#actualizar').attr("disabled","");
 if($('#borrar'))     $('#borrar').attr("disabled","");
 if($('#limpiar'))    $('#limpiar').attr("disabled","");											
											
});
}

function showTable(){
  
  var frame_grid =  document.getElementById('frame_grid');
  
    //Se valida que el iFrame no exista
    if(frame_grid == null ){

    var QueryString   = 'ACTIONCONTROLER=showGrid';

    $.ajax({
      url        : "DocumentosClass.php?rand="+Math.random(),
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

function DocumentosOnSaveOnUpdateonDelete(formulario,resp){
  
  if(resp > 0){
    var tipo_documento_id = parseInt($.parseJSON(resp));
    $('#tipo_documento_id').val(tipo_documento_id);
    LlenarFormDocumentos();
    alertJquery("Se ingreso Exitosamente la Documentos");
  }else{
    alertJquery(resp, "Documentos");
  }
  
  $("#refresh_QUERYGRID_tipo_de_documento").click();
   
}

function DocumentosOnReset(formulario){
	
	Reset(formulario);
    clearFind();	
    setFocusFirstFieldForm(formulario);	
    resetDetalle('detalleDocumento');	
	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
}