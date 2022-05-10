// JavaScript Document
function setDataFormWithResponse() {

    var tercero_id = $('#tercero_id').val();


    RequiredRemove();

    var parametros = new Array({ campos: "tercero_id", valores: $('#tercero_id').val() });
    var forma = document.forms[0];
    var controlador = 'ClientesClass.php';

    FindRow(parametros, forma, controlador, null, function(resp) {

        var data = $.parseJSON(resp);

        console.log(data);
        ocultaFilaNombresRazon(data[0]['tipo_persona_id']);
        if ($('#guardar')) $('#guardar').attr("disabled", "true");
        if ($('#actualizar')) $('#actualizar').attr("disabled", "");
        if ($('#imprimir')) $('#imprimir').attr("disabled", "");
        if ($('#borrar')) $('#borrar').attr("disabled", "");
        if ($('#limpiar')) $('#limpiar').attr("disabled", "");

        var url = "SocioClass.php?tercero_id=" + tercero_id + "&rand=" + Math.random();
        $("#socios").attr("src", url);

        var url = "ComercialClass.php?tercero_id=" + tercero_id + "&rand=" + Math.random();
        $("#comerciales").attr("src", url);

        var url = "OperativaClass.php?tercero_id=" + tercero_id + "&rand=" + Math.random();
        $("#operativa").attr("src", url);

        var url = "ProyectosClass.php?tercero_id=" + tercero_id + "&rand=" + Math.random();
        $("#proyecto").attr("src", url);

        var url = "ClientesClass.php?ACTIONCONTROLER=comprobar_obligaciones&tercero_id=" + tercero_id + "&rand=" + Math.random();
        $("#obligaciones").attr("src", url);

        $("#legal,#tributaria,#operativas,#financiera,#proyectos,#comercial").css("display", "");
        $("#regimen_id,#recursos_cliente_factura,#comercial,#tipo_comision,#codigo_ciiu").addClass("obligatorio");


    });


}

function showTable(){
  
    var frame_grid =  document.getElementById('frame_grid');
    
      //Se valida que el iFrame no exista
      if(frame_grid == null ){
  
      var QueryString   = 'ACTIONCONTROLER=showGrid';
  
      $.ajax({
        url        : "ClientesClass.php?rand="+Math.random(),
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

function LlenarFormNumId() {

    RequiredRemove();

    FindRow([{ campos: "tercero_id", valores: $('#tercero_id').val() }], document.forms[0], 'ClientesClass.php');

    if ($('#guardar')) $('#guardar').attr("disabled", "true");
    if ($('#actualizar')) $('#actualizar').attr("disabled", "");
    if ($('#imprimir')) $('#imprimir').attr("disabled", "");
    if ($('#borrar')) $('#borrar').attr("disabled", "");
    if ($('#limpiar')) $('#limpiar').attr("disabled", "");
}

function ClienteOnSave(formulario, resp) {

    $("#refresh_QUERYGRID_terceros").click();

    try {
        var dataJSON = $.parseJSON(resp)
    } catch (e) {
        alertJquery(e);
    }

    if ($.isArray(dataJSON)) {

        var tercero_id = dataJSON[0]['tercero_id'];
        var cliente_id = dataJSON[0]['cliente_id'];
        var remitente_destinatario_id = dataJSON[0]['remitente_destinatario_id'];

        $("#tercero_id").val(tercero_id);
        $("#cliente_id").val(cliente_id);
        $("#remitente_destinatario_id").val(remitente_destinatario_id);

        $("#legal,#tributaria,#operativas,#financiera,#proyectos,#comercial").css("display", "");
        $("#regimen_id,#recursos_cliente_factura,#comercial,#tipo_comision,#codigo_ciiu").addClass("obligatorio");

        var url = "SocioClass.php?tercero_id=" + tercero_id + "&rand=" + Math.random();
        $("#socios").attr("src", url);

        var url = "ComercialClass.php?tercero_id=" + tercero_id + "&rand=" + Math.random();
        $("#comerciales").attr("src", url);


        var url = "OperativaClass.php?tercero_id=" + tercero_id + "&rand=" + Math.random();
        $("#operativa").attr("src", url);
        var url = "ProyectosClass.php?tercero_id=" + tercero_id + "&rand=" + Math.random();
        $("#proyecto").attr("src", url);

        var url = "ClientesClass.php?ACTIONCONTROLER=comprobar_obligaciones&tercero_id=" + tercero_id + "&rand=" + Math.random();
        $("#obligaciones").attr("src", url);

        //sendRemitenteDestinatarioMintransporte(resp, formulario);

        Reset(formulario);
        clearFind();
        ClienteOnReset(formulario);
        
        $("#estado").val("D");

        if ($('#guardar')) $('#guardar').attr("disabled", "");
        if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
        if ($('#borrar')) $('#borrar').attr("disabled", "true");
        if ($('#limpiar')) $('#limpiar').attr("disabled", "");

        alertJquery("Ciente guardado de manera existosa");

    } else {

        alertJquery("Ocurrio una inconsistencia : " + resp, +" GUARDANDO...");

        if ($('#guardar')) $('#guardar').attr("disabled", "");
        if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
        if ($('#borrar')) $('#borrar').attr("disabled", "true");
        if ($('#imprimir')) $('#imprimir').attr("disabled", "true");
        if ($('#limpiar')) $('#limpiar').attr("disabled", "");

    }
}

var formSubmitted = false;

function sendRemitenteDestinatarioMintransporte(resp, formulario) {

    if ($.trim(resp) == 'true') {

        if (!formSubmitted) {

            var QueryString = FormSerialize(formulario) + "&ACTIONCONTROLER=sendRemitenteDestinatarioMintransporte";

            $.ajax({
                url: "RemitenteClass.php?rand=" + Math.random(),
                data: QueryString,
                beforeSend: function() {
                    window.scrollTo(0, 0);
                    showDivMessage("Reportando al Ministerio de Transporte<br>Por Favor Espere..", "../../../framework/media/images/general/cable_data_transfer_md_wht.gif");
                    formSubmitted = true;
                },
                success: function(resp) {

                    removeDivMessage();
                    showDivMessage(resp, "../../../framework/media/images/general/cable_data_transfer_md_wht.gif");
                    formSubmitted = false;

                    Reset(formulario);
                    clearFind();
                    $("#tipo").val("R");
                    $("#estado").val("D");
                    $("#refresh_QUERYGRID_remitente").click();

                    if ($('#guardar')) $('#guardar').attr("disabled", "");
                    if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
                    if ($('#borrar')) $('#borrar').attr("disabled", "true");
                    if ($('#limpiar')) $('#limpiar').attr("disabled", "");

                }

            });

        }

    } else {
        alertJquery(resp);
    }



}

function ClienteOnUpdate(formulario, resp) {

    $("#refresh_QUERYGRID_terceros").click();

    if (resp == 'true' || resp == true || !isNaN(resp)) {


        var clienteId = isNaN(resp) ? $('#cliente_id').val() : resp;
        $('#cliente_id').val(clienteId);

        $("#legal,#tributaria,#operativas,#financiera,#proyectos,#comercial").css("display", "");
        $("#regimen_id,#recursos_cliente_factura,#comercial,#tipo_comision,#codigo_ciiu").addClass("obligatorio");

        var tercero_id = $('#tercero_id').val();
        var url = "SocioClass.php?tercero_id=" + tercero_id + "&rand=" + Math.random();
        $("#socios").attr("src", url);

        var url = "ComercialClass.php?tercero_id=" + tercero_id + "&rand=" + Math.random();
        $("#comerciales").attr("src", url);


        var url = "OperativaClass.php?tercero_id=" + tercero_id + "&rand=" + Math.random();
        $("#operativa").attr("src", url);

        var url = "ProyectosClass.php?tercero_id=" + tercero_id + "&rand=" + Math.random();
        $("#proyecto").attr("src", url);

        var url = "ClientesClass.php?ACTIONCONTROLER=comprobar_obligaciones&tercero_id=" + tercero_id + "&rand=" + Math.random();
        $("#obligaciones").attr("src", url);

        //sendRemitenteDestinatarioMintransporte(resp, formulario);

        Reset(formulario);
        clearFind();
        ClienteOnReset(formulario);
        
        $("#estado").val("D");

        if ($('#guardar')) $('#guardar').attr("disabled", "");
        if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
        if ($('#borrar')) $('#borrar').attr("disabled", "true");
        if ($('#limpiar')) $('#limpiar').attr("disabled", "");

        alertJquery("Ciente actualizado de manera existosa");

    } else {

        alertJquery("Ocurrio una inconsistencia : " + resp, +" ACTUALIZANDO...");

        if ($('#guardar')) $('#guardar').attr("disabled", "");
        if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
        if ($('#borrar')) $('#borrar').attr("disabled", "true");
        if ($('#imprimir')) $('#imprimir').attr("disabled", "true");
        if ($('#limpiar')) $('#limpiar').attr("disabled", "");

    }
}

function ClienteonDelete(formulario, resp) {

    $("#socios").attr("src", "../../../framework/tpl/blank.html");
    $("#operativa").attr("src", "../../../framework/tpl/blank.html");
    $("#proyecto").attr("src", "../../../framework/tpl/blank.html");
    $("#obligaciones").attr("src", "../../../framework/tpl/blank.html");
    $("#legal,#tributaria,#operativas,#financiera,#proyectos,#comercial").css("display", "none");
    $("#regimen_id,#recursos_cliente_factura,#comercial,#ejecutivo,#tipo_comision,#codigo_ciiu").removeClass("obligatorio");

    $("#refresh_QUERYGRID_terceros").click();
    clearFind();
    if ($('#guardar')) $('#guardar').attr("disabled", "");
    if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
    if ($('#borrar')) $('#borrar').attr("disabled", "true");
    if ($('#imprimir')) $('#imprimir').attr("disabled", "true");
    if ($('#limpiar')) $('#limpiar').attr("disabled", "");
    $('#estado').val('B');

    alertJquery(resp, "Clientes");

}

function ClienteOnReset(formulario) {

    $("#socios").attr("src", "../../../framework/tpl/blank.html");
    $("#operativa").attr("src", "../../../framework/tpl/blank.html");
    $("#proyecto").attr("src", "../../../framework/tpl/blank.html");
    $("#obligaciones").attr("src", "../../../framework/tpl/blank.html");
    $("#legal,#tributaria,#operativas,#financiera,#proyectos,#comercial").css("display", "none");
    $("#regimen_id,#recursos_cliente_factura,#comercial,#ejecutivo,#tipo_comision,#codigo_ciiu").removeClass("obligatorio");
    clearFind();
    if ($('#guardar')) $('#guardar').attr("disabled", "");
    if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
    if ($('#borrar')) $('#borrar').attr("disabled", "true");
    if ($('#imprimir')) $('#imprimir').attr("disabled", "true");
    if ($('#limpiar')) $('#limpiar').attr("disabled", "");
    $('#estado').val('B');
}

function beforePrint(formulario, url, title, width, height) {

    var cliente_id = parseInt($("#cliente_id").val());

    if (isNaN(cliente_id)) {

        alertJquery('Debe seleccionar un Cliente a imprimir !!!', 'Impresion Cliente');
        return false;

    } else {
        return true;
    }

}

function guardarObligacion(obj) {

    var row = obj.parentNode.parentNode;

    var Celda = obj.parentNode;
    var Fila = obj.parentNode.parentNode;
    var tercero_id = $("#tercero_id").val();
    var tercero_obligacion_id = $(Fila).find("input[name=tercero_obligacion_id]").val();
    var codigo_obligacion_id = $(Fila).find("input[name=codigo_obligacion_id]").val();

    if (obj.checked == true) {
        var estado = 'A';
    } else {
        var estado = 'I';
    }

    if (parseInt(tercero_obligacion_id) > 0) {

        var QueryString = "ACTIONCONTROLER=UpdateObligacion&tercero_id=" + tercero_id + "&tercero_obligacion_id=" +
            tercero_obligacion_id + "&codigo_obligacion_id=" + codigo_obligacion_id + "&estado=" + estado;

        $.ajax({

            url: "ClientesClass.php",
            data: QueryString,
            beforeSend: function() {

            },
            success: function(response) {}

        });

    } else {


        var QueryString = "ACTIONCONTROLER=SaveObligacion&tercero_id=" + tercero_id + "&tercero_obligacion_id=" +
            tercero_obligacion_id + "&codigo_obligacion_id=" + codigo_obligacion_id + "&estado=" + estado;

        $.ajax({

            url: "ClientesClass.php",
            data: QueryString,
            beforeSend: function() {

            },
            success: function(response) {
                $(Fila).find("input[name=tercero_obligacion_id]").val(response);

            }

        });
    }
}

$(document).ready(function() {

    $("#legal,#tributaria,#operativas,#financiera,#proyectos,#comercial").css("display", "none");

    $("#saveDetallesoc").click(function() {
        window.frames[0].saveDetalles();
    });


    $("#deleteDetallesoc").click(function() {
        window.frames[0].deleteDetalles();
    });

    $("#saveDetalleope").click(function() {
        window.frames[2].saveDetalles();
    });
    $("#deleteDetalleope").click(function() {
        window.frames[2].deleteDetalles();
    });

    $("#saveDetallepro").click(function() {
        window.frames[3].saveDetalles();
    });
    $("#deleteDetallepro").click(function() {
        window.frames[3].deleteDetalles();
    });



    $("#saveDetallecom").click(function() {
        window.frames[4].saveDetalles();
    });

    $("#deleteDetallecom").click(function() {
        window.frames[4].deleteDetalles();
    });


    $("#tipo_identificacion_id").change(function() {
        calculaDigitoTercero();
    });

    // addNewRowComercial();

    $("#numero_identificacion").blur(function() {

        var tercero_id = $("#tercero_id").val();
        var cliente_id = $("#cliente_id").val();
        var numero_identificacion = this.value;
        var params = new Array({ campos: "numero_identificacion", valores: numero_identificacion });

        if (!tercero_id.length > 0) {

            validaRegistro(this, params, "ClientesClass.php", null, function(resp) {

                if (parseInt(resp) != 0) {
                    var params = new Array({ campos: "numero_identificacion", valores: numero_identificacion });
                    var formulario = document.forms[0];
                    var url = 'ClientesClass.php';

                    FindRow(params, formulario, url, null, function(resp) {

                        var data = $.parseJSON(resp);
                        ocultaFilaNombresRazon(data[0]['tipo_persona_id']);

                        clearFind();

                        $('#guardar').attr("disabled", "true");
                        $('#actualizar').attr("disabled", "");
                        $('#borrar').attr("disabled", "");
                        $('#limpiar').attr("disabled", "");
                        var tercero_id = $("#tercero_id").val();
                        var cliente_id = $("#cliente_id").val();

                        if (cliente_id > 0 && tercero_id > 0) {

                            var url = "SocioClass.php?tercero_id=" + tercero_id + "&rand=" + Math.random();
                            $("#socios").attr("src", url);

                            var url = "ComercialClass.php?tercero_id=" + tercero_id + "&rand=" + Math.random();
                            $("#comerciales").attr("src", url);

                            var url = "OperativaClass.php?tercero_id=" + tercero_id + "&rand=" + Math.random();
                            $("#operativa").attr("src", url);

                            var url = "ProyectosClass.php?tercero_id=" + tercero_id + "&rand=" + Math.random();
                            $("#proyecto").attr("src", url);

                            var url = "ClientesClass.php?ACTIONCONTROLER=comprobar_obligaciones&tercero_id=" + tercero_id + "&rand=" + Math.random();
                            $("#obligaciones").attr("src", url);

                            $("#legal,#tributaria,#operativas,#financiera,#proyectos").css("display", "");
                            $("#regimen_id,#recursos_cliente_factura,#comercial,#tipo_comision,#codigo_ciiu").addClass("obligatorio");


                        } else if (tercero_id > 0) {
                            $('#guardar').attr("disabled", "");
                            $('#actualizar').attr("disabled", "true");
                            $('#borrar').attr("disabled", "true");
                            $('#limpiar').attr("disabled", "");
                        }

                    });

                } else {
                    calculaDigitoTercero();
                    $('#guardar').attr("disabled", "");
                    $('#actualizar').attr("disabled", "true");
                    $('#borrar').attr("disabled", "true");
                    $('#limpiar').attr("disabled", "");
                }
            });

        }

    });

    $("#guardar,#actualizar").click(function() {

        var formulario = document.getElementById('ClientesForm');

        if (ValidaRequeridos(formulario) && ValidaOtrosTercero(formulario)) {
            if (this.id == 'guardar') {
                Send(formulario, 'onclickSave', null, ClienteOnSave)
            } else {
                Send(formulario, 'onclickUpdate', null, ClienteOnUpdate)
            }
        }

    });

    $("#tipo_persona_id").change(function() {
        ocultaFilaNombresRazon(this.value);

    });

});