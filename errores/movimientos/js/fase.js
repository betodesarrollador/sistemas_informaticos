// JavaScript Document

function setDataFormWithResponse(){

  RequiredRemove();
  var forma     = document.forms[0];  
  FindRow([{campos:"fase_id",valores:$('#fase_id').val()}],document.forms[0],'faseClass.php',null, 
    function(resp){

      try{

        var data          = $.parseJSON(resp);  
        var estado     = data[0]['estado'];

        if(estado == '0'){ // entra si la fase esta en estado : cerrada
          disabledInputsFormManifiesto(forma);
          if($('#guardar'))    $('#guardar').attr("disabled","true");
          if($('#actualizar')) $('#actualizar').attr("disabled","true");
          if($('#cerrar'))     $('#cerrar').attr("disabled","true");
          if($('#borrar'))     $('#borrar').attr("disabled","true");
          if($('#limpiar'))    $('#limpiar').attr("disabled",""); 

          $('#label_mensaje').html(" * FASE CERRADA * ");

        }else{
          enabledInputsFormManifiesto(forma);
          if($('#guardar'))    $('#guardar').attr("disabled","true");
          if($('#actualizar')) $('#actualizar').attr("disabled","");
          if($('#cerrar'))     $('#cerrar').attr("disabled","");
          if($('#borrar'))     $('#borrar').attr("disabled","");
          if($('#limpiar'))    $('#limpiar').attr("disabled","");

          $('#label_mensaje').html("");
        }



      }catch(e){

       alertJquery(resp,"Error :"+e);

     }

   });


}


function disabledInputsFormManifiesto(forma){

  $(forma).find("input,select,textarea").each(function(){

    if(this.type != 'button'){
      this.disabled = true;
    }                   

  }); 

}

function enabledInputsFormManifiesto(forma){
  $(forma).find("input,select,textarea").each(function(){

    if(this.type != 'button'){
      this.disabled = false;
    }                   

  }); 
  $('#usuario').attr("disabled","true");
  $('#fase_id').attr("disabled","true");
  $('#fecha_registro').attr("disabled","true");
  $('#abierta').attr("disabled","true");
  $('#cerrada').attr("disabled","true");

  

}

function faseOnSaveOnUpdateonDelete(formulario,resp){

 try{

   faseOnReset(formulario);
   clearFind();
   /*alertJquery(resp,"fase");*/
   $("#refresh_QUERYGRID_fase").click();

 }catch(e){

  alertJquery(resp,"Error :");    

} 

}

function faseOnReset(formulario){

  Reset(formulario);
  $('#label_mensaje').html("");
  enabledInputsFormManifiesto(formulario);
  $("#fecha_registro").val($("#fecha_static").val());
  $("#usuario_id").val($("#usuario_id_static").val());
 /*$("#usuario_actualiza_id").val($("#usuario_id_static").val());
 $("#usuario_cierre_id").val($("#usuario_id_static").val());*/
 $("#usuario").val($("#usuario_static").val());
 clearFind(); 
 if($('#guardar'))    $('#guardar').attr("disabled","");
 if($('#actualizar')) $('#actualizar').attr("disabled","true");
 if($('#cerrar'))     $('#cerrar').attr("disabled","true");
 if($('#borrar'))     $('#borrar').attr("disabled","true");
 if($('#limpiar'))    $('#limpiar').attr("disabled",""); 

}

function cerrarFase(formulario){

  var fase_id = $('#fase_id').val();  
  var QueryString = "ACTIONCONTROLER=cerrarFase&fase_id="+fase_id;
  
  $.ajax({
    url        : 'faseClass.php?random='+Math.random(),
    data       : QueryString,
    success    : function(resp){
      try{
        faseOnReset(formulario);
        document.getElementById("cerrada").checked = false;
        document.getElementById("abierta").checked = true;
        alertJquery (resp);
      }catch(e){
        alertJquery(resp,"Error :");       
      } 
    }

  });

}