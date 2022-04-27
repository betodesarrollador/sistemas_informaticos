// JavaScript Document
function LlenarFormImpuesto() {

    RequiredRemove();
    var params = new Array({ campos: "impuesto_id", valores: $('#impuesto_id').val() });
    var formulario = document.forms[0];
    var url = 'ImpuestosClass.php';
    FindRow(params, formulario, url, null, function(resp) {

        try {
            var data = $.parseJSON(resp);
            var impuesto_id = data[0]['impuesto_id'];
            var empresa_id = data[0]['empresa_id'];
            var exentos = data[0]['exentos'];
            var subcodigo = data[0]['subcodigo'];
            if (exentos == 'RT') {
                $('#subcodigo').attr("disabled", "");
            } else {
                document.getElementById('subcodigo').value = 'NULL';
                $('#subcodigo').attr("disabled", "true");
            }

            var QueryString = "ACTIONCONTROLER=onchangeSetOptionList&empresa_id=" + empresa_id;

            $.ajax({
                url: "ImpuestosClass.php?rand=" + Math.random(),
                data: QueryString,
                beforeSend: function() {
                    showDivLoading();
                },
                success: function(resp) {

                    $("#oficina_id").replaceWith(resp);
                    removeDivLoading();

                    var QueryString = "ACTIONCONTROLER=getOficinasImpuesto&impuesto_id=" + impuesto_id;

                    $.ajax({
                        url: "ImpuestosClass.php?rand=" + Math.random(),
                        data: QueryString,
                        beforeSend: function() {
                            showDivLoading();
                        },
                        success: function(resp) {

                            var oficinas = $.parseJSON(resp);

                            if (oficinas) {

                                for (var i = 0; i < oficinas.length; i++) {

                                    var oficina_id = oficinas[i]['oficina_id'];

                                    $("select[name=oficina_id] option").each(function() {

                                        if (this.value == oficina_id) {
                                            this.selected = true;
                                            return true;
                                        }

                                    });


                                }

                            }

                            removeDivLoading();

                            document.getElementById('frameImpuestos').src = "DetalleImpuestosClass.php?impuesto_id=" + impuesto_id;

                            if ($('#guardar')) $('#guardar').attr("disabled", "true");
                            if ($('#actualizar')) $('#actualizar').attr("disabled", "");
                            if ($('#borrar')) $('#borrar').attr("disabled", "");
                            if ($('#limpiar')) $('#limpiar').attr("disabled", "");

                        }
                    });


                }
            });

            var exentos = $("#exentos").val();
            if (exentos == 'RIC') {
                $("#ubicacion").show();
                $("#ubica").show();
            }

        } catch (e) {

            alertJquery(resp, "Error :" + e);

            if ($('#guardar')) $('#guardar').attr("disabled", "true");
            if ($('#actualizar')) $('#actualizar').attr("disabled", "");
            if ($('#borrar')) $('#borrar').attr("disabled", "");
            if ($('#limpiar')) $('#limpiar').attr("disabled", "");

        }


    });
}


function showTable(){
  
    var frame_grid =  document.getElementById('frame_grid');
    
      //Se valida que el iFrame no exista
      if(frame_grid == null ){
  
      var QueryString   = 'ACTIONCONTROLER=showGrid';
  
      $.ajax({
        url        : "ImpuestosClass.php?rand="+Math.random(),
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

function ImpuestoOnSave(formulario, resp) {

    if (!isNaN(parseInt(resp))) {

        var impuesto_id = resp;
        var url = "DetalleImpuestosClass.php?impuesto_id=" + impuesto_id;

        $("#impuesto_id").val(impuesto_id);
        $("#frameImpuestos").attr("src", url);

        if ($('#guardar')) $('#guardar').attr("disabled", "true");
        if ($('#actualizar')) $('#actualizar').attr("disabled", "");
        if ($('#borrar')) $('#borrar').attr("disabled", "");
        if ($('#limpiar')) $('#limpiar').attr("disabled", "");

        $("#refresh_QUERYGRID_impuesto").click();

    } else {
        alertJquery("Ocurrio una inconsistencia : " + resp);
    }


}

function ImpuestoOnUpdate(formulario, resp) {
    Reset(formulario);
    clearFind();
    setFocusFirstFieldForm(formulario);
    $("#refresh_QUERYGRID_impuesto").click();
    document.getElementById('frameImpuestos').src = 'about:blank';

    if ($('#guardar')) $('#guardar').attr("disabled", "");
    if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
    if ($('#borrar')) $('#borrar').attr("disabled", "true");
    if ($('#limpiar')) $('#limpiar').attr("disabled", "");

    alertJquery(resp, "Impuestos");

}

function ImpuestoOnDelete(formulario, resp) {
    ImpuestoOnReset(formulario);
    Reset(formulario);
    clearFind();
    $("#refresh_QUERYGRID_impuesto").click();
    alertJquery(resp);
}

function ImpuestoOnReset(formulario) {

    Reset(formulario);
    clearFind();
    setFocusFirstFieldForm(formulario);
    resetDetalle("frameImpuestos");

    $("#naturaleza").val("D");

    if ($('#guardar')) $('#guardar').attr("disabled", "");
    if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
    if ($('#borrar')) $('#borrar').attr("disabled", "true");
    if ($('#limpiar')) $('#limpiar').attr("disabled", "");
}

function findImpuesto(puc_id, text, obj) {

    var QueryString = "ACTIONCONTROLER=findImpuesto&puc_id=" + puc_id;

    $.ajax({
        url: "ImpuestosClass.php?rand=" + Math.random(),
        data: QueryString,
        beforeSend: function() {
            showDivLoading();
        },
        success: function(resp) {

            try {
                var impuesto = $.parseJSON(resp);

                if ($.isArray(impuesto)) {

                    setFormWithJSON(document.forms[0], impuesto);

                    if ($('#guardar')) $('#guardar').attr("disabled", "true");
                    if ($('#actualizar')) $('#actualizar').attr("disabled", "");
                    if ($('#borrar')) $('#borrar').attr("disabled", "");
                    if ($('#limpiar')) $('#limpiar').attr("disabled", "");

                } else {

                    var codigo_puc = text.split("-");
                    obj.value = $.trim(codigo_puc[0]);
                    $('#nombre,#descripcion').val($.trim(codigo_puc[1]));

                }

            } catch (e) {

                if ($.trim(resp) != 'false') {
                    alertJquery(resp);
                }

            }

            removeDivLoading();
        }
    });

}
$(document).ready(function() {


    $("#saveDetallesSoliServi").click(function() {
        window.frames[0].saveDetallesSoliServi();
    });

    $("#deleteDetallesSoliServi").click(function() {
        window.frames[0].deleteDetallesSoliServi();
    });

    $("#exentos").change(function() {
        if (document.getElementById('exentos').value == 'RT') {
            $('#subcodigo').attr("disabled", "");
        } else {
            document.getElementById('subcodigo').value = 'NULL';
            $('#subcodigo').attr("disabled", "true");
        }


    });

    resetDetalle("frameImpuestos");

    $("#ubicacion").hide();
    $("#ubica").hide();
    $("#ubicacion_id").removeClass("obligatorio");

    $("#exentos").change(function() {
        if ($(this).val() == 'RIC') {
            $("#ubicacion").show();
            $("#ubica").show();
            $("#ubicacion_id").addClass("obligatorio");
        } else {
            $("#ubicacion").hide();
            $("#ubica").hide();
            $("#ubicacion").val('');
            $("#ubicacion_id").val('');
            $("#ubicacion_id").removeClass("obligatorio");
        }
    });

});