// JavaScript Document
function setDataFormWithResponse() {
    var parametrosId = $('#parametros_factura_id').val();
    RequiredRemove();

    var parametros = new Array({ campos: "parametros_factura_id", valores: $('#parametros_factura_id').val() });
    var forma = document.forms[0];
    var controlador = 'ParametrosClass.php';

    FindRow(parametros, forma, controlador, null, function(resp) {
        if ($('#guardar')) $('#guardar').attr("disabled", "true");
        if ($('#actualizar')) $('#actualizar').attr("disabled", "");
        if ($('#borrar')) $('#borrar').attr("disabled", "");
        if ($('#limpiar')) $('#limpiar').attr("disabled", "");

        var QueryString = "ACTIONCONTROLER=getFuentes&parametros_factura_id=" + parametrosId;

        $.ajax({
            url: "ParametrosClass.php",
            data: QueryString,
            success: function(response) {

                try {
                    var fuente = $.parseJSON(response);

                    if (fuente != null && fuente != '' && fuente != 'null') {

                        var fuentes = fuente[0]['fuente_facturacion_cod'];
                        var res = fuentes.split(",");

                        for (i = 0; i < res.length; i++) {
                            $("#fuente_facturacion_cod option").each(function() {
                                if (this.value == 'NULL') {
                                    this.selected = false;
                                }
                                if (this.value == res[i]) {
                                    this.selected = true;
                                }

                            });
                        }
                    }
                } catch (e) {

                }
            }

        });

    });


}

function ParametrosOnSaveOnUpdateonDelete(formulario, resp) {
    Reset(formulario);
    clearFind();
    $("#refresh_QUERYGRID_parametros").click();
    if ($('#guardar')) $('#guardar').attr("disabled", "");
    if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
    if ($('#borrar')) $('#borrar').attr("disabled", "true");
    if ($('#limpiar')) $('#limpiar').attr("disabled", "");
    alertJquery(resp, "Parametros");
}

function showTable(){
  
    var frame_grid =  document.getElementById('frame_grid');
    
      //Se valida que el iFrame no exista
      if(frame_grid == null ){
  
      var QueryString   = 'ACTIONCONTROLER=showGrid';
  
      $.ajax({
        url        : "ParametrosClass.php?rand="+Math.random(),
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

function ParametrosOnReset(formulario) {

    clearFind();
    if ($('#guardar')) $('#guardar').attr("disabled", "");
    if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
    if ($('#borrar')) $('#borrar').attr("disabled", "true");
    if ($('#limpiar')) $('#limpiar').attr("disabled", "");
}

$(document).ready(function() {

    $("#guardar,#actualizar").click(function() {

        var formulario = document.getElementById('ParametrosForm');

        if (ValidaRequeridos(formulario)) {
            if (this.id == 'guardar') {
                if (parseInt($('#rango_inicial').val()) < parseInt($('#rango_final').val())) {
                    Send(formulario, 'onclickSave', null, ParametrosOnSaveOnUpdateonDelete)
                } else {
                    alertJquery("El rango Inicial no puede ser mayor que el Final", "Parametros");
                }
            } else {
                if (parseInt($('#rango_inicial').val()) < parseInt($('#rango_final').val())) {
                    Send(formulario, 'onclickUpdate', null, ParametrosOnSaveOnUpdateonDelete)
                } else {
                    alertJquery("El rango Inicial no puede ser mayor que el Final", "Parametros");
                }

            }
        }

    });

});