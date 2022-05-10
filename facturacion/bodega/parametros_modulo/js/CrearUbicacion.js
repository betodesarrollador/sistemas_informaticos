// JavaScript Document

$(document).ready(function(){
  resetDetalle('detalleCrearUbicacion');
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

});

function setDataFormWithResponse(){
  
RequiredRemove();

  var forma = document.forms[0];
  var QueryString = "ACTIONCONTROLER=onclickFind&ubicacion_bodega_id=" + $('#ubicacion_bodega_id').val();

  $.ajax({
    url: 'CrearUbicacionClass.php?random=' + Math.random(),
    data: QueryString,
    beforeSend: function () {
      showDivLoading();
    },
    success: function (resp) {
    
      try{
      var data          = $.parseJSON(resp);  
        var ubicacion_bodega = data[0]['ubicacion_bodega']; 
        var ubicacion_bodega_id = ubicacion_bodega[0]['ubicacion_bodega_id']; 
        var estado_ubicacion = data[0]['estado_ubicacion'];

        setFormWithJSON(forma, ubicacion_bodega, false, function () {

          if (estado_ubicacion != null) {
            for (var i = 0; i < estado_ubicacion.length; i++) {

              var estado_producto = estado_ubicacion[i]['estado_producto'];

              $("select[name=estado_producto] option").each(function () {

                if (this.value == estado_producto) {
                  this.selected = true;
                  return true;
                }

              });
            }
          }

          $('select option[value="NULL"]').attr("selected", false);
        
          if($('#guardar'))    $('#guardar').attr("disabled","true");
          if($('#actualizar')) $('#actualizar').attr("disabled","");
          if($('#borrar'))     $('#borrar').attr("disabled","");
          if($('#limpiar'))    $('#limpiar').attr("disabled","");
        });
      }catch(e){
        alertJquery(resp,"Error :"+e);
        }

      removeDivLoading();
  
      }

    });



}

function CrearUbicacionOnSaveOnUpdateonDelete(formulario,resp){

   Reset(formulario);
   clearFind();
   resetDetalle('detalleCrearUbicacion');   
  var usuario_id = $('#usuario_static').val();
  $('#usuario_id').val(usuario_id);
   $("#refresh_QUERYGRID_ubicacion_bodega").click();
   
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
  
   alertJquery(resp,"CrearUbicacion");
   
}
function CrearUbicacionOnReset(formulario){
  
    Reset(formulario);
    clearFind();  
  resetDetalle('detalleCrearUbicacion');
  var usuario_id = $('#usuario_static').val();
  $('#usuario_id').val(usuario_id);
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled",""); 
}

function all_estados() {
  if (document.getElementById('all_estado').checked == true) {
    $('#all_estado').val('SI');

    var objSelect = document.getElementById('estado_producto');
    var numOp = objSelect.options.length - 1;


    for (var i = numOp; i > 0; i--) {

      if (objSelect.options[i].value != 'NULL') {
        objSelect.options[i].selected = true;
      } else {
        objSelect.options[i].selected = false;
      }
    }

  } else {
    $('#all_estado').val('NO');
    var objSelect = document.getElementById('estado_producto');
    var numOp = objSelect.options.length - 1;


    for (var i = numOp; i > 0; i--) {

      if (objSelect.options[i].value != 'NULL') {
        objSelect.options[i].selected = false;
      } else {
        objSelect.options[i].selected = true;
      }
    }
  }
}