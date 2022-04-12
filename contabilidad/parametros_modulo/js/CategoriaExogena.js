// JavaScript Document
function setDataFormWithResponse() {

    RequiredRemove();
    FindRow([{ campos: "categoria_exogena_id", valores: $('#categoria_exogena_id').val() }], document.forms[0], 'CategoriaExogenaClass.php', null,
        function (resp) {

            if ($('#guardar')) $('#guardar').attr("disabled", "true");
            if ($('#actualizar')) $('#actualizar').attr("disabled", "");
            if ($('#borrar')) $('#borrar').attr("disabled", "");
            if ($('#limpiar')) $('#limpiar').attr("disabled", "");

        });

}

function showTable(){
  
    var frame_grid =  document.getElementById('frame_grid');
    
      //Se valida que el iFrame no exista
      if(frame_grid == null ){
  
      var QueryString   = 'ACTIONCONTROLER=showGrid';
  
      $.ajax({
        url        : "CategoriaExogenaClass.php?rand="+Math.random(),
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

function CategoriaExogenaOnSaveOnUpdateonDelete(formulario, resp) {
    Reset(formulario);
    clearFind();
    $("#refresh_QUERYGRID_CategoriaExogena").click();

    if ($('#guardar')) $('#guardar').attr("disabled", "");
    if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
    if ($('#borrar')) $('#borrar').attr("disabled", "true");
    if ($('#limpiar')) $('#limpiar').attr("disabled", "");

    alertJquery(resp, "Categoria Exogena");

}
function CategoriaExogenaOnReset(formulario) {

    Reset(formulario);
    clearFind();

    if ($('#guardar')) $('#guardar').attr("disabled", "");
    if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
    if ($('#borrar')) $('#borrar').attr("disabled", "true");
    if ($('#limpiar')) $('#limpiar').attr("disabled", "");
}